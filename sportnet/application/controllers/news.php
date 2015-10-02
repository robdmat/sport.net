<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//load the facebook sdk
require_once APPPATH . 'libraries/facebook/facebook.php';

class News extends CI_Controller {

    protected $node;

    public function __construct() {
        parent::__construct();
//Sets the variable $head to use the slice head (/views/slices/head.php)
        $this->stencil->slice(array('head', 'header', 'footer', 'banner'));
//Sets the variable $header to use the slice header (/views/slices/header.php)
//load the libraries
        $this->lang->load("common", $this->session->userdata('site_lang'));
        $this->load->helper(array('url', 'date', 'webmaster')); //load required helpers
        $this->load->library(array('session', 'pagination', 'email')); //load the session library
        $this->config->load('facebook'); //load the facebook config file
        $this->load->model('feed_model', 'feedModel');
    }

    /* ===============================================================================================
     *                                  News FEED CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
//    function _remap($method, $args) {
//        $this->index($method, $args);
//    }

    public function index() {
        $type = 'news';
        $this->stencil->title('Sport.net | News');
        $this->stencil->layout('home_layout');
        $result = $this->getAllDataCount($type);
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
        $data["feeds_list"] = $this->getAllData($limit, $offset, $type);
        $data["links"] = $this->pagination->create_links();
        $data["per_page"] = $config["per_page"];
        $data["page"] = ($page == 0) ? 1 : $page;
        $this->stencil->paint('news/news_view', $data);
    }

    /**
     * Get the count of all the posts
     * @return type
     */
    public function getAllDataCount($type) {
        $count = $this->feedModel->getAllNewsDataCount($type);
        return $count;
    }

    /**
     * Get the data
     * @param type $limit
     * @param type $offset
     * @return boolean
     */
    public function getAllData($limit, $offset, $type) {
        $data = $this->feedModel->getAllNewsData($limit, $offset, $type);
        if (!empty($data)) {
            return $data;
        } else {
            return FALSE;
        }
    }

    /* ===============================================================================================
     *                                  AJAX NEXT SET CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
    public function next() {
        $type = 'news';
        $pagination = $this->input->post('page', TRUE);
        $ulclass = $this->input->post('ulclass', TRUE);
        if (isset($ulclass) && $ulclass == 'true'):
            $sponserList = 'style="display:none"';
            $description = 'style="display:block"';
        else:
            $sponserList = 'style="display:block"';
            $description = 'style="display:none"';
        endif;
        if (isset($pagination) && $pagination != ''):
            $next_set = $pagination;
        else:
            $next_set = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        endif;
        $count = $this->feedModel->getAllDataCount($type);
        $config = array();
        $config["base_url"] = base_url() . "home/next";
        $config["total_rows"] = $count;
        $config["per_page"] = 22;
        $config['use_page_numbers'] = true;
        $config["uri_segment"] = 3;
        $config['num_links'] = '10';
        $config['last_link'] = '';
        $this->pagination->initialize($config);
        $page = $next_set;
        $limit = $config["per_page"];
        $offset = $limit * ($page - 1);
        $feeds_list = $this->getAllData($limit, $offset, $type);
        $pagination_links = $this->pagination->create_links();
        $postsdata = '';
        $countForAd = 1;
        if (!empty($feeds_list)):
            $default_image = getDefaultImage();
            $default_url = 'javascript:void(0)';
            foreach ($feeds_list as $feed):
                $feed_url = isset($feed->feed_url) ? $feed->feed_url : $default_url;
                $feed_title = isset($feed->feed_title) ? $feed->feed_title : 'title';
//                Get the title
                $feed_image_title = isset($feed->feed_user_title) ? $feed->feed_user_title : 'Admin';
                $feed_title_truncated = substr($feed_image_title, 0, 40);
                $alt_image = isset($feed->feed_image_title) ? $feed->feed_image_title : '';
// Feed content to remove the html tags and get the first image
                $html = $feed->feed_content;
                preg_match_all('/<img[^>]+>/i', $html, $result);
                $feed_image = $result;
                $date = isset($feed->feed_date) ? $feed->feed_date : date('Y-m-d');
                $feed_image = isset($feed_image[0][0]) ? $feed_image[0][0] : $default_image;
//                $avater = isset($feed->feed_image_urls) ? $feed->feed_image_urls : site_url('assets/img/avatar.jpg');
                $avatar = feedIconByUrl($feed->feed_admin_url);
                if (!empty($avatar)):
                    $favicon = site_url() . 'uploads/feed/' . $avatar;
                else:
                    $favicon = site_url('assets/img/avatar.jpg');
                endif;
                $postsdata .='<li>';
                $postsdata .='<div class="item video clear_fix">';
                $postsdata .='<div class="img fl_left">';
                $postsdata .='<a href="' . site_url() . 'feeds/preview/' . $feed->feed_content_hash . '">';
                if (file_exists($feed_image)) {
                    $feed_image;
                } else {
                    $default_image;
                }
                $postsdata .='</a>';
                $postsdata .='</div>';
                $postsdata .='<div class="info">';
                $postsdata .='<div class="name">';
                $postsdata .='<a href="' . site_url() . 'feeds/preview/' . $feed->feed_content_hash . '">' . ($feed->feed_title) . '</a>';
                $postsdata .='</div>';
                $postsdata .='<div class = "text">' . strip_tags(substr($html, 0, 800)) . '</div>';
                $postsdata .='<div class="bottom table clear_fix">';
                $postsdata .=' <div class="author clear_fix">';
                $postsdata .='<div class="author_img fl_left">';
                $postsdata .='<a href="#">';
                $postsdata .='<img alt="Ashley Clements" src="' . site_url() . '/assets/img/avatar.jpg' . '">';
                $postsdata .='</a>';
                $postsdata .='</div>';
                $postsdata .='<div>';
                $postsdata .='<div class="author_name">';
                $postsdata .='<a href="#">' . $feed_title . '</a>';
                $postsdata .='</div>';
                $postsdata .='<div class="date">' . nicetime($date) . '</div>';
                $postsdata .='</div>';
                $postsdata .='</div>';
                $postsdata .='<div class="icon">';
                $postsdata .='<a href="#"></a>';
                $postsdata .='</div>';
                $postsdata .='</div>';
                $postsdata .='</div>';
                $postsdata .='</div>';
                $postsdata .= '</li>';
                $countForAd++;
            endforeach;
            echo$postsdata;
            return;
        else:
            return;
        endif;
    }

//Example of using a different Layout
    public function subpage() {
        $this->stencil->title('Subpage Example');
        $this->stencil->layout('subpage_layout');
        $this->stencil->slice('sidebar');
        $data['subpage_text'] = 'A Subpage Example!';
        $this->stencil->paint('example_view', $data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */