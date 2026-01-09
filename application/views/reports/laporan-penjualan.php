<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        .header-info {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer-total {
            font-size: 14px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<h2>LAPORAN PENJUALAN</h2>

<div class="header-info">
    Periode: <b><?= $periode ?></b><br>
    Customer: <b><?= $customer_filter ?></b><br>
    Tanggal Cetak: <?= date('d M Y') ?>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Transaksi</th>
            <th>Customer</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $no = 1;
    foreach ($transaksi as $tr): 
        $total = $tr->total ?? 0;
    ?>
    <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td class="text-center"><?= date('d M Y', strtotime($tr->tanggal)) ?></td>
        <td><?= $tr->kode_transaksi ?></td>
        <td><?= $tr->nama_customer ?? '-' ?></td>
        <td class="text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>
    </tr>
    <?php endforeach; ?>

    <?php if (empty($transaksi)): ?>
    <tr>
        <td colspan="7" class="text-center">Tidak ada data transaksi pada periode ini.</td>
    </tr>
    <?php endif; ?>
</tbody>
<tfoot>
    <tr>
        <th colspan="4" class="text-right">TOTAL KESELURUHAN</th>
        <th class="text-right">Rp <?= number_format($total_keseluruhan, 0, ',', '.') ?></th>
    </tr>
</tfoot>
</table>

</body>
</html>
