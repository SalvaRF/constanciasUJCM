<?php
// Include the main TCPDF library (search for installation path).
require_once('./tools/TCPDF/examples/tcpdf_include.php');
class MyPDF extends TCPDF{
    public function __construct() {
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('UJCM');
        $this->SetTitle('Constancia de No Adeudo');
        $this->SetSubject('Protipo Constancias UJCM');
        $this->SetKeywords('UJCM, Constancias, Adeudo');
    
        // remove default header/footer
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);

        $this->AddPage();
        
    }
    public function addCode2D($txt,$x=85,$y=10,$w=0,$h=20){
        // set style for barcode
        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        // Set font
        $this->SetFont('helvetica', 'I', 8);

        $this->write2DBarcode($txt, 'PDF417', $x,$y,$w,$h, $style, 'N');
        // $this->Text($x, $y-3, $txt);

    }
    public function addQR($txt,$x=80,$y=140,$w=30,$h=30){
        // new style
        $style = array(
            'border' => false,
            'padding' => 0,
            'fgcolor' => array(0,0,0),
            'bgcolor' => false
        );
        // Set font
        $this->SetFont('helvetica', 'B', 8);
        // QRCODE,H : QR-CODE Best error correction
        $this->write2DBarcode($txt, 'QRCODE,H', $x,$y,$w,$h, $style, 'N');
        $this->Text($x,$y-4, $txt);
    }
    public function addTable($header,$data){
        $this->SetFont('', 'B');
        $this->SetLineWidth(0.3);
        $this->SetTextColor(255);
        $w = array(10, 70, 20, 20,20, 20, 25);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2],2), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3],2), 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, number_format($row[4],2), 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, number_format($row[2]+$row[3]+$row[4],2), 'LR', 0, 'R', $fill);
            $this->Cell($w[6], 6, $row[6], 'LR', 0, 'C', $fill);
           // $this->Cell($w[7], 6, $row[7], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');

    }
}