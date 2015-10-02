<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('encrypt', 'session', 'form_validation', 'pagination', 'table'));
        $this->user_table = 'users';
        $this->pages_table = 'pages';
        $this->footer_copyright_table = 'footer_copyright';
        $this->footer_social_table = 'footer_social';
    }

    /**
     * Add users to table
     * @param type $post
     * @return type
     */
    public function addUser($post) {
        $add_array = array(
            'username' => $post['username'],
            'user_email' => $post['euser_email'],
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
     * Check the user user_email In database
     * @param type $input
     * @return type
     */
    public function checkUserMail($input) {
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where('user_email', $input);
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
     * Check the password of the user_email
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
     * Get the password of the euser_email
     * @param type $euser_email
     * @return type
     */
    public function getPassword($euser_email) {
        $this->db->select('password');
        $this->db->from($this->user_table);
        $this->db->where('user_email', $euser_email);
        $query = $this->db->get();
        return $query->row('password');
    }

    /**
     * Login function 
     * @param type $euser_email
     * @param type $password
     * @return boolean
     */
    public function login($input) {
        $this->db->select('*');
        $this->db->from($this->user_table);
        $this->db->where('user_email', $input);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            $this->session->set_flashdata('login_error', '<div class="alert alert-error">Invalid euser_email and password</div>');
            redirect(site_url('login'));
        }
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
     *                                   ADMIN PAGE CONTROL 
     * 
     * =============================================================================================== */

    public function getPages() {
        $this->db->select('*');
        $this->db->from($this->pages_table);
        $this->db->where('status', 1);
        $this->db->order_by("id", "desc");
        $info = $this->db->get();
        return $info->result();
    }

    public function getPageById($id) {
        $data = $this->db->get_where($this->pages_table, array('id' => $id));
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Update the table
     * @param type $id
     * @return boolean
     */
    public function updatePage($id) {
        $update_array = array(
            'title' => $this->input->post('title', TRUE),
            'content' => $this->input->post('content', TRUE),
            'slug' => $this->input->post('slug', TRUE),
        );
        $this->db->where('id', $id);
        $updated = $this->db->update($this->pages_table, $update_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
        return;
    }

    /**
     * Check the slug if exists
     * @param type $slug
     * @return boolean
     */
    public function pageFilterByslug($slug) {
        $data = $this->db->get_where($this->pages_table, array('slug' => $slug));
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Add page to table
     * @param type $post
     * @return type
     */
    public function addPage() {
        $add_page_array = array(
            'title' => $this->input->post('title', TRUE),
            'content' => $this->input->post('content', TRUE),
            'slug' => $this->input->post('slug', TRUE),
            'date' => date('Y-m-d H:i:s'),
            'status' => 1,
        );
        $this->db->insert($this->pages_table, $add_page_array);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    /**
     * Delete Page
     * @param type $id
     * @return boolean
     */
    public function deletPage($id) {
        $this->db->where('id', $id);
        $data = $this->db->delete($this->pages_table);
        if ($data) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* ===============================================================================================
     *                                   ADMIN FOOTER CONTROL 
     * 
     * =============================================================================================== */

    public function checkCopyRight() {
        $this->db->select('*');
        $this->db->from($this->footer_copyright_table);
        $this->db->where('status', 1);
        $info = $this->db->get();
        if ($info->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addCopyRight() {
        $add_array = array(
            'copy_right_text' => $this->input->post('copy_right_text', TRUE),
            'copy_right_tagline' => $this->input->post('copy_right_tagline', TRUE),
            'status' => 1,
        );
        $this->db->insert($this->footer_copyright_table, $add_array);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateCopyRight() {
        $update_array = array(
            'copy_right_text' => $this->input->post('copy_right_text', TRUE),
            'copy_right_tagline' => $this->input->post('copy_right_tagline', TRUE),
            'status' => 1,
        );
        $this->db->where('id', 1);
        $updated = $this->db->update($this->footer_copyright_table, $update_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
        return;
    }

    /* ===============================================================================================
     *                                   ADMIN FOOTER SOCIAL 
     * =============================================================================================== */

    public function checkSocial() {
        $this->db->select('*');
        $this->db->from($this->footer_social_table);
        $this->db->where('status', 1);
        $info = $this->db->get();
        if ($info->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addSocial($facebook = '', $twitter = '', $youtube = '', $pinterest = '', $instagram = '', $googleplug = '') {
        $add_array = array(
            'facebook' => ($facebook),
            'googleplug	' => ($googleplug),
            'twitter' => ($twitter),
            'youtube' => ($youtube),
            'pinterest' => ($pinterest),
            'instagram' => ($instagram),
            'status' => 1,
        );
        $this->db->insert($this->footer_social_table, $add_array);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateSocial($facebook = '', $twitter = '', $youtube = '', $pinterest = '', $instagram = '', $googleplug = '', $social_id = 1) {
        $update_array = array(
            'facebook' => ($facebook),
            'googleplug	' => ($googleplug),
            'twitter' => ($twitter),
            'youtube' => ($youtube),
            'pinterest' => ($pinterest),
            'instagram' => ($instagram),
            'status' => 1,
        );
        $this->db->where('id', $social_id);
        $updated = $this->db->update($this->footer_social_table, $update_array);
        if ($updated):
            return TRUE;
        else:
            return FALSE;
        endif;
        return;
    }

    /* ===============================================================================================
     *                                   PAGE FRONT END 
     * =============================================================================================== */

    public function getPageContent($slug = '') {
        $this->db->select('*');
        $this->db->from($this->pages_table);
        $this->db->where('slug', $slug);
        $info = $this->db->get();
        return $info->result();
    }

    /* ===============================================================================================
     *                                   ADD SETTING CONTROL 
     * 
     * =============================================================================================== */

    public function saveAd() {
        $addId = $this->input->post('id', TRUE);
        $addType = $this->input->post('add_type', TRUE);
        $addContent = $this->input->post('content', TRUE);
        $checkTypeExists = $this->checkType($addType);
        if (empty($addId) && $addId == '' && $checkTypeExists == FALSE):
            $addArray = array(
                'type' => $addType,
                'content' => $addContent,
                'date' => date('Y-m-d H:i:s'),
                'status' => 1,
            );
            $this->db->insert('settings', $addArray);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        else:
            $update_array = array(
                'type' => $addType,
                'content' => $addContent,
                'date' => date('Y-m-d H:i:s'),
                'status' => 1,
            );
            $this->db->where('id', $addId);
            $updated = $this->db->update('settings', $update_array);
            $this->db->trans_complete();
            return $updated;
        endif;
    }

    /**
     * Check if type exists
     * @param type $addType
     * @return boolean
     */
    public function checkType($addType = '') {
        $info = $this->db->get_where('settings', array('type' => $addType));
        if ($info->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

}

?>
