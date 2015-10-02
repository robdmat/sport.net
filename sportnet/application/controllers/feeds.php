<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feeds extends CI_Controller {

    // Important Links
    //http://samueljcarlson.blogspot.in/2011/12/rss-feeds-to-mysql-database-script.html
    //http://dannyherran.com/2013/06/how-to-load-and-use-simplepie-1-3-with-codeigniter-2-1/
    public function __construct() {
        parent::__construct();

        //Sets the variable $head to use the slice head (/views/slices/head.php)
        $this->stencil->slice(array('admin_sidebar'));
        //load the libraries
        $this->load->helper(array('url', 'date', 'sportnet')); //load required helpers
        $this->load->library(array('session', 'email', 'form_validation')); //load the library 
        $this->load->model('admin_model', 'adminModel');

        //        Required Model
        $this->load->model('feed_model', 'feedModel');
        $this->load->helper('csv');
    }

    /**
     * Default function for the controller
     */
    public function index() {
        $this->stencil->title('Feeds');
        $this->stencil->layout('admin_layout');
        $this->stencil->css(array('admin_css/bootstrap.min', 'admin_css/bootstrap-responsive.min', 'admin_css/styles'));
        $this->stencil->js(array('vendors/datatables/js/jquery.dataTables.min.js', 'DT_bootstrap'));

        $data['feeds_list'] = $this->feedModel->getFeeds();
        $this->stencil->layout('admin_layout');
        $this->stencil->paint('admin/feeds/view', $data);
    }

    /* ===============================================================================================
     *                                  ADD FEEDS CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
    public function add() {
        $feed_user_title = $this->input->post('feed_title', TRUE);
        $feed_url = $this->input->post('feed_url');
        $usercat = $this->input->post('category');
        $feed_filter_type = $this->input->post('feed_type');
        $_icon = $this->input->post('favicon_icon');
        $favicon_icon = $_icon;
        if (!isset($feed_url) || $feed_url == ''):
            $this->stencil->title('Feeds');
            $this->stencil->layout('admin_layout');
            $this->stencil->css(array('admin_css/bootstrap.min', 'admin_css/bootstrap-responsive.min', 'admin_css/styles'));
            $this->stencil->js(array('vendors/datatables/js/jquery.dataTables.min.js', 'DT_bootstrap'));
            $this->stencil->paint('admin/feeds/add');
        else:

            $check = $this->validateUrl($feed_url);
            if ($check == FALSE):
                echo json_encode(array('result' => 'fail', 'msg' => '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>Url Already exists in the database!</div>'));
                die();
            endif;
            $feed = new SimplePie();
            $feed->set_feed_url($feed_url);
            $feed->set_cache_location(APPPATH . '/cache');
            $feed->set_output_encoding('ISO-8859-1');
            $feed->init();
            $feed->handle_content_type();

            // Language
            $lang = $feed->get_language();
            $language = isset($lang) ? $lang : 'en-us';
            if ($feed->get_type() & SIMPLEPIE_TYPE_NONE) {
                $feed_type = 'Unknown';
            } elseif ($feed->get_type() & SIMPLEPIE_TYPE_RSS_ALL) {
                $feed_type = 'RSS';
            } elseif ($feed->get_type() & SIMPLEPIE_TYPE_ATOM_ALL) {
                $feed_type = 'Atom';
            } elseif ($feed->get_type() & SIMPLEPIE_TYPE_ALL) {
                $feed_type = 'Supported';
            }
            // Author
            if ($author = $feed->get_author()):
                $feedAuthor = $author->get_name();
            else:
                $feedAuthor = '';
            endif;
            if ($feed->error()):
                echo json_encode(array('result' => 'fail', 'msg' => '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>Found error while making request</div>'));
            else:
//                $return = $this->feed_model->addFeeds($feed->get_items(0, 500));
                $feed_image_link = $feed->get_image_link();
                $feed_image_url = $feed->get_image_url();
                $feed_image_title = $feed->get_image_title();
                $return = $this->feedModel->addFeeds($feed->get_items(0, 500), $feed_image_link, $feed_image_url, $feed_image_title, $usercat, $feed_url, $language, $feed_type, $feedAuthor, $feed_filter_type, $feed_user_title, $favicon_icon);
                if ($return) {
                    echo json_encode(array('result' => 'success', 'msg' => '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Blog is added successfully</div>'));
                } else {
                    echo json_encode(array('result' => 'fail', 'msg' => '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>Found error while making request</div>'));
                }
            endif;
        endif;
    }

    /**
     * Uploading the sites
     * @param type $item
     * @return type
     */
    function do_upload($item = 'userfile') {
        $config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]) . "/uploads/feed/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '10000';

        $this->load->library('upload', $config);
        $this->upload->do_upload($item);
        $image_data = $this->upload->data();
        echo json_encode($image_data);
        return;
    }

    /**
     * Check weather url exists or not
     * @param type $url
     * @return boolean
     */
    public function validateUrl($url = '') {
        $isIt = $this->feedModel->checkFeedUrl($url);
        return $isIt;
    }

    /* ===============================================================================================
     *                                  FEED FAVICON CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
    public function addFavicon() {
        $this->stencil->title('Update Feeds favicon');
        $this->stencil->layout('admin_layout');
        $this->stencil->css(array('admin_css/bootstrap.min', 'admin_css/bootstrap-responsive.min', 'admin_css/styles'));
        $this->stencil->js(array('vendors/datatables/js/jquery.dataTables.min.js', 'DT_bootstrap'));

        $data['feeds_list'] = $this->feedModel->returnDistinctUrl();
        $this->stencil->paint('admin/feeds/updateFavicon', $data);
    }

    /* ===============================================================================================
     *                                  UPDATE FAVICON  
     * 
     * =============================================================================================== */

    /**
     */
    public function updateFavicons() {
        $feed_id = $this->input->post('feed_id', TRUE);
        if (!empty($feed_id)):
            $return = $this->uploadFile($feed_id);
            if ($return):
                $this->session->set_flashdata('info', "<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button>Favicon updated!</div>");
                $this->addFavicon();
            endif;
        endif;
    }

    /**
     * Upload the file to the server
     * @param type $insert_id
     * @param type $name
     * @return boolean
     */
    public function uploadFile($insert_id = '', $name = 'attachment') {
        if ($insert_id != '' && isset($_FILES)):
            if (file_exists($_FILES['attachment']['tmp_name']) || is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                $config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]) . "/uploads/feed/";
                $config['allowed_types'] = '*';
                $config['max_size'] = '10000';
                $config['max_width'] = '10000';
                $config['max_height'] = '10000';
                $config['encrypt_name'] = FALSE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload($name)) {
                    $error = array('error' => $this->upload->display_errors());
                    return FALSE;
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    if (isset($data['upload_data'])):
                        $upload_data_array = array(
                            'feed_favicon' =>  $data['upload_data']['file_name'],
                        );
                        $this->db->where('id', $insert_id);
                        $this->db->update('feeds', $upload_data_array);
                        return TRUE;
                    endif;
                    return TRUE;
                }
            }
        endif; // End check Insert
    }

    /**
     * Function to delete the Feed
     * @return type
     */
    public function delete() {
        $id = $this->input->post('id', TRUE);
        $status = $this->feedModel->deleteFeed($id);
        //fetch the category from the table by its primary key
        if ($status) {
            $this->session->set_flashdata('info', "<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button>The requested feed is deleted successfully!</div>");
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'true'));
            return;
        } else {
            $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>An error has been occured during delete operation. Please try again!</div>");
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'false'));
            return;
        }
    }

    public function check() {
        $feed = new SimplePie();
        $feed->set_feed_url('http://zeenews.india.com/rss/india-national-news.xml');
        $feed->set_cache_location(APPPATH . '/cache');
        $feed->set_output_encoding('ISO-8859-1');
        $feed->init();
        $feed->handle_content_type();
//        $i = $feed->get_items(0, 500);
        $allFeeds = array();
        foreach ($feed->get_items(0, 100) as $item) {
            if ($author = $item->get_author()) {
                $email = $author->get_email();
                $name = $author->get_name();
                if ($name != ''):
                    $authorname = $name;
                else:
                    $authorname = $email;
                endif;
            } 
            $date = $item->get_date();
            $singleFeed = array(
                'author' => $item->get_author(),
                'authoremail' => $item->get_author(),
                'categories' => $item->get_categories(),
                'copyright' => $item->get_copyright(),
                'content' => $item->get_content(),
                'date' => $item->get_date("d.m.Y H:i"),
                'description' => $item->get_description(),
                'id' => $item->get_id(),
                'latitude' => $item->get_latitude(),
                'longitude' => $item->get_longitude(),
                'permalink' => $item->get_permalink(),
                'title' => $item->get_title()
            );
            pri($item);
            array_push($allFeeds, $singleFeed);
            echo $date . '$date<br>';
        }

        die();
    }

    /**
     * Function to create the preview page of the item
     */
    public function preview() {
        $this->stencil->layout('preview_layout');
        $slug = $this->uri->segment(3);
        $list = $this->feedModel->validateHash($slug);
        //If Item found or not
        //----------------------------------------------------------------------
        if (empty($list)) {
            //Set the header of page to 404  i.e. item not found
            $this->output->set_status_header('404');
            //Set the title of the page
            $this->stencil->title('404 Page Not Found');
            //Paint the 404 default page
            $this->stencil->paint('404_view');
        } else {
            $page_title = $list[0]->feed_title;
            $page_data['url'] = $list[0]->feed_url;
            $this->stencil->title($page_title);
            $this->stencil->slice('head');
            $this->stencil->slice('preview_footer');
            $this->stencil->slice('preview_header');
            $this->stencil->layout('preview_layout');
            $this->stencil->paint('admin/feeds/preview', $page_data);
        }
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */