<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Invoice Detail
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="<?= base_url('GenerateLaporan/detail_riwayat_customer/'.$transaksi->id) ?>" class="btn btn-primary shadow-md mr-2" target="_blank">
                Print detail riwayat customer
            </a>
            <a href="<?= base_url('GenerateLaporan/suratJalan/'.$transaksi->id) ?>" class="btn btn-primary shadow-md mr-2" target="_blank">
                Print surat jalan
            </a>
        </div>
    </div>

    <div class="intro-y box overflow-hidden mt-5">
		<div class="border-b border-slate-200/60 dark:border-darkmode-400">
			<div class="px-5 py-10 sm:px-20 sm:py-20 flex flex-col sm:flex-row">
				<div>
					<div class="text-primary font-semibold text-3xl">INVOICE</div>
					<div class="mt-2"> Receipt <span class="font-medium">#<?= $transaksi->kode_transaksi ?></span>
					</div>
					<div class="mt-1"><?= date('D, d M Y H:i A', strtotime($transaksi->tanggal)) ?></div>
				</div>
				<div class="mt-10 sm:mt-0 sm:ml-auto text-right">
					<img src="<?= base_url('assets/images/logo.jpg') ?>" class="h-20 ml-auto" alt="Logo">
				</div>
			</div>
		</div>

        <div class="px-5 sm:px-16 py-10">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="">
                            <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">NAMA BARANG</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">HARGA BELI</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">JUMLAH BELI</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">HARGA JUAL</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">JUMLAH JUAL</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">MARGIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_margin = 0;
                        foreach ($details as $dt): 
                            $jml_beli = $dt->harga_beli * $dt->jumlah;
                            $jml_jual = $dt->harga_jual * $dt->jumlah;
                            $margin = $jml_jual - $jml_beli;
                            $total_margin += $margin;
                        ?>
                        <tr>
                            <td class="border-b dark:border-darkmode-400">
                                <div class="font-medium whitespace-nowrap"><?= $dt->nama ?></div>
                            </td>
                            <td class="text-right border-b dark:border-darkmode-400"><?= str_replace('.', ',', (float)$dt->jumlah) ?></td>
                            <td class="text-right border-b dark:border-darkmode-400">Rp <?= number_format($dt->harga_beli, 0, ',', '.') ?></td>
                            <td class="text-right border-b dark:border-darkmode-400">Rp <?= number_format($jml_beli, 0, ',', '.') ?></td>
                            <td class="text-right border-b dark:border-darkmode-400">Rp <?= number_format($dt->harga_jual, 0, ',', '.') ?></td>
                            <td class="text-right border-b dark:border-darkmode-400">Rp <?= number_format($jml_jual, 0, ',', '.') ?></td>
                            <td class="text-right border-b dark:border-darkmode-400">Rp <?= number_format($margin, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
					
                </table>
            </div>
        </div>

        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
            <div class="text-center sm:text-left mt-10 sm:mt-0">
            </div>
            <div class="text-center sm:text-right sm:ml-auto">
                <div class="text-base text-slate-500">Total Jual</div>
                <div class="text-xl text-primary font-medium mt-2 bg-green-400 text-white px-2 py-1 inline-block">
                    Rp <?= number_format($transaksi->total_jual, 0, ',', '.') ?>
                </div>
                <div class="mt-1 text-sm">Total Margin: Rp <?= number_format($total_margin, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
</div>
