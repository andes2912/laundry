@extends('layouts.frontend')
@section('title','Selamat Datang')
@section('header')
  @include('frontend.header')
@endsection
@section('banner')
{{-- banner --}}
    @include('frontend.banner')
{{-- End banner --}}
@endsection

@section('content')
    @include('frontend.content')
@endsection

@section('footer')
  @include('frontend.footer')

{{-- Whatsapp Button Start--}}
  <a href="https://wa.me/{{$setpage->whatsapp ?? ''}}" target="blank_">
    <img src="{{asset('frontend/img/wa.png')}}" class="wabutton" alt="WhatsApp-Button">
  </a>
{{-- End: Whatsapp Button --}}
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).on('click', '.search-btn', function(e){
      _curr_val = $('#search_status').val();
      $('#search_status').val(_curr_val + $(this).html());
  });

  $(document).on('click', '#search-btn', function (e) {
      var search_status = $("#search_status").val();
      $.get('pencarian-laundry',{'_token': $('meta[name=csrf-token]').attr('content'),search_status:search_status}, function(resp){
            if (resp != 0) {
                  $(".modal_status").show();
                  $("#customer").html(resp.customer);
                  $("#tgl_transaksi").html(resp.tgl_transaksi);
                  $("#status_order").html(resp.status_order);
            }else{
                swal({html: "No Invoice Tidak Terdaftar!"})
            }
      });
  });
  function close_dlgs(){
        $(".modal_status").hide();
        $("#search_status").val("");
  }
</script>
@endsection