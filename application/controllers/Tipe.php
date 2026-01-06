<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipe extends CI_Controller {
	public function index()
	{
		$data = [
			'title' => 'Tipe pengeluaran'
		];

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('tipe', $data);
		$this->load->view('layouts/footer', $data);
	}
}
