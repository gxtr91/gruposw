<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMetaModel extends Model
{
    use HasFactory;
    protected $table = 'wpxy_postmeta';
    protected $primaryKey = 'meta_id';
    protected $fillable = [
        'post_id',
        'meta_key',
        'meta_value'
    ];

    public $timestamps = false;


    public function post()
    {
        return $this->belongsTo(GruposModel::class, 'ID', 'post_id');
    }

}