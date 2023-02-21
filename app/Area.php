<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable =[
        "name", "phone", "email", "address", "is_active","created_at","updated_at"
    ];
}
