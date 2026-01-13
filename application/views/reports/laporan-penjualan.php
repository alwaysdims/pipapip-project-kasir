<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan & Pengeluaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px;
            color: #333;
        }
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
        .title {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .logo-img {
            max-height: 60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .section-title {
            background-color: #e2e8f0;
            font-weight: bold;
            padding: 8px;
            border: 1px solid #000;
            margin-top: 20px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <div class="title">Laporan Penjualan & Pengeluaran</div>
                <div>Periode: <b><?= $periode ?></b></div>
                <div>Customer: <b><?= $customer_filter ?></b></div>
                <div>Tanggal Cetak: <?= date('d M Y') ?></div>
            </td>
            <td class="text-right">
                <img src="<?= base_url('assets/images/logo.jpg') ?>" class="logo-img" alt="Logo">
            </td>
        </tr>
    </table>

    <div class="section-title">I. DATA PENJUALAN</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Customer</th>
                <th class="text-right">Total Belanja</th>
                <th class="text-right">Total Jual</th>
                <th class="text-right">Margin</th>
                <th class="text-right">% Margin</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($transaksi as $tr): 
                $t_belanja = $tr->total_belanja ?? 0;
                $t_jual = $tr->total_jual ?? 0;
                $laba = $t_jual - $t_belanja;
                $p_margin = ($t_jual > 0) ? ($laba / $t_jual) * 100 : 0;
            ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= date('D, d M Y', strtotime($tr->tanggal)) ?></td>
                <td><?= $tr->kode_transaksi ?></td>
                <td><?= $tr->nama_customer ?? '-' ?></td>
                <td class="text-right">Rp <?= number_format($t_belanja, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($t_jual, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($laba, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($p_margin, 2, ',', '.') ?>%</td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($transaksi)): ?>
            <tr><td colspan="8" class="text-center">Tidak ada data penjualan.</td></tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="font-bold">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN PENJUALAN</td>
                <td class="text-right">Rp <?= number_format($total_keseluruhan_belanja, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($total_keseluruhan_jual, 0, ',', '.') ?></td>
                <td class="text-right">Rp <?= number_format($margin_keseluruhan, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($persentase_margin_keseluruhan, 2, ',', '.') ?>%</td>
            </tr>
        </tfoot>
    </table>

    <div class="section-title">II. DATA PENGELUARAN (BIAYA OPERASIONAL)</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Tipe Pengeluaran</th>
                <th>Keterangan</th>
                <th width="20%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no_p = 1;
            $total_pengeluaran = 0;
            foreach ($pengeluaran as $p): 
                $total_pengeluaran += $p->jumlah;
            ?>
            <tr>
                <td class="text-center"><?= $no_p++ ?></td>
                <td class="text-center"><?= date('D, d M Y', strtotime($p->tanggal)) ?></td>
                <td class="text-center"><?= $p->nama ?></td>
                <td><?= $p->keterangan ?></td>
                <td class="text-right">Rp <?= number_format($p->jumlah, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($pengeluaran)): ?>
            <tr><td colspan="5" class="text-center">Tidak ada data pengeluaran.</td></tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="font-bold">
                <td colspan="4" class="text-right">TOTAL PENGELUARAN</td>
                <td class="text-right">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="section-title">III. RINGKASAN LABA BERSIH (NET PROFIT)</div>
    <table>
        <tr>
            <td width="70%" class="font-bold">Total Margin Penjualan (Laba Kotor)</td>
            <td class="text-right font-bold">Rp <?= number_format($margin_keseluruhan, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td class="font-bold">Total Pengeluaran</td>
            <td class="text-right font-bold" style="color: red;">- Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></td>
        </tr>
        <tr style="background-color: #f2f2f2;">
            <td class="font-bold" style="font-size: 14px;">LABA BERSIH</td>
            <td class="text-right font-bold" style="font-size: 14px;">
                Rp <?= number_format($margin_keseluruhan - $total_pengeluaran, 0, ',', '.') ?>
            </td>
        </tr>
    </table>

</body>
</html>
