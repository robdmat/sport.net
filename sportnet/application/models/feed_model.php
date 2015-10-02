<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feed_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->feed_table = 'feeds';
        $this->user_table = 'users';
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
     * Function @getUserSelectedCategories get the list of the categories selected by user
     * @param type $userId
     * @return type
     */
    public function getUserSelectedCategories($userId) {
        $categories = $this->db->get_where($this->user_table, array('id' => $userId))->row('user_categories');
        return $categories;
    }

    public function getAllDataCount() {
        $login = $this->isLoggedIn();
        $udata = $this->session->all_userdata();
        $user_id = isset($udata['user_id']) ? $udata['user_id'] : 1;
        $userSelectedCategories = $this->getUserSelectedCategories($user_id);
        $unserilize = maybe_unserialize($userSelectedCategories);
        if ($login && !empty($unserilize) && is_array($unserilize)):
            try {
                $list_id = join(',', $unserilize);
                $this->db->select('*');
                $this->db->from($this->feed_table);
                $this->db->where('status', '1');
//                $this->db->where('feed_filter_type', '1');
                $this->db->where_in('feed_user_category', $list_id);
                $query = $this->db->get();
                return $query->num_rows();
            } catch (Exception $ex) {
                return 0;
            }
        else:
            try {
                $this->db->select('*');
                $this->db->from($this->feed_table);
                $query = $this->db->get();
                return $query->num_rows();
            } catch (Exception $ex) {
                return 0;
            }
        endif;
    }

    /**
     * Return feeds data by limit and offset
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getAllData($limit, $offset) {
        $login = $this->isLoggedIn();
        $udata = $this->session->all_userdata();
        $user_id = isset($udata['user_id']) ? $udata['user_id'] : 1;
        $userSelectedCategories = $this->getUserSelectedCategories($user_id);
        $unserilize = maybe_unserialize($userSelectedCategories);
        if ($login && !empty($unserilize) && is_array($unserilize)):
            $list_id = join(',', $unserilize);
//            $this->db->select('*');
//            $this->db->from($this->feed_table);
//            $this->db->where_in('feed_user_category', str_replace("'", "", $list_id));
//            $this->db->order_by('id', 'desc');
//            $query = $this->db->get(); 
            $sql = "SELECT * FROM (`feeds`) WHERE `feed_user_category` IN ($list_id) AND `feed_filter_type` != 'news' ORDER BY `feed_date` desc LIMIT $limit OFFSET $offset";
//            $sql = "SELECT * FROM (`feeds`) WHERE `feed_user_category` IN ($list_id) order  by convert(datetime, feed_date, 103) desc";
//          echo $sql;
//          die();
            $query = $this->db->query($sql);
            return $query->result();
        else:
            $this->db->select('*');
            $this->db->from($this->feed_table);
            $this->db->where('feed_filter_type !=', 'news');
            $this->db->limit($limit, $offset);
            $this->db->order_by('feed_date', 'desc');
            $query = $this->db->get();
            return $query->result();
        endif;
    }

    public function getFeeds() {
        $this->db->select('*');
        $this->db->from($this->feed_table);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * 
     * @param type $data
     * @param type $feed_image_link
     * @param type $feed_image_url
     * @param type $feed_image_title
     * @param type $user_cat
     * @param type $admin_feed_url
     * @param type $language
     * @param type $feed_type
     * @param type $author
     * @param type $feed_filter_type
     * @param type $feed_user_title
     * @param type $favicon_icon
     * @return boolean
     */
    public function addFeeds($data, $feed_image_link = '', $feed_image_url = '', $feed_image_title = '', $user_cat = '', $admin_feed_url = '', $language = '', $feed_type = '', $author = '', $feed_filter_type = '', $feed_user_title = "", $favicon_icon = "") {
        if (!empty($data)):
            foreach ($data as $item):
                $prev_ids = array('guid1', 'guid2', 'guid3', 'guid4');
                if (in_array($item->get_id(true), $prev_ids)) {
                    $feed_post_id = $item->get_id(true);
                } else {
                    $feed_post_id = $item->get_id(true);
                }

//                get the author name
                if ($author = $item->get_author()) {
                    $emailAuthor = $author->get_email();
                    $nameAuthor = $author->get_name();
                    if ($nameAuthor != ''):
                        $authorname = $nameAuthor;
                    else:
                        $authorname = $emailAuthor;
                    endif;
                }
// Here are some of the various items you can pull from an RSS feed:
                $permalink = $item->get_permalink();
                $title = $item->get_title();
                $content = $item->get_description();



//get feed post category
                if ($category = $item->get_category()) {
                    $feed_post_category = $category->get_label();
                }
                $date_ = $item->get_date('Y-m-j g:i:s');
                if ($date_ == ''):
                    $date = date('Y-m-d H:i:s');
                else:
                    $date = $date_;
                endif;
// This next part will check for duplicated items by hashing the content and comparing it to the hashes in the database. This part is optional, but recommended.
                $content_hash = md5($permalink);
                $data = $this->db->get_where($this->feed_table, array('feed_content_hash' => $content_hash));
                if ($data->num_rows() > 0):

                else:
// This part will check if the date has been set. Sometimes feeds don't post the date so I found this to be necessary. If it has a date, then INSERT everything, if not, set a default date in MySQL and don't INSERT the date.
                    if (isset($date)):
                        preg_match('/(<img[^>]+>)/i', $content, $matchMe);
                        $resultImage = isset($matchMe[0]) ? $matchMe[0] : '';
                        if ($resultImage):
                            $filter = $feed_filter_type;
                        else:
                            $filter = 'news';
                        endif;
                        $add_array = array(
                            'feed_title' => isset($title) ? $title : '',
                            'feed_user_title' => isset($feed_user_title) ? $feed_user_title : '',
                            'feed_url' => isset($permalink) ? $permalink : '',
                            'feed_content' => isset($content) ? $content : '',
                            'feed_content_hash' => isset($content_hash) ? $content_hash : '',
                            'feed_date' => isset($date) ? $date : '',
                            'feed_language' => isset($language) ? $language : '',
                            'feed_type' => isset($feed_type) ? $feed_type : '',
                            'feed_filter_type' => isset($filter) ? $filter : '',
                            'feed_post_id' => isset($feed_post_id) ? $feed_post_id : '',
                            'feed_author' => isset($authorname) ? $authorname : '',
                            'feed_category' => isset($feed_post_category) ? $feed_post_category : '',
                            'feed_image_url' => isset($feed_image_url) ? $feed_image_url : '',
                            'feed_image_title' => isset($feed_image_title) ? $feed_image_title : '',
                            'feed_image_link' => isset($feed_image_link) ? $feed_image_link : '',
                            'feed_user_category' => isset($user_cat) ? $user_cat : '',
                            'feed_admin_url' => isset($admin_feed_url) ? $admin_feed_url : '',
                            'feed_favicon' => isset($favicon_icon) ? $favicon_icon : '',
                            'status' => 1,
                        );
                        $this->db->insert($this->feed_table, $add_array);
                    else:
                        preg_match('/(<img[^>]+>)/i', $content, $matchMe);
                        $resultImage = isset($matchMe[0]) ? $matchMe[0] : '';
                        if ($resultImage):
                            $filter = $feed_filter_type;
                        else:
                            $filter = 'news';
                        endif;

                        $add_array = array(
                            'feed_title' => isset($title) ? $title : '',
                            'feed_user_title' => isset($feed_user_title) ? $feed_user_title : '',
                            'feed_url' => isset($permalink) ? $permalink : '',
                            'feed_content' => isset($content) ? $content : '',
                            'feed_content_hash' => isset($content_hash) ? $content_hash : '',
                            'feed_language' => isset($language) ? $language : '',
                            'feed_type' => isset($filter) ? $filter : '',
                            'feed_filter_type' => isset($feed_filter_type) ? $feed_filter_type : '',
                            'feed_post_id' => isset($feed_post_id) ? $feed_post_id : '',
                            'feed_author' => isset($authorname) ? $authorname : '',
                            'feed_category' => isset($feed_post_category) ? $feed_post_category : '',
                            'feed_image_url' => isset($feed_image_url) ? $feed_image_url : '',
                            'feed_image_title' => isset($feed_image_title) ? $feed_image_title : '',
                            'feed_image_link' => isset($feed_image_link) ? $feed_image_link : '',
                            'feed_user_category' => isset($user_cat) ? $user_cat : '',
                            'feed_admin_url' => isset($admin_feed_url) ? $admin_feed_url : '',
                            'feed_favicon' => isset($favicon_icon) ? $favicon_icon : '',
                            'status' => 1,
                        );
                        $this->db->insert($this->feed_table, $add_array);
                    endif;
                endif;
            endforeach;
        else:
            return FALSE;
        endif;
        return TRUE;
    }

    public function checkFeedUrl($url = '') {
        $this->db->select('*');
        $this->db->from($this->feed_table);
        $this->db->like('feed_admin_url', $url);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function returnDistinctUrl() {
        $sql = 'SELECT DISTINCT(`feed_admin_url`) FROM `feeds` WHERE `status` = 1';
        $query = $this->db->query($sql);
// If nothing was returned invalid query.
        if ($query->num_rows() == 0):
            return false;
        else:
            return $query->result();
        endif;
    }

    /**
     * Del single  by id
     * @param type $id
     * @param type $url
     * @return boolean
     */
    public function deleteFeed($url) {
        $this->db->select('*');
        $this->db->from($this->feed_table);
        $this->db->like('feed_admin_url', $url);
        $query = $this->db->get();
        $resutl = $query->result();
        if (!empty($resutl)):
            foreach ($resutl as $del):
                $id = $del->id;
                $this->db->where('id', $id);
                $this->db->delete($this->feed_table);
            endforeach;
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public function validateHash($hash = '') {
        $data = $this->db->get_where($this->feed_table, array('feed_content_hash' => $hash));
        if ($data->num_rows() > 0):
            return $data->result();
        else:
            return FALSE;
        endif;
    }

///////NEWS 


    public function getAllNewsDataCount($type = '') {
        try {
            $this->db->select('*');
            $this->db->from($this->feed_table);
            $this->db->where('feed_filter_type', $type);
            $query = $this->db->get();
            return $query->num_rows();
        } catch (Exception $ex) {
            return 0;
        }
    }

    /**
     * Return feeds data by limit and offset
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getAllNewsData($limit, $offset, $type) {
        try {
            $this->db->select('*');
            $this->db->from($this->feed_table);
            $this->db->where('feed_filter_type', $type);
            $this->db->limit($limit, $offset);
            $this->db->order_by('feed_date', 'desc');
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $ex) {
            return 0;
        }
    }

}

?>
