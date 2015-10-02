<?php

class Model_user extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->page_meta_table = 'tbl_page_meta_data';
        $this->users = 'users';
        $this->tbl_user_meta = 'tbl_user_meta';
    }

    var $details;

    function validate_user($user, $password) {
        // Build a query to retrieve the user's details
        // based on the received username and password
        $this->db->from('tbl_users');
        $this->db->where('users_username', $user);
        //$this->db->where( 'Password', sha1($password) );
        $this->db->where('users_password', $password);
        $login = $this->db->get()->result();

        // The results of the query are stored in $login.
        // If a value exists, then the user account exists and is validated
        if (is_array($login) && count($login) == 1) {
            // Set the users details into the $details property of this class
            $this->details = $login[0];
            // Call set_session to set the user's session vars via CodeIgniter
            $this->set_session();
            return true;
        }

        return false;
    }

    function set_session() {
        // session->set_userdata is a CodeIgniter function that
        // stores data in CodeIgniter's session storage.  Some of the values are built in
        // to CodeIgniter, others are added.  See CodeIgniter's documentation for details.
        $this->session->set_userdata(array(
            'id' => $this->details->users_id,
            'username' => $this->details->users_username,
            'email' => $this->details->users_email,
            'role' => $this->details->users_role,
            /*                'avatar'=>$this->details->avatar,
              'tagline'=>$this->details->tagline,
              'isAdmin'=>$this->details->isAdmin,
              'teamId'=>$this->details->teamId, */
            'isLoggedIn' => true
                )
        );
    }

    function create_new_user($userData) {
        $data['firstName'] = $userData['firstName'];
        $data['lastName'] = $userData['lastName'];
        $data['teamId'] = (int) $userData['teamId'];
        $data['isAdmin'] = (int) $userData['isAdmin'];
        $data['avatar'] = $this->getAvatar();
        $data['email'] = $userData['email'];
        $data['tagline'] = "Click here to edit tagline.";
        $data['password'] = sha1($userData['password1']);

        return $this->db->insert('tbl_users', $data);
    }

    public function update_tagline($user_id, $tagline) {
        $data = array('tagline' => $tagline);
        $result = $this->db->update('tbl_users', $data, array('id' => $user_id));
        return $result;
    }

    private function getAvatar() {
        $avatar_names = array();

        foreach (glob('assets/img/avatars/*.png') as $avatar_filename) {
            $avatar_filename = str_replace("assets/img/avatars/", "", $avatar_filename);
            array_push($avatar_names, str_replace(".png", "", $avatar_filename));
        }

        return $avatar_names[array_rand($avatar_names)];
    }

    /*
     * Get all of the users.
     */

    function get_users() {
        $sql = "SELECT u.users_id,
					   u.users_username,
					   u.users_email,
					   u.users_role,
					   u.users_is_active,
					   u.users_creation_date
			  	  FROM tbl_users u
			  ORDER BY u.users_id DESC;";

        $query = $this->db->query($sql);

        // If nothing was returned invalid query.
        if ($query->num_rows() == 0)
            return false;

        return $query->result_array();
    }

    /**
     * Get the user info
     * @return type
     */
    public function getUsersInfo() {
        $this->db->select('*');
        $this->db->from($this->users);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get the user info
     * @return type
     */
//    public function getUserInfoById($userId) {
//        $this->db->select('*');
//        $this->db->from($this->users);
//        $this->db->where('ID', $userId);
//        $query = $this->db->get();
//        return $query->result();
//    }

    public function getUserInfoById($userId) {
        $this->db->select('*');
        $this->db->from($this->users);
        $this->db->join('tbl_user_meta', 'tbl_user_meta.user_id=users.ID', 'left');
        $this->db->where('users.ID', $userId);
        $this->db->group_by('users.ID');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getrefUser($ref_url = '') {
        if ($ref_url != ''):
            $data = $this->db->get_where($this->users, array('user_affiliate_url' => $ref_url));
            $name = $data->result();
            $user_id = isset($name[0]->ID) ? $name[0]->ID : 1;
            return $user_id;
        endif;
    }

    public function checkRefExisting($user_id) {
        if ($user_id != ''):
            $data = $this->db->get_where($this->users, array('ID' => $user_id));
            $name = $data->result();
            $user_affiliate_url = isset($name[0]->user_affiliate_url) ? $name[0]->user_affiliate_url : 1;
            return $user_affiliate_url;
        endif;
    }

    public function checkRefExistingRef($ref_url = '') {
        if ($ref_url != ''):
            $data = $this->db->get_where($this->users, array('user_affiliate_url' => $ref_url, 'status' => 1));
            $name = $data->result();
            $user_affiliate_url = isset($name[0]->user_affiliate_url) ? $name[0]->user_affiliate_url : 1;
            return $user_affiliate_url;
        endif;
    }

    public function checkAffiliateIpByUrl($ref_url = '') {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("status", 1);
        $this->db->where('user_affiliate_url', $ref_url);
        $this->db->where('user_ip', $_SERVER['REMOTE_ADDR']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
        return FALSE;
    }

    public function checkId($user_id = '') {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("status", 1);
        $this->db->where('ID', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
        return FALSE;
    }

    public function getUserNameById($userId) {
        $data = $this->db->get_where($this->users, array('ID' => $userId, 'status' => 1));
        $name = $data->result();
        $username = isset($name[0]->username) ? $name[0]->username : 'username';
        return $username;
    }

    public function updateGenderValue($user_id, $gender) {
        $update_gen_array = array(
            'user_gender' => $gender,
        );
        $this->db->where('ID', $user_id);
        $updated = $this->db->update($this->users, $update_gen_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
        return;
    }

    public function updateSocialInfromation($user_id) {
        $update_social_array = array(
            'user_skpye' => $this->input->post('user_skpye', TRUE),
            'user_google_plus' => $this->input->post('user_google_plus', TRUE),
            'user_twitter' => $this->input->post('user_twitter', TRUE),
            'user_facebook' => $this->input->post('user_facebook', TRUE),
            'user_linkedin' => $this->input->post('user_linkedin', TRUE),
            'user_instagram' => $this->input->post('user_instagram', TRUE),
        );
        $this->db->where('ID', $user_id);
        $updated = $this->db->update($this->users, $update_social_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
        return;
    }

    /**
     * Delete the particular user
     * @param type $id
     * @return boolean
     */
    public function deletUser($id) {
        $this->db->where('ID', $id);
        $data = $this->db->delete($this->users);
        if ($data) {
            $this->db->where('ID', $id);
            $this->db->delete($this->tbl_user_meta);
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
