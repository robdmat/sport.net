<?php

/**
 * Description of dashboard
 *
 * @author dimpy
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    protected $node;

    public function __construct() {
        parent::__construct();
//Sets the variable $head to use the slice head (/views/slices/head.php)
        $this->stencil->slice(array('head', 'header', 'dashboard_footer', 'banner'));
//Sets the variable $header to use the slice header (/views/slices/header.php)
//load the libraries
        $this->lang->load("common", $this->session->userdata('site_lang'));
        $this->load->helper(array('url', 'date', 'webmaster')); //load required helpers
        $this->load->library(array('session', 'pagination', 'email')); //load the session library
        $this->config->load('facebook'); //load the facebook config file
        $this->load->model('feed_model', 'feedModel');
        $this->load->model('category_model', 'categoryModel');
    }

    /**
     * Default function
     */
    public function index() {
        $this->stencil->title('Sports Net');
        $data['categories'] = $this->categoryModel->getParentCategories();
        $this->stencil->layout('dashboard_layout');
        $this->stencil->css('font-awesome');
        $this->stencil->data('welcome_text', 'Welcome to Stencil!');
        $this->stencil->paint('user/dashboard/explore', $data);
    }

    /* ===============================================================================================
     *                                  CATEGORY DISPLAY 
     * 
     * =============================================================================================== */

    /**
     */
    public function categorySubList() {
        $id = $this->input->post('id', TRUE);
        $selected = $this->input->post('selected', TRUE);
        if (isset($id) || $id != ''):
            //delete the requested user
            $chck = $this->categoryModel->getSubCategoriesListByParentId($id);
            if (empty($chck)):
                $getByid = $this->categoryModel->getCategoryListById($id);
                if (!empty($getByid)):
                    foreach ($getByid as $cat):
                        $checked = backChecked($cat->id, $selected);
                        echo '<ul id="checkList_' . $cat->id . '" class="chk-list-wrap light clear_fix">';
//                        echo '<li><strong class="title">' . $cat->category_name . '</strong><div class="checkbox chk-all">
//                                        <label><input type="checkbox"><span>' . $cat->category_name . '</span></label>
//                                    </div>';
                        echo '<li><strong class="title">' . $cat->category_name . '</strong><div class="checkbox chk-all">
                                        <label><input class="' . $cat->category_name . '" name="isCheckedAll" id="' . $cat->id . '"  class="' . $cat->category_name . '" type="checkbox" id="' . $cat->id . '" value="' . $cat->id . '"' . $checked . '><span>All From &nbsp;' . $cat->category_name . '</span></label>
                                    </div>';
                        echo '</ul>';
                    endforeach;
                endif;
            else:
                $html = getList($id, $selected);
                echo $html;
            endif;
        endif;
    }

}
