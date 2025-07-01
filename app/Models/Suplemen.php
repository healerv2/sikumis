<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplemen extends Model
{
    use HasFactory;
    protected $table = 'suplemens';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'suplemen_user', 'suplemen_id', 'user_id');
    }
}
