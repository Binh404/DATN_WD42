<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhomQuyen extends Model
{
    use HasFactory;

    protected $table = 'nhom_quyen';

    protected $fillable = [
        'ten',
        'ma',
        'mo_ta',
    ];

    // Relationships
    public function quyens()
    {
        return $this->hasMany(Quyen::class, 'nhom_quyen_id');
    }
}
