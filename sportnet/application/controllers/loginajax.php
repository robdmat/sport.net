<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//load the facebook sdk
require_once APPPATH . 'libraries/facebook/facebook.php';

class Loginajax extends CI_Controller {

    public $node;

    public function __construct() {
        parent::__construct();

        //Sets the variable $header to use the slice 
        $this->stencil->slice(array('head', 'header', 'footer'));
//        Settings
        //load the libraries
        $this->load->helper(array('url', 'date', 'form', 'captcha')); //load required helpers 
        $this->load->library(array('session', 'email', 'form_validation', 'recaptcha', 'encrypt', 'pagination')); //load the session library
        $this->config->load('facebook'); //load the facebook config file
        //Sets the layout to be home_layout (/views/layouts/main_layout.php)
        $this->stencil->layout('home_layout');
        $this->stencil->css(array('font-awesome'));
        $this->stencil->css(array('admin_css/bootstrap.min', 'admin_css/bootstrap-responsive.min', 'style'));
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
                redirect('user/dashboard');
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
        $login = $this->isLoggedIn();
        if ($login == TRUE):
            redirect();
        else:
            //Set the variable $title to be used in your views
            $this->stencil->title('Create A Sportnet Account');
            // field name, error message, validation rules
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|xss_clean|callback_check_whitespaces|callback_check_user');
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|min_length[6]|xss_clean');
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|min_length[6]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
            if ($this->form_validation->run() == FALSE) {
                $this->stencil->paint('user/register');
            } else {
                $this->add_user();
                $this->thanks($this->input->post('email'));
            }
        endif;
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
        $this->load->model('userprofilequery');

        $existing_email = $this->userprofilequery->filterByemail($this->input->post('email'))->findOne();

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

        $user_name = $this->input->post('fullname');
        $explode = explode(' ', $user_name);
        $firstname = $explode[0];
        $lastname = (isset($explode[1]) ? $explode[1] : "");
        //load the user model
        $this->load->model(array('users', 'userprofile'));
        //get all the post values
        $post = $this->input->post();

        $auth = $this->encrypt->encode(strrev(random_string('unique', 16)) . '_' . strrev(now()));
        //Set the values of the user 
        $this->users->setusername($post['username']);
        $this->users->setpassword($this->encrypt->encode($post['password']));
        $this->users->setusertype('0');
        $this->users->setstatus('0');
        $this->users->setauthtoken($auth);
        $this->users->save();

        //Add the data in the user profile
        $this->userprofile->setemail($post['email']);
        $this->userprofile->setuserid($this->users->getId());
        $this->userprofile->setfirstname($firstname);
        $this->userprofile->setlastname($lastname);
        $this->userprofile->setregisteron(now());
        $this->userprofile->save();
        $user_id = $this->userprofile->getUserId();
        $this->set_user_affiliates($user_id);
        //Send mail to the user and admin
        $this->sendVerificationMail($post['email'], $this->users->getusername(), $auth);
    }

    /**
     * Thanks page
     */
    public function thanks($mail) {
        //Set the title of the page
        $this->stencil->title('Webmaster Account');
        //Render the page
        $this->stencil->paint('user/thanks', array('mail_id' => $mail));
    }

    /**
     * Account confirmation
     */
    public function confirm() {
        //load the user model
        $this->load->model(array('usersquery', 'users'));

        $get = $this->input->get();
        //fetch the user as per the user name
        $users = $this->usersquery->filterByusername($get['user'])->filterByauthtoken(base64_decode($get['auth']))->findOne();
        //auth token 
        $auth = $this->encrypt->encode(strrev(random_string('unique', 16)) . '_' . strrev(now()));
        if (!empty($users)) {
            $this->usersquery->filterByPrimaryKey($users->getId())->update(array('status' => '1', 'authtoken' => $auth));
            //Set the title of the page
            $this->stencil->title('Webmaster Account');
            //Render the associated page
            $this->stencil->paint('user/confirm');
        } else {
            //Set the title of the page
            $this->stencil->title('Webmaster Account');
            //Render the associated page
            $this->stencil->paint('user/confirm_expired');
        }
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
     * Function get login with the Facebook
     * and save the session of the logged in user
     */
    public function fbLogin() {
        //load the models
        $this->load->model(array('users', 'userprofile', 'userprofilequery', 'usersquery'));
        //get the Facebook appId and app secret from facebook.php which located in config directory for the creating the object for Facebook class
        $facebook = new Facebook(array(
            'appId' => $this->config->item('appID'),
            'secret' => $this->config->item('appSecret'),
            'access_token' => $this->config->item('appID') . '|' . $this->config->item('appSecret'),
        ));

        $user = $facebook->getUser(); // Get the facebook user id 

        if ($user) {

            try {
                $userData = $facebook->api('/me');  //Get the facebook user profile data

                $auth = $this->encrypt->encode(strrev(random_string('unique', 16)) . '_' . strrev(now()));
                //Set the values of the user 

                $checkUser = $this->userprofilequery->filterByemail($userData['email'])->findOne();

                if (empty($checkUser)) {
                    $data['fb_user_data'] = base64_encode(json_encode($userData));

                    //set the rules for the form validation
                    $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|min_length[6]|xss_clean|callback_check_whitespaces|callback_check_user');
                    $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[6]|max_length[32]');
                    $this->form_validation->set_rules('confirm_password', $this->lang->line('confirm_password'), 'trim|required|matches[password]');

                    //Form validation
                    if ($this->form_validation->run() == FALSE) {
                        $this->stencil->title($this->lang->line('create_account'));
                        $this->stencil->paint('user/fblogin');
                    } else {
                        $post = $this->input->post();
                        $auth = $this->encrypt->encode(strrev(random_string('unique', 16)) . '_' . strrev(now()));
                        //save the user detail
                        $user = new users();
                        $user->setusername($post['username']);
                        $user->setpassword($this->encrypt->encode($post['password']));
                        $user->setusertype('0');
                        $user->setstatus('0');
                        $user->setauthtoken($auth);
                        $user->save();

                        //User profile data
                        $userprofile = new userprofile();
                        $userprofile->setuserid($user->getid());
                        $userprofile->setfirstname($userData['first_name']);
                        $userprofile->setlastname($userData['last_name']);
                        $userprofile->setemail($userData['email']);
                        $userprofile->setdob($userData['birthday']);
                        $userprofile->setregisteron(now());
                        $userprofile->setlastlogin(now());
                        $userprofile->setlastip($_SERVER['SERVER_ADDR']);
                        $userprofile->save();
                        //send the verification mail 
                        $this->sendVerificationMail($userData['email'], $user->getusername(), $auth);
                        //redirect to thanks page
                        $this->thanks($userData['email']);
                    }
                } else {
                    $profile = userprofilequery::create()->filterByemail($userData['email'])->findOne();
                    $users = usersquery::create()->filterByPrimaryKey($profile->getuserid())->findOne();
                    //Set the session data
                    $data['username'] = $users->getusername();
                    $data['user_id'] = $profile->getuserid();
                    $data['auth'] = $users->getauthtoken();
                    $data['valid'] = $users->getstatus();
                    $data['first_name'] = $profile->getfirstname();
                    $data['last_name'] = $profile->getlastname();
                    $data['email'] = $profile->getemail();
                    $data['last_login'] = $profile->getlastlogin();
                    $data['ip'] = $_SERVER['SERVER_ADDR'];
                    $data['is_logged_in'] = TRUE;

                    //Set the session of the user 
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('info', '<div class="alert alert-info top_buffer">Hi ' . $this->users->getUsername() . '! you have logged in successfully.</div>');
                    redirect('user/dashboard', 'refresh');
                }
            } catch (FacebookApiException $e) {
                error_log($e);
            }
        }
    }

    /**
     * Function to send the verification mail
     * @param type $mail
     * @param type $username
     * @param type $auth
     */
    public function sendVerificationMail($mail, $username, $auth) {
        $this->email->from($this->config->item('admin_mail'));
        $this->email->to($mail);
        $this->email->subject($this->lang->line('acc_activate'));
        $this->email->message(sprintf($this->lang->line('acc_activate_msg'), $username, base64_encode($auth)));
        $this->email->send();
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
        $email = isset($udata['email']) ? $udata['email'] : '';
        if (!empty($email)) {
            $this->userModel->updateUserLoginInfo();
            $this->session->unset_userdata();
            $this->session->sess_destroy();
            redirect('home', 'refresh');
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

}
