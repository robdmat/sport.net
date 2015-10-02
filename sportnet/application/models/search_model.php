<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->feed_table = 'feeds';
    }

    /**
     * Return search result count
     * @param type $keyword
     * @return type
     */
    public function getAllSearchDataCount($keyword) {
        $this->db->select('*');
        $this->db->from($this->feed_table);
        $this->db->like('feed_title', $keyword);
        $this->db->or_like('feed_category', $keyword);
        $this->db->or_like('feed_image_title', $keyword);
        $this->db->or_like('feed_user_category', $keyword);
        $this->db->or_like('feed_content', $keyword);
        $this->db->order_by("feed_title", "asc");
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Function return the list of the rows
     * @param type $keyword
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getAllSearchData($keyword, $limit, $offset) {
        $this->db->select('*');
        $this->db->from($this->feed_table);
        $this->db->like('feed_title', $keyword);
        $this->db->or_like('feed_category', $keyword);
        $this->db->or_like('feed_image_title', $keyword);
        $this->db->or_like('feed_user_category', $keyword);
        $this->db->or_like('feed_content', $keyword);
        $this->db->limit($limit, $offset);
        $this->db->order_by("feed_title", "asc");
        $query = $this->db->get();
        return $query->result();
    }

}

?>
