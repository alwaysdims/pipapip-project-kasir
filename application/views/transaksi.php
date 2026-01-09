<!-- BEGIN: Content -->
<div class="content">
	<div class="intro-y grid grid-cols-12 gap-5 mt-5">
		<div class="col-span-12 lg:col-span-3 2xl:col-span-3">
			<div class="box p-5 rounded-md">
				<div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
					<div class="font-medium text-base truncate">Tambah keranjang</div>
				</div>
				<form action="<?= base_url('penjualan/addTemp') ?>" method="post">
					<div class="block">
						<input type="hidden" name="customer_id" value="<?= $this->uri->segment(3) ?>" id="">
						<div class="preview w-full">
							<div class="w-full"> <label class="form-label">Bahan</label>
								<div class="mt-2">
									<select data-placeholder="Pilih Bahan" name="bahan_id" class="tom-select w-full"
										required>
										<option value="">Pilih Bahan</option>
										<?php 
                                foreach($bahan as $row): 
                                    $satuan = $this->db->get_where('satuan', ['id' => $row->satuan_id])->row();
                                    $nama_satuan = $satuan ? $satuan->nama : '';
                                ?>
										<option value="<?= $row->id ?>">
											<?= $row->nama ?> (<?= $nama_satuan ?>)
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="mt-3"> <label for="vertical-form-1" class="form-label">Harga beli</label>
								<input id="vertical-form-1" type="number" name="harga_beli" class="form-control w-full"
									placeholder="Input harga beli">
							</div>
							<div class="mt-3">
								<label for="vertical-form-2" class="form-label">Harga jual</label>
								<input id="vertical-form-2" type="number" class="form-control w-full" name="harga_jual"
									placeholder="Input harga jual">
							</div>
							<div class="mt-3">
								<label for="vertical-form-2" class="form-label">Jumlah</label>
								<input id="vertical-form-2" type="number" class="form-control w-full" name="jumlah"
									placeholder="Input jumlah">
							</div>
							<button type="submit" class="btn btn-primary mt-5 w-full"
								fdprocessedid="ofmn05">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-span-12 lg:col-span-9 2xl:col-span-8">
			<div class="box p-5 rounded-md">
				<div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
					<div class="font-medium text-base truncate">Detail keranjang</div>
				</div>
				<div class="overflow-x-auto">
					<table class="table">
						<thead>
							<tr>
								<th class="whitespace-nowrap">#</th>
								<th class="whitespace-nowrap">Bahan</th>
								<th class="whitespace-nowrap">Harga beli</th>
								<th class="whitespace-nowrap">Harga jual</th>
								<th class="whitespace-nowrap">Satuan</th>
								<th class="whitespace-nowrap">Jumlah</th>
								<th class="whitespace-nowrap"></th>
								<th class="whitespace-nowrap">Total</th>
								<th class="whitespace-nowrap">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if($temp): ?>

							<?php 
									$no = 1;  
									foreach($temp as $row):  
								?>

							<tr>
								<td class="whitespace-nowrap"><?= $no++ ?></td>
								<td class="whitespace-nowrap"><?= htmlspecialchars($row->nama_bahan) ?></td>
								<td class="whitespace-nowrap">Rp <?= number_format($row->harga_beli, 0, ',', '.') ?>
								</td>
								<td class="whitespace-nowrap">Rp <?= number_format($row->harga_jual, 0, ',', '.') ?>
								</td>
								<td class="whitespace-nowrap"><?= htmlspecialchars($row->nama_satuan) ?></td>
								<td class="whitespace-nowrap" colspan="2">
									<input type="number" value="<?= $row->jumlah ?>"
										class="form-control w-full jumlah-input" data-id="<?= $row->id ?>" min="1">
								</td>
								<td class="whitespace-nowrap">
									Rp <?= number_format($row->harga_jual * $row->jumlah, 0, ',', '.') ?>
								</td>
								<td class="whitespace-nowrap">
									<a href="<?= base_url('penjualan/deleteTemp/'.$row->id) ?>" class="text-danger"
										onclick="return confirm('Yakin ingin menghapus item ini?')">
										<i data-lucide="trash-2" class="w-4 h-4"></i>
									</a>
								</td>
							</tr>
							<?php endforeach; ?>
							<tr>
								<td class="whitespace-nowrap text-right" colspan="7">Sub Total : </td>
								<td class="whitespace-nowrap" colspan="2">Rp
									<?= number_format($sub_total, 0, ',', '.') ?></td>
							</tr>
							<form action="<?= base_url('penjualan/prosesPembayaran') ?>" method="post">
								<input type="hidden" name="total" value="<?= $sub_total ?>" id="">
								<input type="hidden" name="customer_id" value="<?= $this->uri->segment(3) ?>" id="">
								<input type="hidden" name="user_id" value="<?= $this->session->userdata('user_id') ?>"
									id="">

								<tr>
									<td class="whitespace-nowrap" colspan="9">
										<button type="submit" class="btn btn-primary mt-2 w-full">Proses
											Pembayaran</button>
									</td>
								</tr>
							</form>
							<?php else: ?>
							<tr>
								<td colspan="9" class="text-center text-slate-500">Keranjang kosong</td>
							</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Content -->
<script>
	document.querySelectorAll('.jumlah-input').forEach(input => {
		input.addEventListener('change', function () {
			fetch("<?= base_url('penjualan/updateTemp') ?>/" + this.dataset.id, {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: "jumlah=" + this.value
			}).then(() => location.reload());
		});
	});

</script>
