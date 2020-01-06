<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db extends Common_Controller 
{
    public function __construct(){
        parent::__construct();

        $this->load->dbutil();
    }


    public function backup()
    {
        $backup_file = FCPATH . '/DB/' . 'backup-'. date('Y-m-d') .'.sql.gz';

        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file($backup_file, $backup);  
          
        echo 'Backup run successfully.';    
    }

}