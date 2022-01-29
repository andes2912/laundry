@extends('layouts.backend')
@section('title','Tentang Aplikasi | Dokumentasi Aplikasi Laundry')
@section('content')
  <section id="knowledge-base-question">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-12 order-1 order-md-2">
          <div class="card">
              <img src=" {{asset('backend/images/doc/laundry-banner.png')}}">
              <div class="card-body">
                  <h4 class="card-title mb-1">
                      <i data-feather="smartphone" class="font-medium-5 mr-25"></i>
                      <span>Aplikasi Laundry</span> <hr>
                  </h4>
                  <p>
                    Halo, ini adalah aplikasi Laundry yang dibangun dengan Framwork Laravel. Aplikasi ini sudah bisa multi toko, dengan kata lain kamu bisa membuat cabang laundry. <br>
                    <h5>Sekilas Utas</h5>
                    Aplikasi Laundry mulai di develop di tahun 2019, pada saat itu aplikasi ini dibuat hanya untuk keperluan protofolio saja. Seiring dengan berjalan nya waktu aplikasi ini mulai di kenal banyak orang. Akhirnya saya memutuskan untuk menambah fitur-fitur baru serta memperbaiki hal-hal yang kurang demi kenyamanan pengguna nya. <br> <br>

                    <h5>Ucapan Terima Kasih</h5>
                    Saya ingin mengucapkan terima kasih kepada teman-teman yang sudah menggunakan aplikasi Laundry sebagai bahan belajar atau digunakan untuk keperluan pribadi sebagai penunjang usaha Laundry kalian. Terima kasih juga untuk teman-teman yang sudah membagikan sedikit rezeki nya kepada saya melalu <a href="https://saweria.co/andes2912">Saweria</a>, dukungan kalian amat sangat berharga buat saya.
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