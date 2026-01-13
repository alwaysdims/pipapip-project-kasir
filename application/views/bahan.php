<!-- BEGIN: Content -->
<div class="content">
	<div id="header-footer-modal" class="p-5">
		<div class="preview">
			<!-- BEGIN: Modal Toggle -->
			<div class="text-left">
				<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#insert-modal"
					class="btn btn-primary">Tambah Bahan</a>
				<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#cetak-laporan_penjualan"
					class="btn btn-primary justify-end">Cetak laporan</a>
			</div>
			<!-- END: Modal Toggle -->

			<div id="cetak-laporan_penjualan" class="modal" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<!-- BEGIN: Modal Header -->
						<div class="modal-header">
							<h2 class="font-medium text-base mr-auto">
								Cetak laporan bahan
							</h2>
						</div>
						<!-- END: Modal Header -->
						<!-- BEGIN: Modal Body -->
						<form action="<?= base_url('GenerateLaporan/cetak_laporanBahan') ?>" target="_blank"
							method="POST">
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
										<label>Bahan</label>
										<div class="mt-2">
											<select data-placeholder="Select bahan"
												class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
												hidden="hidden" name="id">
												<?php
										
										echo '<option value="semua" selected="true">Semua</option>';
										foreach($bahans as $data){
											echo '<option value="'.$data->id.'">'.$data->nama.' - ('. $data->kode_bahan .')</option>';
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
			<!-- BEGIN: Modal Content -->
			<div id="insert-modal" class="modal" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<!-- BEGIN: Modal Header -->
						<div class="modal-header">
							<h2 class="font-medium text-base mr-auto">Insert Bahan</h2>
						</div>
						<!-- END: Modal Header -->
						<!-- BEGIN: Modal Body -->
						<form action="<?= base_url('bahan/store') ?>" method="post">
							<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
								<div class="col-span-12 sm:col-span-6">
									<label class="form-label">Kode SKU</label>
									<input type="text" class="form-control" name="kode_bahan" placeholder="Kode SKU"
										value="<?= $kode_sku ?>" required>
								</div>
								<div class="col-span-12 sm:col-span-6">
									<label class="form-label">Nama</label>
									<input type="text" class="form-control" name="nama" placeholder="Nama Bahan"
										required>
								</div>

								<div class="col-span-12 sm:col-span-12">
									<label class="form-label">Satuan</label>
									<select data-placeholder="Select customer"
												class="tom-select w-full tomselected" id="tomselect-1" tabindex="-1"
												hidden="hidden"  name="satuan_id" required>
										<option value="">Pilih Satuan</option>
										<?php
                                        $satuans = $this->db->get('satuan')->result();
                                        foreach($satuans as $satuan){
                                            echo '<option value="'.$satuan->id.'">'.$satuan->nama.'</option>';
                                        }
                                        ?>
									</select>
								</div>
							</div>
							<!-- END: Modal Body -->
							<!-- BEGIN: Modal Footer -->
							<div class="modal-footer">
								<button type="button" data-tw-dismiss="modal"
									class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
								<button type="submit" class="btn btn-primary w-20">Submit</button>
							</div>
							<!-- END: Modal Footer -->
						</form>
					</div>
				</div>
			</div>
			<!-- END: Modal Content -->
		</div>
	</div>
	<div class="overflow-x-auto mt-2 box p-5">
		<table id="example" class="stripe" style="width:100%">
			<thead>
				<tr>
					<th class="whitespace-nowrap">#</th>
					<th class="whitespace-nowrap">Kode SKU</th>
					<th class="whitespace-nowrap">Nama</th>
					<th class="whitespace-nowrap">Satuan</th>
					<th class="whitespace-nowrap">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
                $no = 1;
              
                foreach($bahans as $data){
                ?>
				<tr>
					<td class="whitespace-nowrap"><?= $no++ ?></td>
					<td class="whitespace-nowrap"><?= $data->kode_bahan?></td>
					<td class="whitespace-nowrap"><?= $data->nama ?></td>
					<td class="whitespace-nowrap"><?= $data->satuan_nama ?></td>
					<td class="whitespace-nowrap">
						<div class="flex items-center justify-start">
							<a href="javascript:;" class="flex items-center mr-3" data-tw-toggle="modal"
								data-tw-target="#edit-modal-<?= $data->id ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round" class="lucide lucide-edit w-4 h-4 mr-1">
									<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
									<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
								</svg> Edit
							</a>
							<a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
								data-tw-target="#delete-confirmation-modal-<?= $data->id ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
									fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
									stroke-linejoin="round" class="lucide lucide-trash-2 w-4 h-4 mr-1">
									<polyline points="3 6 5 6 21 6"></polyline>
									<path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2">
									</path>
									<line x1="10" y1="11" x2="10" y2="17"></line>
									<line x1="14" y1="11" x2="14" y2="17"></line>
								</svg> Delete
							</a>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<!-- Edit and Delete Modals -->
	<?php foreach($bahans as $data){ ?>
	<div id="edit-modal-<?= $data->id ?>" class="modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- BEGIN: Modal Header -->
				<div class="modal-header">
					<h2 class="font-medium text-base mr-auto">Edit Bahan</h2>
				</div>
				<!-- END: Modal Header -->
				<!-- BEGIN: Modal Body -->
				<form action="<?= base_url('bahan/edit/' . $data->id) ?>" method="post">
					<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
						<div class="col-span-12 sm:col-span-6">
							<label class="form-label">Kode SKU</label>
							<input type="text" class="form-control" name="kode_bahan" value="<?= $data->kode_bahan ?>"
								required>
						</div>
						<div class="col-span-12 sm:col-span-6">
							<label class="form-label">Nama</label>
							<input type="text" class="form-control" name="nama" value="<?= $data->nama ?>"
								placeholder="Nama Bahan" required>
						</div>

						<div class="col-span-12 sm:col-span-12">
							<label class="form-label">Satuan</label>
							<select class="form-control" name="satuan_id" required>
								<option value="">Pilih Satuan</option>
								<?php
                                $satuans = $this->db->get('satuan')->result();
                                foreach($satuans as $satuan){
                                    $selected = ($satuan->id == $data->satuan_id) ? 'selected' : '';
                                    echo '<option value="'.$satuan->id.'" '.$selected.'>'.$satuan->nama.'</option>';
                                }
                                ?>
							</select>
						</div>
					</div>
					<!-- END: Modal Body -->
					<!-- BEGIN: Modal Footer -->
					<div class="modal-footer">
						<button type="button" data-tw-dismiss="modal"
							class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
						<button type="submit" class="btn btn-primary w-20">Submit</button>
					</div>
					<!-- END: Modal Footer -->
				</form>
			</div>
		</div>
	</div>

	<div id="delete-confirmation-modal-<?= $data->id ?>" class="modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- BEGIN: Modal Header -->
				<div class="modal-header">
					<h2 class="font-medium text-base mr-auto">Confirm Delete</h2>
				</div>
				<!-- END: Modal Header -->
				<!-- BEGIN: Modal Body -->
				<form action="<?= base_url('bahan/delete/' . $data->id) ?>" method="post">
					<div class="modal-body">
						<p>Anda yakin akan menghapus bahan dengan nama "<strong><?= $data->nama ?></strong>"?</p>
					</div>
					<!-- END: Modal Body -->
					<!-- BEGIN: Modal Footer -->
					<div class="modal-footer">
						<button type="button" data-tw-dismiss="modal"
							class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
						<button type="submit" class="btn btn-danger w-20">Delete</button>
					</div>
					<!-- END: Modal Footer -->
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<!-- END: Content -->
