<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCan;

class Tim extends Model
{
    use HasFactory;
    use HasCan;
    protected $fillable=['nama'];


}
