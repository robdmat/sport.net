<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
//Sets the variable $head to use the slice head (/views/slices/head.php)
        $this->stencil->slice('head');
        $this->stencil->slice('header');
        $this->stencil->slice('footer');
        $this->stencil->slice('banner');
//Sets the variable $header to use the slice header (/views/slices/header.php)
        $this->load->library(array('session', 'email', 'pagination')); //load the session library
        $this->stencil->layout('home_layout');
        $this->load->model('search_model', 'modelSearch');
    }

    /* ===============================================================================================
     *                                  SEARCH CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
    function index() {
        $this->stencil->title('Search');
        if (isset($_GET['search_item'])) {
            $keyword = $this->input->get('search_item');
            $result = $this->getAllDataCount($keyword);
            $data['keyword'] = $keyword;
            $data['count_results'] = $result;
            $config = array();
            $config["base_url"] = site_url() . 'search';
            $config["total_rows"] = $result;
            $config["per_page"] = 22;
            $config["uri_segment"] = 2;
            $limit = $config["per_page"];
            $config['use_page_numbers'] = true;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 1;
            $offset = $limit * ($page - 1);
            $data["feeds_list"] = $this->getAllData($keyword, $limit, $offset);
            $data["links"] = $this->pagination->create_links();
            $data["per_page"] = $config["per_page"];
            $data["page"] = ($page == 0) ? 1 : $page;
            $this->stencil->paint('search', $data);
        } else {
            redirect('/');
        }
    }

    /* ===============================================================================================
     *                                  LOAD MORE CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
    public function next() {
        $count = $this->feedModel->getAllDataCount();
        $config = array();
        $config["base_url"] = base_url() . "home/next";
        $config["total_rows"] = $count;
        $config["per_page"] = 22;
        $config['use_page_numbers'] = true;
        $config["uri_segment"] = 3;
        $config['num_links'] = '10';
        $config['full_tag_open'] = '<ul class="paginatepag1 mr0" style="margin-left:35%">';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = '<li>FIRST</li>';
        $config['last_link'] = '';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $limit = $config["per_page"];
        $offset = $limit * ($page - 1);
        $feeds_list = $this->getAllData($limit, $offset);
        $pagination_links = $this->pagination->create_links();
        $postsdata = '';
        if (!empty($feeds_list)):
            $default_image = getDefaultImage();
            $default_url = 'javascript:void(0)';
            foreach ($feeds_list as $feed):
                $feed_url = isset($feed->feed_url) ? $feed->feed_url : $default_url;
                $feed_title = isset($feed->feed_title) ? $feed->feed_title : 'title';
                $feed_image_title = isset($feed->feed_image_title) ? $feed->feed_image_title : 'Admin';
                $alt_image = isset($feed->feed_image_title) ? $feed->feed_image_title : '';

                $html = $feed->feed_content;
                preg_match_all('/<img[^>]+>/i', $html, $result);
                $feed_image = $result;
                $date = isset($feed->feed_date) ? $feed->feed_date : date('Y-m-d');
                $feed_image = isset($feed_image[0][0]) ? $feed_image[0][0] : $default_image;
                $avater = isset($feed->feed_image_urls) ? $feed->feed_image_urls : site_url('assets/img/avatar.jpg');
                $postsdata .='<li style="position:absolute">';
                $postsdata .='<div class="item">';
                $postsdata .='<div class="img">';
                $postsdata .='<a href ="' . $feed_url . '">' . $feed_image . '</a>';
                $postsdata .= ' </div>';
                $postsdata .= '<div class="name">';
                $postsdata .= '<a href="' . $feed_url . '">' . $feed_title . '</a>';
                $postsdata .= '</div>';
                $postsdata .= '<div class="bottom table clear_fix">';
                $postsdata .= '<div class="author clear_fix">';
                $postsdata .= '<div class="author_img fl_left">';
                $postsdata .= '<a href="' . $feed_url . '">';
                $postsdata .= '<img class="avatar_class" src = "' . $avater . '" alt = "' . $alt_image . '">';
                $postsdata .= '</a>';
                $postsdata .= '</div>';
                $postsdata .= '<div>';
                $postsdata .= '<div class="author_name">';
                $postsdata .= '<a href="' . $default_url . '">' . $feed_image_title . '</a>';
                $postsdata .= '</div>';
                $postsdata .= '<div class="date">' . date("d-M-y", strtotime($date)) . '</div>';
                $postsdata .= '</div>';
                $postsdata .= ' </div>';
                $postsdata .= '<div class = "icon"><a href="' . $default_url . '"></a></div>';
                $postsdata .= '</div>';
                $postsdata .= '</div>';
                $postsdata .= '</li >';
            endforeach;
            echo$postsdata;
            return;
        else:
            echo '<li class="items nothing_found" id="nothing_found" style="width:100%;text-align:center;float:left">No more feed results!</li>';
            return;
        endif;
    }

    /**
     * Get the count of all the posts
     * @return type
     */
    public function getAllDataCount($keyword) {
        $count = $this->modelSearch->getAllSearchDataCount($keyword);
        return $count;
    }

    /**
     * Get the data
     * @param type $limit
     * @param type $offset
     * @return boolean
     */
    public function getAllData($keyword, $limit, $offset) {
        $data = $this->modelSearch->getAllSearchData($keyword, $limit, $offset);
        if (!empty($data)) {
            return $data;
        } else {
            return FALSE;
        }
    }

}
