<!-- BEGIN: Content -->
<div class="content">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview"
		class="btn btn-primary mr-1 mb-2 mt-5">Tambah transaksi</a>
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#cetak-pdf"
		class="btn btn-primary justify-end" >Export Pdf</a>
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#cetak-exel"
		class="btn btn-primary justify-end" >Export Excel</a>

	<!-- BEGIN: Modal Content -->
	<div id="cetak-exel" class="modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- BEGIN: Modal Header -->
				<div class="modal-header">
					<h2 class="font-medium text-base mr-auto">
						Cetak laporan penjualan ke-Excel
					</h2>
				</div>
				<!-- END: Modal Header -->
				<!-- BEGIN: Modal Body -->
				<form action="<?= base_url('ExportExel/export') ?>" target="_blank" method="POST">
					<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
						<div class="col-span-12 sm:col-span-6">
							<label for="modal-form-2" class="form-label">Tanggal awal</label>
							<input id="modal-form-2" name="tanggal_awal" type="date" class="form-control" required>
						</div>
						<div class="col-span-12 sm:col-span-6">
							<label for="modal-form-1" class="form-label">Tanggal akhir</label>
							<input id="modal-form-1" name="tanggal_akhir" type="date" class="form-control" required>
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
	<div id="cetak-pdf" class="modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- BEGIN: Modal Header -->
				<div class="modal-header">
					<h2 class="font-medium text-base mr-auto">
						Cetak laporan penjualan Pdf
					</h2>
				</div>
				<!-- END: Modal Header -->
				<!-- BEGIN: Modal Body -->
				<form action="<?= base_url('GenerateLaporan/cetak_laporanPenjualan') ?>" target="_blank" method="POST">
					<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
						<div class="col-span-12 sm:col-span-6">
							<label for="modal-form-2" class="form-label">Tanggal awal</label>
							<input id="modal-form-2" name="tanggal_awal" type="date" class="form-control"
								placeholder="example@gmail.com" required>
						</div>
						<div class="col-span-12 sm:col-span-6">
							<label for="modal-form-1" class="form-label">Tanggal akhir</label>
							<input id="modal-form-1" name="tanggal_akhir" type="date" class="form-control"
								placeholder="example@gmail.com" required>
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
					<th>Tanggal</th>
					<th>Customer</th>
					<th>Total Belanja</th>
					<th>Total Penjualan</th>
					<th>Margin</th>
					<th>Presentase</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1; foreach ($penjualan as $row) :
				$laba = $row->total_jual - $row->total_belanja;

				$margin = ($row->total_jual > 0)
					? ($laba / $row->total_jual) * 100
					: 0;
				?>
				<tr>
					<td><?= $no++ ?></td>
					<td><?= $row->kode_transaksi ?></td>
					<td><?= date('D, d m Y H:i A', strtotime($row->tanggal)) ?></td>
					<td><?= $row->nama_customer ?? '-' ?></td>
					<td>Rp <?= number_format($row->total_belanja, 0, ',', '.') ?></td>
					<td>Rp <?= number_format($row->total_jual, 0, ',', '.') ?></td>
					<td>Rp <?= number_format($row->total_jual - $row->total_belanja, 0, ',', '.') ?></td>
					<td><?= number_format($margin, 2, ',', '.') ?>%</td>
					<td class="border-b dark:border-darkmode-400 w-48 font-medium">
						<div class="flex items-center justify-start">
							<a href="<?= base_url('penjualan/detail_transaksi/'.$row->kode_transaksi) ?>" 
							class="flex items-center mr-3 text-primary" title="Lihat Detail">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye w-4 h-4 mr-1">
									<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
									<circle cx="12" cy="12" r="3"></circle>
								</svg> 
								<span>Detail</span>
							</a>

							<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#edit-transaksi-<?= $row->id ?>" 
							class="flex items-center mr-3 text-warning" title="Edit Transaksi">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit w-4 h-4 mr-1">
									<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
									<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
								</svg> 
								<span>Edit</span>
							</a>

							<a href="<?= base_url('penjualan/batalkanTransaksi/'.$row->id) ?>" 
							class="flex items-center text-danger" title="Batalkan Transaksi" 
							onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2 w-4 h-4 mr-1">
									<polyline points="3 6 5 6 21 6"></polyline>
									<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
									<line x1="10" y1="11" x2="10" y2="17"></line>
									<line x1="14" y1="11" x2="14" y2="17"></line>
								</svg> 
								<span>Batalkan</span>
							</a>
						</div>

						<div id="edit-transaksi-<?= $row->id ?>" class="modal" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h2 class="font-medium text-base mr-auto">Edit Transaksi: <?= $row->kode_transaksi ?></h2>
									</div>
									<form action="<?= base_url('penjualan/updateTransaksi/' . $row->id) ?>" method="post">
										<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
											<div class="col-span-12">
												<label class="form-label">Tanggal (Kosongkan jika tidak ingin diubah)</label>
												<input type="date" class="form-control" name="tanggal" value="<?= $row->tanggal ?>">
											</div>
											<div class="col-span-12">
												<label class="form-label">Customer (Kosongkan jila tidak di ubah)</label>
												<select data-placeholder="Pilih customer" class="tom-select w-full" name="customer_id" class="form-control" required>
													<?php foreach($customers as $c): ?>
														<option value="<?= $c->id ?>" <?= $c->id == $row->customer_id ? 'selected' : '' ?>><?= $c->nama ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-span-12">
												<label class="form-label">Catatan</label>
												<textarea class="form-control" name="catatan"><?= $row->catatan ?></textarea>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
											<button type="submit" class="btn btn-primary w-20">Update</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
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
