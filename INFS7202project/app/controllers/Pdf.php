<?php
include_once APPROOT.'/helpers/TCPDF/tcpdf.php';
        
class Pdf extends Controller{
    public function __construct(){
        $this->ProductModel = $this->model('ProductModel');
    }

    public function index(){
        $this->view('includes/header');
        echo '<div class="col-12 text-center">Error 404: page not found</div>';
        $this->view('includes/footer');
    }
    
    public function download($ProductID = null) {
        // Redirect to Product search page (default) if no Product id is provided
        if($ProductID == null) {
            redirect('pdf');
        }

        // Get Product data
        $Product = $this->ProductModel->getProductData($ProductID);

        // If Product does not exist redirect to search page
        if($Product == null) {
            redirect('pdf');
        }

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetAuthor('TheProductsProject');
        $pdf->SetTitle($Product->short_des);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->AddPage();
        $html = '<h1 style="text-align:center">'.$Product->short_des.'</h1>
        <p style="text-align:center">Author: '.$Product->uid.'</p>
        <img src="images/products'.$Product->imagePath.'" style="text-align:center;object-fit:cover;height: 200px; max-width: 90%;" alt="Product Preview Image Here">
        <h4>Description: </h4><p>'.$Product->long_des.'</p>
        <h4>Quantity: </h4><p>'.$Product->quantity.'</p>
        <h4>Price: </h4><p>'.$Product->price.'</p>';

        // writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
        $pdf->writeHTML($html, true, false, true, false);

        // Output to screen for view/download
        ob_end_clean();
        $pdf->Output('hello_world.pdf'); 
    }
}