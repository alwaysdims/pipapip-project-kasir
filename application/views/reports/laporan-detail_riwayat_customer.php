<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $transaksi->kode_transaksi ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #333; margin: 20px; }
        
        /* Layout Header */
        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 20px;
        }
        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }
        
        .invoice-title { font-size: 18px; font-weight: bold; margin: 0; }
        .logo-img { max-height: 50px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f2f2f2; text-align: center; font-weight: bold; }
        
        .right { text-align: right; }
        .center { text-align: center; }
        .total-box { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="invoice-title">INVOICE</div>
                <p style="margin: 5px 0 0 0;">
                    No Nota: <b><?= $transaksi->kode_transaksi ?></b><br>
                    Tanggal: <?= date('d M Y', strtotime($transaksi->tanggal)) ?>
                </p>
            </td>
            <td class="right">
                <img src="<?= base_url('assets/images/logo.jpg') ?>" class="logo-img" alt="Logo">
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>NAMA BARANG</th>
                <th class="right">QTY</th>
                <th class="right">HARGA BELI</th>
                <th class="right">JUMLAH BELI</th>
                <th class="right">HARGA JUAL</th>
                <th class="right">JUMLAH JUAL</th>
                <th class="right">MARGIN</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total_margin = 0;
            foreach ($details as $dt):
                $jml_beli = $dt->harga_beli * $dt->jumlah;
                $jml_jual = $dt->harga_jual * $dt->jumlah;
                $margin   = $jml_jual - $jml_beli;
                $total_margin += $margin;
            ?>
            <tr>
                <td class="center"><?= $no++ ?></td>
                <td><?= $dt->nama_bahan ?></td>
                <td class="right"><?= str_replace('.', ',', (float)$dt->jumlah) ?></td>
                <td class="right">Rp <?= number_format($dt->harga_beli, 0, ',', '.') ?></td>
                <td class="right">Rp <?= number_format($jml_beli, 0, ',', '.') ?></td>
                <td class="right">Rp <?= number_format($dt->harga_jual, 0, ',', '.') ?></td>
                <td class="right">Rp <?= number_format($jml_jual, 0, ',', '.') ?></td>
                <td class="right">Rp <?= number_format($margin, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-box">
        <div style="margin-bottom: 5px;">Total Margin: <b>Rp <?= number_format($total_margin, 0, ',', '.') ?></b></div>
        <div>
            <div>Total Jual: </div>
            <b>Rp <?= number_format($transaksi->total_jual, 0, ',', '.') ?></b>
        </div>
    </div>

</body>
</html>
