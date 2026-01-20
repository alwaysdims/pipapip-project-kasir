<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
        }

        /* Layout Header */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header-table td {
            vertical-align: middle;
            border: none;
        }

        .logo-container {
            width: 15%;
        }

        .logo-img {
            max-height: 90px;
            width: auto;
            display: block;
        }

        .store-info {
            text-align: left;
            padding-left: 15px;
        }

        .store-box {
            border: 1px dashed #000;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 9px;
            margin-bottom: 6px;
            display: inline-block;
            text-align: center;
        }

        .customer-info {
            width: 32%;
            padding-left: 10px;
        }

        .customer-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .customer-info td {
            padding: 2px 0;
            font-size: 10px;
        }

        .line-bottom {
            border-bottom: 1px dotted #000;
        }

        /* Watermark Container */
        .watermark-container {
            position: relative;
            width: 100%;
        }

        /* Watermark Image */
        .watermark-logo {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: auto;
            opacity: 0.3; /* ATUR OPACITY DI SINI: 0.1, 0.2, 0.3, dll */
            z-index: 1;
            pointer-events: none;
        }

        /* Main Table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            position: relative;
            z-index: 2; /* Lebih tinggi dari watermark */
        }

        .main-table th {
            background-color: #84b56d;
            color: white;
            border: 1px solid #000;
            padding: 8px;
            text-transform: uppercase;
        }

        .main-table td {
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 5px;
            vertical-align: top;
            background-color: transparent;
        }

        .empty-row td {
            height: 350px;
        }

        .footer-total {
            border: 1px solid #000;
            font-weight: bold;
            background: #f2f2f2;
        }

        .total-label {
            text-align: right;
            padding-right: 10px;
        }

        .sig-container {
            margin-top: 20px;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .sig-box {
            width: 40%;
            text-align: center;
            display: inline-block;
        }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td class="logo-container">
                <img src="<?= base_url('assets/images/logo.jpg') ?>" class="logo-img">
            </td>
            <td class="store-info">
                <div class="store-box">
                    <strong>SUPPLIER SAYUR, BUAH LOKAL MAUPUN IMPORT, DAGING SEGAR, DAN SEMBAKO</strong>
                </div>
                <div style="font-size: 10px; line-height: 1.3;">
                    <strong style="font-size: 11px; display: block; margin-bottom: 2px;">Kauman Pasar Legi, Kastalan, Banjarsari, Surakarta</strong>
                    <table style="font-size: 9px; border: none; border-collapse: collapse;">
                        <tr>
                            <td style="width: 48px; border: none; padding: 0;">Whatsapp</td>
                            <td style="width: 8px; border: none; padding: 0;">:</td>
                            <td style="border: none; padding: 0;">089652821177</td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 0;">Email</td>
                            <td style="border: none; padding: 0;">:</td>
                            <td style="border: none; padding: 0;">amdgsuppliersolo@gmail.com</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="customer-info">
                <table style="border-collapse: collapse;">
                    <?php
                        $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $tgl = date('d', strtotime($transaksi->tanggal));
                        $bln = (int)date('m', strtotime($transaksi->tanggal));
                        $thn = date('Y', strtotime($transaksi->tanggal));
                    ?>
                    <tr>
                        <td style="width: 30px;">Tgl</td>
                        <td style="width: 8px;">:</td>
                        <td class="line-bottom"><?= $tgl . ' ' . $bulan[$bln] . ' ' . $thn ?></td>
                    </tr>
                    <tr>
                        <td>Tuan Toko</td>
                        <td>:</td>
                        <td class="line-bottom"><?= htmlspecialchars($transaksi->nama_customer) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="font-weight:bold; padding-top: 10px; white-space: nowrap;">
                            NOTA NO : <span style="font-weight: normal; border-bottom: 1px dotted #000;"><?= $transaksi->kode_transaksi ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Container untuk watermark -->
    <div class="watermark-container">
        <!-- Watermark menggunakan tag <img> -->
        
        <table class="main-table">
			<img src="<?= base_url('assets/images/logo.jpg') ?>" class="watermark-logo" alt="Watermark">
            <thead>
                <tr>
                    <th width="8%">Qty</th>
                    <th width="52%">Nama Barang</th>
                    <th width="20%">Harga</th>
                    <th width="20%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_akhir = 0;
                foreach ($details as $dt): 
                    $subtotal = $dt->harga_jual * $dt->jumlah;
                    $total_akhir += $subtotal;
                ?>
                <tr class="row-item">
                    <td align="left"><?= $dt->jumlah ?> <?= $dt->nama_satuan ?></td>
                    <td><?= $dt->nama_bahan ?></td>
                    <td align="right"><?= number_format($dt->harga_jual, 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>

                <tr class="empty-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="footer-total total-label">Jumlah Rp.</td>
                    <td class="footer-total" align="right"><?= number_format($total_akhir, 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="sig-container">
        <div class="sig-box" style="float: left;">
            Tanda terima,<br><br><br><br>
            ............................
        </div>
        <div class="sig-box" style="float: right;">
            Hormat kami,<br><br><br><br>
            <?= $transaksi->nama_user ?>
        </div>
    </div>
</body>
</html>
