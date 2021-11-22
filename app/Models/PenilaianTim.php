<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianTim extends Model
{
    use HasFactory;
    protected $fillable = ['tim_id','tim_unit_id'];
    public function tim()
    {
        return $this->belongsTo(Tim::class, 'tim_id', 'id');
    }
    public function timUnit()
    {
        return $this->belongsTo(TimUnit::class, 'tim_unit_id', 'id'); 
    }     
}
