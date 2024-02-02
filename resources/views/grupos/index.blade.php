<x-app-layout>
    <title>Mis grupos - Grupos de WhatsApp</title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">

            <h2 class="h4">Mis grupos</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a data-bs-toggle="modal" data-bs-target="#modal-block-fadein" href="#"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Agregar grupo
            </a>

        </div>
    </div>
    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-9 col-lg-8 d-md-flex">
                <div class="input-group me-2 me-lg-3 fmxw-300">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input id="external_search" type="text" class="form-control" placeholder="Buscar en mis grupos">
                </div>
                <select id="estados" name="estados" class="form-select fmxw-200 d-none d-md-inline"
                    aria-label="Message select example 2">
                    <option selected value="todos">Todos</option>
                    <option value="Publicado">Publicados</option>
                    <option value="Pendiente">Pendientes</option>
                    <option value="Desactivado">Desactivados</option>
                    <option value="Restringido">Restringidos</option>
                </select>
            </div>

        </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table id="posts-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th class="border-gray-200">ID</th>
                    <th class="border-gray-200">Nombre</th>
                    <th class="border-gray-200">Enlace</th>
                    <th class="border-gray-200">Categoria</th>
                    <th class="border-gray-200">Abierto</th>
                    <th class="border-gray-200">Adulto</th>
                    <th class="border-gray-200">Visitas</th>
                    <th class="border-gray-200">Clics</th>
                    <th class="border-gray-200">Estado</th>
                    <th style="width:50px" class="border-gray-200">Acciones</th>

                </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="modal-block-fadein" tabindex="-1" aria-labelledby="modal-block-fadein"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card p-3 p-lg-4">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <form action="{{ route('grupos.store') }}" method="POST" class="mt-4">
                            @csrf
                            <!-- Form -->
                            <div class="form-group mb-2">
                                <label for="email">Nombre del grupo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="" id="nombre"
                                        name="nombre" autofocus required>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Enlace para unirse al grupo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="" id="enlace"
                                        name="enlace" autofocus required>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Categoria</label>
                                <div class="input-group">
                                    <select class="form-control" id="category" name="category_id" required>
                                        <option value="">Choose a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->term_id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="email">Descripcion</label>
                                <div class="input-group">
                                    <textarea class="form-control" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Aceptas usuarios de todo el mundo?</label>
                                <br>
                                <div style="">
                                    <input type="radio" id="mundo_si" name="todo_mundo" value="si" required
                                        checked>
                                    <label for="status_yes">Sí</label><br>
                                    <input type="radio" id="mundo_no" name="todo_mundo" value="no">
                                    <label for="status_no">No</label>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Se incluye contenido sexual o adulto?</label>
                                <br>
                                <div style="">
                                    <input type="radio" id="adulto_no" name="adulto" value="no" checked>
                                    <label for="status_no">No</label><br>
                                    <input type="radio" id="adulto_si" name="adulto" value="si" required>
                                    <label for="status_yes">Sí</label><br>
                                </div>
                            </div>


                            <!-- End of Form -->
                            <div class="d-grid">
                                <button id="enviar" type="submit" class="btn btn-gray-800">Cear grupo</button>
                            </div>
                        </form>
                        <div class="mt-3 mb-4 text-center">
                            <span class="fw-normal">Una vez enviado, debes esperar por su aprobacion.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-block-fadein-update-grupo" tabindex="-1" aria-labelledby="modal-block-fadein"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card p-3 p-lg-4">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <form action="{{ route('grupos.store') }}" method="POST" class="mt-4">
                            @csrf
                            <!-- Form -->
                            <div class="form-group mb-2">
                                <label for="email">Nombre del grupo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="" id="updtnombre"
                                        name="updtnombre" autofocus required>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Enlace para unirse al grupo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="" id="updtenlace"
                                        name="updtenlace" autofocus required>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Categoria</label>
                                <div class="input-group">
                                    <select class="form-control" id="updtcategory_id" name="updtcategory_id"
                                        required>
                                        <option value="">Choose a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->term_id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="email">Descripcion</label>
                                <div class="input-group">
                                    <textarea class="form-control" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Aceptas usuarios de todo el mundo?</label>
                                <br>
                                <div style="">
                                    <input type="radio" id="mundo_si" name="updttodo_mundo" value="si"
                                        required checked>
                                    <label for="status_yes">Sí</label><br>
                                    <input type="radio" id="mundo_no" name="updttodo_mundo" value="no">
                                    <label for="status_no">No</label>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Se incluye contenido sexual o adulto?</label>
                                <br>
                                <div style="">
                                    <input type="radio" id="adulto_no" name="updtadulto" value="no" checked>
                                    <label for="status_no">No</label><br>
                                    <input type="radio" id="adulto_si" name="updtadulto" value="si" required>
                                    <label for="status_yes">Sí</label><br>
                                </div>
                            </div>


                            <!-- End of Form -->
                            <div class="d-grid">
                                <button id="enviar" type="submit" class="btn btn-gray-800">Cear grupo</button>
                            </div>
                        </form>
                        <div class="mt-3 mb-4 text-center">
                            <span class="fw-normal">Una vez enviado, debes esperar por su aprobacion.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

        <script>
            $(function() {
                var table = $('#posts-table').DataTable({
                    processing: false,
                    serverSide: false,
                    language: {
                        search: "@lang('datatable.search')",
                        lengthMenu: "@lang('datatable.lengthMenu')",
                        info: "@lang('datatable.info')",
                        infoEmpty: "@lang('datatable.infoEmpty')",
                        infoFiltered: "@lang('datatable.infoFiltered')",
                        loadingRecords: "@lang('datatable.loadingRecords')",
                        processing: "@lang('datatable.processing')",
                        zeroRecords: "@lang('datatable.zeroRecords')",
                        paginate: {
                            first: "@lang('datatable.paginate.first')",
                            last: "@lang('datatable.paginate.last')",
                            next: "@lang('datatable.paginate.next')",
                            previous: "@lang('datatable.paginate.previous')",
                        },
                    },
                    header: true, // Enable custom header styles
                    initComplete: function(settings, json) {
                        $('#data-table thead th').css({
                            "background-color": "gray", // Set background color to black
                            "height": "50px", // Set background color to black
                            "color": "white" // Set text color to white
                        });
                    },
                    order: [
                        [0, "desc"]
                    ], // Sort by the second column in descending order
                    ajax: '{{ route('grupos.getGrupos') }}',
                    columns: [{
                            data: 'ID',
                            name: 'ID'
                        },
                        {
                            data: 'post_title',
                            name: 'post_title'
                        },
                        {
                            data: 'post_meta',
                            name: 'enlace_grupo',
                            render: function(data, type, row) {
                                let pais = data.find(meta => meta.meta_key === 'enlace_grupo');
                                return pais ? pais.meta_value : 'N/A';
                            }
                        },
                        {
                            data: 'category',
                            name: 'post_status'
                        },

                        {
                            data: 'post_meta',
                            name: 'todo_mundo',
                            className: 'centered-column',
                            render: function(data, type, row) {
                                let pais = data.find(meta => meta.meta_key === 'todo_mundo');
                                return pais ? pais.meta_value : 'N/A';
                            }
                        },
                        {
                            data: 'post_meta',
                            name: 'adulto',
                            className: 'centered-column',
                            render: function(data, type, row) {
                                let pais = data.find(meta => meta.meta_key === 'adulto');
                                return pais ? pais.meta_value : 'N/A';
                            }
                        },

                        {
                            data: 'post_meta',
                            name: 'visitas',
                            className: 'centered-column',
                            render: function(data, type, row) {
                                let pais = data.find(meta => meta.meta_key === 'post_views_count');
                                return pais ? pais.meta_value : 'N/A';
                            }
                        },
                        {
                            data: 'post_meta',
                            name: 'clics',
                            className: 'centered-column',
                            render: function(data, type, row) {
                                let pais = data.find(meta => meta.meta_key === 'increment_views_count');
                                return pais ? pais.meta_value : 'N/A';
                            }
                        },
                        {
                            data: 'post_status',
                            name: 'post_status',
                            render: function(data, type, row) {
                                if (data == "pending") {
                                    return '<span class="text-warning">Pendiente</span>';
                                } else if (data == "publish") {
                                    return '<span class="fw-normal text-success">Publicado</span>';
                                } else if (data == "desactivated_admin") {
                                    return '<span class="fw-normal text-danger">Restringido</span>';
                                } else {
                                    return "<spa class='text-danger'>Desactivado</span>";
                                }
                            }
                        },
                        {
                            data: 'acciones',
                            name: 'acciones',
                            className: 'centered-column'
                        },
                    ],
                    dom: 'lrtip',
                    dom: 'rtip',

                    language: {
                        paginate: {
                            previous: "<",
                            next: ">"
                        },
                        info: "  _START_ - _END_ de _TOTAL_ "
                    }
                });
                $('#external_search').on('keyup', function() {
                    table.search(this.value).draw();
                });

                $('#estados').on('change', function() {
                    var estado = $(this).val();

                    // Verifica si el valor seleccionado es el que representa "todos"
                    if (estado === "todos") {
                        // Si es "todos", reinicia el filtro de búsqueda y vuelve a cargar la tabla
                        table.search('').columns().search('').draw();
                    } else {
                        // Filtra por ese estado en la columna específica y dibuja la tabla
                        table.column(8).search(estado).draw();
                    }
                });
                table.column(0).visible(false);
                $('#posts-table tbody').on('click', '.update', function() {
                    var rowId = $(this).attr('data-id');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('grupos.updtState') }}",
                        method: 'POST',
                        data: {
                            id: rowId
                        },
                        success: function(data) {
                            table.ajax.reload();
                            Swal.fire({
                                title: data.error ? 'Error!' : 'Exito',
                                icon: data.error ? 'info' : 'success',
                                text: data.message,
                                icon: 'info',
                                confirmButtonText: 'Aceptar'
                            });
                        },
                        error: function(error) {
                            console.log('Error actualizando estado.');
                        }
                    });
                });

                $('#posts-table tbody').on('click', '.update-grupo', function() {
                    var rowData = table.row($(this).closest('tr')).data();
                    // Populate the modal with the data
                    $('#updtnombre').val(rowData['post_title']); // Assuming the data is in the first column

                    let enlaceGrupoMeta = rowData['post_meta'].find(meta => meta.meta_key == 'enlace_grupo');
                    let enlaceGrupo = enlaceGrupoMeta ? enlaceGrupoMeta.meta_value : 'N/A';

                    // Asumiendo que tienes un campo de entrada en tu modal para 'enlace_grupo'
                    $('#updtenlace').val(
                        enlaceGrupo); // Reemplaza 'tuCampoEnlaceGrupo' con el ID real de tu campo

                    $('modal-block-fadein-update-grupo').modal('show');
                });

            });
        </script>
    @endpush

    @push('styles')
        <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="{{ asset('/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <style>
            .centered-column {
                text-align: center;
            }
        </style>
    @endpush


</x-app-layout>
