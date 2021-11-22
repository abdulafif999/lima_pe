<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCan;

class TimDetail extends Model
{
    use HasFactory;
    use HasCan;
    protected $fillable = ['tim_id','nip','posisi'];
    public function tim()
    {
        return $this->belongsTo(Tim::class, 'tim_id', 'id'); 
    }
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nip', 'nip'); 
    }
    
}
