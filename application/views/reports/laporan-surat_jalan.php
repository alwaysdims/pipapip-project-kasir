<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #000;
        }

        /* Header Layout */
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

        /* Header Content */
        .header-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 10px 0;
            line-height: 1;
        }
        .logo-img {
            height: 80px;
            width: auto;
            display: block;
        }

        /* Info Table (Nomor Nota, Tanggal, dll) */
        .info-table {
            border-collapse: collapse;
            border: none;
        }
        .info-table td {
            padding: 2px 0;
            vertical-align: top;
            line-height: 1.4;
        }
        .info-table td.label {
            font-weight: bold;
            width: 100px;
        }
        .info-table td.separator {
            width: 15px;
            text-align: center;
        }

        /* Items Table */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.items th, 
        table.items td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        table.items th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        table.items .center {
            text-align: center;
        }

        /* Footer & Signatures */
        .footer {
            margin-top: 80px;
            width: 100%;
            border-collapse: collapse;
        }
        .footer td {
            text-align: center;
            width: 50%;
            vertical-align: bottom;
        }
        .footer b {
            display: block;
            margin-top: 60px;
        }

        /* Page Number */
        .page {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <div class="header-left">
            <h1 class="header-title">Surat Jalan</h1>
            
            <?php
                $bulan = [
                    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                $split = explode('-', date('d-m-Y', strtotime($transaksi->tanggal)));
                $tanggal_indo = $split[0] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[2];
            ?>

            <table class="info-table">
                <tr>
                    <td class="label">Nomor Nota</td>
                    <td class="separator">:</td>
                    <td><?= $transaksi->kode_transaksi ?></td>
                </tr>
                <tr>
                    <td class="label">Tanggal</td>
                    <td class="separator">:</td>
                    <td><?= $tanggal_indo ?></td>
                </tr>
                <tr>
                    <td class="label">Penerima</td>
                    <td class="separator">:</td>
                    <td><?= htmlspecialchars($transaksi->nama) ?></td>
                </tr>
                <tr>
                    <td class="label">No. Telp</td>
                    <td class="separator">:</td>
                    <td><?= htmlspecialchars($transaksi->no_telp) ?: '-' ?></td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td class="separator">:</td>
                    <td><?= htmlspecialchars($transaksi->alamat) ?></td>
                </tr>
            </table>
        </div>
        <div class="header-right">
            <img src="<?= base_url('assets/images/logo.jpg') ?>" class="logo-img" alt="Logo">
        </div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Nama Produk</th>
                <th style="width: 30%;">Deskripsi</th>
                <th style="width: 15%;">Kuantitas</th>
                <th style="width: 15%;">Unit</th>
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
            
            <?php /* Baris kosong tambahan jika item sedikit */
            for ($i = $no; $i <= 2; $i++): ?>
            <tr>
                <td class="center">&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <table style="margin-top:30px; width:100%; border-collapse: collapse;">
        <tr>
            <td style="font-weight:bold; width:80px; vertical-align: top;">Catatan :</td>
            <td style="vertical-align: top; ">
                <?= $transaksi->catatan ?: '-' ?>
            </td>
        </tr>
    </table>

    <table class="footer">
        <tr>
            <td>
                Pengirim
                <b><?= $transaksi->pengirim_username ?></b>
            </td>
            <td>
                Penerima
                <b><?= htmlspecialchars($transaksi->nama) ?></b>
            </td>
        </tr>
    </table>

</body>
</html>
