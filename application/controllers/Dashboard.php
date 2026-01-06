<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()
	{
		$data = [
			'title' => 'Dashboard'
		];
	
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('dashboard', $data);
		$this->load->view('layouts/footer', $data);
	}
}
