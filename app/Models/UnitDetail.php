<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UnitDetail extends Model
{
    use HasFactory;
    protected $fillable = ['pernum','tim_unit_id', 'posisi'];
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'pernum','pernum'); 
    }
    public function timUnit()
    {
        return $this->belongsTo(TimUnit::class, 'tim_unit_id', 'id');
    }    
    
}
