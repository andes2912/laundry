<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

  <head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700" rel="stylesheet" media="screen">
    <style>
      .hover-underline:hover {
        text-decoration: underline !important;
      }

      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }

      @keyframes ping {

        75%,
        100% {
          transform: scale(2);
          opacity: 0;
        }
      }

      @keyframes pulse {
        50% {
          opacity: .5;
        }
      }

      @keyframes bounce {

        0%,
        100% {
          transform: translateY(-25%);
          animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
        }

        50% {
          transform: none;
          animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }
      }

      @media (max-width: 600px) {
        .sm-px-24 {
          padding-left: 24px !important;
          padding-right: 24px !important;
        }

        .sm-py-32 {
          padding-top: 32px !important;
          padding-bottom: 32px !important;
        }

        .sm-w-full {
          width: 100% !important;
        }
      }
    </style>
  </head>

  <body style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased;">
    <div role="article" aria-roledescription="email" aria-label="" lang="en">
      <table style="font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
          <td align="center" style="--bg-opacity: 1; background-color: #eceff1; background-color: rgba(236, 239, 241, var(--bg-opacity)); font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;" bgcolor="rgba(236, 239, 241, var(--bg-opacity))">
            <table class="sm-w-full" style="font-family: 'Montserrat',Arial,sans-serif; width: 600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
              <tr>
                <td align="center" class="sm-px-24" style="font-family: 'Montserrat',Arial,sans-serif;">
                  <table style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                      <td class="sm-px-24" style="--bg-opacity: 1; background-color: #ffffff; background-color: rgba(255, 255, 255, var(--bg-opacity)); border-radius: 4px; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 14px; line-height: 24px; padding: 48px; text-align: left; --text-opacity: 1; color: #626262; color: rgba(98, 98, 98, var(--text-opacity));" bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
                        <p style="font-weight: 600; font-size: 18px; margin-bottom: 0;">Halo Kak,</p>
                        <p style="font-weight: 700; font-size: 20px; margin-top: 0; --text-opacity: 1; color: #ff5850; color: rgba(255, 88, 80, var(--text-opacity));">{{$data['customer']}}</p>

                        <p style="font-size: 14px; line-height: 24px; margin-top: 6px; margin-bottom: 20px;">
                          Terima kasih sudah mempercayakan pakaian kakak kepada kami, berikut ini adalah invoice untuk Laundry kakak. Untuk mengetahui status Laundry, kakak bisa mengecek nya melalui halaman Dashboard.
                        </p>
                        <table style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td style="font-family: 'Montserrat',Arial,sans-serif;">
                              <h3 style="font-weight: 700; font-size: 12px; margin-top: 0; text-align: left;">Invoice {{$data['invoice']}}</h3>
                            </td>
                            <td style="font-family: 'Montserrat',Arial,sans-serif;">
                              <h3 style="font-weight: 700; font-size: 12px; margin-top: 0; text-align: right;">
                                {{$data['tgl_transaksi']}}
                              </h3>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3" style="font-family: 'Montserrat',Arial,sans-serif;">
                              <table style="font-family: 'Montserrat',Arial,sans-serif; width: 100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tbody>
                                  <tr>
                                      <th class="text-center">#</th>
                                      <th>Jenis Pakaian</th>
                                      <th class="text-right">Berat</th>
                                      <th class="text-right">Harga</th>
                                      <th class="text-right">Total</th>
                                  </tr>
                                  <tr>
                                      <td style="color:black">1</td>
                                      <td style="color:black">{{$data['pakaian']}}</td>
                                      <td style="color:black">{{$data['berat']}} Kg</td>
                                      <td style="color:black">Rp. {{number_format($data['harga'],0,",",".")}} /Kg</td>
                                      <td>
                                        <p style="color:black">Rp. {{number_format($data['total'],0,",",".")}}</p>
                                      </td>
                                  </tr>
                                  <tr>
                                    <th colspan="4">
                                      Diskon {{$data['disc'] == null || 0 ? '0' : $data['disc']}} %
                                    </th>
                                      <td style="color:black">
                                       Rp. {{number_format($data['harga_disc'],0,",",".")}}
                                      </td>
                                  </tr>
                                  <tr>
                                    <th colspan="4">Total Bayar</th>
                                    <td style="color:black; font-weight:bold">Rp. {{number_format($data['harga_akhir'],0,",",".")}}</td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <br>
                        <p style="font-size: 12px; font-weight:bold; color:black">
                        <h5>Metode Pembayaran :</h5>
                          <ol>
                            @foreach ($data['bank'] as $banks)
                              <li> {{$banks->nama_bank}} <br> {{$banks->no_rekening}} a/n {{$banks->nama_pemilik}}</li>
                            @endforeach
                          </ol>
                        </p>
                        <br>
                        <p style="font-size: 14px; line-height: 24px; margin-top: 6px; margin-bottom: 20px;">
                          Jika kakak memiliki pertanyaan tentang invoice ini, cukup balas email ini atau hubungi tim dukungan kami untuk mendapatkan bantuan.
                        </p>
                        <p style="font-size: 14px; line-height: 24px; margin-top: 6px; margin-bottom: 20px;">
                          Cheers,
                          <br>{{$data['laundry_name']}} Team
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </body>

</html>