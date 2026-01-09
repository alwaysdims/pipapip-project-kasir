<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Invoice #<?= $transaksi->kode_transaksi ?></title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
		}

		h2 {
			margin-bottom: 5px;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 15px;
		}

		th,
		td {
			border: 1px solid #000;
			padding: 6px;
		}

		th {
			background: #f2f2f2;
		}

		.right {
			text-align: right;
		}

		.center {
			text-align: center;
		}

	</style>
</head>

<body>

	<h2>INVOICE</h2>
	<p>
		Receipt #: <b><?= $transaksi->kode_transaksi ?></b><br>
		Tanggal: <?= date('d M Y', strtotime($transaksi->tanggal)) ?>
	</p>

	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>KODE SKU</th>
				<th>NAMA</th>
				<th>DESCRIPTION</th>
				<th class="right">QTY</th>
				<th class="right">HARGA</th>
				<th class="right">SUBTOTAL</th>
			</tr>
		</thead>
		<tbody>
			<?php
$no = 1;
$subtotal_all = 0;
foreach ($details as $dt):
    $subtotal = $dt->harga_jual * $dt->jumlah;
    $subtotal_all += $subtotal;
?>
			<tr>
				<td class="center"><?= $no++ ?></td>
				<td><?= $dt->kode_bahan ?></td>
				<td><?= $dt->nama_bahan ?></td>
				<td><?= $dt->deskripsi ?></td>
				<td class="right">
					<?= $dt->jumlah . ' ' . $dt->nama_satuan ?>
				</td>
				<td class="right">
					Rp <?= number_format($dt->harga_jual, 0, ',', '.') ?>
				</td>
				<td class="right">
					Rp <?= number_format($subtotal, 0, ',', '.') ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>

		<tfoot>
			<tr>
				<td colspan="6" class="right"><b>SUB TOTAL</b></td>
				<td class="right"><b>Rp <?= number_format($subtotal_all, 0, ',', '.') ?></b></td>
			</tr>
		</tfoot>
	</table>


</body>

</html>
