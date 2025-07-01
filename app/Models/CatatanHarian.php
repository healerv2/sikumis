<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanHarian extends Model
{
    use HasFactory;

    protected $table = 'catatan_harians';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'tanggal',
        'status_minum',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'status_minum' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
