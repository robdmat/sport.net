<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//load the facebook sdk
require_once APPPATH . 'libraries/facebook/facebook.php';

class Home extends CI_Controller {

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
     *                                  HOME CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
    public function index() {
        $this->stencil->title('Sport.net');
        $this->stencil->layout('home_layout');
        $this->stencil->css('font-awesome');
        $result = $this->getAllDataCount();
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
        $data["feeds_list"] = $this->getAllData($limit, $offset);
        $data["links"] = $this->pagination->create_links();
        $data["per_page"] = $config["per_page"];
        $data["page"] = ($page == 0) ? 1 : $page;
        $this->stencil->paint('home_view', $data);
    }

    /**
     * Get the count of all the posts
     * @return type
     */
    public function getAllDataCount() {
        $count = $this->feedModel->getAllDataCount();
        return $count;
    }

    /**
     * Get the data
     * @param type $limit
     * @param type $offset
     * @return boolean
     */
    public function getAllData($limit, $offset) {
        $data = $this->feedModel->getAllData($limit, $offset);
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
        $count = $this->feedModel->getAllDataCount();
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
        $feeds_list = $this->getAllData($limit, $offset);
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
                if ($countForAd == 4):
                    $postsdata.='<li class="sponserList"' . $sponserList . '>';
                    $postsdata.='<div class="item sponsor">';
                    $postsdata.='<div class="img">';
                    $postsdata.='<a href="javascript:void(0)">' . sidebarAd() . '</a>';
                    $postsdata.='</div>';
                    $postsdata.='<div class="ads text_center">';
                    $postsdata.='<a href="javascript:void(0)">SPONSOR ADS</a>';
                    $postsdata.='</div>';
                    $postsdata.='</div>';
                    $postsdata.='</li>';
                endif;
                if ($countForAd == 13):
                    $postsdata.='<li class="sponserList"' . $sponserList . '>';
                    $postsdata.='<div class="small_height">';
                    $postsdata.='<div class="item">';
                    $postsdata.='<div class="img_class">';
                    $postsdata.='<a href="javascript:void(0)">' . pageinsideAd() . '</a>';
                    $postsdata.='</div>';
                    $postsdata.='</div>';
                    $postsdata.='</div>';
                    $postsdata.='<div class="small_height">';
                    $postsdata.='<div class="item">';
                    $postsdata.='<div class="img_class">';
                    $postsdata.='<a href="javascript:void(0)">' . pageinsideTwo() . '</a>';
                    $postsdata.='</div>';
                    $postsdata.='</div>';
                    $postsdata.='</div>';
                    $postsdata.='</li>';
                endif;
                $postsdata .='<li>';
                $postsdata .='<div class="item">';
                $postsdata .='<div class="img getImage">';
                $postsdata .='<a href ="' . $feed_url . '">' . $feed_image . '</a>';
                $postsdata .= ' </div>';
                $postsdata .= '<div class="rightSide">';
                $postsdata .= '<div class="name">';
                $postsdata .= '<a href="' . $feed_url . '">' . $feed_title . '</a>';
                $postsdata .= '</div>';
                $postsdata .= '<div class="description textStyle" ' . $description . '>' . strip_tags(substr($html, 0, 800)) . '</div>';
                $postsdata .= '</div>';
                $postsdata .= '<div class="bottom table wd100_wd clear_fix">';
                $postsdata .= '<div class="author wd80_wd clear_fix">';
                $postsdata .= '<div class="author_img fl_left">';
                $postsdata .= '<a href="' . $feed_url . '">';
                $postsdata .= '<img class="avatar_class" src = "' . $favicon . '" alt = "' . $alt_image . '">';
                $postsdata .= '</a>';
                $postsdata .= '</div>';
                $postsdata .= '<div>';
                $postsdata .= '<div class="author_name">';
                $postsdata .= '<a href="' . $default_url . '">' . $feed_title_truncated . '</a>';
                $postsdata .= '</div>';
                $postsdata .= '<div class="date">' . date("d-M-y", strtotime($date)) . '</div>';
                $postsdata .= '</div>';
                $postsdata .= ' </div>';

                $postsdata .= '<div class="main_content_share_button wd20_wd" style="">
                                <script type="text/javascript">var switchTo5x = true;</script>
                                <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                                <script type="text/javascript">stLight.options({publisher: "d661bce1-3df6-41f2-a167-27cb74203fc1", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                                <div id="slideToggleParent_' . $feed->id . '" class="main_content_share" style="display: none">
                                    <span class="st_facebook_large" displayText="Facebook"></span>
                                    <span class="st_twitter_large" displayText="Tweet"></span>
                                    <span class="st_email_large" displayText="Email"></span>
                                    <span class="st_plusone_large" displayText="Google +1"></span>
                                </div>
                                <div id="slideToggle_' . $feed->id . '" onclick="javascript:getShareDiv(' . $feed->id . ')" class="icon slideToggle">
                                    <a href="javascript:void(0)"></a>
                                </div>
                            </div>';
                $postsdata .= '</div>';
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