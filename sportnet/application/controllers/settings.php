<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//include APPPATH . 'controllers/user.php';

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //Sets the variable $head to use the slice head (/views/slices/head.php)
        $this->stencil->slice(array('admin_sidebar'));
        //load the libraries
        $this->load->helper(array('url', 'date', 'sportnet')); //load required helpers
        $this->load->library(array('session', 'email', 'form_validation')); //load the library 
        //Sets the variable $title to be used in your views
        $this->stencil->title('Admin Dashboard');
        //Sets the layout to be home_layout (/views/layouts/main_layout.php        
        $this->stencil->layout('admin_layout');
        $this->load->model('admin_model', 'adminModel');
        //load the required css
        $this->stencil->css(array('admin_css/bootstrap.min', 'admin_css/bootstrap-responsive.min', 'admin_css/styles'));
    }

    /**
     * Default action of the controller 
     */
    public function index() {
        $this->stencil->title('Ads Management');
        $this->isLoggedIn();
        $this->isAdmin();
        $this->stencil->paint('admin/settings/adds');
    }

    /**
     * Add page controller function where the page content is inserted by the admin
     */
    public function ad() {
        $this->stencil->title('Ads Management');
        $this->isLoggedIn();
        $this->isAdmin();
        $saved = $this->saveAd();
        if ($saved) {
            $this->session->set_flashdata('info', "<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button>The requested ad is updated successfully!</div>");
        } else {
            $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>Error found while updating the ad!</div>");
        }
        redirect('settings');
    }

    /**
     * Function to insert the page into the database 
     * and returns whether the data is saved or not
     * @return boolean 
     */
    protected function saveAd() {
        $page_id = $this->adminModel->saveAd();
        if (isset($page_id) && !empty($page_id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Check wheather the user is logged in or not
     * @return type
     */
    public function isLoggedIn() {

        $udata = $this->session->all_userdata();

        if (isset($udata) && isset($udata['valid']) && isset($udata['is_logged_in'])) {
            if ($udata['valid'] == 1 && $udata['is_logged_in'] == TRUE) {
                return TRUE;
            }

            /* unverified user, show them the confirm page */
            if ($udata['valid'] == 0 && $udata['is_logged_in'] == TRUE) {
                redirect('user/confirm?user=' . $udata['username'] . '&auth=' . base64_encode($udata['auth']));
                return;
            }
        } else {
            $seg = $this->uri->segment(1);
            if ($seg == 'admin') {
                return FALSE;
            }
            redirect('user/login');
        }
        /* something was wrong, destroy and redirect to welcome */
        //redirect(base_url());
        return;
    }

    /**
     * Check wheather the user logged in is Admin or not
     * @return boolean
     */
    public function isAdmin() {
        $udata = $this->session->all_userData();
        if (isset($udata['user_type']) && $udata['user_type'] == 'admin') {
            return;
        }
        redirect(site_url('admin/login'), 'refresh');
        return;
    }

}

?>