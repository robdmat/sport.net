<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//include APPPATH . 'controllers/user.php';

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //Sets the variable $head to use the slice head (/views/slices/head.php)
        $this->stencil->slice(array('admin_sidebar'));
        //load the libraries
        $this->load->helper(array('url', 'date', 'sportnet')); //load required helpers
        $this->load->library(array('session', 'email', 'form_validation')); //load the library 
        //Sets the variable $title to be used in your views
        $this->stencil->title('AdminDashboard');
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
        redirect('admin/login');
    }

    /**
     * Check wheather the user is logged in or not
     * @return type
     */
    public function isLoggedIn() {
        // Get session
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
     * Login function for the admin     
     */
    public function login() {
        //Check wheather user is logged in or user is admin
        $is_logged = $this->isLoggedIn();
        if ($is_logged) {
            redirect('admin/dashboard');
        }
        //title of the page
        $this->stencil->title('Login');
        //Set the rules for the login form
        $this->form_validation->set_rules('email', 'Username', 'trim|required|xss_clean|callback_check_username');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[32]|callback_check_password');
        if ($this->form_validation->run() == FALSE) {
            //Render the login page
            $this->stencil->paint('admin/login');
        } else {
            $data = $this->getUserInfo();
            if ($data['user_type'] == 'admin') {
                $data['is_logged_in'] = 'TRUE';
                $data['ip'] = $_SERVER['SERVER_ADDR'];
                $this->session->unset_userdata();
                $this->session->set_userdata($data);
                redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>You are not admin!</div>");
                redirect('admin/login');
            }
        }
    }

    /**
     * Check wheather the username is correct or incorrect 
     * @return boolean
     */
    public function check_username() {
        $users = $this->adminModel->checkUserMail($this->input->post('email'));
        if (!empty($users)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_username', 'Email is incorrect!');
            return FALSE;
        }
    }

    /**
     * Check wheather the password is incorrect or correct
     * @return boolean
     */
    public function check_password() {
        $this->load->library('encrypt');
        $email = $this->input->post('email', TRUE);
        $user = $this->adminModel->checkPassword($email);
        if (!empty($user)) {
            $password_return = $this->adminModel->getPassword($email);
            $actual_password = $this->encrypt->decode($password_return);
            if ($this->input->post('password') == $actual_password) {
                return TRUE;
            } else {
                $this->form_validation->set_message('check_password', 'Incorrect Password');
                return FALSE;
            }
        } else {
            $this->form_validation->set_message('check_password', 'Incorrect Password');
            return FALSE;
        }
    }

    /**
     * Fetch the user details and save session
     * @return type
     */
    public function getUserInfo() {
        $email = $this->input->post('email');
        //getting the info of the user
        $users = $this->adminModel->getUserInfo($email);
        if (!empty($users)) {
            $data['username'] = $users[0]->username;
            $data['first_name'] = $users[0]->user_first_name;
            $data['last_name'] = $users[0]->user_last_name;
            $data['email'] = $users[0]->user_email;
            $data['auth'] = $users[0]->token;
            $data['valid'] = $users[0]->status;
            $data['user_type'] = $users[0]->user_type;
            $data['user_id'] = $users[0]->id;
            $data['last_login'] = $users[0]->user_last_login;
            return $data;
        }
    }

    /**
     * Dashboard of the admin user  
     */
    public function dashboard() {
        $this->stencil->paint('admin/dashboard');
    }

    /* ===============================================================================================
     *                                   ADMIN PAGE CONTROL 
     * 
     * =============================================================================================== */
    /**
     * Add page controller function where the page content is inserted by the admin
     */
    public function addPage() {
        $this->stencil->title($this->lang->line('add_page'));
        $this->isLoggedIn();
        $this->isAdmin();
        $this->stencil->js(array('vendors/ckeditor/ckeditor', 'vendors/ckeditor/adapters/jquery'));
        //Set the rules for the login form
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->stencil->paint('admin/page/add_page');
        } else {
            $saved = $this->savePage();
            if ($saved) {
                $this->session->set_flashdata('info', "<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button>The requested page is saved successfully!</div>");
            } else {
                $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>Error found while saving the page!</div>");
            }
            $this->stencil->paint('admin/page/add_page');
        }
    }

    /**
     * Function to insert the page into the database 
     * and returns whether the data is saved or not
     * @return boolean 
     */
    protected function savePage() {
        $page_id = $this->adminModel->addPage();
        //Check whether the page is saved or not
        if (isset($page_id) && !empty($page_id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Controller action to get all the pages inserted by the Admin
     */
    public function getPages() {
        $this->isLoggedIn();
        $this->isAdmin();
        $this->stencil->title($this->lang->line('all_pages'));
        $this->stencil->js(array('vendors/datatables/js/jquery.dataTables.min.js', 'DT_bootstrap'));
        $data['pages'] = $this->adminModel->getPages();
        $this->stencil->paint('admin/page/view_pages', $data);
    }

    /**
     * Controller action to view the page content which is to be edited
     * @param type $id
     */
    public function edit_page($id) {
        $this->isLoggedIn();
        $this->isAdmin();
        if (!empty($id)) {
            $this->stencil->js(array('vendors/ckeditor/ckeditor', 'vendors/ckeditor/adapters/jquery'));
            $page = $this->adminModel->getPageById($id);
            //Set the rules for the login form
            $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['page'] = $page;
                $this->stencil->paint('admin/page/edit_page', $data);
            } else {
                $this->updatePage($id);
                $data['page'] = $page;
                $this->stencil->paint('admin/page/edit_page', $data);
            }
        } else {
            redirect(site_url('admin/getpages'), 'refresh');
        }
    }

    /**
     * Function to save the updation of the page into the data base 
     * @param type $id
     * @return boolean
     */
    protected function updatePage($id) {
        if (!empty($id)) {
            $page = $this->adminModel->updatePage($id);
            if (!empty($page)) {
                $this->session->set_flashdata('info', $this->lang->line('page_save_success'));
                return TRUE;
            } else {
                $this->session->set_flashdata('info', $this->lang->line('page_save_failed'));
                return FALSE;
            }
        } else {
            redirect(site_url('admin/edit_page/' . $id), 'refresh');
        }
    }

    /**
     * Page delete function as per the id provided by the post argument
     * @return type
     */
    public function pageDelete() {
        $id = $this->input->post('id');
        if (!empty($id)) {
            $page = $this->adminModel->deletPage($id);
            if (!empty($page) && $page == TRUE) {
                $this->session->set_flashdata('info', "<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button>The requested page is deleted successfully!</div>");
                header('Content-Type: application/json');
                echo json_encode(array('result' => 'true'));
                return;
            } else {
                $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>Error found while deleting the page!</div>");
                header('Content-Type: application/json');
                echo json_encode(array('result' => 'true'));
                return;
            }
        } else {
            $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>An unexpected error found while operating the delete operation!</div>");
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'true'));
            return;
        }
    }

    /**
     * Function to check the slug whether it exists or not
     * @return boolean
     */
    public function checkSlug() {
        $post = $this->input->post();
        $slug = $this->adminModel->pageFilterByslug($post['slug']);
        if (!empty($slug)) {
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'false'));
            return;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('result' => 'true'));
            return;
        }
    }

    /* ===============================================================================================
     *                                   ADMIN FOOTER CONTROL 
     * 
     * =============================================================================================== */

    /**
     * 
     */
    public function footer_settings($setting_parameters = "") {
        if ($setting_parameters == '') {
            $this->stencil->title('Footer Menu');
            $this->stencil->paint('admin/footer');
        } else {
            switch ($setting_parameters) {
                case 'copyright':
                    $this->copyright();
                    break;
                case 'social':
                    $this->footerSocial();
                    break;
                case 'footer_menus':
                    $this->footerMenus();
                    break;
            }
        }
    }

    /**
     * Save the footer copyright content to the table
     */
    public function copyright() {
        $check_copyrignt = $this->adminModel->checkCopyRight();
        if ($check_copyrignt == FALSE) {
            $retturn = $this->adminModel->addCopyRight();
            if ($retturn) {
                $this->session->set_flashdata('footer_message', '<div class="alert alert-success top_buffer">Copyright content saved<button type="button" class="close" data-dismiss="alert">×</button></div>');
                redirect(site_url() . 'admin/footer_settings');
            } else {
                $this->session->set_flashdata('footer_message', '<div class="alert alert-success top_buffer">Error: Cannot add the copyright content <button type="button" class="close" data-dismiss="alert">×</button></div>');
                redirect(site_url() . 'admin/footer_settings');
            }
        } else {
            $retturn = $this->adminModel->updateCopyRight();
            if ($retturn == TRUE) {
                $this->session->set_flashdata('footer_message', '<div class="alert alert-success top_buffer">Copyright content updated<button type="button" class="close" data-dismiss="alert">×</button></div>');
                redirect(site_url() . 'admin/footer_settings');
            } else {
                $this->session->set_flashdata('footer_message', '<div class="alert alert-success top_buffer">Error: Cannot update the copyright content <button type="button" class="close" data-dismiss="alert">×</button></div>');
                redirect(site_url() . 'admin/footer_settings');
            }
        }
    }

    /**
     * Save the footer social items
     */
    public function footerSocial() {
        $facebook = ($this->input->post('facebook', TRUE));
        $twitter = ($this->input->post('twitter', TRUE));
        $youtube = ($this->input->post('youtube', TRUE));
        $pinterest = ($this->input->post('pinterest', TRUE));
        $instagram = ($this->input->post('instagram', TRUE));
        $googleplug = ($this->input->post('googleplug', TRUE));
        $social_id = ($this->input->post('social_id', TRUE));
        $check_social = $this->adminModel->checkSocial();
        if ($check_social == FALSE):
            $retturn = $this->adminModel->addSocial($facebook, $twitter, $youtube, $pinterest, $instagram, $googleplug);
            if ($retturn) {
                $this->session->set_flashdata('footer_message', '<div class="alert alert-success top_buffer">Social links are saved<button type="button" class="close" data-dismiss="alert">×</button></div>');
                redirect(site_url() . 'admin/footer_settings');
            } else {
                $this->session->set_flashdata('footer_message', '<div class="alert alert-success top_buffer">Error: Cannot add the social links <button type="button" class="close" data-dismiss="alert">×</button></div>');
                redirect(site_url() . 'admin/footer_settings');
            }
        else:
            $retturn = $this->adminModel->updateSocial($facebook, $twitter, $youtube, $pinterest, $instagram, $googleplug, $social_id);
            if ($retturn) {
                $this->session->set_flashdata('footer_message', '<div class="alert alert-success top_buffer">Social profile links are updated<button type="button" class="close" data-dismiss="alert">×</button></div>');
                redirect(site_url() . 'admin/footer_settings');
            } else {
                $this->session->set_flashdata('footer_message', '<div class="alert alert-success top_buffer">Error: Cannot update content <button type="button" class="close" data-dismiss="alert">×</button></div>');
                redirect(site_url() . 'admin/footer_settings');
            }
        endif;
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