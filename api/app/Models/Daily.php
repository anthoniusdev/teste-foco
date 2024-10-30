<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;
    protected $table = "dailies";
    protected $fillable = [
        'Date',
        'Value',
        'reserveCode'
    ];
}
