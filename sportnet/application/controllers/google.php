<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Google extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->redirectErrorGoogle();
        $this->load->helper('url');
        $this->load->model('register_Model', 'model');
        $this->load->model('login_model', 'model_login');

        $this->load->config('googleplus');
        require_once APPPATH . 'third_party/Google_Client.php';
        require_once APPPATH . 'third_party/contrib/Google_Oauth2Service.php';
    }

    public function index() {
        $google_client_id = $this->returnClientId();
        $google_client_secret = $this->returnSecret();
        $google_app_name = $this->returnAppName();
        $google_developer_key = $this->returnAPIKey();
        $google_redirect_url = $this->returnRedurectUrl();


        $gClient = new Google_Client();
        $gClient->setAccessType("online");
        $gClient->setApplicationName($google_app_name);
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        //If code is empty, redirect user to google authentication page for code.
        //Code is required to aquire Access Token from google
        //Once we have access token, assign token to session variable
        //and we can redirect user back to page and login.

        if (isset($_GET['code'])) {
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
            if ($gClient->getAccessToken()) {
                $google_user_data = $google_oauthV2->userinfo->get();
                //For logged in user, get details from google using access token
                $data['first_name'] = isset($google_user_data['given_name']) ? $google_user_data['given_name'] : '';
                $data['last_name'] = isset($google_user_data['family_name']) ? $google_user_data['family_name'] : '';
                $data['link'] = isset($google_user_data['link']) ? $google_user_data['link'] : '';
                $data['locale'] = isset($google_user_data['locale']) ? $google_user_data['locale'] : '';
                $data['timezone'] = '';
                $data['updated_time'] = date('Y-m-d H:i:s');
                $data['gender'] = isset($google_user_data['gender']) ? $google_user_data['gender'] : '';
                $data['profile_picture'] = isset($google_user_data['picture']) ? $google_user_data['picture'] : '';
                $google_user_email = isset($google_user_data['email']) ? $google_user_data['email'] : 'email';
                $google_user_name = isset($google_user_data['name']) ? $google_user_data['name'] : 'name';
                $google_user_id = isset($google_user_data['id']) ? $google_user_data['id'] : 'id';
                $exist_user = $this->email_check($google_user_email);
                if (empty($exist_user) || $exist_user == ''):
                    $insert_id = $this->signUpUser($google_user_name, $google_user_email, $google_user_id, $data);
                    $userdata = $this->getProfile($insert_id);
                else:
                    $userdata = $this->getProfileByEmail($google_user_email);
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
                redirect('/', $data);
            }
        } else {
            $post_google_request = $this->input->post('google_request', TRUE);
            if (isset($post_google_request) && $post_google_request != ''):
                $authUrl = $gClient->createAuthUrl();
                echo json_encode(array('result' => 'success', 'url' => $authUrl));
            else:
                //For Guest user, get google login url
                $data['authUrl'] = $gClient->createAuthUrl();
                $this->load->view('login/google/index', $data);
            endif;
        }
    }

    /**
     * If user click the cancel button@@@
     */
    public function redirectErrorGoogle() {
        if (isset($_GET['error']) && $_GET['error'] == "access_denied"):
            redirect(site_url('login'), 'refresh');
        endif;
    }

    /**
     * Check User Email Address
     * @param type $google_user_email
     * @return boolean
     */
    function email_check($google_user_email = '') {
//        $email = $this->getByEmail($google_user_email, 'google');
        $email = $this->model->checkmails($google_user_email);
        if (empty($email)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    /**
     * Get Email by @email and @type
     * @param type $email
     * @param type $type
     * @return type
     */
    function getByEmail($email, $type = 'google') {
        return $this->db->get_where('users', array('user_email' => $email, 'user_type' => $type))->row();
    }

    /**
     * Signup Google User
     * @param type $google_user_name
     * @param type $google_user_email
     * @param type $google_user_id
     * @return type
     */
    public function signUpUser($google_user_name, $google_user_email, $google_user_id, $data) {
        $return = $this->model->registerSocialUser($google_user_name, $google_user_email, $google_user_id, $data, '', $this->getToken(), 'google');
        return $return;
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

    public function returnSecret() {
        $secret = $this->config->item('google_client_secret');
        return $secret;
    }

    public function returnClientId() {
        $client_id = $this->config->item('google_client_id');
        return $client_id;
    }

    public function returnAppName() {
        $google_application_name = $this->config->item('google_application_name');
        return $google_application_name;
    }

    public function returnAPIKey() {
        $google_api_key = $this->config->item('google_api_key');
        return $google_api_key;
    }

    public function returnRedurectUrl() {
        $google_api_key = $this->config->item('google_redirect_uri');
        return $google_api_key;
    }

    public function logout() {
        //If user wish to log out, we just unset Session variable
        if (isset($_REQUEST['reset'])) {
            unset($_SESSION['token']);
            $gClient->revokeToken();
            header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
        }
    }

}
