<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCan;

class Karyawan extends Model
{
    use HasFactory;
    use HasCan;
    protected $primaryKey = 'pernum';
    protected $uniqueKey = 'nip';
    
}
