<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Laporan Penjualan & Pengeluaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Laporan Penjualan & Pengeluaran</h1>
        </div>
        <div class="container">
            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#cetak-exel" class="btn btn-primary justify-end">Export to Excel</a>
            <table id="exportTable" class="table table-hover">
                <thead>
                    <tr>
                        <th colspan="8">I. DATA PENJUALAN</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Customer</th>
                        <th>Total Belanja</th>
                        <th>Total Jual</th>
                        <th>Margin</th>
                        <th>% Margin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_belanja = 0;
                    $total_jual = 0;
                    $total_margin = 0;
                    foreach ($nilai_siswa as $key => $v) { // Ganti $nilai_siswa dengan variabel data penjualan Anda jika ada
                        $margin = $v['total_jual'] - $v['total_belanja']; // Sesuaikan field
                        $persen_margin = ($v['total_jual'] > 0) ? ($margin / $v['total_jual']) * 100 : 0;
                        $total_belanja += $v['total_belanja'];
                        $total_jual += $v['total_jual'];
                        $total_margin += $margin;
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo date('D, d M Y', strtotime($v['tanggal'])); ?></td>
                        <td><?php echo $v['kode_transaksi']; ?></td>
                        <td><?php echo $v['customer_nama']; ?></td>
                        <td>Rp <?php echo number_format($v['total_belanja'], 0); ?></td>
                        <td>Rp <?php echo number_format($v['total_jual'], 0); ?></td>
                        <td>Rp <?php echo number_format($margin, 0); ?></td>
                        <td><?php echo number_format($persen_margin, 2); ?>%</td>
                    </tr>
                    <?php 
                        $no++;
                    } 
                    $persen_total_margin = ($total_jual > 0) ? ($total_margin / $total_jual) * 100 : 0;
                    ?>
                    <tr>
                        <td colspan="4">TOTAL KESELURUHAN PENJUALAN</td>
                        <td>Rp <?php echo number_format($total_belanja, 0); ?></td>
                        <td>Rp <?php echo number_format($total_jual, 0); ?></td>
                        <td>Rp <?php echo number_format($total_margin, 0); ?></td>
                        <td><?php echo number_format($persen_total_margin, 2); ?>%</td>
                    </tr>
                </tbody>
            </table>

            <table id="exportTable" class="table table-hover mt-4">
                <thead>
                    <tr>
                        <th colspan="5">II. DATA PENGELUARAN (BIAYA OPERASIONAL)</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Tipe Pengeluaran</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no_p = 1;
                    $total_pengeluaran = 0;
                    foreach ($nilai_siswa as $key => $v) { // Ganti dengan variabel data pengeluaran Anda jika ada
                        $total_pengeluaran += $v['jumlah']; // Sesuaikan field
                    ?>
                    <tr>
                        <td><?php echo $no_p; ?></td>
                        <td><?php echo date('D, d M Y', strtotime($v['tanggal'])); ?></td>
                        <td><?php echo $v['tipe_nama']; ?></td>
                        <td><?php echo $v['keterangan']; ?></td>
                        <td>Rp <?php echo number_format($v['jumlah'], 0); ?></td>
                    </tr>
                    <?php 
                        $no_p++;
                    } 
                    ?>
                    <tr>
                        <td colspan="4">TOTAL PENGELUARAN</td>
                        <td>Rp <?php echo number_format($total_pengeluaran, 0); ?></td>
                    </tr>
                </tbody>
            </table>

            <table id="exportTable" class="table table-hover mt-4">
                <thead>
                    <tr>
                        <th colspan="2">III. RINGKASAN LABA BERSIH (NET PROFIT)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Margin Penjualan (Laba Kotor)</td>
                        <td>Rp <?php echo number_format($total_margin, 0); ?></td>
                    </tr>
                    <tr>
                        <td>Total Pengeluaran</td>
                        <td>- Rp <?php echo number_format($total_pengeluaran, 0); ?></td>
                    </tr>
                    <tr>
                        <td>LABA BERSIH</td>
                        <td>Rp <?php echo number_format($total_margin - $total_pengeluaran, 0); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
        </style>
    </div>
</body>
</html>
