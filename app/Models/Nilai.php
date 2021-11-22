<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCan;

class Nilai extends Model
{
    use HasFactory;
    use HasCan;
    protected $fillable = ['kriteria_id','nilai','keterangan'];
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id'); 
    }
}
