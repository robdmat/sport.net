<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//load the facebook sdk
require_once APPPATH . 'libraries/facebook/facebook.php';

class User extends CI_Controller {

    public $node;

    public function __construct() {
        parent::__construct();

        //Sets the variable $header to use the slice 
        $this->stencil->slice(array('head', 'header', 'footer', 'banner'));
//        Settings
        //load the libraries
        $this->load->helper(array('url', 'date', 'form', 'captcha')); //load required helpers 
        $this->load->library(array('session', 'email', 'form_validation', 'recaptcha', 'encrypt', 'pagination')); //load the session library
        $this->config->load('facebook'); //load the facebook config file
        $this->stencil->layout('home_layout');
        $this->stencil->css(array('font-awesome'));
//        $this->stencil->css(array('admin_css/bootstrap.min', 'admin_css/bootstrap-responsive.min', 'style'));
        //User Model
        $this->load->model('user_model', 'userModel');
    }

    /**
     * default action of the controller
     */
    public function index() {
        if (!isLogged()) {
            redirect('user/login', 'refresh');
        } else {
            redirect();
        }
    }

    /* ===============================================================================================
     *                                  USER CONTROL 
     * 
     * =============================================================================================== */

    /**
     */
    public function login() {
        $login = $this->isLoggedIn();
        if ($login == TRUE):
            redirect();
        else:
            $this->stencil->title('Sports Net Login');
            $this->form_validation->set_rules('email', 'Username', 'trim|required|xss_clean|callback_check_login_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[32]|callback_check_password');

            if ($this->form_validation->run() == FALSE) {
                //Render the login page
                $this->stencil->paint('user/login');
            } else {
                $data = $this->getUserInfo();
                $data['is_logged_in'] = 'TRUE';
                $data['ip'] = $_SERVER['SERVER_ADDR'];
                $this->session->unset_userdata();
                $this->session->set_userdata($data);
                redirect('dashboard');
            }
        endif;
    }

    /**
     * Fetch the user details and save session
     * @return type
     */
    public function getUserInfo() {
        $email = $this->input->post('email');
        //getting the info of the user
        $users = $this->userModel->getUserInfo($email);
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
            $this->userModel->updateIsActive($users[0]->id);
            return $data;
        }
    }

    /**
     * Check wheather the username is correct or incorrect 
     * @return boolean
     */
    public function check_login_email() {
        //Load models 
        $users = $this->userModel->filterByEmail($this->input->post('email', TRUE));
        if (!empty($users)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_login_email', 'Email is incorrect!');
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
        $user = $this->userModel->checkPassword($email);
        if (!empty($user)) {
            $password_return = $this->userModel->getPassword($email);
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
     * Check weather the username exists or not
     * @return boolean
     */
    function check_user() {
        $users = $this->userModel->checkUserMail($this->input->post('email'));
        if (!empty($users)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_username', 'Email is incorrect!');
            return FALSE;
        }
    }

    /**
     * User registration 
     */
    public function register() {
//        $login = $this->isLoggedIn();
//        if ($login == TRUE):
//            redirect();
//        else:
        //Set the variable $title to be used in your views
        $this->stencil->title('Create A Sportnet Account');
        // field name, error message, validation rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->stencil->paint('user/register');
        } else {
            $amIDone = $this->add_user();
            if ($amIDone):
                $email = $this->input->post('email', TRUE);
                $data = $this->userModel->getUserInfoForRegisterUser($email);
                $data['is_logged_in'] = 'TRUE';
                $data['ip'] = $_SERVER['SERVER_ADDR'];
                $this->session->unset_userdata();
                $this->session->set_userdata($data);
                redirect('dashboard');
            else:
                redirect('/');
            endif;
        }
//        endif;
    }

    public function check_whitespaces() {
        $post = $this->input->post();
        if (strpos($post['username'], " ") != TRUE) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_whitespaces', 'Username contains the white spaces!');
            return FALSE;
        }
    }

    /**
     * Check weather the email already exists 
     * @return boolean
     */
    function check_email() {
        $existing_email = $this->userModel->filterByRegisterEmail($this->input->post('email'));
        if (empty($existing_email)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_email', 'Email already exists.');
            return FALSE;
        }
    }

    /**
     * Check weather the recaptcha code is correct or incorrect
     * @param type $val
     * @return boolean
     */
    function check_captcha($val) {
        if ($this->recaptcha->recaptcha_check_answer($this->input->ip_address(), $this->input->post('recaptcha_challenge_field'), $val)) {
            return TRUE;
        }
        $this->form_validation->set_message('check_captcha', 'The captcha code entered by you is incorrect');
        return FALSE;
    }

    /**
     * Add the user into the database
     */
    public function add_user() {
        //load the user model
        $password = $this->input->post('password', TRUE);
        $email = $this->input->post('email', TRUE);
        $token = $this->getToken();
        $done = $this->userModel->addRegisterUser($email, $password, $token);
        return $done;
    }

    /**
     * Generate token
     * @return type
     */
    public function getToken() {
        $rand_string = md5(rand());
        $timestamp = date('ljSFYh:i:sA');
        $revert_str = strrev($timestamp);
        $main_string = $revert_str . $rand_string;
        $auth_token = $this->encrypt->encode($main_string);
        $string = str_replace(' ', '-', $auth_token); // Replaces all spaces with hyphens.
        $auth = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        return $auth;
    }

    /**
     * Generattoken
     * @return type
     */
    public function session() {
        $udata = $this->session->all_userdata();
        $user_id = isset($udata['user_id']) ? $udata['user_id'] : 1;
        $categories = $this->input->post('category_array', TRUE);
        $category_main = $this->input->post('category_main', TRUE);
        $parentSubs = isset($category_main) ? $category_main : '';
        if (!empty($categories) && is_array($categories) || !empty($parentSubs)):
            $done = $this->userModel->updateUserCategories($categories, $user_id, $parentSubs);
            if ($done):
                $this->session->set_flashdata('info', "<div class='alert alert-success'> <button type='button' class='close' data-dismiss='alert'>&times;</button>The requested is completed successfully!</div>");
                redirect('/');
            else:
                $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>Error: Something went wrong please try again.!</div>");
                redirect('/');
            endif;
        else:
            $this->session->set_flashdata('info', "<div class='alert alert-error'> <button type='button' class='close' data-dismiss='alert'>&times;</button>Error: Please add categories to the list</div>");
            redirect('/');
        endif;
        redirect('/');
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
        } else {
            $seg = $this->uri->segment(1);
            if ($seg == 'admin') {
                return FALSE;
            }
        }
        return;
    }

    /**
     * Check wheather the user logged in is Admin or not
     * @return boolean
     */
    public function isAdmin() {
        $udata = $this->session->all_userData();
        if (isset($udata['user_type']) && $udata['user_type'] == 1) {
            return;
        }
        redirect(site_url('admin/login'), 'refresh');
        return;
    }

    /**
     * User log out
     */
    public function logout() {
        //load the model 
        $udata = $this->session->all_userdata();
//        pri($udata);
//        die();
        $email = isset($udata['email']) ? $udata['email'] : '';
        if (!empty($email)) {
            $this->userModel->updateUserLoginInfo();
            $this->session->unset_userdata();
            $this->session->sess_destroy();
            redirect('/', 'refresh');
        } else {
            redirect('/');
        }
    }

    /**
     * Url validation
     * @return boolean
     */
    public function validate_url() {
        if (filter_var($this->input->post('url'), FILTER_VALIDATE_URL) === FALSE) {
            $this->form_validation->set_message('validate_url', $this->lang->line('invalid_url'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Username recover 
     */
    public function password_reset() {
        $this->stencil->title('Sportnet reset password');

        //set the rules for the form validation
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_user_email');
        //Sets the layout to be home_layout (/views/layouts/home_layout.php)
        //Adding the js file of the bxslider
        $this->stencil->js(array('jquery.easing.1.3', 'jquery.fitvids'));
        if ($this->form_validation->run() == FALSE) {
            $this->stencil->paint('user/password_reset');
        } else {
            $this->requestNewPassword();
            $this->session->set_flashdata('info', '<div class="alert alert-info top_buffer">Password reset instructions have been emailed to you, follow the link in the email to continue.</div>');
            redirect('user/login', 'refresh');
        }
    }

    /**
     * Request for new password
     */
    public function requestNewPassword() {
        //Load the models
        $post = $this->input->post();
        $user = $this->userModel->getUserInfo($post['email']);
        if (!empty($user)):
            $siteurl = site_url();
            $msg = "Hello Dimpy,\n\nTo reset your password please follow the link below:\n\n " . base_url() . "user/recover_password/?user=admin@sport.net&auth=" . $user[0]->token . "\n\nIf you need help or have any questions, please visit $siteurl \n\nThanks!\n Sport.net";
//            $msg = 'Hello Dimpy,\n\nTo reset your password please follow the link below:\n\n' . base_url() . 'user/recover_password/?user=robertdeanmatuk@gmail.com&auth=' . $user[0]->token . '\n\nIf you need help or have any questions, please visit ' . $siteurl . ' \n\nThanks!\n Sport.net';
            $this->email->from($this->config->item('admin_mail'));
            $this->email->to('dimplevkumar117@gmail.com');
            $this->email->subject('Reset your Sport.net password');
            $this->email->message($msg);
            $this->email->send();
        endif;
    }

    /**
     * Recover the password
     */
    public function recover_password() {
        $this->stencil->title('Sport.net recover password');
        //set the rules for the form validation
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[32]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        //Sets the layout to be home_layout (/views/layouts/home_layout.php)
        $this->stencil->layout('home_layout');
        //Adding the js file of the bxslider
        $this->stencil->js(array('jquery.easing.1.3', 'jquery.fitvids'));
        if ($this->form_validation->run() == FALSE) {
            $this->stencil->paint('user/recover_password');
        } else {
            $this->updatePassword();
            $this->session->set_flashdata('info', '<div class="alert alert-success top_buffer">Your password has been reset.</div>');
            redirect('user/login', 'refresh');
        }
    }

    /**
     * Update the password along with the auth token
     */
    public function updatePassword() {
        //Load the required model
//        $this->load->model('usersquery');
        $post = $this->input->post();
        $auth = $this->encrypt->encode(strrev(random_string('unique', 16)) . '_' . strrev(now()));
        $password = $this->encrypt->encode($post['password']);
//        $users = $this->usersquery->filterByusername($post['email'])->findOne();
        $users = $this->userModel->getUserInfo($post['email']);
        if (!empty($users)) {
            $data = $this->userModel->updateUserPassword($post['email'], $password, $auth);
        } else {
            //Adding the js file of the bxslider
            $this->stencil->paint('user/confirm_expired');
        }
    }

}
