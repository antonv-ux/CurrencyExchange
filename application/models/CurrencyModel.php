<?php
/**
 * Description of CurrencyModel
 *
 * @author anton
 */

class CurrencyModel extends CI_Model{
    
    const CACHE_DURATION_SEC = 30; // Время жизни кэша в секундах
    const CACHE_KEY = 'exchange_currency_cache_key';// Ключ кэша в котором хранятся данные о валютах
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['CurrencyApiModel', 'DataBase/CourseHistory']);
        $this->load->driver('cache',['adapter' => 'file']);
    }
    
    /**
     * Метод для получения истории курса валют
     * @return array
     */
    public function getHistory(){
        return $this->CourseHistory->getAllRecord();
    }
    
    /**
     * Метод для получения данных (Либо из КЭШ либо по API)
     * @return array
     */
    public function getData () {
        if ($this->cache->get(self::CACHE_KEY) === FALSE){
            $result = $this->CourseHistory->saveRecord($this->CurrencyApiModel->data());
            $this->cache->file->save(self::CACHE_KEY, $result, self::CACHE_DURATION_SEC );
        } 
        return $this->cache->get(self::CACHE_KEY);
    }
    
}
