<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermModel extends Model
{
    use HasFactory;
    protected $table = 'wpxy_terms';
    protected $primaryKey = 'term_id';

    public function posts()
    {
        return $this->belongsToMany(GruposModel::class, 'wpxy_term_relationships', 'term_taxonomy_id', 'object_id');
    }
}