<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session'); // untuk flashdata
    }

    public function index() {
        $data = [
            'title' => 'Satuan barang',
            'satuans' => $this->db->get('satuan')->result()
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('satuan', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function store() {
        $data = [
            'nama' => $this->input->post('nama')
        ];

        $this->db->insert('satuan', $data);

        $this->session->set_flashdata('success', 'Satuan berhasil ditambahkan');
        redirect('satuan');
    }

    public function edit($id) {
        $data = [
            'nama' => $this->input->post('nama')
        ];

        $this->db->where('id', $id);
        $this->db->update('satuan', $data);

        $this->session->set_flashdata('success', 'Satuan berhasil diperbarui');
        redirect('satuan');
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('satuan');

        $this->session->set_flashdata('success', 'Satuan berhasil dihapus');
        redirect('satuan');
    }
}
