<!-- BEGIN: Content -->
<div class="content">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview"
		class="btn btn-primary mr-1 mb-2 mt-5">Tambah transaksi</a>
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#cetak-laporan_penjualan"
		class="btn btn-primary justify-end" >Cetak laporan</a>

	<!-- BEGIN: Modal Content -->
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
				<form action="<?= base_url('GenerateLaporan/cetak_laporanPenjualan') ?>" target="_blank" method="POST">
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
									<select data-placeholder="Select customer" class="tom-select w-full tomselected"
										id="tomselect-1" tabindex="-1" hidden="hidden" name="customer_id">
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
						<button type="submit" class="btn btn-primary w-20" >Send</button>
					</div>
					<!-- END: Modal Footer -->
				</form>
			</div>
		</div>
	</div>
	<!-- END: Modal Content -->
	<div class="grid grid-cols-12 gap-6">
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
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
														viewBox="0 0 24 24" fill="none" stroke="currentColor"
														stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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

	<div class="overflow-x-auto mt-2 box p-5">
		<table id="penjualan-table" class="stripe w-full">
			<thead>
				<tr>
					<th>#</th>
					<th>Kode Transaksi</th>
					<th>Customer</th>
					<th>Total</th>
					<th>Tanggal</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($penjualan)) : ?>
				<?php $no = 1; foreach ($penjualan as $row) : ?>
				<tr>
					<td><?= $no++ ?></td>
					<td><?= $row->kode_transaksi ?></td>
					<td><?= $row->nama_customer ?? '-' ?></td>
					<td>Rp <?= number_format($row->total, 0, ',', '.') ?></td>
					<td><?= date('D, d m Y H:i A', strtotime($row->tanggal)) ?></td>
					<td>
						<div class="flex items-center justify-start"> <a
								href="<?= base_url('penjualan/detail_transaksi/'.$row->kode_transaksi) ?>"
								class="flex items-center mr-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
									height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
									stroke-linecap="round" stroke-linejoin="round"
									class="lucide lucide-edit w-4 h-4 mr-1">
									<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
									<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
								</svg> Detail </a> </div>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php else : ?>
				<tr>
					<td colspan="6" class="text-center">Data penjualan belum ada</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>


</div>
<!-- END: Content -->

<link rel="stylesheet" href="https://datatables.net/legacy/v1/media/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://datatables.net/legacy/v1/media/js/jquery.dataTables.js"></script>

<script>
	$('#penjualan-table').DataTable();

</script>
