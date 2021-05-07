<?php
use App\Models\{customer};

class Rupiah {
    public static function getRupiah($value) {
        $format = "Rp " . number_format($value,2,',','.');
        return $format;
    }
}

// Get Email Customer by id
if (! function_exists('email_customer'))
{
    function email_customer($id=0)
    {
      $model = new customer;
      $data  = $model::where('id',$id)->first();
      $email_customer = !empty($data) ? $data->email_customer : 'Not Found';
      return $email_customer;
    }
}

// Get Nama Customer by id
if (! function_exists('namaCustomer'))
{
    function namaCustomer($id=0)
    {
        $model = new customer;
        $data  = $model::where('id',$id)->first();
        $name = !empty($data) ? $data->nama : 'Not Found';
        return $name;
    }
}