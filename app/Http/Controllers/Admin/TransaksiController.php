<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{transaksi,user};
use Rupiah;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $transaksi = transaksi::with('price')
      ->orderBy('created_at','desc')->get();

      $filter = User::select('id','name')->where('auth','Karyawan')->get();

      return view('modul_admin.transaksi.index', compact('transaksi','filter'));
    }

    // Filter Transaksi
    public function filtertransaksi(Request $request)
    {
      if ($request->user_id != 'all') {
        $transaksi = transaksi::with('price')
        ->where('user_id', $request->user_id)
        ->orderBy('created_at','desc')
        ->get();
      }elseif($request->user_id == 'all') {
        $transaksi = transaksi::with('price')
        ->orderBy('created_at','desc')
        ->get();
      }


      $return = "";
      $no=1;
      foreach($transaksi as $item) {
        $return .="<tr>
          <td>".$no."</td>
          <td>".$item->tgl_transaksi."</td>
          <td>".$item->customer."</td>
          <td>".$item->status_order."</td>
          <td>".$item->status_payment."</td>
          <td>".$item->price->jenis."</td>";
          $return .="
          <input type='hidden' value='".$item->kg * $item->harga."'>
          <td>".Rupiah::getRupiah($item->kg * $item->harga)."</td>
          ";
          if ($item->status_order == "Delivery"){
              $return .="<td><a href='invoice-customer/$item->id' class='btn btn-sm btn-success style='color:white'>Invoice</a>
              <a class='btn btn-sm btn-info' style='color:white'>Detail</a></td>";
          }
          elseif($item->status_order == "Done")
          {
            $return .="<td> <a href='invoice-customer/$item->id' class='btn btn-sm btn-success' style='color:white'>Invoice</a>
            <a class='btn btn-sm btn-info' style='color:white'>Detail</a></td>";
          }
          elseif($item->status_order == "Process")
          {
            $return .="<td> <a href='invoice-customer/$item->id' class='btn btn-sm btn-success' style='color:white'>Invoice</a>
            <a class='btn btn-sm btn-info' style='color:white'>Detail</a></td>";
          }
        $return .= "</td>
        </tr>";
        $no++;
      }
      return $return;
    }

    // Invoice
    public function invoice( Request $request)
    {
      $invoice = transaksi::with('price')
      ->where('invoice', $request->invoice)
      ->orderBy('id','DESC')->get();

      $dataInvoice = transaksi::with('customers.users')
      ->where('invoice', $request->invoice)
      ->first();

      return view('modul_admin.transaksi.invoice', compact('invoice','dataInvoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
