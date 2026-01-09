<!-- BEGIN: Content -->
<div class="content">
	<div class="grid grid-cols-12 gap-6">
		<div class="col-span-12 mt-8">
			<div class="intro-y flex  items-center h-10">
				<h2 class="text-lg font-medium truncate mr-5">
					General Report
				</h2>
				<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#cetak-laporan_penjualan"
					class="btn btn-primary ml-auto">
					Cetak laporan
				</a>

				<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview"
					class="btn btn-primary ml-2">
					Tambah transaksi
				</a>

				<div id="cetak-laporan_penjualan" class="modal" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<!-- BEGIN: Modal Header -->
							<div class="modal-header">
								<h2 class="font-medium text-base mr-auto">
									Cetak laporan penjualan
								</h2>
							</div>
							<!-- END: Modal Header -->
							<!-- BEGIN: Modal Body -->
							<form action="<?= base_url('GenerateLaporan/cetak_laporanPenjualan') ?>" target="_blank"
								method="POST">
								<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
									<div class="col-span-12 sm:col-span-6">
										<label for="modal-form-2" class="form-label">Tanggal awal</label>
										<input id="modal-form-2" name="tanggal_awal" type="date" class="form-control"
											placeholder="example@gmail.com">
									</div>
									<div class="col-span-12 sm:col-span-6">
										<label for="modal-form-1" class="form-label">Tanggal akhir</label>
										<input id="modal-form-1" name="tanggal_akhir" type="date" class="form-control"
											placeholder="example@gmail.com">
									</div>
									<div class="col-span-12 sm:col-span-12">
										<div>
											<label>Customer</label>
											<div class="mt-2">
												<select data-placeholder="Select customer"
													class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
													hidden="hidden" name="customer_id">
													<?php
													echo '<option value="semua" selected="true">Semua</option>';
													foreach($customers as $cust){
														echo '<option value="'.$cust->id.'">'.$cust->nama.'</option>';
													}
													
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<!-- END: Modal Body -->
								<!-- BEGIN: Modal Footer -->
								<div class="modal-footer">
									<button type="button" data-tw-dismiss="modal"
										class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
									<button type="submit" class="btn btn-primary w-20">Send</button>
								</div>
								<!-- END: Modal Footer -->
							</form>
						</div>
					</div>
				</div>

				<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog modal-xl">
						<div class="modal-content">
							<div class="modal-header ">
								<h2 class="font-medium mt-2 mb-2 text-center">
									Pilih customer untuk transaksi selanjutnya!
								</h2>
							</div>
							<div class="modal-body p-5 text-center">
								<div class="overflow-x-auto mt-2 box p-5">
									<table id="example" class="stripe" style="width:100%">
										<thead>
											<tr>
												<th class="whitespace-nowrap">#</th>
												<th class="whitespace-nowrap">Customer Code</th>
												<th class="whitespace-nowrap">Email</th>
												<th class="whitespace-nowrap">Alamat</th>
												<th class="whitespace-nowrap">No. Telp</th>
												<th class="whitespace-nowrap">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
								$no = 1;
								foreach($customers as $data){
								?>
											<tr>
												<td class="whitespace-nowrap"><?= $no++ ?></td>
												<td class="whitespace-nowrap"><?= $data->customer_code ?></td>
												<td class="whitespace-nowrap"><?= $data->email ?></td>
												<td class="whitespace-nowrap"><?= $data->alamat ?></td>
												<td class="whitespace-nowrap"><?= $data->no_telp ?></td>
												<td class="whitespace-nowrap">
													<div class="flex items-center justify-start">
														<a href="<?= base_url('penjualan/transaksi/'.$data->id) ?>"
															class="flex items-center mr-3">
															<svg xmlns="http://www.w3.org/2000/svg" width="24"
																height="24" viewBox="0 0 24 24" fill="none"
																stroke="currentColor" stroke-width="2"
																stroke-linecap="round" stroke-linejoin="round"
																class="lucide lucide-edit w-4 h-4 mr-1">
																<path
																	d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
																</path>
																<path
																	d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
																</path>
															</svg> Transaksi
														</a>
													</div>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="grid grid-cols-12 gap-6 mt-5">
				<div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
					<div class="report-box zoom-in">
						<div class="box p-5">
							<div class="flex">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round"
									class="lucide lucide-shopping-cart report-box__icon text-primary">
									<circle cx="9" cy="21" r="1"></circle>
									<circle cx="20" cy="21" r="1"></circle>
									<path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"></path>
								</svg>
							</div>
							<div class="text-3xl font-medium leading-8 mt-6"><?= $penjualan_hari_ini ?></div>
							<div class="text-base text-slate-500 mt-1">Penjualan hari ini</div>
						</div>
					</div>
				</div>

				<div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
					<div class="report-box zoom-in">
						<div class="box p-5">
							<div class="flex">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round"
									class="lucide lucide-credit-card report-box__icon text-pending">
									<rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
									<line x1="1" y1="10" x2="23" y2="10"></line>
								</svg>
							</div>
							<div class="text-3xl font-medium leading-8 mt-6"><?= $produk_terjual ?></div>
							<div class="text-base text-slate-500 mt-1">Produk terjual hari ini</div>
						</div>
					</div>
				</div>

				<div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
					<div class="report-box zoom-in">
						<div class="box p-5">
							<div class="flex">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round" class="lucide lucide-monitor report-box__icon text-warning">
									<rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
									<line x1="8" y1="21" x2="16" y2="21"></line>
									<line x1="12" y1="17" x2="12" y2="21"></line>
								</svg>
							</div>
							<div class="text-3xl font-medium leading-8 mt-6"><?= $total_bahan ?></div>
							<div class="text-base text-slate-500 mt-1">Total bahan</div>
						</div>
					</div>
				</div>

				<div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
					<div class="report-box zoom-in">
						<div class="box p-5">
							<div class="flex">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round" class="lucide lucide-user report-box__icon text-success">
									<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
									<circle cx="12" cy="7" r="4"></circle>
								</svg>
							</div>
							<div class="text-3xl font-medium leading-8 mt-6"><?= $total_customer ?></div>
							<div class="text-base text-slate-500 mt-1">Total customer</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-span-12 xl:col-span-8 mt-6">
			<div class="flex flex-col lg:flex-row items-center">
				<div>
					<h2 class="text-lg font-medium mr-auto">Grafik Penjualan Bulanan</h2>
					<span class="text-slate-500 mt-1 text-xs">Data penjualan 2 bulan terakhir hingga 5 bulan ke
						depan</span>
				</div>
			</div>
			<canvas id="myChart" style="width:100%; " class="box intro-y p-5 mt-2"></canvas>
		</div>
		<div class="col-span-12 xl:col-span-4 mt-6">
			<div class="intro-y flex items-center h-10">
				<div>
					<h2 class="text-lg font-medium mr-auto">Data penjualan terbaru</h2>
					<span class="text-slate-500 mt-1 text-xs">Menampilkan 7 data terbaru</span>
				</div>
			</div>
			<div class="mt-4">
				<?php foreach ($penjualan_hari_ini_list as $row) : ?>
				<div class="intro-y">
					<a href="<?= base_url('penjualan/detail_transaksi/' . $row->kode_transaksi) ?>" class="block">

						<div
							class="box px-4 py-4 mb-3 flex items-center zoom-in cursor-pointer hover:bg-slate-100 dark:hover:bg-darkmode-400 transition">

							<div
								class="w-10 h-10 flex-none rounded-md flex items-center justify-center bg-primary text-white">
								<i data-lucide="shopping-cart" class="w-5 h-5"></i>
							</div>

							<div class="ml-4 mr-auto">
								<div class="font-medium">
									<?= $row->kode_transaksi ?>
								</div>
								<div class="text-slate-500 text-xs mt-0.5">
									<?= date('d M Y H:i', strtotime($row->tanggal)) ?>
								</div>
							</div>

							<div class="py-1 px-2 rounded-full text-xs bg-success text-white font-medium">
								<?= number_format($row->total, 0, ',', '.') ?>
							</div>

						</div>
					</a>
				</div>
				<?php endforeach; ?>


				<a href="<?= base_url('penjualan') ?>"
					class="intro-y w-full block text-center rounded-md py-4 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">Lihat
					selengkapnya</a>
			</div>
		</div>
	</div>
</div>
<!-- END: Content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script>
	var xValues = <?= $chart_labels ?> ;
	var yValues = <?= $chart_values ?> ;

	new Chart("myChart", {
		type: "bar",
		data: {
			labels: xValues,
			datasets: [{
				label: "Total Penjualan",
				backgroundColor: "#1e40af",
				data: yValues
			}]
		},
		options: {
			legend: {
				display: false
			},
			title: {
				display: true,
				text: "Grafik Penjualan 5 Bulan"
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}
	});

</script>
