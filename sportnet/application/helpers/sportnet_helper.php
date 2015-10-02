<?php

/**
 * Webmaster helpers to get the data related to the site 
 * Product views, coments likes etc
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/**
 * Active menu Class
 * @return string
 */
if (!function_exists('navigation_user_sidebar')) {

    function navigation_user_sidebar() {
        $CI = &get_instance();
        $segment = $CI->uri->segment(2);
        switch ($segment) {
            case 'profile':
                $menu = array('profile' => 'active', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'settings':
                $menu = array('profile' => '', 'author' => '', 'settings' => 'active', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'hidden_items':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => 'active', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'downloads':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => 'active', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'reviews':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => 'active', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'invoices':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => 'active', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
            case 'withdrawal':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => 'active', 'earnings' => '', 'statement' => '');
                break;
            case 'earnings':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => 'active', 'statement' => '');
                break;
            case 'statement':
                $menu = array('profile' => '', 'author' => '', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => 'active');
                break;
            default :
                $menu = array('profile' => '', 'author' => 'active', 'settings' => '', 'hidden_items' => '', 'downloads' => '', 'reviews' => '', 'invoices' => '', 'withdrawal' => '', 'earnings' => '', 'statement' => '');
                break;
        }
        return $menu;
    }

}
/* ===============================================================================================
 *                                  GET CATEGORY 
 * 
 * =============================================================================================== */

/**
 */
if (!function_exists('getCategories')) {

    function getCategories() {
        $CI = &get_instance();
        $cat = $CI->db->get_where('categories');
        return $cat->result();
    }

}

/**
 * Get Category By Id
 */
if (!function_exists('getCatById')) {

    function getCatById($id) {
        if ($id != ''):
            $CI = & get_instance();
            $category_name = $CI->db->get_where('categories', array('id' => $id))->row('category_name');
            if (empty($category_name)):
                return '';
            else:
                return $category_name;
            endif;
        else:
            return 'No Parent';
        endif;
    }

}

/**
 * Get the header add ID@@ 
 * @return string
 */
if (!function_exists('headerTypeAddId')) {

    function headerTypeAddId() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'header'))->row('id');
        if (empty($data)):
            return '';
        else:
            return $data;
        endif;
    }

}
/**
 * Get the content add ID@@ 
 * @return string
 */
if (!function_exists('pageinsideTypeAdId')) {

    function pageinsideTypeAdId() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'content'))->row('id');
        if (empty($data)):
            return '';
        else:
            return $data;
        endif;
    }

}
/**
 * Get the content add ID@@ 
 * @return string
 */
if (!function_exists('pageinsideTwoTypeAdId')) {

    function pageinsideTwoTypeAdId() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'content_two'))->row('id');
        if (empty($data)):
            return '';
        else:
            return $data;
        endif;
    }

}
/**
 * Get the content add Content@@@ 
 * @return string
 */
if (!function_exists('pageinsideAdContent')) {

    function pageinsideAdContent() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'content'))->row('content');
        if (empty($data)):
            return '';
        else:
            return $data;
        endif;
    }

}
/**
 * Get the content add Content@@@ 
 * @return string
 */
if (!function_exists('pageinsideTwoAdContent')) {

    function pageinsideTwoAdContent() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'content_two'))->row('content');
        if (empty($data)):
            return '';
        else:
            return $data;
        endif;
    }

}
/**
 * Get the Sidebar add ID@@ 
 * @return string
 */
if (!function_exists('sidebarTypeAddId')) {

    function sidebarTypeAddId() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'sidebar'))->row('id');
        if (empty($data)):
            return '';
        else:
            return $data;
        endif;
    }

}

/**
 * Get the header add Content@@@ 
 * @return string
 */
if (!function_exists('headerAdContent')) {

    function headerAdContent() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'header'))->row('content');
        if (empty($data)):
            return '';
        else:
            return $data;
        endif;
    }

}
/**
 * Get the Sidebar ad content @@@@ 
 * @return string
 */
if (!function_exists('sidebarAdContent')) {

    function sidebarAdContent() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'sidebar'))->row('content');
        if (empty($data)):
            return '';
        else:
            return $data;
        endif;
    }

}

/**
 * Get the sidebar ad@@ 
 * @return string
 */
if (!function_exists('sidebarAd')) {

    function sidebarAd() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'sidebar'))->row('content');
        if (empty($data)):
            return '<img src="' . site_url("/assets/img/img_4.jpg") . '" alt="SPONSOR ADS">';
        else:
            return $data;
        endif;
    }

}
/**
 * Get the content ad@@ 
 * @return string
 */
if (!function_exists('pageinsideAd')) {

    function pageinsideAd() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'content'))->row('content');
        if (empty($data)):
            return '<img src="' . site_url("/assets/img/img_7.jpg") . '" alt="SPONSOR ADS">';
        else:
            return $data;
        endif;
    }

}
/**
 * Get the content two ad@@ 
 * @return string
 */
if (!function_exists('pageinsideTwo')) {

    function pageinsideTwo() {
        $CI = & get_instance();
        $data = $CI->db->get_where('settings', array('type' => 'content_two'))->row('content');
        if (empty($data)):
            return '<img src="' . site_url("/assets/img/img_8.jpg") . '" alt="SPONSOR ADS">';
        else:
            return $data;
        endif;
    }

}



/**
 * Get Category By Slug
 */
if (!function_exists('getCatNameBySlug')) {

    function getCatNameBySlug($slug) {
        if ($slug != ''):
            $CI = & get_instance();
            $category_name = $CI->db->get_where('categories', array('slug' => $slug))->row('category_name');
            if (empty($category_name)):
                return '';
            else:
                return $category_name;
            endif;
        else:
            return '';
        endif;
    }

}
/**
 * Get Category By Id
 */
if (!function_exists('getCatNameById')) {

    function getCatNameById($id) {
        if ($id != ''):
            $CI = & get_instance();
            $category_name = $CI->db->get_where('categories', array('id' => $id))->row('category_name');
            if (empty($category_name)):
                return '';
            else:
                return $category_name;
            endif;
        else:
            return '';
        endif;
    }

}
if (!function_exists('getHierarchicalCategories')) {

    /**
     * Get labels for category
     * @param type $parent_id
     * @param type $level
     * @return type
     */
    function getHierarchicalCategories($parent_id, $level) {
        $CI = & get_instance();
        $cats = getCategoriesByParentId($parent_id);
        if (!empty($cats)):
            foreach ($cats as $cat) {
                $dash = '';
                for ($j = 0; $j < $level; $j++) {
                    $dash .= '—';
                }
                $CI->node[$cat->id] = $dash . $cat->category_name;
                getHierarchicalCategories($cat->id, $level + 1);
            }
        endif;
        if (!empty($CI->node)):
            return $CI->node;
        else:
            return '';
        endif;
    }

}





if (!function_exists('getParentCategories')) {

    /**
     * Get labels for category
     * @param type $parent_id
     * @param type $level
     * @return type
     */
    function getParentCategories($parent_id, $level) {
        $CI = & get_instance();
        $cats = getParentByCategoryId($parent_id);
//        pri($cats);
//        die();
        if (!empty($cats)):
            foreach ($cats as $cat) {
                $dash = '';
                for ($j = 0; $j < $level; $j++) {
                    $dash .= '—';
                }
                $CI->node[$cat->id] = '<a href="' . $cat->slug . '">' . $cat->category_name . '</a>';
                getParentCategories($cat->parent_id, $level + 1);
            }
        endif;
        if (!empty($CI->node)):
            return $CI->node;
        else:
            return '';
        endif;
    }

}


/**
 * Get the list of categories by parent id@@@
 * @param type $parent_id
 * @return string
 */
if (!function_exists('getParentByCategoryId')) {

    function getParentByCategoryId($parent_id = 0) {
        $CI = & get_instance();
        if (isset($parent_id)) {
            $attachment = $CI->db->get_where('categories', array('id' => $parent_id));
            if ($attachment->num_rows() != 0):
                return $attachment->result();
            else:
                return '';
            endif;
        }
    }

}









/**
 * Get the list of categories by parent id@@@
 * @param type $parent_id
 * @return string
 */
if (!function_exists('getCategoriesByParentId')) {

    function getCategoriesByParentId($parent_id = 0) {
        $CI = & get_instance();
        if (isset($parent_id)) {
            $attachment = $CI->db->get_where('categories', array('parent_id' => $parent_id));
            if ($attachment->num_rows() != 0):
                return $attachment->result();
            else:
                return '';
            endif;
        }
    }

}
/**
 * Get the time like facebook
 * @param type $datetime
 * @param type $full
 * @return type
 */
if (!function_exists('nicetime')) {

    function nicetime($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

}
/**
 * Get the formatted time
 * @param type $time
 * @return string
 */
if (!function_exists('time_elapsed_string')) {

    function time_elapsed_string($time) {
        if ($time !== intval($time)) {
            $time = strtotime($time);
        }
        $d = time() - $time;
        if ($time < strtotime(date('Y-m-d 00:00:00')) - 60 * 60 * 24 * 3) {
            $format = 'F j';
            if (date('Y') !== date('Y', $time)) {
                $format .= ", Y";
            }
            return date($format, $time);
        }
        if ($d >= 60 * 60 * 24) {
            $day = 'Yesterday';
            if (date('l', time() - 60 * 60 * 24) !== date('l', $time)) {
                $day = date('l', $time);
            }
            return $day . " at " . date('g:ia', $time);
        }
        if ($d >= 60 * 60 * 2) {
            return intval($d / (60 * 60)) . " hours ago";
        }
        if ($d >= 60 * 60) {
            return "about an hour ago";
        }
        if ($d >= 60 * 2) {
            return intval($d / 60) . " minutes ago";
        }
        if ($d >= 60) {
            return "about a minute ago";
        }
        if ($d >= 2) {
            return intval($d) . " seconds ago";
        }
        return "a few seconds ago";
    }

}
/**
 * Default image
 * @return type
 */
if (!function_exists('getImageNotFound')) {

    function getImageNotFound() {
        return site_url('assets/img/image_not_found.png');
    }

}

/**
 * Upload the files to the server and save the info to database
 * @param type $insert_id
 * @param type $name
 * @param type $file_in
 * @return boolean
 */
if (!function_exists('doUploadFiles')) {

    function doUploadFiles($insert_id = '', $name = 'attachment', $file_in = '') {
        $CI = & get_instance();
        if ($insert_id != '' && isset($_FILES)):
            if (file_exists($_FILES['attachment']['tmp_name']) || is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                $config['upload_path'] = APPPATH . 'uploads/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '10000';
                $config['max_width'] = '10000';
                $config['max_height'] = '10000';
                $config['encrypt_name'] = FALSE;
                $CI->load->library('upload', $config);
                if (!$CI->upload->do_upload($name)) {
                    $error = array('error' => $CI->upload->display_errors());
                    return FALSE;
                } else {
                    $data = array('upload_data' => $CI->upload->data());
                    if (isset($data['upload_data'])):
                        $upload_data_array = array(
                            'file_name' => $data['upload_data']['file_name'],
                            'file_type' => $data['upload_data']['file_type'],
                            'file_date' => date('Y-m-d'),
                            'file_in' => $file_in,
                            'file_in_id' => $insert_id,
                            'file_location' => 'uploads/' . $data['upload_data']['file_name'],
                            'file_extension' => $data['upload_data']['file_ext'],
                            'file_path' => $data['upload_data']['file_path'],
                            'file_full_path' => $data['upload_data']['full_path'],
                            'file_status' => 1,
                        );
                        $this->db->insert('table', $upload_data_array);
                    endif;
                    return TRUE;
                }
            }
        endif; // End check Insert
    }

}

/**
 * Function Check the blogger type
 */
if (!function_exists('getCategory')) {

    function getCategory($catid) {
        $CI = & get_instance();
        if (isset($catid)) {
            $catname = $CI->db->get_where('category', array('id' => $catid))->row('category_name');
            print_r($catname);
            die();
            if (!empty($catname)) {
                return $catname;
            } else {
                return $catid;
            }
        }
    }

}
/**
 * Print array with <pre> tag
 * @param type $array
 */
if (!function_exists('pri')) {

    function pri($array) {
        echo '<pre>';
        print_r($array);
    }

}

/// Admin footer settings

/**
 * Get the copyright text
 */
if (!function_exists('get_copyright_text')) {

    function get_copyright_text() {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('footer_copyright');
        $query = $CI->db->get();
        $result = $query->result();
        if (!empty($result)):
            return $result[0]->copy_right_text;
        else:
            return '';
        endif;
    }

}

/**
 * Get the copyright tagline
 */
if (!function_exists('get_copyright_tagline')) {

    function get_copyright_tagline() {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('footer_copyright');
        $query = $CI->db->get();
        $result = $query->result();
        if (!empty($result)):
            return $result[0]->copy_right_tagline;
        else:
            return '';
        endif;
    }

}
/**
 * Get the getUserLastSignIN
 */
if (!function_exists('footer_social_profiles')) {

    function footer_social_profiles() {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('footer_social');
        $query = $CI->db->get();
        $result = $query->result();
        if (!empty($result)):
            return $result[0];
        else:
            return '';
        endif;
    }

}

/**
 * Remove http://
 */
if (!function_exists('removehttp')) {

    function removehttp($input) {
        $input = trim($input, '/');
        if (!preg_match('#^http(s)?://#', $input)) {
            $input = 'http://' . $input;
        }
        $urlParts = parse_url($input);
        $domain = preg_replace('/^www\./', '', $urlParts['host']);
        return $domain;
    }

}

/**
 * Add http://
 */
if (!function_exists('addhttp')) {

    function addhttp($url) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }

}

//function get_first_image($html) {
//    require_once('SimpleHTML.class.php')
//    $post_html = str_get_html($html);
//    $first_img = $post_html->find('img', 0);
//
//    if ($first_img !== null) {
//        return $first_img->src;
//    }
//
//    return 'null';
//}


if (!function_exists('getDefaultImage')) {

    function getDefaultImage() {
        return '<img src="' . site_url("assets/img/no_image.jpg") . '" class="image_not_found" alt="Image not found" height="200" width="200" />';
    }

}
if (!function_exists('getCategoryDefaultImage')) {

    function getCategoryDefaultImage() {
        return '<img src="' . site_url("assets/img/no_image.jpg") . '" class="categoryClass" alt="Image not found" height="200" width="200" />';
    }

}
if (!function_exists('getOopsImage')) {

    function getOopsImage() {
        return '<img src="' . site_url("assets/img/oops_image.png") . '" class="categoryClass" alt="Image not found" height="200" width="200" />';
    }

}
/**
 * Get the list of menus for header
 * @param type $count
 * @return string
 */
if (!function_exists('getHeaderMenu')) {

    function getHeaderMenu($count = '') {
        $CI = & get_instance();
        $html = '';
        if ($count != ''):
            $limit = $CI->db->limit($count);
        endif;
        $CI->db->select('*');
        $CI->db->from('categories');
        $CI->db->where('parent_id', 0);
        $limit;
        $query = $CI->db->get();
        $result = $query->result();
        if (!empty($result)):
            foreach ($result as $cat):
                $id = $cat->id;
                $html .='<li><a href="' . site_url() . '' . $cat->slug . '">' . $cat->category_name . '</a>';
                $CI = & get_instance();
                $CI->db->select('*');
                $CI->db->from('categories');
                $CI->db->where('parent_id', $id);
                $query = $CI->db->get();
                $result_sub = $query->result();
                if (!empty($result_sub)):
                    $html .='<ul class="dropdown">';
                    foreach ($result_sub as $sub_cat):
                        $id = $sub_cat->id;
                        $html .='<li><a href="' . $sub_cat->slug . '">' . $sub_cat->category_name . '</a></li>';
                    endforeach;
                    $html .='</ul>';
                endif;
                $html .='</li>';
            endforeach;
        endif;
        return $html;
    }

}


/**
 * Display list for dashboard page
 * @param type $catid
 * @return string
 */
if (!function_exists('getList')) {

    function getList($catid, $selected = '') {
        $html = '';
        $html = '<ul id="checkList_' . $catid . '" class="chk-list-wrap light clear_fix">';
        $result = returnResult($catid);
        if (!empty($result)):
            foreach ($result as $cat):
                $idOne = $cat->id;
                $checked = backChecked($idOne, $selected);
                $html .='<li><strong class="titles">' . $cat->category_name . '</strong><div class="checkbox chk-all">
                                        <label><input class="' . $cat->category_name . '" name="isCheckedAll" id="' . $cat->id . '"  class="' . $cat->category_name . '" type="checkbox" id="' . $cat->id . '" value="' . $cat->id . '"' . $checked . '><span>All From &nbsp;' . $cat->category_name . '</span></label>
                                    </div>';
                $result_sub = returnResult($idOne);
                if (!empty($result_sub)):
                    $html .='<ul class="sub sub1">';
                    foreach ($result_sub as $sub_cat):
                        $id = $sub_cat->id;
                        $checked = backChecked($id, $selected);
                        $html .=' <li><div class="checkbox">';
                        $html .='<label class="checkit"  name="' . $sub_cat->category_name . '" id="' . $sub_cat->id . '"><input name="check_added"  class="' . $sub_cat->category_name . '" type="checkbox" id="' . $sub_cat->id . '" value="' . $sub_cat->id . '"' . $checked . '><span>' . $sub_cat->category_name . '</span></label>';
                        $html .='</div>';
                        $result_sub_2 = returnResult($id);
                        if (!empty($result_sub_2)):
                            $html .='<ul class="sub sub2">';
                            foreach ($result_sub_2 as $sub_cat_2):
                                $id = $sub_cat_2->id;
                                $checked = backChecked($id, $selected);
                                $html .='<li><div class="checkbox">';
                                $html .='<label class="checkit" name="' . $sub_cat_2->category_name . '" id="' . $sub_cat_2->id . '"><input name="check_added"  class="' . $sub_cat_2->category_name . '" type="checkbox" id="' . $sub_cat_2->id . '" name="' . $sub_cat_2->id . '" value="' . $sub_cat_2->id . '"' . $checked . '><span>' . $sub_cat_2->category_name . '</span></label>';
                                $html .='</div></li>';
                                $result_sub_3 = returnResult($id);
                                if (!empty($result_sub_3)):
                                    $html .='<ul class="sub sub3">';
                                    foreach ($result_sub_3 as $sub_cat_3):
                                        $checked = backChecked($sub_cat_3->id, $selected);
                                        $html .='<li><div class="checkbox">';
                                        $html .='<label class="checkit" name="' . $sub_cat_3->category_name . '" id="' . $sub_cat_3->id . '"><input name="check_added"  class="' . $sub_cat_3->category_name . '" type="checkbox" id="' . $sub_cat_3->id . '" name="' . $sub_cat_3->id . '" value="' . $sub_cat_3->id . '"><span>' . $sub_cat_3->category_name . '</span></label>';
                                        $html .='</div></li>';
                                    endforeach;
                                    $html .='</ul>';
                                endif;
                                $html .='</li>';
                            endforeach;
                            $html .='</ul>';
                        endif;
                        $html .='</li>';

                    endforeach;
                    $html .='</ul>';
                endif;
                $html .='</li>';
            endforeach;
        endif;
        $html.='</ul>';
        return $html;
    }

}

function backChecked($categoryId = '', $selectedArray = '') {
    if (is_array($selectedArray) && $categoryId != '' && !empty($selectedArray)):
        if (in_array($categoryId, $selectedArray)):
            $checked = 'checked';
        else:
            $checked = '';
        endif;
        return $checked;
    endif;
    return '';
}

/**
 * Return result by id
 * @param type $id
 * @return type
 */
if (!function_exists('returnResult')) {

    function returnResult($id) {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('categories');
        $CI->db->where('parent_id', $id);
        $query = $CI->db->get();
        $result = $query->result();
        return $result;
    }

}
/**
 * Get pages
 */
if (!function_exists('getPages')) {

    function getPages() {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('pages');
        $CI->db->where('status', 1);
        $query = $CI->db->get();
        $result_page = $query->result();
        if (!empty($result_page)):
            foreach ($result_page as $page):
                echo '<li><a href="' . $page->slug . '">' . $page->title . '</a></li>';
            endforeach;
        endif;
    }

}
/**
 * Return first add @@@ Default
 * @return string
 */
if (!function_exists('getFirstAdd')) {

    function getFirstAdd() {
        $image = '<li>
            <div class="item sponsor">
                <div class="img">
                    <a href="#">
                        <img src="http://sports.thinkigaming.com/assets/img/img_4.jpg" alt="SPONSOR ADS">
                    </a>
                </div>
                <div class="ads text_center">
                    <a href="#">SPONSOR ADS</a>
                </div>
            </div>
        </li>';
        return $image;
    }

}

/**
 * Get the social icons
 * @return type
 */
if (!function_exists('getSocials')) {

    function getSocials() {
        $instance = & get_instance();
        $socialLinksResult = $instance->db->get_where('footer_social', array('status' => 1));
        $socialLinks = $socialLinksResult->result();
        $linksSocial = $socialLinks[0];
        return $linksSocial;
    }

}
/**
 * feed icon by url
 * @param type $url
 * @return type
 */
if (!function_exists('feedIconByUrl')) {

    function feedIconByUrl($url = '') {
        $instance = & get_instance();
        $feed_icon = $instance->db->get_where('feeds', array('feed_admin_url' => $url));
        $feed_url = $feed_icon->result();
        $return = $feed_url[0]->feed_favicon;
        return $return;
    }

}
/**
 * Feed id by url
 * @param type $url
 * @return type
 */
if (!function_exists('feedIdByUrl')) {

    function feedIdByUrl($url = '') {
        $instance = & get_instance();
        $feed_icon = $instance->db->get_where('feeds', array('feed_admin_url' => $url));
        $feed_url = $feed_icon->result();
        return $feed_url[0]->id;
    }

}
/**
 * Feed title by url
 * @param type $url
 * @return type
 */
if (!function_exists('feedTitleByUrl')) {

    function feedTitleByUrl($url = '') {
        $instance = & get_instance();
        $feed_icon = $instance->db->get_where('feeds', array('feed_admin_url' => $url));
        $feed_url = $feed_icon->result();
        return $feed_url[0]->feed_title;
    }

}

/**
 * Serialize data, if needed.
 * @param string|array|object $data Data that might be serialized.
 * @return mixed A scalar data
 */
function maybe_serialize($data) {
    if (is_array($data) || is_object($data))
        return serialize($data);

    if (is_serialized($data, false))
        return serialize($data);

    return $data;
}

/**
 * Unserialize value only if it was serialized.
 *
 * @param string $original Maybe unserialized original, if is needed.
 * @return mixed Unserialized data can be any type.
 */
function maybe_unserialize($original) {
    if (is_serialized($original)): // don't attempt to unserialize data that wasn't serialized going in
        return @unserialize($original);
    endif;
    return $original;
}

/**
 * Check value to find if it was serialized.
 *
 * If $data is not an string, then returned value will always be false.
 * Serialized data is always a string.
 *
 * @param string $data   Value to check to see if was serialized.
 * @param bool   $strict Optional. Whether to be strict about the end of the string. Default true.
 * @return bool False if not serialized and true if it was.
 */
function is_serialized($data, $strict = true) {
    // if it isn't a string, it isn't serialized.
    if (!is_string($data)) {
        return false;
    }
    $data = trim($data);
    if ('N;' == $data) {
        return true;
    }
    if (strlen($data) < 4) {
        return false;
    }
    if (':' !== $data[1]) {
        return false;
    }
    if ($strict) {
        $lastc = substr($data, -1);
        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }
    } else {
        $semicolon = strpos($data, ';');
        $brace = strpos($data, '}');
        // Either ; or } must exist.
        if (false === $semicolon && false === $brace)
            return false;
        // But neither must be in the first X characters.
        if (false !== $semicolon && $semicolon < 3)
            return false;
        if (false !== $brace && $brace < 4)
            return false;
    }
    $token = $data[0];
    switch ($token) {
        case 's' :
            if ($strict) {
                if ('"' !== substr($data, -2, 1)) {
                    return false;
                }
            } elseif (false === strpos($data, '"')) {
                return false;
            }
        // or else fall through
        case 'a' :
        case 'O' :
            return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
        case 'b' :
        case 'i' :
        case 'd' :
            $end = $strict ? '$' : '';
            return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
    }
    return false;
}

function getSelectedCats() {
    $instance = & get_instance();
    $udata = $instance->session->all_userdata();
    $user_id = isset($udata['user_id']) ? $udata['user_id'] : 1;
    $userSelectedCategories = getFeedsSelectedCategories($user_id);
    $unserilize = maybe_unserialize($userSelectedCategories);
    if (!empty($unserilize)):
        return $unserilize;
    else:
        return '';
    endif;
}

/**
 * Get the list of categories added by user
 * @param type $userId
 * @return type
 */
function getFeedsSelectedCategories($userId) {
    $instance = & get_instance();
    $categories = $instance->db->get_where('users', array('id' => $userId))->row('user_categories');
    return $categories;
}

/**
 * Return Name of category
 */
if (!function_exists('getCatNameByCatId')) {

    function getCatNameByCatId($id) {
        if ($id != ''):
            $CI = & get_instance();
            $category_name = $CI->db->get_where('categories', array('id' => $id))->row('category_name');
            if (empty($category_name)):
                return '';
            else:
                return $category_name;
            endif;
        else:
            return '';
        endif;
    }

}
/**
 * Check if user is logged in or not return@@@@ True on logged and false on not logged
 */
if (!function_exists('isUserLoggedIn')) {

    function isUserLoggedIn() {
        $CI = & get_instance();
        $udata = $CI->session->all_userdata();

        if (isset($udata) && isset($udata['valid']) && isset($udata['is_logged_in'])) {
            if ($udata['valid'] == 1 && $udata['is_logged_in'] == TRUE) {
                return TRUE;
            }
        } else {
            return FALSE;
        }
        return;
    }

}

/**
 * Create Slug
 * @package string to slug
 * @param type $string
 * @param type $maxlen
 * @return string
 */
if (!function_exists('makeSlugs')) {

    function makeSlugs($string = '', $maxlen = 0) {
        $newStringTab = array();
        $string = strtolower(noDiacritics($string));
        if (function_exists('str_split')) {
            $stringTab = str_split($string);
        } else {
            $stringTab = my_str_split($string);
        }

        $numbers = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-");
        //$numbers=array("0","1","2","3","4","5","6","7","8","9");

        foreach ($stringTab as $letter) {
            if (in_array($letter, range("a", "z")) || in_array($letter, $numbers)) {
                $newStringTab[] = $letter;
                //print($letter);
            } elseif ($letter == " ") {
                $newStringTab[] = "-";
            }
        }

        if (count($newStringTab)) {
            $newString = implode($newStringTab);
            if ($maxlen > 0) {
                $newString = substr($newString, 0, $maxlen);
            }

            $newString = removeDuplicates('--', '-', $newString);
        } else {
            $newString = '';
        }

        return $newString;
    }

}

/**
 * Check directives in the string
 * @package string to url slug
 * @param type $string
 * @return type
 */
if (!function_exists('noDiacritics')) {

    function noDiacritics($string) {
        //cyrylic transcription
        $cyrylicFrom = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $cyrylicTo = array('A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia');


        $from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
        $to = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");


        $from = array_merge($from, $cyrylicFrom);
        $to = array_merge($to, $cyrylicTo);

        $newstring = str_replace($from, $to, $string);
        return $newstring;
    }

}

/**
 * Remove duplicate charectors from the string
 * @package string to url slug
 * @param type $sSearch
 * @param type $sReplace
 * @param type $sSubject
 * @return type
 */
if (!function_exists('removeDuplicates')) {

    function removeDuplicates($sSearch, $sReplace, $sSubject) {
        $i = 0;
        do {

            $sSubject = str_replace($sSearch, $sReplace, $sSubject);
            $pos = strpos($sSubject, $sSearch);

            $i++;
            if ($i > 100) {
                die('removeDuplicates() loop error');
            }
        } while ($pos !== false);

        return $sSubject;
    }

}

/**
 * Split the string
 * @package string to url slug
 * @param type $string
 * @return type
 */
if (!function_exists('my_str_split')) {

    function my_str_split($string) {
        $slen = strlen($string);
        for ($i = 0; $i < $slen; $i++) {
            $sArray[$i] = $string{$i};
        }
        return $sArray;
    }

}

/**
 * Get Category Id Slug
 */
if (!function_exists('getCategoryIdBySlug')) {

    function getCategoryIdBySlug($slug) {
        if ($slug != ''):
            $CI = & get_instance();
            $categoryId = $CI->db->get_where('categories', array('slug' => $slug))->row('id');
            if (empty($categoryId)):
                return '';
            else:
                return $categoryId;
            endif;
        else:
            return '';
        endif;
    }

}


/**
 * Get the list of menus for header
 * @param type $count
 * @return string
 */
if (!function_exists('getCategoriesForMenus')) {

    function getCategoriesForMenus($count = '') {
        $CI = & get_instance();
        $html = '';
        if ($count != ''):
            $limit = $CI->db->limit($count);
        endif;
        $CI->db->select('*');
        $CI->db->from('categories');
        $CI->db->where('parent_id', 0);
        $limit;
        $query = $CI->db->get();
        $result = $query->result();
        if (!empty($result)):
            foreach ($result as $cat):
                $html .='<li><a href="' . site_url() . '' . $cat->slug . '">' . $cat->category_name . '</a>';
                $html .='</li>';
            endforeach;
        endif;
        return $html;
    }

}


/**
 * Get Picture feeds only
 */
if (!function_exists('getOnlyPictureFeeds')) {

    function getOnlyPictureFeeds() {
        $CI = & get_instance();
        $result = $CI->db->get_where('feeds', array('feed_filter_type' => 'picture'), 4);
        $numRows = $result->num_rows();
        if (empty($result) && $numRows <= 0):
            return '';
        else:
            return $result->result();
        endif;
    }

}



/**
 * Get News feeds only
 */
if (!function_exists('getOnlyNewsFeeds')) {

    function getOnlyNewsFeeds() {
        $CI = & get_instance();
        $result = $CI->db->get_where('feeds', array('feed_filter_type' => 'news'), 4);
        $numRows = $result->num_rows();
        if (empty($result) && $numRows <= 0):
            return '';
        else:
            return $result->result();
        endif;
    }

}