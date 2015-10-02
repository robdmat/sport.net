<?php

class Register_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_user', 'user');
        $this->load->library(array('encrypt', 'form_validation', 'email', 'session'));
        $this->load->helper('cookie');
    }

    public function registerUser($username, $email, $password, $token) {
        // User location information
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
            "username" => $username,
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
        $this->db->insert_id();
    }

    /**
     * Return affiliate
     * @param type $user_id
     * @return type
     */
    public function getAffiliateurl($user_id) {
        if ($user_id != ''):
            $data = $this->db->get_where('users', array('ID' => $user_id));
            $name = $data->result();
            $user_affiliate_url = isset($name[0]->user_affiliate_url) ? $name[0]->user_affiliate_url : 1;
            return $user_affiliate_url;
        endif;
    }

    /**
     * Update user affialate url @@@@
     * @param type $return_id
     * @return boolean
     */
    public function generateAffiliate($return_id = '') {
        $user_affiliate_url = $return_id . time();
        $this->db->where('ID', $return_id);
        $this->db->set('user_affiliate_url', $user_affiliate_url);
        $this->db->update('users');
        return TRUE;
    }

    public function checkEmailIsFree($email) {
        $s = $this->db->where("user_email", $email)->get("users");
        if ($s->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check user name
     * @param type $username
     * @return boolean
     */
    public function check_username_is_free($username) {
        $s = $this->db->where("username", $username)->get("users");
        if ($s->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * add user name
     * @param type $userid
     * @param type $username
     */
    public function add_username($userid, $username) {
        $this->db->where("ID", $userid)->update("users", array("username" => $username));
    }

    /**
     * Get account by username
     *
     * @access public
     * @param string $username
     * @return object account object
     */
    function get_by_username($username) {
        return $this->db->get_where('users', array('username' => $username))->row();
    }

    /**
     * Get account by email
     *
     * @access public
     * @param string $email
     * @return object account object
     */
    function get_by_email($email) {
        return $this->db->get_where('users', array('user_email' => $email))->row();
    }

    function checkmails($email) {
        $s = $this->db->where("user_email", $email)->get("users");
        if ($s->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * User Facebook Login
     * @param type $username
     * @param type $email
     * @param type $password
     * @param type $token
     * @param type $facebook_user_id
     * @param type $type
     */
    public function registerSocialUser($user_name, $user_email, $user_id, $data, $password = '', $token = '', $type = '') {
//        Other fields
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $user_link = $data['link'];
        $user_locale = $data['locale'];
        $user_updated_time = $data['updated_time'];
        $user_gender = $data['gender'];
        $user_profile_picture = $data['profile_picture'];

        $ref_url = isset($_SESSION['org_referer']) ? $_SESSION['org_referer'] : '';
        // User location information
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
        if ($type == 'google'):
            $user_timezone = $timezone;
        else:
            $user_timezone = $data['timezone'];
        endif;
        $this->db->insert("users", array(
            "user_email" => $user_email,
            "username" => $user_name,
            'user_first_name' => $first_name,
            'user_last_name' => $last_name,
            'user_link' => $user_link,
            'user_locale' => $user_locale,
            'user_profile_timezone' => $user_timezone,
            'user_updated_time' => $user_updated_time,
            'user_gender' => $user_gender,
            'user_profile_picture' => $user_profile_picture,
            'user_avatar' => $user_profile_picture,
            "token" => $token,
            'user_type' => $type,
            "user_created" => date("Y-m-d"),
            "password" => '',
            "user_ip" => $ip,
            "user_timezone" => $timezone,
            "user_country" => $country,
            "user_city" => $city,
            "user_lat" => $lat,
            "user_lon" => $lon,
            "status" => 1,
            "user_ref_address" => '',
            "user_ref_link_type" => isset($ref_url) ? $ref_url : '',
                )
        );
        $return_id = $this->db->insert_id();
        return $return_id;
    }

}

?>
