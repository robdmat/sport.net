<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mypage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->stencil->slice(array('head', 'header', 'footer', 'banner'));
        $this->stencil->slice(array(
            'banner' => 'mypage/banner',
            'feedback' => 'mypage/feedback',
            'pluses' => 'mypage/pluses',
            'statistics' => 'mypage/statistics',
        ));
        $this->load->helper(array('url', 'date')); //load required helpers
        $this->load->library(array('session', 'pagination', 'email')); //load the session library
        $this->load->model('feed_model', 'feedModel');
        $this->stencil->layout('mypage_layout');
    }

    /* ===============================================================================================
     *                                 USER CONTROL SPLASH PAGE
     * 
     * =============================================================================================== */

    /**
     */
    public function index() {
        $this->stencil->title('My Page');
        $this->stencil->css('font-awesome');
        $this->stencil->paint('user/dashboard/mypage');
    }

}
