<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordpressUserModel extends Model
{
    use HasFactory;
    protected $table = 'wpxy_users';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'user_login',
        'user_pass',
        'user_nicename',
        'user_email',
        'user_url',
        'user_status',
    ];
}