<?php class GenerateLaporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

	public function detailPenjualan($id_transaksi)
	{
		$this->load->library('pdfgenerator');

		/* ===============================
		TRANSAKSI
		=============================== */
		$data['transaksi'] = $this->db
			->where('id', $id_transaksi)
			->get('transaksi')
			->row();

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
			bahan.deskripsi,
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
		$this->load->library('pdfgenerator');

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
			bahan.deskripsi AS deskripsi,
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
		$this->load->library('pdfgenerator');

		// Ambil input filter dari form POST
		$tanggal_awal = $this->input->post('tanggal_awal');
		$tanggal_akhir = $this->input->post('tanggal_akhir');
		$customer_id = $this->input->post('customer_id');

		if ($tanggal_awal && $tanggal_akhir) {

			$start = new DateTime($tanggal_awal);
			$end   = new DateTime($tanggal_akhir);
		
			$selisih_hari = $start->diff($end)->days;
		
			if ($selisih_hari > 30) {
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
			$this->db->where('transaksi.tanggal <=', $tanggal_akhir);
		}
		if ($customer_id && $customer_id != 'semua') {
			$this->db->where('transaksi.customer_id', $customer_id);
		}

		$this->db->order_by('transaksi.tanggal', 'ASC');
		$this->db->order_by('transaksi.kode_transaksi', 'ASC');

		$data['transaksi'] = $this->db->get()->result();

		// === PERBAIKAN DISINI: Aman terhadap field yang tidak ada ===
		$total_keseluruhan = 0;
		$total_bayar = 0;
		$total_kembalian = 0;

		foreach ($data['transaksi'] as $tr) {
			$total = $tr->total ?? 0;

			// Cek apakah ada field 'bayar', jika tidak → anggap bayar = total (lunas)
			$bayar = isset($tr->bayar) ? $tr->bayar : $total;

			$total_keseluruhan += $total;
			$total_bayar += $bayar;
			$total_kembalian += ($bayar - $total);
		}

		$data['total_keseluruhan'] = $total_keseluruhan;
		$data['total_bayar'] = $total_bayar;
		$data['total_kembalian'] = $total_kembalian;

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

		// Filename
		$filename = 'laporan-penjualan-' . date('Ymd') . '-' . time();

		// Generate PDF
		$this->pdfgenerator->generate($html, $filename, 'A4', 'landscape');
	}
}
