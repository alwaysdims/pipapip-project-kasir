<div class="content">
	<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
		<h2 class="text-lg font-medium mr-auto">
			Invoice
		</h2>
		<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
			<a href="<?= base_url('GenerateLaporan/detailPenjualan/'.$transaksi->id) ?>"
				class="btn btn-primary shadow-md mr-2"  target="_blank">
				Print nota
			</a>
			<a href="<?= base_url('GenerateLaporan/suratJalan/'.$transaksi->id) ?>"
				class="btn btn-primary shadow-md mr-2"  target="_blank">
				Print surat jalan
			</a>
		</div>
	</div>

	<!-- BEGIN: Invoice -->
	<div class="intro-y box overflow-hidden mt-5">
		<div class="border-b border-slate-200/60 dark:border-darkmode-400 text-center sm:text-left">
			<div class="px-5 py-10 sm:px-20 sm:py-20">
				<div class="text-primary font-semibold text-3xl">INVOICE</div>
				<div class="mt-2"> Receipt <span class="font-medium">#<?= $transaksi->kode_transaksi ?></span> </div>
				<div class="mt-1"><?= date('D, d M Y H:i A', strtotime($transaksi->tanggal)) ?></div>
			</div>
		</div>

		<div class="px-5 sm:px-16 py-10 sm:py-20">
			<div class="overflow-x-auto">
				<table class="table">
					<thead>
						<tr>
							<th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">#</th>
							<th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
							<th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
							<th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">HARGA JUAL</th>
							<th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
						</tr>
					</thead>
					<tbody>
						<?php 
                        $subtotal_all = 0;
						$no=1;
                        foreach ($details as $dt): 
                            $subtotal = $dt->harga_jual * $dt->jumlah;
                            $subtotal_all += $subtotal;
                        ?>
						<tr>
							<td class="text-left"><?= $no++?></td>
							<td class="border-b dark:border-darkmode-400">
								<div class="font-medium whitespace-nowrap"><?= $dt->nama ?></div>
								<div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">
									Harga Beli: Rp <?= number_format($dt->harga_beli, 0, ',', '.') ?>
								</div>
							</td>
							<td class="text-right border-b dark:border-darkmode-400 w-32"><?= $dt->jumlah ?></td>
							<td class="text-right border-b dark:border-darkmode-400 w-32">
								Rp <?= number_format($dt->harga_jual, 0, ',', '.') ?>
							</td>
							<td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">
								Rp <?= number_format($subtotal, 0, ',', '.') ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4" class="text-right font-medium ">SUB TOTAL</td>
							<td class="text-right font-medium " colspan="1">
								Rp <?= number_format($subtotal_all, 0, ',', '.') ?>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</div>
	<!-- END: Invoice -->
</div>
