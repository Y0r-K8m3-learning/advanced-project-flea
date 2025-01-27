<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'users_details';

    protected $fillable = [
        'user_id',
        'image_id',
        'post_code',
        'address',
        'building',
    ];

    public function user()
    {
        $this->belongsTo(User::class, 'id');
    }
}
