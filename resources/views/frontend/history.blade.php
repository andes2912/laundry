@extends('layouts.frontend')
@section('title','History')
@section('header')
  @include('frontend.header')
@endsection
@section('banner')
    <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Berat</th>
                <th>Diskon</th>
                <th>Jumlah</th>
                <th>Tanggal Transaksi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($history[0]['transaksiCustomer'] as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->customer}}</td>
                    <td>{{$item->kg}} Kg</td>
                    <td>{{$item->disc ?? 0}} %</td>
                    <td>Rp {{number_format($item->harga_akhir)}}</td>
                    <td>{{$item->tgl_transaksi}}</td>
                    <td>{{$item->status_order}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
<style>
    td {
        color: black;
    }
</style>
@section('scripts')

@endsection


