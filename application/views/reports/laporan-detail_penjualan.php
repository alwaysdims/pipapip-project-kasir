<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Invoice #<?= $transaksi->kode_transaksi ?></title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
			line-height: 1.6;
			color: #000;
			margin: 20px;
		}

		/* Header Section: Membuat Invoice info dan Logo Simetris */
		.header-container {
			display: table;
			width: 100%;
			margin-bottom: 30px;
			border-collapse: collapse;
		}

		.header-left {
			display: table-cell;
			vertical-align: top;
			text-align: left;
		}

		.header-right {
			display: table-cell;
			vertical-align: top;
			text-align: right;
			width: 1%;
			white-space: nowrap;
		}

		.header-left h1 {
			margin: 0 0 10px 0;
			font-size: 24px;
			line-height: 1;
			text-transform: uppercase;
		}

		.info-nota {
			font-size: 12px;
			line-height: 1.5;
		}

		.logo {
			height: 90px;
			/* Tinggi disesuaikan karena data pelanggan bertambah */
			width: auto;
			display: inline-block;
			object-fit: contain;
		}

		/* Table Utama dengan FULL BORDER */
		.main-table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
		}

		.main-table th,
		.main-table td {
			border: 1px solid #000;
			padding: 8px 5px;
		}

		.main-table th {
			background-color: #f2f2f2;
			text-align: center;
		}

		.main-table tfoot td {
			font-weight: bold;
			background-color: #f9f9f9;
		}

		.right {
			text-align: right;
		}

		.center {
			text-align: center;
		}

		/* Tanda Tangan */
		.signature-wrapper {
			margin-top: 50px;
			width: 100%;
		}

		.signature-table {
			width: 100%;
			border-collapse: collapse;
			border: none !important;
		}

		.signature-table td {
			border: none !important;
			width: 50%;
			text-align: center;
			vertical-align: bottom;
		}

		.signature-space {
			height: 70px;
		}

		.signature-name {
			font-weight: bold;
		}

		/* CSS untuk merapikan titik dua agar sejajar vertikal */
		.table-info-header {
			border-collapse: collapse;
			border: none !important;
		}

		.table-info-header td {
			border: none !important;
			padding: 1px 0;
			/* Jarak antar baris */
			vertical-align: top;
			line-height: 1.4;
		}

		/* Mengatur lebar kolom label agar titik dua terkunci di posisi yang sama */
		.table-info-header td:first-child {
			width: 85px;
			/* Sesuaikan lebar ini jika label Pelanggan/Alamat terpotong */
			white-space: nowrap;
		}

		/* Memberi sedikit jarak antara titik dua dan isi data */
		.table-info-header td:nth-child(2) {
			width: 15px;
			text-align: center;
		}

	</style>
</head>

<body>

	<div class="header-container">
		<div class="header-left">
			<h1>INVOICE</h1>
			<div class="info-nota">
				<?php
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $split = explode('-', date('d-m-Y', strtotime($transaksi->tanggal)));
        $tanggal_indo = $split[0] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[2];
    ?>
				<table class="table-info-header">
					<tr>
						<td><strong>Nomor Nota</strong></td>
						<td><strong>:</strong></td>
						<td><?= $transaksi->kode_transaksi ?></td>
					</tr>
					<tr>
						<td><strong>Tanggal</strong></td>
						<td><strong>:</strong></td>
						<td><?= $tanggal_indo ?></td>
					</tr>
					<tr>
						<td><strong>Pelanggan</strong></td>
						<td><strong>:</strong></td>
						<td><?= htmlspecialchars($transaksi->nama_customer) ?></td>
					</tr>
					<tr>
						<td><strong>No. Telp</strong></td>
						<td><strong>:</strong></td>
						<td><?= htmlspecialchars($transaksi->no_telp_customer) ?: '-' ?></td>
					</tr>
					<tr>
						<td><strong>Alamat</strong></td>
						<td><strong>:</strong></td>
						<td><?= htmlspecialchars($transaksi->alamat_customer) ?: '-' ?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="header-right">
			<img src="<?= base_url('assets/images/logo.jpg') ?>" class="logo" alt="Logo">
		</div>
	</div>

	<table class="main-table">
		<thead>
			<tr>
				<th width="5%">No</th>
				<th width="25%">Nama Produk</th>
				<th width="25%">Deskripsi</th>
				<th width="10%">Kuantitas</th>
				<th width="10%">Unit</th>
				<th width="12%">Harga</th>
				<th width="13%">Total</th>
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
				<td><?= htmlspecialchars($dt->nama_bahan) ?></td>
				<td><?= htmlspecialchars($dt->deskripsi) ?></td>
				<td class="center"><?= $dt->jumlah ?> </td>
				<td class="center"><?= $dt->nama_satuan ?></td>
				<td class="right">Rp <?= number_format($dt->harga_jual, 0, ',', '.') ?></td>
				<td class="right">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6" class="right">Sub Total</td>
				<td class="right">Rp <?= number_format($subtotal_all, 0, ',', '.') ?></td>
			</tr>
		</tfoot>
	</table>

	<div class="signature-wrapper">
		<table class="signature-table">
			<tr>
				<td>
					<p>Pengirim,</p>
					<div class="signature-space"></div>
					<p class="signature-name"><?= htmlspecialchars($transaksi->nama_user) ?> </p>
				</td>
				<td>
					<p>Penerima,</p>
					<div class="signature-space"></div>
					<p class="signature-name"><?= htmlspecialchars($transaksi->nama_customer) ?> </p>
				</td>
			</tr>
		</table>
	</div>

</body>

</html>
