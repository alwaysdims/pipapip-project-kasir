<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {
	public function index()
	{
		$data = [
			'title' => 'Pengeluaran'
		];
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('pengeluaran', $data);
		$this->load->view('layouts/footer', $data);
	}
}
