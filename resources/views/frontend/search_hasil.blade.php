<div class="modal_status">
    <div class="modal_window">
        {{-- <div class="title">Hasil Pencarian</div> --}}
            <div class="row">
                <div class="col-lg-5">
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
            </div>
        <br />
    </div>
</div>

<style>
.modal_window > .title{
    font-size: 18px;
    font-weight: bold;
    color: black;
}

.text {
    color: black !important;
    font-weight: bold;
}

.font {
    color: slategrey !important;
}
</style>
