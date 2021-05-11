<?php
use App\Models\{customer,notifications_setting};

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

// Setting Email Notifications
if (! function_exists('setNotificationEmail'))
{
    function setNotificationEmail($id='')
    {
        $model = new notifications_setting;
        $data  = $model::where('email',$id)->first();
        $email = $data ? $data->email : 'Email Notification Aktif Tidak';
        return $email;
    }
}

// Setting Telegram Order Masuk Notifications
if (! function_exists('setNotificationTelegramIn'))
{
    function setNotificationTelegramIn($id='')
    {
        $model = new notifications_setting;
        $data  = $model::where('telegram_order_masuk',$id)->first();
        $teleIn = $data ? $data->telegram_order_masuk : 'Telegram Notification Order Masuk Tidak Aktif';
        return $teleIn;
    }
}

// Setting Telegram Order Selesai Notifications
if (! function_exists('setNotificationTelegramFinish'))
{
    function setNotificationTelegramFinish($id='')
    {
        $model = new notifications_setting;
        $data  = $model::where('telegram_order_selesai',$id)->first();
        $teleFininsh = $data ? $data->telegram_order_selesai : 'Telegram Notification Order Selesai Tidak Aktif';
        return $teleFininsh;
    }
}