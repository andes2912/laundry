@php
    $total_colspan = 11;
    $no = 0;
@endphp
<table class="table table-hover table-bordered">
    <thead>
       <tr>
            <th colspan="{{ $total_colspan }}" style="text-align: center;"><b>LAPORAN LAUNDRY</b></th>
        </tr>
        <tr>
            <th colspan="{{ $total_colspan }}" style="text-align: center;"><b>{{strtoupper(Auth::user()->name)}}</b></th>
        </tr>
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th><b>No</b></th>
            <th colspan="2"><b>Customer</b></th>
            <th colspan="2"><b>Jenis Laundry</b></th>
            <th colspan="2"><b>Jenis Pembayaran</b></th>
            <th colspan="2"><b>Total</b></th>
        </tr>
    </thead>
    <tbody>
       @foreach ($data as $key => $items)
          <tr>
            <td> {{$key+1}}  </td>
            <td colspan="2"> {{$items->customer}} </td>
            <td colspan="2"> {{$items->price->jenis}} </td>
            <td colspan="2"> {{$items->jenis_pembayaran}} </td>
            <td colspan="2"> {{$items->harga_akhir}} </td>
          </tr>
       @endforeach
    </tbody>
</table>