@extends('layouts.backend')
@section('title','Notifikasi | Dokumentasi Aplikasi Laundry')
@section('content')
  <section id="knowledge-base-question">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-12 order-1 order-md-2">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title mb-1">
                      <i data-feather="smartphone" class="font-medium-5 mr-25"></i>
                      <span>Pengaturan Notifikasi Aplikasi Laundry</span> <hr>
                  </h4>
                  <p>
                    <h5>Email Notifikasi</h5>
                    Ada beberapa hal yang harus kalian sesuaikan jika ingin menggunakan email Notifikasi dan saya harap kalian sudah cukup familiar dengan SMTP. Karena jika saya jabarkan akan sangat panjang, silahkan buka tautan ini untuk memperlajari cara penggunaan SMPT, <a href="https://www.twilio.com/blog/send-emails-laravel-8-gmail-smtp-server">link disini.</a> <br><br>

                    <h5>Telegram Notifikasi</h5>
                    Harus kalian ketahui, untuk Telegram Notifikasi ini tidak mengirimkan nya pada setiap customer melainkan pada halaman group yang sudah kalian buat terlebih dahulu. Dengan kata lain notifikasi ini dikirimkan oleh Bot Telegram. Untuk cara membuat Bot Telegram kalian bisa bukan tautan ini, <a href="https://kumparan.com/berita-terkini/cara-membuat-bot-telegram-tak-sampai-5-menit-jadi-mudah-dan-simpel-1v3iKFA8Jkt/full">link disini.</a> <br>
                    Perlu diingat, kalian hanya perlu mendapatkan TOKEN API yang kalian dapatkan saat membuat Bot. Nantinya TOKEN ini yang akan kita integrasikan pada Aplikasi Laundry. <br> <br>
                    <ol>
                      <li>Pergi ke file <code>.env</code> lalu paste <b>TOKEN API</b> pada variable <code>TELEGRAM_BOT_TOKEN</code> </li>
                      <li>Pada halaman <b>Other > Setting > Notifications</b> masukan username Channel Telegram yang sudah kalian buat </li>
                    </ol>
                    <br>

                    <h5>WhatsApp Notifikasi</h5>
                    Pada WhatsApp Notifikasi ini ada beberapa yang harus terpenuhi agar Notifikasi bisa berjalan. Berbeda dengan Telegram Notifikasi, WhatsApp notifikasi akan mengirimkan pemberitahuan secara real time/langsung kepada customer. Untuk hal ini, pemberitahuan yang dikirimkan hanya ketika Laundry sudah selesai atau pada page <b>Data Transaksi > Order Masuk</b> kalian meng-klik button selesai yang hanya bisa dilakukan jika kalian Login sebagai Karyawan. <br>
                    Pada kasus ini saya menggunakan API dari <a href="https://developer.kirimwa.id/">KirimWA.id</a>, ini adalah sebuah layanan unofficial WhatsApp API Gateway. <br><br>
                    <ol>
                      <li>Pastikan kalian sudah mendaftar terlebih dahulu untuk mendapatkan TOKEN nya, <a href="https://developer.kirimwa.id/#register">daftar disini.</a></li>
                      <li><b>Copy</b> dan <b>Paste</b> TOKEN yang sudah di dapat pada halaman <b>Other > Setting > Notifications</b> </li>
                    </ol>
                  </p>
              </div>
          </div>
      </div>
    </div>
  </section>
  <!-- contact me -->
  <section class="faq-contact">
      <div class="row mt-2 pt-75">
          <div class="col-12 text-center">
              <h2>Punya Pertanyaan ?</h2>
              <p class="mb-3">
              </p>
          </div>
          <div class="col-sm-6">
              <div class="card text-center faq-contact-card shadow-none py-1">
                  <div class="card-body">
                      <div class="avatar avatar-tag bg-light-primary mb-2 mx-auto">
                          <i class="font-medium-3 feather icon-message-circle"></i>
                      </div>
                      <h4><a href="https://t.me/andridesmana">Telegram</a></h4>
                      <span class="text-body">Best way to get answer faster!</span>
                  </div>
              </div>
          </div>
          <div class="col-sm-6">
              <div class="card text-center faq-contact-card shadow-none py-1">
                  <div class="card-body">
                      <div class="avatar avatar-tag bg-light-primary mb-2 mx-auto">
                          <i class="font-medium-3 feather icon-mail"></i>
                      </div>
                      <h4><a href="mailto:andridesmana29@outlook.com">andridesmana29@outlook.com</a> </h4>
                      <span class="text-body">Saya selalu senang mambantu!</span>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!--/ contact me -->
@endsection