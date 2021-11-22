<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianDetail extends Model
{
    use HasFactory;
    protected $fillable = ['kriteria_id','penilaian_id','nilai','status','rekomendasi', 'foto'];
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id'); 
    }
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id', 'id'); 
    }
}
