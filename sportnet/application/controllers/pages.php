<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->stencil->slice(array('head', 'header', 'footer', 'banner'));
        $this->stencil->layout('home_layout');
        //load the libraries
        $this->load->helper(array('url', 'date')); //load required helpers
        $this->load->library(array('session', 'email')); //load the session library
        // Load model
        $this->load->model('admin_model', 'adminModel');
        $this->load->model('category_model', 'categoryModel');
        $this->load->model('feed_model', 'feedModel');
    }

    /* ===============================================================================================
     *                                  CATEGORY AND PAGES CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
    function index() {
        $slug = $this->uri->segment(1);
        $data = $this->adminModel->getPageContent($slug);
        if (!empty($data)):
            $this->stencil->title($data[0]->title);
            $info['title'] = $data[0]->title;
            $info['content'] = $data[0]->content;
            $this->stencil->paint('page', $info);
        else:
            $check = $this->categoryModel->checkCategorySlug($slug);
            $category = $this->categoryModel->getCategoryBySlug($slug);
            $categoryName = isset($category->category_name) ? $category->category_name : 'Category';
            $categoryId = isset($category->id) ? $category->id : '';
            if ($check):
                $this->stencil->title($categoryName);
                $result = $this->categoryModel->getAllDataCount($categoryId);
                $config = array();
                $config["base_url"] = site_url() . 'home';
                $config["total_rows"] = $result;
                $config["per_page"] = 22;
                $config["uri_segment"] = 2;
                $limit = $config["per_page"];
                $config['use_page_numbers'] = true;
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 1;
                $offset = $limit * ($page - 1);
                $data["feeds_list"] = $this->categoryModel->getAllData($limit, $offset, $categoryId);
                $data["links"] = $this->pagination->create_links();
                $data["per_page"] = $config["per_page"];
                $data["page"] = ($page == 0) ? 1 : $page;
                $data["category_id"] = $categoryId;
                $this->stencil->paint('category_page', $data);
            else:
                $this->output->set_status_header('404');
                $this->stencil->title('404 Page Not Found');
                $data['subpage_text'] = '404 Page Does not Exist!';
                $this->stencil->data($data);
                $this->stencil->paint('404_view');
            endif;
        endif;
    }

}

/* End of file pages.php */
    /* Location: ./application/controllers/pages.php */    