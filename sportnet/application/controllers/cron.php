<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //load the model for the blog 
        $this->load->model('cron_model', 'cronModel', TRUE);
    }

    /**
     * Default function of the controller to add the blogs 
     * in to the database as per the date 
     * **This is the cron job which will get the blog as per the updated date
     *  and then update the data 
     * 
     */
    public function index() {
        error_reporting(E_ALL);
        $this->cronModel->setCron();
    }

}

?>
