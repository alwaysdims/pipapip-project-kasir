<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan extends CI_Controller {

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
		$last = $this->db->select('id')
                 ->order_by('id', 'DESC')
                 ->limit(1)
                 ->get('bahan')
                 ->row();

		$count = $last ? $last->id + 1 : 1;
		$kode_sku = 'SKU-' . str_pad($count, 4, '0', STR_PAD_LEFT);

		$this->db->select('bahan.*, satuan.nama as satuan_nama');
		$this->db->join('satuan', 'satuan.id = bahan.satuan_id');
		$bahans = $this->db->get('bahan')->result();

		$data = [
			'title' => 'Bahan',
			'kode_sku' => $kode_sku,
			'bahans' => $bahans,
		];
	
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('bahan', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function store()
	{
		$data = [
			'kode_bahan' => $this->input->post('kode_bahan'),
			'nama' => $this->input->post('nama'),
			'satuan_id' => $this->input->post('satuan_id')
		];

		$this->db->insert('bahan', $data);
		$this->session->set_flashdata('success', 'Bahan berhasil ditambahkan');

		redirect('bahan');
	}

	public function edit($id)
	{
		$data = [
			'kode_bahan' => $this->input->post('kode_bahan'),
			'nama' => $this->input->post('nama'),
			'satuan_id' => $this->input->post('satuan_id')
		];

		$this->db->where('id', $id);
		$this->db->update('bahan', $data);
		$this->session->set_flashdata('success', 'Bahan berhasil diperbarui');

		redirect('bahan');
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('bahan');
		$this->session->set_flashdata('success', 'Bahan berhasil dihapus');

		redirect('bahan');
	}
}
