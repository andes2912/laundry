<!DOCTYPE html>
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
            padding:40px;
            width:750px;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size:28px;
            margin-bottom:15px;
        }
        table{
            border:1px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:740px;
        }
        td, tr, th{
            padding:12px;
            border:1px solid #333;
            width:185px;
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
    <div class="container">
        <table>
            <caption>
                Daengweb Invoice App
            </caption>
            <thead>
                <tr>
                    <th colspan="3">Invoice <strong>#{{ $data->id }}</strong></th>
                    <th>{{ $data->tgl_transaksi }}</th>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Perusahaan: </h4>
                        <p>Daengweb.<br>
                            Jl Sultan Hasanuddin Makassar<br>
                            085343966997<br>
                            support@daengweb.id
                        </p>
                    </td>
                    <td colspan="2">
                        <h4>Pelanggan: </h4>
                        <p>{{ $data->nama }}<br>
                        {{ $data->alamat }}<br>
                        {{ $data->no_elp }} <br>
                        </p>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
                @foreach ($invoice as $item)
                <tr>
                    <td class="text-center">1</td>
                    <td>{{$item->jenis}}</td>
                    <td class="text-right">{{$item->kg}} Kg</td>
                    <td class="text-right">{{Rupiah::getRupiah($item->harga)}} /Kg</td>
                    <td class="text-right">
                        <input type="hidden" value="{{$hitung = $item->kg * $item->harga}}">
                        <p style="color:black">{{Rupiah::getRupiah($hitung)}}</p>
                    </td>
                </tr>
               @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>