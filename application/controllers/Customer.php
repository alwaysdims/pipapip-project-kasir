<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		if (!$this->session->userdata('logged_in')) {
			$this->session->set_flashdata('error', 'Anda harus login terlebih dahulu!');
			redirect('auth');
		}
    }
    public function index() {
        $data = [
            'title' => 'Customer',
            'customers' => $this->db->get('customers')->result()
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('customer', $data);
        $this->load->view('layouts/footer');
    }

    public function store() {
        $data = [
            'customer_code' => $this->input->post('customer_code'),
            'nama'         => $this->input->post('nama'),
            'email'         => $this->input->post('email'),
            'alamat'        => $this->input->post('alamat'),
            'no_telp'       => $this->input->post('no_telp')
        ];

        $this->db->insert('customers', $data);

        $this->session->set_flashdata('success', 'Customer berhasil ditambahkan');
        redirect('customer');
    }

    public function edit($id) {
        $data = [
            'customer_code' => $this->input->post('customer_code'),
            'nama'         => $this->input->post('nama'),
            'email'         => $this->input->post('email'),
            'alamat'        => $this->input->post('alamat'),
            'no_telp'       => $this->input->post('no_telp')
        ];

        $this->db->where('id', $id);
        $this->db->update('customers', $data);

        $this->session->set_flashdata('success', 'Customer berhasil diperbarui');
        redirect('customer');
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('customers');

        $this->session->set_flashdata('success', 'Customer berhasil dihapus');
        redirect('customer');
    }

	public function riwayat($id){
		$transaksi = $this->db->from('transaksi')
			->where('customer_id', $id)
			->order_by('tanggal', 'DESC')
			->get()
			->result();

		$data = [
			'title' => 'Riwayat pembelian customer',
			'transaksi' => $transaksi,
		];

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('customer_riwayat', $data);
		$this->load->view('layouts/footer');
	}
}
