<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;
use Carbon\Carbon;


class GruposModel extends Model
{
    use HasFactory;
    protected $table = 'wpxy_posts';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'post_date',
        'post_author ',
        'post_title',
        'post_name',
        'post_status',
        'post_type',
        'post_content',
        'post_excerpt',
        'to_ping',
        'pinged',
        'post_content_filtered',
    ];

    //Fecha dormato
    public function getPostDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function terms()
    {
        return $this->belongsToMany(TermModel::class, 'wpxy_term_relationships', 'object_id', 'term_taxonomy_id');
    }

    //SLUGS
    use HasSlug;

    // Resto del código del modelo...

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('post_title') // 'title' es el campo que se usará para generar el slug
            ->saveSlugsTo('post_name'); // 'post_name' es el campo donde se guardará el slug
    }

    public function postMeta() {
        return $this->hasMany(PostMetaModel::class, 'post_id', 'ID');
    }

    /**
     * Método para asegurar que el slug sea único.
     */
    public function getUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = static::whereRaw("post_name RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

}