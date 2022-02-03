<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size:18px;
            margin:0;
        }
        .container{
            margin:0 auto;
            margin-top:35px;
            padding:0px;
            width:100%;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size:28px;
            margin-bottom:15px;
        }
        table{
            border:0px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:100%;
        }
        td, tr, th{
            padding:12px;
            border:1px solid #333;
            width:auto;
        }
        th{
            background-color: #f0f0f0;
        }
        h4, p{
            margin:0px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <table>
            <thead>
                <tr>
                    <th colspan="4">Invoice <strong>{{$data->invoice}}</strong></th>
                    <th>{{ $data->created_at->format('d-M-Y') }}</th>
                </tr>
                <tr>
                    <td style="padding-bottom:80px" colspan="2">
                        <h3 style="color:coral">{{$data->nama_cabang}}</h3>
                        <p class="text-muted m-l-5"> Diterima Oleh <span style="margin-left:8px"> </span>: {{$data->user->name}}
                            <br/> Alamat <span style="margin-left:62px"> </span>: {{$data->user->alamat_cabang}},
                            <br/> No. Telp <span style="margin-left:50px"> </span>: {{$data->user->no_telp}},
                            </p>
                    </td>
                    <td colspan="3">
                        <h3 style="text-align:right">Detail Order Customer :</h3>
                        <p style="text-align:right">
                            {{$data->customers->nama}}
                            <br/> {{$data->customers->alamat}}
                            <br/> {{$data->customers->no_telp}}</p> <br>
                        <p style="text-align:right"><b>Tanggal Masuk :</b> <i class="fa fa-calendar"></i> {{carbon\carbon::parse($data->tgl_transaksi)->format('d-m-y')}}</p>
                        <p style="text-align:right"><b>Tanggal Diambil :</b> <i class="fa fa-calendar"></i>
                            @if ($data->tgl_ambil == "")
                                Belum Diambil
                            @else
                            {{carbon\carbon::parse($data->tgl_ambil)->format('d-m-y')}}
                            @endif
                        </p>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-center">#</th>
                    <th>Jenis Pakaian</th>
                    <th class="text-right">Berat</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Total</th>
                </tr>
                @foreach ($invoice as $item)
                <tr>
                    <td style="color:black">1</td>
                    <td style="color:black">{{$item->price->jenis}}</td>
                    <td style="color:black">{{$item->kg}} Kg</td>
                    <td style="color:black">{{Rupiah::getRupiah($item->harga)}} /Kg</td>
                    <td><input type="hidden" value="{{$hitung = $item->kg * $item->harga}}">
                        <p style="color:black">{{Rupiah::getRupiah($hitung)}}</p></td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="4">Disc @if ($item->disc == "")
                        0 %
                    @else
                        {{$item->disc}} %
                    @endif </th>
                    <td style="color:black"><input type="hidden" value="{{$disc = ($hitung * $item->disc) / 100}}"> {{Rupiah::getRupiah($disc)}}</td>
                </tr>
                <tr>
                    <th colspan="4">Total Bayar</th>
                    <td style="color:black; font-weight:bold">{{Rupiah::getRupiah($item->harga_akhir)}}</td>
                </tr>
            </tbody>
        </table>
        <h6>Metode Pembayaran :</h6>
        <ol style="font-size: 12px">
          @foreach ($bank as $banks)
            <li style="color: black"> {{$banks->nama_bank}} <br> {{$banks->no_rekening}} a/n {{$banks->nama_pemilik}}</li>
          @endforeach
        </ol>
    </div>
</body>
</html>