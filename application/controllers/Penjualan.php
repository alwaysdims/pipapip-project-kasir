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
			transaksi.id,
			transaksi.kode_transaksi,
			transaksi.customer_id,
			customers.nama AS nama_customer,
			transaksi.total_belanja,
			transaksi.total_jual,
			transaksi.tanggal,
			transaksi.catatan,
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
		$total_belanja = 0;
		$total_jual = 0;

		foreach ($temp as $row) {
			$total_belanja += $row->harga_beli * $row->jumlah;
			$total_jual += $row->harga_jual * $row->jumlah;
		}

		$data = [
			'title' => 'Transaksi',
			'bahan' => $bahan,
			'temp' => $temp,
			'total_jual' => $total_jual,
			'total_belanja' => $total_belanja
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
			'jumlah'     => $this->input->post('jumlah', TRUE),
			'deskripsi'     => $this->input->post('deskripsi')
		];

		$this->db->insert('temp', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('success', 'Item berhasil ditambahkan ke transaksi sementara.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menambahkan item.');
		}

		redirect($this->agent->referrer());
	}

	public function updateJumlahTemp($id)
	{
		$jumlah = $this->input->post('jumlah');

		$this->db->where('id', $id);
		$this->db->update('temp', [
			'jumlah' => $jumlah
		]);
	}

	public function updateHargaBeliTemp($id)
	{
		$harga_beli = $this->input->post('harga_beli');

		$this->db->where('id', $id);
		$this->db->update('temp', [
			'harga_beli' => $harga_beli
		]);
	}

	public function updateHargaJualTemp($id)
	{
		$harga_jual = $this->input->post('harga_jual');
	
		$this->db->where('id', $id);
		$this->db->update('temp', [
			'harga_jual' => $harga_jual
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
		$total_belanja = $this->input->post('total_belanja');
		$total_jual = $this->input->post('total_jual');
		$catatan = $this->input->post('catatan');
	
		$temp = $this->db->get_where('temp', [
			'user_id'     => $user_id,
			'customer_id' => $customer_id
		])->result();
		
	
		if (empty($temp)) {
			$this->session->set_flashdata('error', 'Tidak ada data transaksi');
			redirect($this->agent->referrer());
		}
	
		$this->db->trans_begin();

		$customer = $this->db->from('customers')->where('id', $customer_id)->get()->row();
		$random = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
		$kode_transaksi = $customer->customer_code . '-' . date('YmdHis') . $random;
		
	
		$transaksi = [
			'kode_transaksi' => $kode_transaksi,
			'tanggal'        => date('Y-m-d H:i:s'),
			'total_belanja'  => $total_belanja,
			'total_jual'     => $total_jual,
			'catatan'     => $catatan ?: 'tidak ada catatan',
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
				'jumlah'       => $row->jumlah,
				'deskripsi'    => $row->deskripsi ?: 'tidak ada deskripsi',
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

	public function editDetailTransaksi($id)
	{
		$detailOld = $this->db->get_where('detail_transaksi', ['id' => $id])->row();
		if (!$detailOld) {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			return redirect($_SERVER['HTTP_REFERER']);
		}

		$transaksi_id = $detailOld->transaksi_id;

		$dataUpdateDetail = [
			'harga_jual' => $this->input->post('harga_jual'),
			'harga_beli' => $this->input->post('harga_beli'),
			'jumlah'     => $this->input->post('jumlah')
		];

		$this->db->where('id', $id);
		$this->db->update('detail_transaksi', $dataUpdateDetail);

		$this->db->select('SUM(harga_beli * jumlah) as total_beli, SUM(harga_jual * jumlah) as total_jual');
		$this->db->where('transaksi_id', $transaksi_id);
		$newTotals = $this->db->get('detail_transaksi')->row();

		$dataUpdateTransaksi = [
			'total_belanja' => $newTotals->total_beli,
			'total_jual'    => $newTotals->total_jual
		];

		$this->db->where('id', $transaksi_id);
		$this->db->update('transaksi', $dataUpdateTransaksi);

		$this->session->set_flashdata('success', 'Data berhasil diperbarui');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function hapusDetailTransaksi($id)
	{
		// 1. Ambil data detail untuk mendapatkan transaksi_id
		$detail = $this->db->get_where('detail_transaksi', ['id' => $id])->row();

		if (!$detail) {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			return redirect($_SERVER['HTTP_REFERER']);
		}

		$transaksi_id = $detail->transaksi_id;

		// 2. Cek berapa banyak item yang ada di transaksi ini
		$jumlah_item = $this->db->where('transaksi_id', $transaksi_id)->from('detail_transaksi')->count_all_results();

		if ($jumlah_item <= 1) {
			// OPSIONAL: Jika item terakhir dihapus, hapus juga transaksi induknya
			// atau Anda bisa arahkan redirect ke halaman list penjualan karena detail sudah kosong
			$this->db->delete('transaksi', ['id' => $transaksi_id]);
			$this->db->delete('detail_transaksi', ['transaksi_id' => $transaksi_id]);
			
			$this->session->set_flashdata('success', 'Transaksi dihapus karena semua item telah dihapus');
			return redirect('penjualan'); // Redirect ke list utama karena detail sudah tidak ada
		}

		// 3. Jika item lebih dari 1, hapus item tersebut
		$this->db->delete('detail_transaksi', ['id' => $id]);

		// 4. Hitung ulang total
		$this->db->select('SUM(harga_beli * jumlah) as total_beli, SUM(harga_jual * jumlah) as total_jual');
		$this->db->where('transaksi_id', $transaksi_id);
		$newTotals = $this->db->get('detail_transaksi')->row();

		$dataUpdateTransaksi = [
			'total_belanja' => $newTotals->total_beli ?? 0,
			'total_jual'    => $newTotals->total_jual ?? 0
		];

		$this->db->where('id', $transaksi_id);
		$this->db->update('transaksi', $dataUpdateTransaksi);

		$this->session->set_flashdata('success', 'Item berhasil dihapus');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function updateTransaksi($id)
	{
		$tanggal_input = $this->input->post('tanggal');
		$customer_id = $this->input->post('customer_id');
		$catatan = $this->input->post('catatan');

		// Ambil data transaksi lama
		$transaksi_lama = $this->db->get_where('transaksi', ['id' => $id])->row();

		if ($transaksi_lama) {
			$data_update = [
				'catatan' => $catatan,
				'customer_id' => $customer_id
			];

			// Flag untuk mengecek apakah ada perubahan yang memicu update nota
			$is_changed = false;

			// 1. Logika Tanggal
			if (!empty($tanggal_input)) {
				// Jika tanggal input berbeda dengan tanggal lama (perlu update nota)
				if (date('Y-m-d', strtotime($transaksi_lama->tanggal)) != $tanggal_input) {
					$is_changed = true;
				}
				$waktu_sekarang = date('H:i:s');
				$data_update['tanggal'] = $tanggal_input . ' ' . $waktu_sekarang;
				$format_tgl_nota = date('Ymd', strtotime($tanggal_input));
			} else {
				$format_tgl_nota = date('Ymd', strtotime($transaksi_lama->tanggal));
			}

			// 2. Logika Customer
			if ($transaksi_lama->customer_id != $customer_id) {
				$is_changed = true;
			}

			// 3. Update Nota (Jika tanggal ATAU customer berubah)
			if ($is_changed) {
				$customer = $this->db->get_where('customers', ['id' => $customer_id])->row();
				if ($customer) {
					$parts = explode('-', $transaksi_lama->kode_transaksi);
					$suffix = end($parts); // Ambil angka acak di belakang nota lama
					
					// Format Nota: KodeCustomer-YYYYMMDD-Acak
					$data_update['kode_transaksi'] = $customer->customer_code . '-' . $suffix;
				}
			}

			$this->db->where('id', $id);
			$this->db->update('transaksi', $data_update);
			$this->session->set_flashdata('success', 'Transaksi berhasil diperbarui');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function batalkanTransaksi($id)
	{
		// Hapus data detail transaksi terlebih dahulu (FK)
		$this->db->delete('detail_transaksi', ['transaksi_id' => $id]);
		// Hapus data utama
		$this->db->delete('transaksi', ['id' => $id]);
	
		$this->session->set_flashdata('success', 'Transaksi berhasil dibatalkan');
		redirect('penjualan');
	}
}
