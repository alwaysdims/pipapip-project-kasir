<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Laporan Penjualan Bahan</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 10px;
		}

		/* Ukuran font diperkecil karena kolom bertambah */
		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
		}

		th,
		td {
			
			padding: 5px;
		}

		th {
			background: #f2f2f2;
			text-align: center;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.font-bold {
			font-weight: bold;
		}

	</style>
</head>

<body>
<table width="100%" style="margin-bottom:10px;border-collapse:collapse;">
    <tr>
        <td style="vertical-align: top; border:none;">
            <h3 style="margin:0;">LAPORAN PENJUALAN BAHAN</h3>
            <p style="margin:5px 0 0 0;">
                Periode : <b><?= $periode ?></b><br>
                Bahan : <b><?= $bahan_filter ?></b>

            </p>
        </td>
        <td style="text-align:right; vertical-align: top; border:none;">
            <img src="<?= base_url('assets/images/logo.jpg') ?>" 
                 style="height:60px;">
        </td>
    </tr>
</table>



	<table>
		<thead>
			<tr>
				<th style="border: 1px solid #000;">No</th>
				<th style="border: 1px solid #000;">Tanggal</th>
				<th style="border: 1px solid #000;">Kode Transaksi</th>
				<th style="border: 1px solid #000;">Customer</th>
				<th style="border: 1px solid #000;">Kode Bahan</th>
				<th style="border: 1px solid #000;">Nama Bahan</th>
				<th style="border: 1px solid #000;">Qty</th>
				<th style="border: 1px solid #000;" class="text-right">Total Beli</th>
				<th style="border: 1px solid #000;" class="text-right">Total Jual</th>
				<th style="border: 1px solid #000;" class="text-right">Margin (Rp)</th>
				<th style="border: 1px solid #000;" class="text-right">%</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($transaksi)): ?>
			<?php $no = 1; foreach ($transaksi as $row): 
                $sub_beli = $row->harga_beli * $row->jumlah;
                $sub_jual = $row->harga_jual * $row->jumlah;
                $sub_margin = $sub_jual - $sub_beli;
                $sub_persen = ($sub_jual > 0) ? ($sub_margin / $sub_jual) * 100 : 0;
            ?>
			<tr>
				<td style="border: 1px solid #000;" class="text-center"><?= $no++ ?></td>
				<td style="border: 1px solid #000;"><?= date('D, d M Y', strtotime($row->tanggal)) ?></td>
				<td style="border: 1px solid #000;"><?= $row->kode_transaksi ?></td>
				<td style="border: 1px solid #000;"><?= $row->nama_customer ?? '-' ?></td>
				<td style="border: 1px solid #000;"><?= $row->kode_bahan ?></td>
				<td style="border: 1px solid #000;"><?= $row->nama_bahan ?></td>
				<td style="border: 1px solid #000;" class="text-center"><?= $row->jumlah ?></td>
				<td style="border: 1px solid #000;" class="text-right">Rp <?= number_format($sub_beli, 0, ',', '.') ?></td>
				<td style="border: 1px solid #000;" class="text-right">Rp <?= number_format($sub_jual, 0, ',', '.') ?></td>
				<td style="border: 1px solid #000;" class="text-right">Rp <?= number_format($sub_margin, 0, ',', '.') ?></td>
				<td style="border: 1px solid #000;" class="text-right"><?= number_format($sub_persen, 2, ',', '.') ?>%</td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td style="border: 1px solid #000;" colspan="11" class="text-center">Tidak ada data ditemukan</td>
			</tr>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<tr class="font-bold" style="background: #f9f9f9;">
				<td style="border: 1px solid #000;" colspan="7" class="text-right">TOTAL KESELURUHAN</td>
				<td style="border: 1px solid #000;" class="text-right">Rp <?= number_format($total_beli, 0, ',', '.') ?></td>
				<td style="border: 1px solid #000;" class="text-right">Rp <?= number_format($total_jual, 0, ',', '.') ?></td>
				<td style="border: 1px solid #000;" class="text-right">Rp <?= number_format($margin, 0, ',', '.') ?></td>
				<td style="border: 1px solid #000;" class="text-right"><?= number_format($persentase, 2, ',', '.') ?>%</td>
			</tr>
		</tfoot>
	</table>

</body>

</html>
