<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class Name: Cron_Model
 * Description: This class is used to make use of the database in the cron job
 * Author: Ajay Kumar
 * email: erajaykumar321@gmail.com
 */
class Cron_model extends CI_Model {

    protected $url;

    /**
     * Controller function of the class
     */
    public function __construct() {
        $this->db->reconnect();
        parent::__construct();
    }

    public function setCron() {
        $getUnique = $this->getAllFeedUrls();
        if (!empty($getUnique)):
            foreach ($getUnique as $feedTableData):
                $feed_user_title = $feedTableData->feed_user_title;
                $feed_url = $feedTableData->feed_admin_url;
                $usercat = $feedTableData->feed_user_category;
                $feed_filter_type = $feedTableData->feed_filter_type;
                $favicon_icon = $feedTableData->feed_favicon;
                $feed = new SimplePie();
                $feed->set_feed_url($feed_url);
                $feed->set_cache_location(APPPATH . '/cache');
                $feed->set_output_encoding('ISO-8859-1');
                $feed->init();
                $feed->handle_content_type();
                // Language
                $lang = $feed->get_language();
                $language = isset($lang) ? $lang : 'en-us';
                if ($feed->get_type() & SIMPLEPIE_TYPE_NONE) {
                    $feed_type = 'Unknown';
                } elseif ($feed->get_type() & SIMPLEPIE_TYPE_RSS_ALL) {
                    $feed_type = 'RSS';
                } elseif ($feed->get_type() & SIMPLEPIE_TYPE_ATOM_ALL) {
                    $feed_type = 'Atom';
                } elseif ($feed->get_type() & SIMPLEPIE_TYPE_ALL) {
                    $feed_type = 'Supported';
                }
                // Author
                if ($author = $feed->get_author()):
                    $feedAuthor = $author->get_name();
                else:
                    $feedAuthor = '';
                endif;
                if ($feed->error()):
                    die();
                else:
                    $feed_image_link = $feed->get_image_link();
                    $feed_image_url = $feed->get_image_url();
                    $feed_image_title = $feed->get_image_title();
                    $this->addFeeds($feed->get_items(0, 500), $feed_image_link, $feed_image_url, $feed_image_title, $usercat, $feed_url, $language, $feed_type, $feedAuthor, $feed_filter_type, $feed_user_title, $favicon_icon);
                endif;
            endforeach;
        endif;
    }

    /**
     * Get all the unique urls from the `FEEDS` table
     * @return boolean
     */
    public function getAllFeedUrls() {
        $sql = 'SELECT * FROM `feeds` GROUP BY `feed_admin_url`';
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0):
            return false;
        else:
            return $query->result();
        endif;
    }

    /**
     * Update the feed Add data to table
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
     * @return string
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
                $date = $item->get_date('Y-m-j g:i:s');
// This next part will check for duplicated items by hashing the content and comparing it to the hashes in the database. This part is optional, but recommended.
                $content_hash = md5($permalink);
                $data = $this->db->get_where('feeds', array('feed_content_hash' => $content_hash));
                if ($data->num_rows() > 0):
                    return 'No Feed Posts To Update';
                else:
                    if (isset($date)):
                        $add_array = array(
                            'feed_title' => isset($title) ? $title : '',
                            'feed_user_title' => isset($feed_user_title) ? $feed_user_title : '',
                            'feed_url' => isset($permalink) ? $permalink : '',
                            'feed_content' => isset($content) ? $content : '',
                            'feed_content_hash' => isset($content_hash) ? $content_hash : '',
                            'feed_date' => isset($date) ? $date : '',
                            'feed_language' => isset($language) ? $language : '',
                            'feed_type' => isset($feed_type) ? $feed_type : '',
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
                        $this->db->insert('feeds', $add_array);
                    else:
                        $add_array = array(
                            'feed_title' => isset($title) ? $title : '',
                            'feed_user_title' => isset($feed_user_title) ? $feed_user_title : '',
                            'feed_url' => isset($permalink) ? $permalink : '',
                            'feed_content' => isset($content) ? $content : '',
                            'feed_content_hash' => isset($content_hash) ? $content_hash : '',
                            'feed_language' => isset($language) ? $language : '',
                            'feed_type' => isset($feed_type) ? $feed_type : '',
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
                        $this->db->insert('feeds', $add_array);
                    endif;
                endif;
            endforeach;
        else:
            return 'Updated';
        endif;
    }

}

?>