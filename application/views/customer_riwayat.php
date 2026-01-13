<!-- BEGIN: Content -->
<div class="content">
	<div class="intro-y mt-5">
	<div class="overflow-x-auto mt-2 box p-5">
		<table id="example" class="stripe w-full">
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
				<?php $no = 1; foreach ($transaksi as $row) :
				$laba = $row->total_jual - $row->total_belanja;

				$margin = ($row->total_jual > 0)
					? ($laba / $row->total_jual) * 100
					: 0;
				?>
				<tr>
					<td><?= $no++ ?></td>
					<td><?= $row->kode_transaksi ?></td>
					<td><?= date('D, d m Y H:i A', strtotime($row->tanggal)) ?></td>
					<td><?= $row->nama ?? '-' ?></td>
					<td>Rp <?= number_format($row->total_belanja, 0, ',', '.') ?></td>
					<td>Rp <?= number_format($row->total_jual, 0, ',', '.') ?></td>
					<td>Rp <?= number_format($row->total_jual - $row->total_belanja, 0, ',', '.') ?></td>
					<td><?= number_format($margin, 2, ',', '.') ?>%</td>
					<td>
						<div class="flex items-center justify-start"> 
							<a
								href="<?= base_url('customer/detail_riwayat/'.$row->kode_transaksi) ?>"
								class="flex items-center mr-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
									height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
									stroke-linecap="round" stroke-linejoin="round"
									class="lucide lucide-edit w-4 h-4 mr-1">
									<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
									<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
								</svg> Detail 
							</a> 
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	</div>
</div>
