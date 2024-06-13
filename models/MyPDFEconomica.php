<?php
// Include the main TCPDF library (search for installation path).
require_once('./tools/TCPDF/examples/tcpdf_include.php');
class MyPDFEconomica extends TCPDF{
    public function __construct($institucion=null,$telefono=null,$direccion=null) {
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $this->institucion=$institucion;
        $this->telefono=$telefono;
        $this->direccion=$direccion;
        // set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('UJCM');
        $this->SetTitle('Constancia Economica');
        $this->SetSubject('Protipo Constancias UJCM');
        $this->SetKeywords('UJCM, Constancias, Adeudo');
    
        // remove default header/footer
        $this->setMargins(25,35,25);
        $this->setHeaderMargin(20);
        $this->setPrintHeader(true);
        $this->setPrintFooter(true);

        $this->AddPage();
        
    }
    public function Header(){
        $this->Image('./tools/images/ujcm.png', 25, 10, 15, 15, 'PNG');
        $this->Image('./tools/images/eco_finanza_UJCM.jpg', 175, 10, 15, 15, 'JPG');
        $this->setY(13);
        $html='
            <h2 align="center">'.$this->institucion.'</h2>
            <h4 align="center">OFICINA DE ECONOMÍA Y FINANZAS</h4>
        ';
        $this->writeHTML($html,true,false,true,false,'');

    }
    public function Footer(){
        $this->setY(-21);
        $this->SetFont('helvetica', '', 8);
        $this->Text(30,$this->getY(), 'c.c. Archivo');

        $this->setY(-15);

        $html='
        <p style="border-top:1px solid #999">&nbsp;</p>
           
        ';
        $this->writeHTML($html,true,false,true,false,'');
        $this->setY(-15);
        
        $this->Text(30,$this->getY(), $this->direccion);
        $this->Text(160,$this->getY(), 'Cel.:'.$this->telefono);
        $this->Text(30,$this->getY()+3, 'Moquegua');

    }
    public function addCode2D($txt,$x=20,$y=40,$w=0,$h=20){
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
    
}