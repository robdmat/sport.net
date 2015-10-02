<?php

class Login_Model extends CI_Model {

    public function getUser($email, $pass) {
        return $this->db->select("ID")
                        ->where("user_email", $email)->where("password", $pass)->get("users");
    }

    public function getUserByEmail($email) {
        return $this->db->select("ID,password")
                        ->where("user_email", $email)->get("users");
    }

    public function updateUserToken($userid, $token) {
        $this->db->where("ID", $userid)
                ->update("users", array("token" => $token));
    }

    public function addToResetLog($ip) {
        $this->db->insert("reset_log", array(
            "IP" => $ip,
            "timestamp" => time()
                )
        );
    }

    public function getResetLog($ip) {
        return $this->db->where("IP", $ip)->get("reset_log");
    }

    public function getUserEmail($email) {
        return $this->db->where("user_email", $email)
                        ->select("ID, name")->get("users");
    }

    public function resetPW($userid, $token) {
        $this->db->insert("password_reset", array(
            "userid" => $userid,
            "token" => $token,
            "IP" => $_SERVER['REMOTE_ADDR'],
            "timestamp" => time()
                )
        );
    }

    public function getResetUser($token, $userid) {
        return $this->db->where("token", $token)
                        ->where("userid", $userid)->get("password_reset");
    }

    public function updatePassword($userid, $password) {
        $this->db->where("ID", $userid)
                ->update("users", array("password" => $password));
    }

    public function deleteReset($token) {
        $this->db->where("token", $token)->delete("password_reset");
    }

    public function get_oauth_user($provider, $oauth_id) {
        return $this->db->where("oauth_provider", $provider)
                        ->where("oauth_id", $oauth_id)
                        ->get("users");
    }

    public function register_oauth_user($provider, $oauth_id, $name, $oauth_token, $oauth_token_secret) {

        $this->db->insert("users", array(
            "oauth_provider" => $provider,
            "oauth_id" => $oauth_id,
            "name" => $name,
            "oauth_token" => $oauth_token,
            "oauth_secret" => $oauth_token_secret,
            "IP" => $_SERVER['REMOTE_ADDR']
                )
        );
    }

    public function register_facebook_user($provider, $oauth_id, $name, $token) {
        $this->db->insert("users", array(
            "oauth_provider" => $provider,
            "oauth_id" => $oauth_id,
            "name" => $name,
            "token" => $token,
            "IP" => $_SERVER['REMOTE_ADDR']
                )
        );
    }

    public function update_facebook_user($provider, $oauth_id, $token) {
        $this->db->where("oauth_id", $oauth_id)
                ->where("oauth_provider", $provider)
                ->update("users", array(
                    "token" => $token,
                    "IP" => $_SERVER['REMOTE_ADDR']
                        )
        );
    }

    public function update_oauth_user($oauth_token, $oauth_secret, $oauth_id, $provider) {

        $this->db->where("oauth_id", $oauth_id)
                ->where("oauth_provider", $provider)
                ->update("users", array(
                    "oauth_token" => $oauth_token,
                    "oauth_secret" => $oauth_secret,
                    "IP" => $_SERVER['REMOTE_ADDR']
                        )
        );
    }

    public function checkUserBymail($email) {
        $query = $this->db->get_where('users', array('user_email' => $email));
        return $query->num_rows();
    }

    public function getmail() {
        $email = $this->input->post('email', TRUE);
        $query = $this->db->get_where('users', array('user_email' => $email));
        $userMail = $query->row('user_email');
        return $userMail;
    }

    public function getPassword($email) {
        $this->db->select('password');
        $this->db->from('users');
        $this->db->where('user_email', $email);
        $query = $this->db->get();
        return $query->row('password');
    }

    public function login() {
        $email = $this->input->post('email', TRUE);
        $where = "user_email = '$email' OR username = '$email'";
        $this->db->select('*');
        $this->db->from('users');
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
     * Update the status of the user that is active on the site
     * @param type $userId
     */
    public function updateIsLogin($userId) {
        $update_array = array(
            'user_is_active' => TRUE,
        );
        $this->db->where('id', $userId);
        $updated = $this->db->update('users', $update_array);
    }

    /**
     * 
     * @return type
     */
    public function sociallogin($email = '', $type = '') {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_email', $email);
        $this->db->where('user_type', $type);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

}

?>