<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$method = $this->router->fetch_method();

		if ($this->session->userdata('logged_in') && $method !== 'logout') {
			redirect('dashboard');
		}
	}


    public function index() {
        $this->load->view('auth');
    }

    public function login() {
        $username = $this->input->post('username'); 
        $password = $this->input->post('password');

        // ambil user berdasarkan username
        $user = $this->db->get_where('users', ['username' => $username])->row();

        if ($user) {
            // cek password hash
            if (password_verify($password, $user->password)) {

                // set session login
                $this->session->set_userdata([
                    'user_id'  => $user->id,
                    'username' => $user->username,
                    'logged_in'=> true
                ]);
				
                $this->session->set_flashdata('success', 'Anda berhasil login!');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password salah');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan');
            redirect('auth');
        }
    }
	public function logout() {
		$this->session->sess_destroy();
		$this->session->set_flashdata('success', 'Logout berhasil!');
		redirect('auth');
	}	
}
