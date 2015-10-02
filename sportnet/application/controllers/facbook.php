<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Facbook extends CI_Controller {

    public function __construct() {
        parent::__construct();

// To use site_url and redirect on this controller.
        $this->load->helper('url');
        $this->load->library('facebook'); // Automatically picks appId and secret from config
        $this->load->model('register_Model', 'model');
    }

    public function index() {
        $user = $this->facebook->getUser();
        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
                $fbdata = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        } else {
            $this->facebook->destroySession();
        }
        if ($user):
            $facebook_user_email = isset($fbdata['email']) ? $fbdata['email'] : 'email';
            $facebook_user_name = isset($fbdata['name']) ? $fbdata['name'] : 'name';
            $facebook_user_id = isset($fbdata['id']) ? $fbdata['id'] : 'id';
            $exist_user = $this->email_check($facebook_user_email);
            if ($exist_user):
                $insert_id = $this->signUpUser($facebook_user_name, $facebook_user_email, $facebook_user_id);
                $userdata = $this->getProfile($insert_id);
            else:
                $userdata = $this->getProfileByEmail($facebook_user_email);
            endif;
            if ($userdata):
// Update the status of the model that is login
                $userid = isset($userdata->ID) ? $userdata->ID : 1;
                $this->updateIsLogin($userid);
                $newdata = array(
                    'user_id' => isset($userdata->ID) ? $userdata->ID : 1,
                    'account_id' => isset($userdata->ID) ? $userdata->ID : 1,
                    'username' => isset($userdata->username) ? $userdata->username : '',
                    'first_name' => isset($userdata->user_first_name) ? $userdata->user_first_name : '',
                    'last_name' => isset($userdata->user_last_name) ? $userdata->user_last_name : '',
                    'email' => isset($userdata->user_email) ? $userdata->user_email : '',
                    'ip_address' => isset($userdata->IP) ? $userdata->IP : '',
                    'avatar' => isset($userdata->avatar) ? $userdata->avatar : '',
                    'user_type' => isset($userdata->user_type) ? $userdata->user_type : 'system',
                    'is_logged_in' => TRUE,
                    'valid' => '1',
                    'auth' => isset($userdata->token) ? $userdata->token : '',
                    'last_login' => isset($userdata->user_last_login) ? $userdata->user_last_login : '',
                );
                $this->session->set_userdata($newdata);
            endif;
            $data['logout_url'] = site_url('facebook/logout'); // Logs off application
        else:
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('facebook/login'),
                'scope' => array("email") // permissions here
            ));
        endif;
        redirect('/', $data);
    }

    public function login() {
        $user = $this->facebook->getUser();

        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
                $fbdata = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        } else {
            $this->facebook->destroySession();
        }

        if ($user):
            $facebook_user_id = isset($fbdata['id']) ? $fbdata['id'] : '1';
            $data['first_name'] = isset($fbdata['first_name']) ? $fbdata['first_name'] : '';
            $data['last_name'] = isset($fbdata['last_name']) ? $fbdata['last_name'] : '';
            $data['link'] = isset($fbdata['link']) ? $fbdata['link'] : '';
            $data['locale'] = isset($fbdata['locale']) ? $fbdata['locale'] : '';
            $data['timezone'] = isset($fbdata['timezone']) ? $fbdata['timezone'] : '';
            $data['updated_time'] = isset($fbdata['updated_time']) ? $fbdata['updated_time'] : '';
            $data['gender'] = isset($fbdata['gender']) ? $fbdata['gender'] : '';
            $data['profile_picture'] = ' https://graph.facebook.com/' . $facebook_user_id . '/picture?type=large';
            $facebook_user_email = isset($fbdata['email']) ? $fbdata['email'] : 'email';
            $facebook_user_name = isset($fbdata['name']) ? $fbdata['name'] : 'name';
            $exist_user = $this->email_check($facebook_user_email);
            if (empty($exist_user) || $exist_user == ''):
                $insert_id = $this->signUpUser($facebook_user_name, $facebook_user_email, $facebook_user_id, $data);
                $userdata = $this->getProfile($insert_id);
            else:
                $userdata = $this->getProfileByEmail($facebook_user_email);
            endif;
            if ($userdata):
// Update the status of the model that is login
                $userid = isset($userdata->ID) ? $userdata->ID : 1;
                $this->updateIsLogin($userid);
                $newdata = array(
                    'user_id' => isset($userdata->ID) ? $userdata->ID : 1,
                    'account_id' => isset($userdata->ID) ? $userdata->ID : 1,
                    'username' => isset($userdata->username) ? $userdata->username : '',
                    'first_name' => isset($userdata->user_first_name) ? $userdata->user_first_name : '',
                    'last_name' => isset($userdata->user_last_name) ? $userdata->user_last_name : '',
                    'email' => isset($userdata->user_email) ? $userdata->user_email : '',
                    'ip_address' => isset($userdata->IP) ? $userdata->IP : '',
                    'avatar' => isset($userdata->avatar) ? $userdata->avatar : '',
                    'user_type' => isset($userdata->user_type) ? $userdata->user_type : 'system',
                    'is_logged_in' => TRUE,
                    'valid' => '1',
                    'auth' => isset($userdata->token) ? $userdata->token : '',
                    'last_login' => isset($userdata->user_last_login) ? $userdata->user_last_login : '',
                );
                $this->session->set_userdata($newdata);
            endif;
            $data['logout_url'] = site_url('facebook/logout'); // Logs off application
        else:
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('facebook/login'),
                'scope' => array("email") // permissions here
            ));
        endif;
        redirect('/', $data);
    }

    /**
     * Signup the facebook user
     * @param type $facebook_user_name
     * @param type $facebook_user_email
     * @param type $facebook_user_id
     * @return type
     */
    public function signUpUser($facebook_user_name, $facebook_user_email, $facebook_user_id, $data) {
        $return = $this->model->registerSocialUser($facebook_user_name, $facebook_user_email, $facebook_user_id, $data, '', $this->getToken(), 'facebook');
        return $return;
    }

    public function logout() {
        $this->load->library('facebook');
// Logs off session from website
        $this->facebook->destroySession();
// Make sure you destory website session as well.
        redirect('facebook/facebook/login');
    }

    /**
     * Generate Token
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
     * Check if a username exist
     *
     * @access public
     * @param string
     * @return bool
     */
    function username_check() {
        $name = $this->model->get_by_username($this->input->post('username', TRUE));
        if (empty($name)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    /**
     * Check if an email exist
     *
     * @access public
     * @param string
     * @return bool
     */
    function email_check($facebook_user_email = '') {
        $email = $this->model->checkmails($facebook_user_email);
        if (empty($email)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    /**
     * Check user signin status
     *
     * @access public
     * @return bool
     */
    public function is_signed_in() {
        return $this->session->userdata('is_logged_in') ? TRUE : FALSE;
    }

    /**
     * Check user type status @@@@Facebook
     *
     * @access public
     * @return bool
     */
    public function user_type() {
        $user_type = $this->session->userdata('user_type');
        return isset($user_type) ? $user_type : 'system';
    }

    /**
     * Get Profile
     * @param type $id
     * @return boolean
     */
    public function getProfile($id = '') {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('ID', $id);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getProfileByEmail($email = '') {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_email', $email);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Update user login
     * @param type $userId
     */
    public function updateIsLogin($userId) {
        $update_array = array(
            'user_is_active' => TRUE,
        );
        $this->db->where('ID', $userId);
        $updated = $this->db->update('users', $update_array);
        return $updated;
    }

}
