<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GruposModel;
use App\Models\TermModel;
use App\Models\PostMetaModel;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GruposController extends Controller
{
    public function index(){
        $categories = TermModel::all();
        return view('grupos.index', compact('categories'));
    }
    //lala

    public function getGrupos(Request $request)
    {
     if ($request->ajax()) {
            $user=Auth::user();
            $posts = GruposModel::with('terms')->select(['ID', 'post_title', 'post_date', 'post_status'])->where('post_type','post')->where('post_author',$user->id)
            ->with(['postMeta' => function ($query) {
                $query->whereIn('meta_key', ['pais', 'cod_pais', 'enlace_grupo', 'todo_mundo', 'adulto','post_views_count','increment_views_count']);
            }])->orderBy('id','ASC');
            foreach ($posts as $post) {
                foreach ($post->postMeta as $meta) {
                    $post->{$meta->meta_key} = $meta->meta_value;
                }
            }
            return DataTables::of($posts)
            ->addColumn('acciones', function($row){
                // Aquí puedes definir el contenido de la columna de acciones
                $acciones="";
                if ($row->post_status != 'pending'){
                    $acciones = '<div class="btn-group">
                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon icon-sm">
                        <span class="fas fa-ellipsis-h icon-dark"></span>
                    </span>
                    <span class="visually-hidden">Toggle Dropdown</span>
                     </button>
                      </button>
                      <div class="dropdown-menu py-0" aria-labelledby="dropdown-align-primary" style="">';
                      if ($row->post_status == 'publish' && $row->post_status != 'desactivated_user') {
                        $acciones .= '<a data-bs-toggle="modal" data-bs-target="#modal-block-fadein-update-grupo" class="dropdown-item update-grupo" data-id="'.$row->ID.'">Editar</a>';
                      }
                      //if ($row->post_status == 'publish' && $row->post_status != 'desactivated_user') {
                        //$acciones .= '<a class="dropdown-item" href="eventos/promocionar/'.$row->id.'">Promocionar</a>';
                      //}
                      if ($row->post_status == 'desactivated_admin') {
                        $acciones .= '<a class="dropdown-item restringido" data-id="'.$row->ID.'">Leer motivo</a>';
                      }
                      if ($row->post_status == 'desactivated_user'){
                        $acciones .= '<a class="dropdown-item update" data-id="'.$row->ID.'">Reactivar</a>';
                      }
                       if ($row->post_status == 'publish' && $row->post_status != 'desactivated_user') {
                        $acciones .= '<a class="dropdown-item update" data-id="'.$row->ID.'">Desactivar</a>';
                      }
                      $acciones .='</div>';
                }
                return $acciones;
            })
                ->addColumn('category', function ($post) {
                    return $post->terms->pluck('name')->implode(', ');
                })
                ->rawColumns(['acciones'])
                ->make(true);
     }
    }

    public function store(Request $request){
       // if ($usuario->id_rol!=1){
           // abort(403);
       // }
        $operation="add";
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|regex:/^[A-Za-z ]+$/',
            'descripcion' => 'required',
            'todo_mundo' => 'required|in:si,no',
            'adulto' => 'required|in:si,no',
        ],[
            'nombre' => 'Nombre del grupo',
            'descripcion' => 'Descripcion',
            'todo_mundo' => 'Seleccione permitido para todos los paises o no',
            'adulto' => 'Seleccione si el grupo permite contenido adulto o sxual',
        ]);

      //  if ($validator->fails()) {
        //    return redirect()->back()
             //   ->withErrors($validator)
             //   ->withInput()->with('operation',$operation);
     //   }

     $usuario = Auth::user();

     $grupo = new GruposModel();
        $grupo->post_title = $request->nombre;
        $grupo->post_name = $grupo->getUniqueSlug($request->nombre);
        $grupo->post_status = 'pending';
        $grupo->post_type ='post';
        $grupo->post_author =$usuario->id;
        $grupo->post_content='';
        $grupo->post_excerpt='';
        $grupo->to_ping='';
        $grupo->pinged='';
        $grupo->post_content_filtered='';
        $grupo->post_date=now();
        $grupo->post_date_gmt=now();
        $grupo->post_modified=now();
        $grupo->post_modified_gmt=now();

        $userIP = $_SERVER['REMOTE_ADDR'];

        $apiUrl = "http://ip-api.com/json/{$userIP}";
        $response = file_get_contents($apiUrl);
        $locationData = json_decode($response, true);

        // Obtener el país
        $pais = $locationData['country'] ?? 'México';
        $code = $locationData['countryCode'] ?? 'MX';
        //$grupo->is_adult = $request->input('adulto') === 'yes' ? 1 : 0; // asumiendo que tienes una columna is_adult
        $grupo->save();
//return dd($grupo);

        PostMetaModel::create([
            'post_id' => $grupo->ID,
            'meta_key' => 'pais',
            'meta_value' => $pais
        ]);
        PostMetaModel::create([
            'post_id' => $grupo->ID,
            'meta_key' => 'cod_pais',
            'meta_value' => $code
        ]);
        PostMetaModel::create([
            'post_id' => $grupo->ID,
            'meta_key' => 'enlace_grupo',
            'meta_value' => $request->enlace
        ]);
        PostMetaModel::create([
            'post_id' => $grupo->ID,
            'meta_key' => 'adulto',
            'meta_value' => $request->adulto
        ]);
        PostMetaModel::create([
            'post_id' => $grupo->ID,
            'meta_key' => 'todo_mundo',
            'meta_value' => $request->todo_mundo
        ]);
        $category_id = $request->category_id;
        $grupo->terms()->attach($category_id);


        return redirect()->route('grupos.index');
    }

    public function updtState(Request $request){
        $usuario = Auth::user();
        //if ($usuario->id_rol!=1){
            //abort(403);
        //}
        //return view('sites.crop');
        $id = $request->input('id');
        //$id_webw = SitesModel::find($request->$id);
        try {
            $grupo = GruposModel::find($id);

            $grupo->post_status=='publish' ? $grupo->post_status = 'desactivated_user': $grupo->post_status = 'pending';
            $grupo->save();

            if ($grupo->post_status=='pending'){
                return response()->json(['success' => true, 'message' => 'Publicado, debes esperar nuevamente su aprobacion.']);
            }else if ($grupo->post_status=='desactivated_user'){
                return response()->json(['success' => true, 'message' => 'Grupo desactivado correctamente.']);

            }

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Error al actualizar estado']);
        }

    }

}