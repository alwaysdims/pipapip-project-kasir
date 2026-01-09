<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator
{
    public function generate($html, $filename = '', $paper = 'A4', $orientation = 'portrait', $stream = TRUE)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        if ($stream) {
            $dompdf->stream($filename . ".pdf", ["Attachment" => 0]);
            exit;
        }

        return $dompdf->output();
    }
}
