<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaiTroQuyen extends Model
{
    use HasFactory;

    protected $table = 'vai_tro_quyen';
    public $incrementing = false;
    protected $primaryKey = ['vai_tro_id', 'quyen_id'];

    protected $fillable = [
        'vai_tro_id',
        'quyen_id',
    ];

    public $timestamps = false;
    protected $dates = ['created_at'];

    // Relationships
    public function vaiTro()
    {
        return $this->belongsTo(VaiTro::class, 'vai_tro_id');
    }

    public function quyen()
    {
        return $this->belongsTo(Quyen::class, 'quyen_id');
    }

}
