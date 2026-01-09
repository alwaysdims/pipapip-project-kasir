<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$today = date('Y-m-d');

        $this->db->select('SUM(total) as penjualan_hari_ini');
        $this->db->from('transaksi');
        $this->db->where('DATE(tanggal)', $today);
        $query = $this->db->get();
        $penjualan = $query->row()->penjualan_hari_ini ?? 0;

        $this->db->select('COUNT(*) as produk_terjual');
        $this->db->from('detail_transaksi dt');
        $this->db->join('transaksi t', 'dt.transaksi_id = t.id');
        $this->db->where('DATE(t.tanggal)', $today);
        $query = $this->db->get();
        $produk_terjual = $query->row()->produk_terjual ?? 0;

        $total_bahan = $this->db->count_all('bahan');

        $total_customer = $this->db->count_all('customers');
		$customers = $this->db->get('customers')->result();


		$labels = [];
		$values = [];

		for ($i = -2; $i <= 2; $i++) {

			$bulan = date('m', strtotime("$i month"));
			$tahun = date('Y', strtotime("$i month"));

			$labels[] = date('M Y', strtotime("$tahun-$bulan-01"));

			$this->db->select('SUM(total) as total_bulanan');
			$this->db->from('transaksi');
			$this->db->where('MONTH(tanggal)', $bulan);
			$this->db->where('YEAR(tanggal)', $tahun);

			$result = $this->db->get()->row();
			$values[] = $result->total_bulanan ?? 0;
		}

		$this->db->select('kode_transaksi, tanggal, total');
		$this->db->from('transaksi');
		$this->db->where('DATE(tanggal)', $today);
		$this->db->order_by('tanggal', 'DESC');
		$this->db->limit(7);
		$penjualan_hari_ini_list = $this->db->get()->result();

        $data = [
            'title'           => 'Dashboard',
            'penjualan_hari_ini' => number_format($penjualan, 0, ',', '.'),
            'produk_terjual'     => number_format($produk_terjual, 0, ',', '.'),
            'total_bahan'        => number_format($total_bahan, 0, ',', '.'),
            'total_customer'     => number_format($total_customer, 0, ',', '.'),
			'customers'			=> $customers,
			'chart_labels' => json_encode($labels),
			'chart_values' => json_encode($values),
			'penjualan_hari_ini_list' => $penjualan_hari_ini_list,
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('layouts/footer', $data);
    }
}
