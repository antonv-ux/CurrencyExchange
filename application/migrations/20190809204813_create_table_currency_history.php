<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 *
 * @author anton
 */
class Migration_create_table_currency_history extends CI_Migration {
    
    public function up() {
        $this->dbforge->add_field([
                'id' => [
                        'type' => 'INT',
                        'constraint' => 10,
                        'unsigned' => FALSE,
                        'auto_increment' => TRUE,
                ],
                'ccy' => [
                        'type' => 'ENUM',
                        'constraint' => ['UAH', 'USD', 'RUR', 'EUR', 'BTC'],
                        'null' => FALSE,
                ],
                'base_ccy' => [
                        'type' => 'ENUM',
                        'constraint' => ['UAH', 'USD', 'RUR', 'EUR', 'BTC'],
                        'null' => FALSE,
                ],
                'buy' => [
                        'type' => 'FLOAT',
                        'null' => FALSE,
                ],
                'sale' => [
                        'type' => 'FLOAT',
                        'null' => FALSE,
                ],
                'created_at' => [
                        'type' => 'TIMESTAMP',
                        'null' => FALSE,
                ],
        ]);
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('currency_history');
    }
     public function down()
    {
        $this->dbforge->drop_table('currency_history');
    }

}
