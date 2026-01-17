<?php 

class GenerateLaporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->library('pdfgenerator');
    }

	public function detailPenjualan($id_transaksi)
	{
		/* ===============================
		TRANSAKSI
		=============================== */
		// Ambil data transaksi utama + customer + user
		$this->db->select('
		transaksi.*,
		customers.nama AS nama_customer,
		customers.alamat AS alamat_customer,
		customers.no_telp AS no_telp_customer,
		customers.email AS email_customer,
		users.username AS nama_user
		');
		$this->db->from('transaksi');
		$this->db->join('customers', 'customers.id = transaksi.customer_id', 'left');
		$this->db->join('users', 'users.id = transaksi.user_id', 'left');
		$this->db->where('transaksi.id', $id_transaksi);

		$data['transaksi'] = $this->db->get()->row();


		if (!$data['transaksi']) {
			show_error('Transaksi tidak ditemukan');
		}

		/* ===============================
		DETAIL TRANSAKSI
		detail_transaksi → bahan → satuan
		=============================== */
		$this->db->select('
			detail_transaksi.*,
			bahan.kode_bahan,
			bahan.nama AS nama_bahan,
			satuan.nama AS nama_satuan
		');
		$this->db->from('detail_transaksi');
		$this->db->join('bahan', 'bahan.id = detail_transaksi.bahan_id', 'left');
		$this->db->join('satuan', 'satuan.id = bahan.satuan_id', 'left');
		$this->db->where('detail_transaksi.transaksi_id', $id_transaksi);

		$query = $this->db->get();
		if (!$query) {
			echo $this->db->error()['message'];
			die;
		}

		$data['details'] = $query->result();

		/* ===============================
		LOAD VIEW → PDF
		=============================== */
		$html = $this->load->view(
			'reports/laporan-detail_penjualan',
			$data,
			true
		);

		$this->pdfgenerator->generate(
			$html,
			'detail-penjualan-' . $data['transaksi']->kode_transaksi,
			'A4',
			'landscape',
			true
		);
	}

	public function suratJalan($id_transaksi)
	{

		/* ===============================
		TRANSAKSI + CUSTOMER + USER
		=============================== */
		$this->db->select('
			transaksi.*,
			customers.nama,
			customers.alamat,
			customers.no_telp,
			users.username AS pengirim_username
		');
		$this->db->from('transaksi');
		$this->db->join('customers', 'customers.id = transaksi.customer_id', 'left');
		$this->db->join('users', 'users.id = transaksi.user_id', 'left');
		$this->db->where('transaksi.id', $id_transaksi);

		$data['transaksi'] = $this->db->get()->row();

		if (!$data['transaksi']) {
			show_error('Transaksi tidak ditemukan');
		}

		/* ===============================
		DETAIL TRANSAKSI + BAHAN + SATUAN
		=============================== */
		$this->db->select('
			detail_transaksi.*,
			bahan.nama AS nama_bahan,
			bahan.kode_bahan AS kode_bahan, 
			satuan.nama AS nama_satuan,
		');
		$this->db->from('detail_transaksi');
		$this->db->join('bahan', 'bahan.id = detail_transaksi.bahan_id', 'left');
		$this->db->join('satuan', 'satuan.id = bahan.satuan_id', 'left');
		$this->db->where('detail_transaksi.transaksi_id', $id_transaksi);

		$query = $this->db->get();
		if (!$query) {
			echo $this->db->error()['message'];
			die;
		}

		$data['details'] = $query->result();

		/* ===============================
		LOAD VIEW → PDF
		=============================== */
		$html = $this->load->view('reports/laporan-surat_jalan', $data, true);

		$this->pdfgenerator->generate(
			$html,
			'surat-jalan-' . $data['transaksi']->kode_transaksi,
			'A4',
			'landscape',
			true
		);
	}


	public function cetak_laporanPenjualan()
	{

		// Ambil input filter dari form POST
		$tanggal_awal = $this->input->post('tanggal_awal');
		$tanggal_akhir = $this->input->post('tanggal_akhir');
		$customer_id = $this->input->post('customer_id');

		if ($tanggal_awal && $tanggal_akhir) {

			$start = new DateTime($tanggal_awal);
			$end   = new DateTime($tanggal_akhir);
		
			$selisih_hari = $start->diff($end)->days;
		
			if ($selisih_hari > 31) {
				$this->session->set_flashdata(
					'error',
					'Maksimal cetak laporan hanya 30 hari!'
				);
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		// Query dasar
		$this->db->select('transaksi.*, customers.nama AS nama_customer');
		$this->db->from('transaksi');
		$this->db->join('customers', 'customers.id = transaksi.customer_id', 'left');

		if ($tanggal_awal) {
			$this->db->where('transaksi.tanggal >=', $tanggal_awal);
		}
		if ($tanggal_akhir) {
			$this->db->where('transaksi.tanggal <=', $tanggal_akhir . ' 23:59:59');
		}
		if ($customer_id && $customer_id != 'semua') {
			$this->db->where('transaksi.customer_id', $customer_id);
		}

		$this->db->order_by('transaksi.tanggal', 'ASC');
		$this->db->order_by('transaksi.kode_transaksi', 'ASC');

		$data['transaksi'] = $this->db->get()->result();

		// === PERBAIKAN DISINI: Aman terhadap field yang tidak ada ===
		$total_belanja = 0;
		$total_jual = 0;

		foreach ($data['transaksi'] as $tr) {
			// Sesuaikan nama field dengan data kamu
			$belanja = $tr->total_belanja ?? 0;
			$jual = $tr->total_jual ?? 0;

			$total_belanja += $belanja;
			$total_jual += $jual;
		}

		// Hitung margin (laba)
		$margin = $total_jual - $total_belanja;

		// Hitung persentase margin (hindari pembagian 0)
		$persentase_margin = ($total_jual > 0)
			? ($margin / $total_jual) * 100
			: 0;

		// Kirim ke view
		$data['total_keseluruhan_belanja'] = $total_belanja;
		$data['total_keseluruhan_jual'] = $total_jual;
		$data['margin_keseluruhan'] = $margin;
		$data['persentase_margin_keseluruhan'] = $persentase_margin;

		$data['pengeluaran'] = $this->db->from('pengeluaran a')->join('tipe b','a.tipe_id = b.id')->where('tanggal >=', $tanggal_awal)
								->where('tanggal <=', $tanggal_akhir)->order_by('a.tanggal','desc')->get()->result(); 

		// Informasi filter
		$data['periode'] = $tanggal_awal && $tanggal_akhir 
			? date('d M Y', strtotime($tanggal_awal)) . ' - ' . date('d M Y', strtotime($tanggal_akhir))
			: 'Semua Periode';

		$customer_nama = 'Semua Customer';
		if ($customer_id && $customer_id != 'semua') {
			$cust = $this->db->get_where('customers', ['id' => $customer_id])->row();
			$customer_nama = $cust ? $cust->nama : 'Unknown';
		}
		$data['customer_filter'] = $customer_nama;

		// Load HTML
		$html = $this->load->view('reports/laporan-penjualan', $data, true);

		$awal = date('Ymd', strtotime($tanggal_awal));
		$akhir = date('Ymd', strtotime($tanggal_akhir));

		$filename = 'laporan-penjualan-periode_' . $awal . '-sampai-' . $akhir;

		// Generate PDF
		$this->pdfgenerator->generate(
			$html,
			$filename,
			'A4',
			'landscape',
			true
		);				
	}

	public function detail_riwayat_customer($id_transaksi)
	{

		// Ambil data transaksi
		$data['transaksi'] = $this->db
			->where('id', $id_transaksi)
			->get('transaksi')
			->row();

		if (!$data['transaksi']) {
			show_error('Transaksi tidak ditemukan');
		}

		// Ambil detail dengan penyesuaian field harga_beli & harga_jual
		$this->db->select('
			detail_transaksi.jumlah,
			detail_transaksi.harga_beli,
			detail_transaksi.harga_jual,
			bahan.nama AS nama_bahan
		');
		$this->db->from('detail_transaksi');
		$this->db->join('bahan', 'bahan.id = detail_transaksi.bahan_id', 'left');
		$this->db->where('detail_transaksi.transaksi_id', $id_transaksi);

		$data['details'] = $this->db->get()->result();

		// Render ke PDF
		$html = $this->load->view('reports/laporan-detail_riwayat_customer', $data, true);

		$this->pdfgenerator->generate(
			$html,
			'detail-penjualan-' . $data['transaksi']->kode_transaksi,
			'A4',
			'landscape', // Orientasi landscape agar kolom yang banyak muat dengan rapi
			true
		);
	}

	public function cetak_laporanBahan()
	{
		$tgl_awal  = $this->input->post('tanggal_awal');
		$tgl_akhir = $this->input->post('tanggal_akhir') . ' 23:59:59';
		$bahan_id  = $this->input->post('id');

		/* ================= FILTER BAHAN ================= */
		if ($bahan_id !== 'semua') {
			$bahan = $this->db->get_where('bahan', ['id' => $bahan_id])->row();
			$data['bahan_filter'] = $bahan ? $bahan->nama : 'Bahan Tidak Diketahui';
		} else {
			$data['bahan_filter'] = 'Semua Bahan';
		}

		/* ================= QUERY UTAMA ================= */
		$this->db->select('
			dt.*,
			b.kode_bahan,
			b.nama AS nama_bahan,
			t.tanggal,
			t.kode_transaksi,
			c.nama AS nama_customer
		');
		$this->db->from('detail_transaksi dt');
		$this->db->join('bahan b', 'b.id = dt.bahan_id');
		$this->db->join('transaksi t', 't.id = dt.transaksi_id');
		$this->db->join('customers c', 'c.id = t.customer_id', 'left');

		$this->db->where('t.tanggal >=', $tgl_awal);
		$this->db->where('t.tanggal <=', $tgl_akhir);

		if ($bahan_id !== 'semua') {
			$this->db->where('dt.bahan_id', $bahan_id);
		}

		$data['transaksi'] = $this->db->get()->result();

		/* ================= TOTAL ================= */
		$total_beli = 0;
		$total_jual = 0;

		foreach ($data['transaksi'] as $row) {
			$total_beli += $row->harga_beli * $row->jumlah;
			$total_jual += $row->harga_jual * $row->jumlah;
		}

		$data['total_beli']  = $total_beli;
		$data['total_jual']  = $total_jual;
		$data['margin']      = $total_jual - $total_beli;
		$data['periode']     = date('d M Y', strtotime($tgl_awal)) . ' - ' . date('d M Y', strtotime($tgl_akhir));
		$data['persentase'] = ($total_jual > 0) ? ($data['margin'] / $total_jual) * 100 : 0;
		/* ================= CETAK PDF ================= */
		$html = $this->load->view('reports/laporan-bahan', $data, true);

		$this->pdfgenerator->generate(
			$html,
			'laporan-penjualan-bahan',
			'A4',
			'landscape',
			true
		);
	}

}
