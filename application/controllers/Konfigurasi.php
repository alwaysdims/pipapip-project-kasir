<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konfigurasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // bisa tambah cek login di sini nanti
    }

    public function index()
    {
        $data['title'] = 'Konfigurasi Toko';

        // Ambil data konfigurasi (hanya 1 baris)
        $this->db->where('id', 1);
        $data['konfig'] = $this->db->get('konfigurasi')->row();

        // Jika belum ada data sama sekali, insert default
        if (!$data['konfig']) {
            $default = [
                'id'         => 1,
                'logo'       => 'o',
                'nama'       => 'Toko Kasir Saya',
                'alamat'     => 'Jl. Contoh No. 123, Surakarta',
                'email'      => 'admin@tokokasir.com',
                'selogan'    => 'Melayani dengan senyuman',
                'deskripsi'  => 'Toko kelontong lengkap dan terpercaya',
                'no_telp'    => '08123456789'
            ];
            $this->db->insert('konfigurasi', $default);
            $data['konfig'] = (object)$default;
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('konfigurasi', $data);
        $this->load->view('layouts/footer');
    }

    public function update()
    {
        $id = 1; // selalu 1

        $data = [
            'nama'      => $this->input->post('nama', TRUE),
            'alamat'    => $this->input->post('alamat', TRUE),
            'email'     => $this->input->post('email', TRUE),
            'selogan'   => $this->input->post('selogan', TRUE),
            'no_telp'   => $this->input->post('no_telp', TRUE),
        ];

        // Proses upload logo
        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path']   = './assets/images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
            $config['max_size']      = 2048; // 2MB
            $config['file_name']     = 'logo_' . date('YmdHis');

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logo')) {
                $upload_data = $this->upload->data();
                $data['logo'] = $upload_data['file_name'];

                // Optional: hapus logo lama jika bukan 'o'
                $old_logo = $this->input->post('old_logo');
                if ($old_logo !== 'o' && file_exists('./assets/images/' . $old_logo)) {
                    @unlink('./assets/images/' . $old_logo);
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('konfigurasi');
            }
        }

        $this->db->where('id', $id);
        $this->db->update('konfigurasi', $data);

        $this->session->set_flashdata('success', 'Konfigurasi toko berhasil diperbarui');
        redirect('konfigurasi');
    }
}
