<?php
// Include the main TCPDF library (search for installation path).
require_once('./tools/TCPDF/examples/tcpdf_include.php');
class MyPDFNoAdeudo extends TCPDF{
    public function __construct($institucion=null,$telefono=null,$direccion=null) {
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $this->institucion=$institucion;
        $this->telefono=$telefono;
        $this->direccion=$direccion;
        // set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('UJCM');
        $this->SetTitle('Constancia No Adeudo');
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
        /* $html='
            <h2 align="center">'.$this->institucion.'</h2>
            <h4 align="center">OFICINA DE ECONOMÍA Y FINANZAS</h4>
        ';
        $this->writeHTML($html,true,false,true,false,''); */

    }
    public function firma(){
        $hoy = getdate();
        $fecha = $hoy['mday'].'-'.$hoy['mon'].'-'.$hoy['year'];
        $fecha .= ' '. $hoy['hours'].':'.$hoy['minutes'].':'.$hoy['seconds'];

        $posX=120; $posY=150;
        $anchoX=15; $altoY=15;

        // set certificate file
        //$certificado = 'file://'.realpath('assets/certificados/tcpdf.crt');
       // $certificado = 'file://'.realpath('assets/certificados/Salvador.crt');
        $certificado = 'file://'.realpath('assets/certificados/certificate.crt');
        $keyPrivada = 'file://'.realpath('assets/certificados/privatekey.pem');

            $info = array(
            'Name' => 'UJCM',
            'Location' => 'Investigación',
            'Reason' => 'Certificado de No Adeudo',
            'ContactInfo' => 'http://www.ujcm.edu.pe',
            );
        
        // *** set signature appearance ***

        // create content for signature (image and/or text)
      // $this->Image('assets/images/logo01.png', $posX, $posY, $anchoX, $altoY, 'PNG');
       $this->Image('./tools/images/ujcm.png', $posX, $posY, $anchoX, $altoY, 'PNG');
       $this->SetFont('helvetica', '', 10);
       $this->Text($posX+$anchoX,$posY, 'Firmado por:');
       $this->SetFont('helvetica', '', 8);
       $this->Text($posX+$anchoX,$posY+6, 'Juan Ubaldo Jimenez Castilla');
       $this->Text($posX+$anchoX,$posY+12, $fecha);

        // define active area for signature appearance
      //  $this->setSignatureAppearance($posX, $posY, $anchoX, $altoY);

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

        // *** set an empty signature appearance ***
        // $this->addEmptySignatureAppearance($posX, $posY+20, $anchoX, $altoY);
        // set document signature
        $this->setSignature($certificado, $keyPrivada, 'UJCM2024', '', 2, $info);

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
    public function addTable($data){
        $header = [
            'Id','CONCEPTO','IMPORTE','RECARGO','INTERES','TOTAL','FECHA. VENC.'
        ];
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
        // $this->Cell(array_sum($w), 0, '', 'T');

    }
    
}