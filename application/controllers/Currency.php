<?php
/**
 * Description of Currency
 *
 * @author anton
 */ 
class Currency extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('CurrencyModel');
        $this->load->view('_menu');
    }
    
   public function current_exchange(){
       $this->load->view('current_exchange', ['data' => $this->CurrencyModel->getData()]);
       
    }
    
    public function history_exchange() {
        $this->load->view('history_exchange', ['data' => $this->CurrencyModel->getHistory()]);
    }
}
