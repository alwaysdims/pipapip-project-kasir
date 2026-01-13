<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        /* Desain Header Baru */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
        }
        .logo-img {
            max-height: 60px; /* Ukuran logo yang proporsional untuk surat jalan */
        }
        
        .info {
            width: 100%;
            margin-bottom: 20px;
        }
        .info td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info .label {
            width: 150px;
            font-weight: bold;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.items th,
        table.items td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        table.items th {
            background-color: #f0f0f0;
            text-align: center;
        }
        table.items .center {
            text-align: center;
        }
        table.items .right {
            text-align: right;
        }
        .footer {
            margin-top: 80px;
            width: 100%;
        }
        .footer td {
            text-align: center;
            padding-top: 20px;
        }
        .page {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="header-title" valign="bottom">Surat Jalan</td>
            <td align="right" valign="top">
                <img src="<?= base_url('assets/images/logo.jpg') ?>" class="logo-img" alt="Logo">
            </td>
        </tr>
    </table>

    <table class="info">
        <tr>
            <td class="label">No. Dokumen</td>
            <td>: <?= $transaksi->kode_transaksi ?></td>
            <td class="label">Tanggal</td>
            <td>: <?= date('d F Y', strtotime($transaksi->tanggal)) ?></td>
        </tr>
        <tr>
            <td class="label">Penerima</td>
            <td>: <?= $transaksi->nama ?></td>
            <td class="label">Telp. Penerima</td>
            <td>: <?= $transaksi->no_telp ?></td>
        </tr>
        <tr>
            <td class="label">Alamat Penerima</td>
            <td colspan="3">: <?= $transaksi->alamat ?></td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Produk</th>
                <th style="width: 20%;">Deskripsi</th>
                <th style="width: 10%;">Kuantitas</th>
                <th style="width: 10%;">Unit</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($details as $dt): ?>
            <tr>
                <td class="center"><?= $no++ ?></td>
                <td><?= $dt->nama_bahan ?></td>
                <td><?= $dt->deskripsi ?: '-' ?></td>
                <td class="center"><?= $dt->jumlah ?></td>
                <td class="center"><?= $dt->nama_satuan ?: '-' ?></td>
            </tr>
            <?php endforeach; ?>
            <?php 
            for ($i = $no; $i <= 2; $i++): ?>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; font-weight: bold; border-bottom: 1px solid #ccc; width: 60px;">Catatan : </div>

    <table class="footer">
        <tr>
            <td width="50%">
                Pengirim<br><br><br><br><br><br>
                <b>( <?= $transaksi->pengirim_username ?> )</b>
            </td>
            <td width="50%">
                Penerima<br><br><br><br><br><br>
                <b>( <?= $transaksi->nama ?> )</b>
            </td>
        </tr>
    </table>

    <div class="page">1/1</div>

</body>
</html>
