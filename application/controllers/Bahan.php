<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session'); // untuk flashdata
	}

	public function index()
	{
		$data = [
			'title' => 'Bahan'
		];
	
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('bahan', $data);
		$this->load->view('layouts/footer', $data);
	}

	public function store()
	{
		$data = [
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
