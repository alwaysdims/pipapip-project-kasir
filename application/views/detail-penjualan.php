<div class="content">
	<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
		<h2 class="text-lg font-medium mr-auto">
			Invoice
		</h2>
		<div class="w-full sm:w-auto flex mt-4 sm:mt-0">
			<a href="<?= base_url('GenerateLaporan/detailPenjualan/'.$transaksi->id) ?>"
				class="btn btn-primary shadow-md mr-2" target="_blank">
				Print nota
			</a>
			<a href="<?= base_url('GenerateLaporan/detailPenjualanB5/'.$transaksi->id) ?>"
				class="btn btn-primary shadow-md mr-2" target="_blank">
				Print nota B5
			</a>
			<a href="<?= base_url('GenerateLaporan/suratJalan/'.$transaksi->id) ?>"
				class="btn btn-primary shadow-md mr-2" target="_blank">
				Print surat jalan
			</a>
		</div>
	</div>

	<div class="intro-y box overflow-hidden mt-5">
		<div class="border-b border-slate-200/60 dark:border-darkmode-400">
			<div class="px-5 py-10 sm:px-20 sm:py-20 flex flex-col sm:flex-row items-start">
				<div>
					<div class="text-primary font-semibold text-3xl">INVOICE</div>
					<div class="mt-2"> Receipt <span class="font-medium">#<?= $transaksi->kode_transaksi ?></span>
					</div>
					<div class="mt-1"><?= date('D, d M Y H:i A', strtotime($transaksi->tanggal)) ?></div>
				</div>
				<div class="sm:ml-auto text-right"> <img src="<?= base_url('assets/images/logo.jpg') ?>"
						class="h-24 ml-auto" alt="Logo" style="margin-top: -5px;"> </div>
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
							<th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">HARGA BELI</th>
							<th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">HARGA JUAL</th>
							<th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
							<th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">ACTION</th>
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
									<?= htmlspecialchars($dt->deskripsi) ?>
								</div>
							</td>
							<td class="text-right border-b dark:border-darkmode-400 w-32"><?= $dt->jumlah ?></td>
							<td class="text-right border-b dark:border-darkmode-400 w-32">
								Rp <?= number_format($dt->harga_beli, 0, ',', '.') ?>
							</td>
							<td class="text-right border-b dark:border-darkmode-400 w-32">
								Rp <?= number_format($dt->harga_jual, 0, ',', '.') ?>
							</td>
							<td class="text-right border-b dark:border-darkmode-400 w-48 font-medium">
								Rp <?= number_format($subtotal, 0, ',', '.') ?>
							</td>
							<td class="border-b dark:border-darkmode-400 w-48 font-medium">
								<div class="flex items-center justify-end">
									<a href="javascript:;" class="flex items-center mr-3 text-primary"
										data-tw-toggle="modal" data-tw-target="#edit-modal-<?= $dt->id ?>">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round"
											class="lucide lucide-edit w-4 h-4 mr-1">
											<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
											<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
										</svg>
										Edit
									</a>

									<a href="<?= base_url('penjualan/hapusDetailTransaksi/' . $dt->id) ?>"
										class="flex items-center text-danger"
										onclick="return confirm('Apakah Anda yakin ingin menghapus item ini? Total transaksi akan dihitung ulang secara otomatis.')">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
											viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
											stroke-linecap="round" stroke-linejoin="round"
											class="lucide lucide-trash-2 w-4 h-4 mr-1">
											<polyline points="3 6 5 6 21 6"></polyline>
											<path
												d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
											</path>
											<line x1="10" y1="11" x2="10" y2="17"></line>
											<line x1="14" y1="11" x2="14" y2="17"></line>
										</svg>
										Delete
									</a>
								</div>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5" class="text-right font-medium ">SUB TOTAL</td>
							<td class="text-right font-medium " colspan="1">
								Rp <?= number_format($subtotal_all, 0, ',', '.') ?>
							</td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<?php foreach($details as $dt){ ?>
	<div id="edit-modal-<?= $dt->id ?>" class="modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="font-medium text-base mr-auto">Edit Item: <?= $dt->nama ?></h2>
				</div>
				<form action="<?= base_url('penjualan/editDetailTransaksi/' . $dt->id) ?>" method="post">
					<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
						<div class="col-span-12">
							<label class="form-label">Harga Beli (Satuan)</label>
							<input type="number" class="form-control" name="harga_beli" value="<?= $dt->harga_beli ?>"
								required>
						</div>
						<div class="col-span-12">
							<label class="form-label">Harga Jual (Satuan)</label>
							<input type="number" class="form-control" name="harga_jual" value="<?= $dt->harga_jual ?>"
								required>
						</div>
						<div class="col-span-12">
							<label class="form-label">Jumlah (Qty)</label>
							<input type="number" class="form-control" name="jumlah" value="<?= $dt->jumlah ?>" min="1"
								required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" data-tw-dismiss="modal"
							class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
						<button type="submit" class="btn btn-primary w-20">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
