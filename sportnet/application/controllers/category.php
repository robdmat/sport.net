<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Category class where all the operation will be handles as per the category
 */
class Category extends CI_Controller {

    public function __construct() {

        parent::__construct();
        //Sets the variable $head to use the slice head (/views/slices/head.php)
        $this->stencil->slice(array('admin_sidebar'));

        //load the libraries
        $this->lang->load("common", $this->session->userdata('site_lang'));
        $this->lang->load("admin", $this->session->userdata('site_lang'));

        $this->load->helper(array('url', 'date')); //load required helpers
        $this->load->library(array('session', 'crumb', 'email', 'form_validation', 'pagination')); //load the library
        $this->stencil->title($this->lang->line('admin_dashboard'));
        //Sets the layout to be home_layout (/views/layouts/main_layout.php        
        $this->stencil->layout('admin_layout');
        //        Required Model
        $this->load->model('admin_model');
        $this->load->model('category_model', 'categoryModel');
        $this->stencil->js(array('vendors/datatables/js/jquery.dataTables.min.js', 'DT_bootstrap'));
    }

    /**
     * Default action of the controller 
     */
    public function index() {
        $this->stencil->title('Category');
        $this->stencil->layout('admin_layout');
        /* Bread crum */
        $this->crumb->add('Home', site_url('dashboard'));
        $this->crumb->add('Project Categories', site_url('categories'));
        $data['crumb'] = $this->crumb->output();
        $data['categories'] = $this->categoryModel->getCategory();
        $this->stencil->paint('admin/category/viewall', $data);
    }

    /* ===============================================================================================
     *                                  CATEGORY CONTROL 
     * 
     * =============================================================================================== */
    /**
     */

    /**
     * View all the categories along with the pagination
     * @param integer $page
     */
    public function viewAll() {
        $data['categories'] = $this->categoryModel->getCategory();
        $this->stencil->paint('admin/category/viewall', $data);
    }

    /**
     * Function to add new categories and also check whether the 
     * requested category exists or not and redurect to same page
     */
    public function add() {
        $this->stencil->title('Add Category');
        $this->stencil->layout('admin_layout');
        /* Bread crum */
        $this->crumb->add('Home', site_url('admin'));
        $this->crumb->add('Add Category', site_url('admin/category/add'));
        $data['crumb'] = $this->crumb->output();
        $data['categories'] = $this->categoryModel->getCategory();
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->stencil->paint('admin/category/add', $data);
        } else {
            $return = $this->categoryModel->adddCategory();
            if ($return) {
                $this->session->set_flashdata('info', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Category is added successfully</div>');
            } else {
                $this->session->set_flashdata('info', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>Can not add the user/div>');
            }
            redirect(site_url('category', 'refresh'));
        }
    }

    /**
     * Function to edit the category as per the id
     * @param type $category_id
     * @return type
     */
    public function edit($category_id = '') {
        $this->stencil->layout('admin_layout');
        /* Bread crum */
        if (!empty($category_id)):
            $category = $this->categoryModel->getCategoryById($category_id);
            $title = getCatNameBySlug($category_id);
            if (!empty($category)):
                $this->stencil->title($title);
                $data['category'] = $category;
                $this->form_validation->set_rules('category_name', 'Category Name', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $this->stencil->paint('admin/category/edit', $data);
                } else {
                    $return = $this->categoryModel->updateProjectcategory($category_id);
                    if ($return == TRUE):
                        $this->session->set_flashdata('info', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Project Categoory is updated successfully.</div>');
                    else:
                        $this->session->set_flashdata('info', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>Can not Update the category</div>');
                    endif;
                    $this->index();
                }
            else:
                $this->index();
            endif;
        else:
            $this->index();
        endif;
    }

    /**
     * Function to delete the category
     * @return type
     */
    public function delete() {
        $id = $this->input->post('id', TRUE);
        $status = $this->categoryModel->deleteCategory($id);
        //fetch the category from the table by its primary key
        if ($status) {
            $this->session->set_flashdata('info', "<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button>The requested category is deleted successfully!</div>");
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'true'));
            return;
        } else {
            $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>An error has been occured during deletion. Please try again!</div>");
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'false'));
            return;
        }
    }

    /**
     * Check the valid category 
     * @return boolean
     */
    public function check_select_cat() {
        if ($this->input->post('category_select') == 'NULL') {
            $this->form_validation->set_message('check_select_cat', $this->lang->line('admin_incorrect_cat'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* ===============================================================================================
     *                                   CATEGORY FRONTEND SECTION 
     * 
     * =============================================================================================== */

    public function loadMore() {
        $pagination = $this->input->post('page', TRUE);
        $ulclass = $this->input->post('ulclass', TRUE);
        //Check UL class
        if (isset($ulclass) && $ulclass == 'true'):
            $sponserList = 'style="display:none"';
            $description = 'style="display:block"';
        else:
            $sponserList = 'style="display:block"';
            $description = 'style="display:none"';
        endif;

        $categoryId = $this->input->post('category_id', TRUE);
        if (isset($pagination) && $pagination != ''):
            $next_set = $pagination;
        else:
            $next_set = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        endif;
        $count = $this->categoryModel->getAllDataCount($categoryId);
        $config = array();
        $config["base_url"] = base_url() . "category/loadMore";
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
        $feeds_list = $this->categoryModel->getAllData($limit, $offset, $categoryId);
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

}
