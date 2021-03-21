<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundrySetting extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id','target_day','target_month','target_year'
    ];
}
