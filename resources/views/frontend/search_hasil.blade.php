<div class="row">
    <div class="col-lg-3">
        <p class="text">Customer</p>
        <p class="font" id="customer"> {{$search->customers->name}} </p>
    </div>
    <div class="col-lg-3">
        <p class="text">Tgl Transaksi</p>
        <p class="font" id="tgl_transaksi">{{$search->tgl_transaksi}}</p>
    </div>
    <div class="col-lg-3">
        <p class="text">Status</p>
        <p class="font" id="status_order">{{$search->status_order}}</p>
    </div>
    <div class="col-lg-3">
        <p class="text">History</p>
        <p class="font" id="status_order">
            <a href="{{url('history', $search->customers->no_telp)}}">Lihat</a></p>
    </div>
</div>

<style>
    .text {
        color: black !important;
        font-weight: bold;
    }

    .font {
        color: slategrey !important;
    }
</style>
