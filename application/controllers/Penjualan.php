<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjualan extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
			$this->session->set_flashdata('error', 'Anda harus login terlebih dahulu!');
			redirect('auth');
		}
    }
	public function index()
	{
		$this->db->select('
			transaksi.kode_transaksi,
			transaksi.customer_id,
			customers.nama AS nama_customer,
			transaksi.total,
			transaksi.tanggal
		');
		$this->db->from('transaksi');
		$this->db->join('customers', 'customers.id = transaksi.customer_id', 'left');
		$this->db->order_by('transaksi.tanggal', 'DESC');	
		$penjualan = $this->db->get()->result();
		$customers = $this->db->get('customers')->result();

		$data = [
			'title'     => 'Penjualan',
			'penjualan' => $penjualan,
			'customers' => $customers,
		];

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('penjualan', $data);
		$this->load->view('layouts/footer', $data);
	}


	public function transaksi($id){
		$this->db->select('id, nama, satuan_id');
		$bahan = $this->db->get('bahan')->result();


		// Ambil data temp berdasarkan user yang sedang login
		$user_id = $this->session->userdata('user_id');
		$customer_id = $this->uri->segment(3); 
		

		// Ambil data temp + join bahan & satuan
		$this->db->select('temp.*, bahan.nama AS nama_bahan, satuan.nama AS nama_satuan');
		$this->db->from('temp');
		$this->db->join('bahan', 'bahan.id = temp.bahan_id');
		$this->db->join('satuan', 'satuan.id = bahan.satuan_id');
		$this->db->where('temp.user_id', $user_id);
		$this->db->where('temp.customer_id', $customer_id); // Updated to use $customer_id
		$this->db->order_by('temp.id', 'ASC');
		$temp = $this->db->get()->result();

		// 🔥 WAJIB: inisialisasi meskipun data kosong
		$sub_total = 0;

		foreach ($temp as $row) {
			$sub_total += $row->harga_jual * $row->jumlah;
		}

		$data = [
			'title' => 'Transaksi',
			'bahan' => $bahan,
			'temp' => $temp,
			'sub_total' => $sub_total
		];
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('transaksi', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function addTemp()
	{
		
		$customer_id = $this->input->post('customer_id');
		$user_id = $this->session->userdata('user_id');

		if (!$user_id) {
			$this->session->set_flashdata('error', 'User tidak terdeteksi. Silakan login ulang.');
			redirect($this->agent->referrer());
		}

		$this->form_validation->set_rules('bahan_id', 'Bahan', 'required|integer');
		$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'required|numeric');
		$this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required|integer|greater_than[0]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($this->agent->referrer());
		}

		$data = [
			'user_id'    => $user_id,
			'customer_id'    => $customer_id,
			'bahan_id'   => $this->input->post('bahan_id', TRUE),
			'harga_beli' => $this->input->post('harga_beli', TRUE),
			'harga_jual' => $this->input->post('harga_jual', TRUE),
			'jumlah'     => $this->input->post('jumlah', TRUE)
		];

		$this->db->insert('temp', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('success', 'Item berhasil ditambahkan ke transaksi sementara.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menambahkan item.');
		}

		redirect($this->agent->referrer());
	}

	public function updateTemp($id)
	{
		$jumlah = $this->input->post('jumlah');

		$this->db->where('id', $id);
		$this->db->update('temp', [
			'jumlah' => $jumlah
		]);
	}

	public function deleteTemp($id)
	{
		$user_id = $this->session->userdata('user_id');

		$this->db->where('id', $id);
		$this->db->where('user_id', $user_id);
		$this->db->delete('temp');

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('success', 'Item berhasil dihapus dari keranjang.');
		} else {
			$this->session->set_flashdata('error', 'Item tidak ditemukan atau gagal dihapus.');
		}

		redirect($this->agent->referrer());
	}

	public function prosesPembayaran()
	{
		$user_id     = $this->input->post('user_id');
		$customer_id = $this->input->post('customer_id');
		$total       = $this->input->post('total');
	
		$temp = $this->db->get_where('temp', [
			'user_id'     => $user_id,
			'customer_id' => $customer_id
		])->result();
		
	
		if (empty($temp)) {
			$this->session->set_flashdata('error', 'Tidak ada data transaksi');
			redirect($this->agent->referrer());
		}
	
		$this->db->trans_begin();

		$customer = $this->db->from('customers')->get()->row();
		$random = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
		$kode_transaksi = $customer->customer_code . '-' . date('YmdHis') . $random;
		
	
		$transaksi = [
			'kode_transaksi' => $kode_transaksi,
			'tanggal'        => date('Y-m-d H:i:s'),
			'total'          => $total,
			'user_id'        => $user_id,
			'customer_id'    => $customer_id
		];
	
		$this->db->insert('transaksi', $transaksi);
		$transaksi_id = $this->db->insert_id();
	
		foreach ($temp as $row) {
			$detail = [
				'transaksi_id' => $transaksi_id,
				'bahan_id'     => $row->bahan_id,
				'harga_jual'   => $row->harga_jual,
				'harga_beli'   => $row->harga_beli,
				'jumlah'       => $row->jumlah
			];
	
			$this->db->insert('detail_transaksi', $detail);
		}
	
		$this->db->delete('temp', [
			'user_id'     => $user_id,
			'customer_id' => $customer_id
		]);
	
		// ==========================
		// COMMIT / ROLLBACK
		// ==========================
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Transaksi gagal diproses');
			redirect($this->agent->referrer());
		} else {
			$this->db->trans_commit();
			$this->session->set_flashdata('success', 'Transaksi berhasil disimpan');
			redirect('penjualan/detail_transaksi/' . $kode_transaksi);
		}
	}
	
	public function detail_transaksi($kode_transaksi)
	{
		// Ambil data transaksi utama
		$transaksi = $this->db->get_where('transaksi', ['kode_transaksi' => $kode_transaksi])->row();
		
		if (!$transaksi) {
			$this->session->set_flashdata('error', 'Transaksi tidak ditemukan');
			redirect('penjualan');
		}

		$this->db->select('dt.*, b.nama'); 
		$this->db->from('detail_transaksi dt');
		$this->db->join('bahan b', 'b.id = dt.bahan_id', 'left');
		$this->db->where('dt.transaksi_id', $transaksi->id);
		$details = $this->db->get()->result();

		$data['transaksi'] = $transaksi;
		$data['details']   = $details;
		$data['title']     = 'Detail Transaksi | ' . $kode_transaksi;

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('detail-penjualan', $data); // view yang akan kita buat
		$this->load->view('layouts/footer', $data);
	}
}
