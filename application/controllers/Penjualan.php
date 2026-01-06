<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjualan extends CI_Controller {
	public function index()
	{
		$data = [
			'title' => 'Penjualan'
		];
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/sidebar', $data);
		$this->load->view('penjualan', $data);
		$this->load->view('layouts/footer', $data);
	}
}
