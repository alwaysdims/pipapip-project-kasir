<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
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
        // Ambil semua pengeluaran dengan join tipe
        $this->db->select('p.*, t.nama as nama_tipe');
        $this->db->from('pengeluaran p');
        $this->db->join('tipe t', 't.id = p.tipe_id', 'left');
        $this->db->order_by('p.tanggal', 'DESC');
        $this->db->order_by('p.id', 'DESC');
        $data['pengeluarans'] = $this->db->get()->result();

        // Ambil semua tipe untuk dropdown
        $data['tipes'] = $this->db->order_by('nama', 'ASC')->get('tipe')->result();

        $data['title'] = 'Pengeluaran';

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('pengeluaran', $data);
        $this->load->view('layouts/footer', $data);
    }

    // Insert
    public function store()
    {
        $keterangan = trim($this->input->post('keterangan'));
        $jumlah     = $this->input->post('jumlah');
        $tipe_id    = $this->input->post('tipe_id');

        if (empty($keterangan) || empty($jumlah) || empty($tipe_id)) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi');
            redirect('pengeluaran');
        }

        if (!is_numeric($jumlah) || $jumlah <= 0) {
            $this->session->set_flashdata('error', 'Jumlah harus angka positif');
            redirect('pengeluaran');
        }

        $this->db->insert('pengeluaran', [
            'keterangan' => $keterangan,
            'tanggal' => date('Y-m-d'),
            'jumlah'     => $jumlah,
            'tipe_id'    => $tipe_id
        ]);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Pengeluaran berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan pengeluaran');
        }

        redirect('pengeluaran');
    }

    // Update
    public function edit($id)
    {
        $keterangan = trim($this->input->post('keterangan'));
        $jumlah     = $this->input->post('jumlah');
        $tanggal    = $this->input->post('tanggal');
        $tipe_id    = $this->input->post('tipe_id');

        if (empty($keterangan) || empty($jumlah) || empty($tipe_id)) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi');
            redirect('pengeluaran');
        }

        if (!is_numeric($jumlah) || $jumlah <= 0) {
            $this->session->set_flashdata('error', 'Jumlah harus angka positif');
            redirect('pengeluaran');
        }

        $this->db->where('id', $id);
        $this->db->update('pengeluaran', [
            'keterangan' => $keterangan,
            'jumlah'     => $jumlah,
            'tanggal'    => $tanggal,
            'tipe_id'    => $tipe_id
        ]);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Pengeluaran berhasil diupdate');
        } else {
            $this->session->set_flashdata('info', 'Tidak ada perubahan data');
        }

        redirect('pengeluaran');
    }

    // Delete
    public function delete($id)
    {
        $this->db->where('id', $id);
        $data = $this->db->get('pengeluaran')->row();

        if (!$data) {
            $this->session->set_flashdata('error', 'Data pengeluaran tidak ditemukan');
            redirect('pengeluaran');
        }

        $this->db->delete('pengeluaran', ['id' => $id]);

        $this->session->set_flashdata('success', 'Pengeluaran berhasil dihapus');
        redirect('pengeluaran');
    }
}
