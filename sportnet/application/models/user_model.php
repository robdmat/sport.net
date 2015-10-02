<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('encrypt', 'session', 'form_validation', 'pagination', 'table'));
        $this->user_table = 'users';
    }

    /**
     * Add pm_users to table
     * @param type $post
     * @return type
     */
    public function addUser($post) {
        $add_array = array(
            'username' => $post['username'],
            'mail' => $post['email'],
            'other_details' => $post['user_details'],
            'phone' => $post['user_phone'],
            'password' => $this->encrypt->encode($post['password']),
            'created_on' => date('Y-m-d H:i:s'),
            'updated_on' => date('Y-m-d H:i:s'),
            'last_login_on' => date('Y-m-d H:i:s'),
            'auth_token' => base64_encode(strrev(date('Y-m-d H:i:s'))),
            'status' => 1,
        );
        $return = $this->db->insert($this->user_table, $add_array);
        return $return;
    }

    /**
     * Get the list of users
     * @return type
     */
    public function getUsers() {
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Check the user mail In database
     * @param type $input
     * @return type
     */
    public function checkUserMail($input) {
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where('mail', $input);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Check the username of the user 
     * 
     * @param type $username
     * @return boolean
     */
    public function checkUsername($username) {
        $query = $this->db->get_where($this->user_table, array('username' => $username));
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Login function 
     * @param type $email
     * @param type $password
     * @return boolean
     */
    public function login($input) {
        $where = "mail = '$input' OR username = '$input'";
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where($where);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            $this->session->set_flashdata('login_error', '<div class="alert alert-error">Invalid email and password</div>');
            redirect(site_url('login'));
        }
    }

    /**
     * Get single User by id
     * @param type $id
     * @return boolean
     */
    public function getUserById($id) {
        $data = $this->db->get_where($this->user_table, array('id' => $id));
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Update User
     * @param type $id
     * @return boolean
     */
    public function updateUser($id) {
        $update_project_array = array(
            'username' => $this->input->post('username', TRUE),
            'other_details' => $this->input->post('user_details', TRUE),
            'phone' => $this->input->post('user_phone', TRUE),
            'updated_on' => date('Y-m-d H:i:s'),
            'status' => 1,
        );

        $this->db->where('id', $id);
        $updated = $this->db->update($this->user_table, $update_project_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
        return;
    }

    /**
     * Delete User
     * @param type $id
     * @return boolean
     */
    public function deletUser($id) {
        $data = $this->db->where('id', $id);
        $data = $this->db->delete($this->user_table);
        if ($data) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* ===============================================================================================
     *                                   USER CONTROL
     * 
     * =============================================================================================== */

    public function filterByEmail($email) {
        $query = $this->db->get_where($this->user_table, array('user_email' => $email));
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function filterByRegisterEmail($email) {
        $query = $this->db->get_where($this->user_table, array('user_email' => $email));
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Check the password of the mail
     * @param type $input
     * @return type
     */
    public function checkUserPassword($input) {
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where('user_email', $input);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Check the password of the mail
     * @param type $input
     * @return type
     */
    public function checkPassword($input) {
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where('user_email', $input);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get the password of the email
     * @param type $email
     * @return type
     */
    public function getPassword($email) {
        $this->db->select('password');
        $this->db->from($this->user_table);
        $this->db->where('user_email', $email);
        $query = $this->db->get();
        return $query->row('password');
    }

    /**
     * Get the user information
     * @param type $input
     * @return type
     */
    public function getUserInfo($input) {
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where('user_email', $input);
        $info = $this->db->get();
        return $info->result();
    }

    /**
     * Update the status of the user that is active on the site
     * @param type $userId
     */
    public function updateIsActive($userId) {
        $update_array = array(
            'user_is_active' => TRUE,
        );
        $this->db->where('id', $userId);
        $updated = $this->db->update($this->user_table, $update_array);
        return $updated;
    }

    public function updateUserLoginInfo() {
        $id = $this->session->userdata('user_id');
        $update_array = array(
            'user_last_login' => date('Y-m-d H:i:s'),
            'user_is_active' => FALSE,
        );
        $this->db->where('id', $id);
        $updated = $this->db->update($this->user_table, $update_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
        return;
    }

    /**
     * Update User password
     * @param type $email
     * @param type $password
     * @param type $auth
     * @return boolean
     */
    public function updateUserPassword($email, $password, $auth) {
        $update_array = array(
            'password' => $password,
            'token' => $auth,
        );
        $this->db->where('user_email', $email);
        $updated = $this->db->update($this->user_table, $update_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
        return;
    }

    public function addRegisterUser($email, $password, $token) {
        $ip = $_SERVER['REMOTE_ADDR']; // the IP address to query
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        if ($query && $query['status'] == 'success') {
            $country = isset($query['country']) ? $query['country'] : '';
            $city = isset($query['city']) ? $query['city'] : $query['regionName'];
            $timezone = isset($query['timezone']) ? $query['timezone'] : '';
            $lat = isset($query['lat']) ? $query['lat'] : '';
            $lon = isset($query['lon']) ? $query['lon'] : '';
        }
        if ($city == ''):
            $city = isset($query['regionName']) ? $query['regionName'] : '';
        endif;
        $this->db->insert("users", array(
            "user_email" => $email,
            "username" => $email,
            'user_type' => 'system',
            "token" => $token,
            "user_created" => date("Y-m-d"),
            "password" => $this->encrypt->encode($password),
            "user_ip" => $ip,
            "user_timezone" => $timezone,
            "user_country" => $country,
            "user_city" => $city,
            "user_lat" => $lat,
            "user_lon" => $lon,
            "user_ref_address" => '',
            "user_ref_link_type" => '',
            'status' => 1
                )
        );
        $return_id = $this->db->insert_id();
        return $return_id;
    }

    /**
     * Fetch the user details and save session
     * @return type
     */
    public function getUserInfoForRegisterUser($input) {
        //getting the info of the user
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where('user_email', $input);
        $info = $this->db->get();
        $users = $info->result();
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
     * Update user table
     * @param type $categories
     * @param type $userId
     * @return boolean
     */
    public function updateUserCategories($categories = '', $userId = '', $parentSubs = '') {
//        $childCats = array();
//        if (!empty($parentSubs) && is_array($parentSubs)):
//            $c = 1;
//            foreach ($parentSubs as $key => $value):
//                $cts = getHierarchicalCategories($key, 0);
//                $childCats[$c] = $cts;
//                $c++;
//            endforeach;
//            pri($childCats);
//            pri($categories);
//            die();
//        endif;
        $serilize_categories = maybe_serialize($categories);
        $update_user_array = array(
            'user_categories' => $serilize_categories
        );
        $this->db->where('id', $userId);
        $updated = $this->db->update($this->user_table, $update_user_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

}

?>
