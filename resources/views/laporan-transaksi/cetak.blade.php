<!DOCTYPE html>
<html>
<head>
	<title> Laporan </title>
	<style type="text/css">
		table {
		  border-collapse: collapse;
		}

		table, th, td {
			border: 1px solid black; padding: 5px;
		}

		.page-break {
		    page-break-after: always;
		}

		hr {
		       display: block;
		       position: relative;
		       padding: 0;
		       margin: 8px auto;
		       height: 0;
		       width: 100%;
		       max-height: 0;
		       font-size: 1px;
		       line-height: 0;
		       clear: both;
		       border: none;
		       border-top: 1px solid #aaaaaa;
		       border-bottom: 1px solid #ffffff;
		}
	</style>
</head>
<body>

	<h3 style="text-align: center; padding-bottom: 20px"> Laporan Transaksi Al Barr Baby SPA {{ $date_start }} Sampai {{ $date_end }} </h3>

	<table style="width:100%" class="fixed">

      <thead>
            <tr>
                  <th style="width: 5%">No</th>
                  <th>Nama Customer</th>
                  <th>Layanan Diambil</th>
                  <th>Ditangani Oleh</th>
                  <th>Tanggal</th>
                  <th>Total Bayar</th>
            </tr>
      </thead>
      <tbody>
      
      <?php $numb = 1; ?>

      @foreach($data as $key => $transaksi_data)

      <tr>
            <td> {{ $numb++ }}</td>
            <td>{{ $transaksi_data->nama_customer }}</td>
            <td>{{ $transaksi_data->daftar_layanan }}</td>
            <td>{{ $transaksi_data->nama_terapis }}</td>
            <td>{{ $transaksi->formatDate($transaksi_data->date) }}</td>
            <td>{{ $transaksi_data->total_harga }}</td>
      </tr>

      @endforeach

      <tr>
      <td colspan="4"><strong>Jumlah</strong></td>
      <td colspan="2">{{ $total_invoice }}</td>
      </tr>
    
    </tbody>
  </table>


</body>
</html>