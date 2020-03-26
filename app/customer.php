<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $primaryKey = 'id_customer';
    
    protected $fillable = [
        'nama','alamat','kelamin','no_telp','email_customer'
    ];
}
