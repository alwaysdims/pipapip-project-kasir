<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session'); // wajib untuk flashdata
    }

    public function index() {
        $data = [
            'title' => 'Users',
            'users' => $this->db->get('users')->result()
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('user', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function store() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');

        if ($password === $confirm_password && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_data = [
                'username' => $username,
                'password' => $hashed_password
            ];
            $this->db->insert('users', $insert_data);

            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Password tidak sesuai atau kosong');
        }

        redirect('user');
    }

    public function edit($id) {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');

        $update_data = ['username' => $username];

        if (!empty($password)) {
            if ($password === $confirm_password) {
                $update_data['password'] = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $this->session->set_flashdata('error', 'Password tidak sesuai');
                redirect('user');
                return;
            }
        }

        $this->db->where('id', $id);
        $this->db->update('users', $update_data);

        $this->session->set_flashdata('success', 'User berhasil diperbarui');
        redirect('user');
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');

        $this->session->set_flashdata('success', 'User berhasil dihapus');
        redirect('user');
    }
}
