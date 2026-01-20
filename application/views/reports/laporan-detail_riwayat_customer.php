<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $transaksi->kode_transaksi ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; color: #333; margin: 20px; }
        
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

        /* Menghapus border khusus untuk tabel di header */
        .table-info-header {
            width: auto;
            border: none;
            margin-top: 0;
        }
        .table-info-header td {
            border: none;
            padding: 2px 5px 2px 0;
            vertical-align: top;
        }

        .logo {
            height: 90px;
            width: auto;
            display: inline-block;
            object-fit: contain;
        }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; }
        th { background: #f2f2f2; text-align: center; font-weight: bold; }
        
        .right { text-align: right; }
        .center { text-align: center; }
        .total-box { margin-top: 20px; text-align: right; }
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
