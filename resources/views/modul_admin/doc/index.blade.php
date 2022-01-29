@extends('layouts.backend')
@section('title','Dokumentasi Aplikasi Laundry')
@section('content')

  <section id="knowledge-base-search">
      <div class="row">
          <div class="col-12">
              <div class="card knowledge-base-bg text-center" style="background-image: url({{asset('backend/images/pages/banner.png')}}">
                  <div class="card-body">
                      <h2 class="text-primary">Dokumentasi Penggunaan Aplikasi Laundry</h2>
                      <p class="card-text mb-2">
                          <span>Halo, halaman ini digunakan untuk keperluan dokumentasi penggunaan pada pada aplikasi Laundry. Dokumentasi ini dibuat untuk mempermudah teman-teman dalam penggunaan aplikasi Laundry.</span>
                      </p>
                  </div>
              </div>
          </div>
      </div>
  </section>


  <!-- Dokumentasi -->
  <section id="knowledge-base-content">
    <div class="row kb-search-content-info match-height">
      <!-- Tentang Laundry -->
      <div class="col-md-4 col-sm-6 col-12 kb-search-content">
          <div class="card">
              <a href="{{url('dokumentasi/tentang')}}">
                  <div class="card-body text-center">
                      <h4>Tentang Aplikasin Laundry</h4>
                      <p class="text-body mt-1 mb-0">
                          Beberapa hal yang perlu diketahui tentang Aplikasi Laundry.
                      </p>
                  </div>
              </a>
          </div>
      </div>

      <!-- Instalasi & Penggunaan -->
      <div class="col-md-4 col-sm-6 col-12 kb-search-content">
          <div class="card">
              <a href="{{url('dokumentasi/instalasi-penggunaan')}}">
                  <div class="card-body text-center">
                      <h4>Instalasi dan Penggunaan</h4>
                      <p class="text-body mt-1 mb-0">
                          Beberapa hal yang perlu diketahui tentang Instalasi dan Penggunaan.
                      </p>
                  </div>
              </a>
          </div>
      </div>

      <!-- Notifikasi -->
      <div class="col-md-4 col-sm-6 col-12 kb-search-content">
        <div class="card">
            <a href="{{url('dokumentasi/notifikasi')}}">
                <div class="card-body text-center">
                    <h4>Notifikasi</h4>
                    <p class="text-body mt-1 mb-0">
                        Beberapa hal yang perlu diketahui untuk penggunaan Notifikasi.
                    </p>
                </div>
            </a>
        </div>
      </div>

      {{-- <!-- Version dan Pembaruan -->
      <div class="col-md-4 col-sm-6 col-12 kb-search-content">
        <div class="card">
            <a href="{{url('dokumentasi/versi')}}">
                <div class="card-body text-center">
                    <h4>Version dan Pembaruan</h4>
                    <p class="text-body mt-1 mb-0">
                        Beberapa hal yang perlu diketahui tentang Version dan Pembaruan.
                    </p>
                </div>
            </a>
        </div>
      </div> --}}

    </div>
  </section>
  <!-- Dokumentasi ends -->

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