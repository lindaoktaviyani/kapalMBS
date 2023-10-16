<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
class Pdf extends Dompdf{
    public $filename;
    public function __construct(){
        parent::__construct();
        $this->filename = "laporan.pdf";
        $options = $this->getOptions();
		$options->setIsHtml5ParserEnabled(true);
		$options->set('isRemoteEnabled', true);
        $this->setOptions($options);
    }
    protected function ci()
    {
        return get_instance();
    }
    public function load_view($view, $data){
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->load_html($html);
        $this->render();
        $this->stream($this->filename, array("Attachment" => true));
    }
}