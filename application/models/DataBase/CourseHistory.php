<?php
/**
 * Description of CourseHistory
 *
 * @author anton
 */

class CourseHistory extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Получение имени таблици из БД.
     * @return string
     */
    public function tableName() {
        return 'currency_history';
    }
    
    /**
     * Получение всех записей истории курса валют.
     * @return array
     */
    public function getAllRecord(){
       $query = $this->db->query("SELECT * FROM {$this->tableName()} ORDER BY created_at DESC");
       return $query->result_array();
    }
    
    /**
     * Сохранение курса валют в базу данных
     * @param array $data
     */
    public function saveRecord(array $data){
        $query = '';
        foreach ($data as $value){
            $insertValues = $this->db->escape($value['ccy']) . ", " .
                    $this->db->escape($value['base_ccy']) . ", " .
                    $this->db->escape($value['buy']) . ", " .
                    $this->db->escape($value['sale']) . "," . 
                    $this->db->escape(date('Y-m-d H:i:s'));
            $query = "INSERT INTO {$this->tableName()} (`ccy`, `base_ccy`, `buy`, `sale`, `created_at`) "
                    . "VALUES ($insertValues)";
            $this->db->query($query);
        } 
        return $data;
    }
}
