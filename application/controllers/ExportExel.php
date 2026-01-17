<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class ExportExel extends CI_Controller {

    public function export()
    {
        // ... (Bagian Query Data Tetap Sama) ...
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $customer_id = $this->input->post('customer_id');
        $where_customer = ($customer_id != 'semua') ? " AND t.customer_id = " . $this->db->escape($customer_id) : "";
        
        $data_penjualan = $this->db->query("SELECT t.id, t.kode_transaksi, t.tanggal, c.nama AS customer_nama, t.total_belanja, t.total_jual 
                            FROM transaksi t JOIN customers c ON t.customer_id = c.id 
                            WHERE DATE(t.tanggal) BETWEEN " . $this->db->escape($tanggal_awal) . " AND " . $this->db->escape($tanggal_akhir) . $where_customer . " 
                            ORDER BY t.tanggal ASC")->result_array();
        
        $total_penjualan = $this->db->query("SELECT SUM(t.total_belanja) AS total_belanja_sum, SUM(t.total_jual) AS total_jual_sum 
                                  FROM transaksi t WHERE DATE(t.tanggal) BETWEEN " . $this->db->escape($tanggal_awal) . " AND " . $this->db->escape($tanggal_akhir) . $where_customer)->row_array();
        
        $data_pengeluaran = $this->db->query("SELECT p.id, p.tanggal, tp.nama AS tipe_nama, p.keterangan, p.jumlah 
                                FROM pengeluaran p JOIN tipe tp ON p.tipe_id = tp.id 
                                WHERE DATE(p.tanggal) BETWEEN " . $this->db->escape($tanggal_awal) . " AND " . $this->db->escape($tanggal_akhir) . " 
                                ORDER BY p.tanggal ASC")->result_array();

        $total_pengeluaran = $this->db->query("SELECT SUM(p.jumlah) AS total_pengeluaran_sum FROM pengeluaran p 
                                    WHERE DATE(p.tanggal) BETWEEN " . $this->db->escape($tanggal_awal) . " AND " . $this->db->escape($tanggal_akhir))->row_array()['total_pengeluaran_sum'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- DEFINISI STYLE ---
        $format_rp = '_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"_-;_-@_-';

        $style_header_table = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        $style_border_thin = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        // --- HEADER LAPORAN ---
        $sheet->setCellValue('A1', 'LAPORAN KEUANGAN');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$sheet->setCellValue('A2', 'Periode: ' . date('d/m/Y', strtotime($tanggal_awal)) . ' - ' . date('d/m/Y', strtotime($tanggal_akhir)));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // --- I. PENJUALAN ---
        $row = 4;
        $sheet->setCellValue('A'.$row, 'I. DATA PENJUALAN');
        $row++;
        $header_penjualan = ['No', 'Tanggal', 'Kode', 'Customer', 'Modal', 'Harga Jual', 'Margin', '%'];
        $sheet->fromArray($header_penjualan, NULL, 'A'.$row);
        $sheet->getStyle('A'.$row.':H'.$row)->applyFromArray($style_header_table);

        $row++;
        $start_row_pj = $row;
        $no = 1;
        foreach ($data_penjualan as $v) {
            $margin = $v['total_jual'] - $v['total_belanja'];
            $persen = ($v['total_jual'] > 0) ? ($margin / $v['total_jual']) : 0;
            
            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValue('B'.$row, date('d/m/Y', strtotime($v['tanggal'])));
            $sheet->setCellValue('C'.$row, $v['kode_transaksi']);
            $sheet->setCellValue('D'.$row, $v['customer_nama']);
            $sheet->setCellValue('E'.$row, $v['total_belanja']);
            $sheet->setCellValue('F'.$row, $v['total_jual']);
            $sheet->setCellValue('G'.$row, $margin);
            $sheet->setCellValue('H'.$row, $persen);
            $row++;
        }
        
        // Summary Penjualan (Footer Tabel Penjualan)
        $sheet->setCellValue('A'.$row, 'TOTAL PENJUALAN');
        $sheet->mergeCells("A$row:D$row");
        $sheet->setCellValue('E'.$row, $total_penjualan['total_belanja_sum']);
        $sheet->setCellValue('F'.$row, $total_penjualan['total_jual_sum']);
        $sheet->setCellValue('G'.$row, "=F$row-E$row"); // Rumus Excel
        $sheet->setCellValue('H'.$row, "=G$row/F$row");
        
        // Terapkan Border dan Format Rp pada Tabel Penjualan
        $sheet->getStyle("A$start_row_pj:H$row")->applyFromArray($style_border_thin);
        $sheet->getStyle("E$start_row_pj:G$row")->getNumberFormat()->setFormatCode($format_rp);
        $sheet->getStyle("H$start_row_pj:H$row")->getNumberFormat()->setFormatCode('0.00%');
        $sheet->getStyle("A$row:H$row")->getFont()->setBold(true);

        // --- II. PENGELUARAN ---
        $row += 3;
        $sheet->setCellValue('A'.$row, 'II. PENGELUARAN OPERASIONAL');
        $row++;
        $header_pengeluaran = ['No', 'Tanggal', 'Tipe', 'Keterangan', 'Nominal'];
        $sheet->fromArray($header_pengeluaran, NULL, 'A'.$row);
        $sheet->getStyle('A'.$row.':E'.$row)->applyFromArray($style_header_table);

        $row++;
        $start_row_pg = $row;
        foreach ($data_pengeluaran as $key => $p) {
            $sheet->setCellValue('A'.$row, ($key+1));
            $sheet->setCellValue('B'.$row, date('d/m/Y', strtotime($p['tanggal'])));
            $sheet->setCellValue('C'.$row, $p['tipe_nama']);
            $sheet->setCellValue('D'.$row, $p['keterangan']);
            $sheet->setCellValue('E'.$row, $p['jumlah']);
            $row++;
        }
        $sheet->setCellValue('A'.$row, 'TOTAL PENGELUARAN');
        $sheet->mergeCells("A$row:D$row");
        $sheet->setCellValue('E'.$row, $total_pengeluaran);
        
        // Terapkan Border dan Format Rp pada Tabel Pengeluaran
        $sheet->getStyle("A$start_row_pg:E$row")->applyFromArray($style_border_thin);
        $sheet->getStyle("E$start_row_pg:E$row")->getNumberFormat()->setFormatCode($format_rp);
        $sheet->getStyle("A$row:E$row")->getFont()->setBold(true);

        // --- III. RINGKASAN LABA BERSIH ---
        $row += 3;
        $sheet->setCellValue('A'.$row, 'III. RINGKASAN LABA BERSIH');
        $sheet->getStyle('A'.$row)->getFont()->setBold(true);
        
        $sheet->setCellValue('A'.($row+1), 'Total Laba Kotor (Margin)');
        $sheet->setCellValue('B'.($row+1), $total_penjualan['total_jual_sum'] - $total_penjualan['total_belanja_sum']);
        
        $sheet->setCellValue('A'.($row+2), 'Total Pengeluaran');
        $sheet->setCellValue('B'.($row+2), $total_pengeluaran);
        
        $sheet->setCellValue('A'.($row+3), 'LABA BERSIH (NET PROFIT)');
        $sheet->setCellValue('B'.($row+3), "=B".($row+1)."-B".($row+2));

        // Format Ringkasan
        $sheet->getStyle("A$row:B".($row+3))->applyFromArray($style_border_thin);
        $sheet->getStyle("B".($row+1).":B".($row+3))->getNumberFormat()->setFormatCode($format_rp);
        $sheet->getStyle("A".($row+3).":B".($row+3))->getFont()->setBold(true);
        $sheet->getStyle("A".($row+3).":B".($row+3))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9EAD3');

        // --- AUTO SIZE ---
        foreach (range('A','H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // --- OUTPUT ---
        $filename = "Laporan_Keuangan_".date('Ymd').".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
