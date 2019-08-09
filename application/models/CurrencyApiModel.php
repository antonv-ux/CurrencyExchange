<?php
/**
 * Description of Money_model
 *
 * @author anton
 */

/**
 * Класс для получение курса валют по API
 */
class CurrencyApiModel extends CI_Model {
    
   /**
    * Получение ссылки API курса валют
    * @return string
    */
    public function get_url() {
        return 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5';
    }
    
    /**
     * Получение данных о курсе валют
     * @return array
     */
    public function data() {
        $data = file_get_contents($this->get_url());
        return json_decode ($data, true);
    }
}
