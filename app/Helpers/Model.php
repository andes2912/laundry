<?php
use App\Models\{Notification, User,notifications_setting,transaksi};
use PhpParser\Node\Stmt\Return_;

class Rupiah {
    public static function getRupiah($value) {
        $format = "Rp " . number_format($value,0,',','.');
        return $format;
    }
}

// Get Email Customer by id
if (! function_exists('email_customer'))
{
    function email_customer($id=0)
    {
      $model = new User;
      $data  = $model::where('id',$id)->first();
      $email_customer = !empty($data) ? $data->email : 'Not Found';
      return $email_customer;
    }
}

// Get Nama Customer by id
if (! function_exists('namaCustomer'))
{
    function namaCustomer($id=0)
    {
        $model = new User;
        $data  = $model::where('id',$id)->first();
        $name = !empty($data) ? $data->name : 'Not Found';
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

// Get Telegram Channel untuk order masuk
if (! function_exists('telegram_channel_masuk'))
{
    function telegram_channel_masuk()
    {
        $model = new notifications_setting;
        $data  = $model::first();
        $channel_masuk = $data ? $data->telegram_channel_masuk : NULL;
        return $channel_masuk;
    }
}

// Get Telegram Channel untuk order selesai
if (! function_exists('telegram_channel_selesai'))
{
    function telegram_channel_selesai()
    {
        $model = new notifications_setting;
        $data  = $model::first();
        $channel_selesai = $data ? $data->telegram_channel_selesai : NULL;
        return $channel_selesai;
    }
}

// Setting WhatsApp Notification order selesai
if (! function_exists('setNotificationWhatsappOrderSelesai'))
{
    function setNotificationWhatsappOrderSelesai($id='')
    {
        $model = new notifications_setting;
        $data  = $model::where('wa_order_selesai',$id)->first();
        $whatsappFinish = $data ? $data->wa_order_selesai : 'WhatsApp Notification Order Selesai Tidak Aktif';
        return $whatsappFinish;
    }
}

// Get WhatsApp Notifikasi order selesai
if (! function_exists('wa_order_selesai'))
{
    function wa_order_selesai()
    {
        $model = new notifications_setting;
        $data  = $model::first();
        $channel_selesai = $data ? $data->wa_order_selesai : NULL;
        return $channel_selesai;
    }
}

// Get Token WhatsApp
if (! function_exists('getTokenWhatsapp'))
{
    function getTokenWhatsapp()
    {
        $model = new notifications_setting;
        $data  = $model::first();
        $channel_selesai = $data ? $data->wa_token : NULL;
        return $channel_selesai;
    }
}

// Notifikasi Whatsapp
if (! function_exists('notificationWhatsapp'))
{
    /**
     * Kirim notifikasi WhatsApp via gateway terkonfigurasi.
     * Provider didukung: kirimwa | fonnte | wablas | wa_cloud
     *
     * - $token  : token autentikasi (semua provider butuh)
     * - $waphone: nomor tujuan (format tergantung provider, lihat helper text di UI)
     * - $pesan  : isi pesan teks
     *
     * Return: ['ok' => bool, 'code' => int, 'body' => array, 'error' => string?]
     */
    function notificationWhatsapp($token, $waphone, $pesan)
    {
        $cfg      = \App\Models\notifications_setting::first();
        $provider = $cfg && $cfg->wa_provider ? $cfg->wa_provider : 'kirimwa';
        $url      = $cfg && $cfg->wa_gateway_url ? $cfg->wa_gateway_url : null;
        $deviceId = $cfg && $cfg->wa_device_id   ? $cfg->wa_device_id   : null;

        // Per-provider mapping
        switch ($provider) {
            case 'fonnte':
                // https://docs.fonnte.com
                $url     = $url ?: 'https://api.fonnte.com/send';
                $headers = ['Authorization' => $token];
                $body    = ['target' => $waphone, 'message' => $pesan];
                $form    = 'form_params';
                break;

            case 'wablas':
                // https://wablas.com — region URL biasanya beda (jkt, sg), wajib disetel di wa_gateway_url
                $url     = $url ?: 'https://console.wablas.com/api/send-message';
                $headers = ['Authorization' => $token];
                $body    = ['phone' => $waphone, 'message' => $pesan];
                $form    = 'form_params';
                break;

            case 'wa_cloud':
                // Meta WhatsApp Cloud API
                // wa_device_id dipakai sebagai phone_number_id
                $phoneNumberId = $deviceId;
                if (!$phoneNumberId) {
                    return ['ok' => false, 'error' => 'WA Cloud API butuh Phone Number ID di field "Device ID".'];
                }
                $url     = $url ?: ('https://graph.facebook.com/v18.0/' . $phoneNumberId . '/messages');
                $headers = ['Authorization' => 'Bearer ' . $token, 'Content-Type' => 'application/json'];
                $body    = [
                    'messaging_product' => 'whatsapp',
                    'to'                => $waphone,
                    'type'              => 'text',
                    'text'              => ['body' => $pesan],
                ];
                $form    = 'json';
                break;

            case 'kirimwa':
            default:
                $url     = $url ?: 'https://api.kirimwa.id/v1/messages';
                $headers = ['Authorization' => 'Bearer ' . $token, 'Content-Type' => 'application/json'];
                $body    = [
                    'message'      => $pesan,
                    'phone_number' => $waphone,
                    'message_type' => 'text',
                    'device_id'    => $deviceId ?: 'iphone',
                ];
                $form    = 'json';
                break;
        }

        try {
            $client   = new \GuzzleHttp\Client(['timeout' => 10]);
            $options  = ['headers' => $headers, 'http_errors' => false];
            $options[$form] = $body;
            $response = $client->request('POST', $url, $options);
            return [
                'ok'       => $response->getStatusCode() < 300,
                'code'     => $response->getStatusCode(),
                'body'     => json_decode($response->getBody(), true),
                'provider' => $provider,
            ];
        } catch (\Throwable $e) {
            \Log::warning("WhatsApp notif failed (provider={$provider}): ".$e->getMessage());
            return ['ok' => false, 'error' => $e->getMessage(), 'provider' => $provider];
        }
    }
}

// Get Notifikasi
function getNotifikasi($user_id)
{
    $model = new Notification;
    $data = $model::where('user_id',$user_id)->where('is_read',0)->orderBy('created_at','desc')->get();
    return $data;
}

// Send Notif
function sendNotification($id=null, $user_id=null, $kategori=null, $title=null, $body=null)
{
    $notif = new Notification;
    $notif->transaksi_id    = $id ?? null;
    $notif->user_id         = $user_id ?? null;
    $notif->kategori        = $kategori;
    $notif->title           = $title;
    $notif->body            = $body;
    $notif->save();

    return $notif;
}
