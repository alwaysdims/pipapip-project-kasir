<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipe extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Optional: cek login jika diperlukan
        // if (!$this->session->userdata('logged_in')) redirect('auth');
    }

    public function index()
    {
        // Ambil semua data tipe
        $query = $this->db->order_by('nama', 'ASC')->get('tipe');
        $data['tipes'] = $query->result();

        $data['title'] = 'Tipe Pengeluaran';

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('tipe', $data); // view yang akan kita buat
        $this->load->view('layouts/footer', $data);
    }

    // Insert
    public function store()
    {
        $nama = trim($this->input->post('nama'));

        if (empty($nama)) {
            $this->session->set_flashdata('error', 'Nama tipe wajib diisi');
            redirect('tipe');
        }

        $cek = $this->db->get_where('tipe', ['nama' => $nama])->row();
        if ($cek) {
            $this->session->set_flashdata('error', 'Tipe "' . $nama . '" sudah ada');
            redirect('tipe');
        }

        $this->db->insert('tipe', ['nama' => $nama]);
        
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Tipe berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan tipe');
        }

        redirect('tipe');
    }

    // Update
    public function edit($id)
    {
        $nama = trim($this->input->post('nama'));

        if (empty($nama)) {
            $this->session->set_flashdata('error', 'Nama tipe wajib diisi');
            redirect('tipe');
        }

        // Cek apakah nama sudah dipakai oleh tipe lain
        $this->db->where('nama', $nama);
        $this->db->where('id !=', $id);
        $cek = $this->db->get('tipe')->row();

        if ($cek) {
            $this->session->set_flashdata('error', 'Tipe "' . $nama . '" sudah ada');
            redirect('tipe');
        }

        $this->db->where('id', $id);
        $this->db->update('tipe', ['nama' => $nama]);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Tipe berhasil diupdate');
        } else {
            $this->session->set_flashdata('info', 'Tidak ada perubahan');
        }

        redirect('tipe');
    }

    // Delete
    public function delete($id)
    {
        $this->db->where('id', $id);
        $data = $this->db->get('tipe')->row();

        if (!$data) {
            $this->session->set_flashdata('error', 'Tipe tidak ditemukan');
            redirect('tipe');
        }

        $this->db->delete('tipe', ['id' => $id]);

        $this->session->set_flashdata('success', 'Tipe "' . $data->nama . '" berhasil dihapus');
        redirect('tipe');
    }
}
