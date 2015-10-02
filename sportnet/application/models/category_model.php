<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->cat_table = 'categories';
        $this->feed_table = 'feeds';
    }

    /**
     * Add users to table
     * @param type $post
     * @return type
     */
    public function adddCategory() {
        $parant = $this->input->post('category_parent');
        $add_array = array(
            'category_name' => $this->input->post('category_name', TRUE),
            'parent_id' => isset($parant) ? $parant : 0,
            'slug' => makeSlugs($this->input->post('category_name', TRUE)),
            'status' => 1,
        );
        $return = $this->db->insert($this->cat_table, $add_array);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        $this->uploadFile($insert_id);
        return $return;
    }

    /**
     * Function to generate the slug
     * @param type $string
     * @return type
     */
    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }

    /**
     * Get the list of users
     * @return type
     */
    public function getCategory() {
        $this->db->select('*');
        $this->db->from($this->cat_table);
        $this->db->where('status', '1');
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Return the list of the parent categories
     * @return type
     */
    public function getParentCategories() {
        $this->db->select('*');
        $this->db->from($this->cat_table);
        $this->db->where('status', '1');
        $this->db->where('parent_id', 0);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Return the list of subcategories by parent id
     * @param type $parentId
     * @return type
     */
    public function getSubCategoriesListByParentId($parentId) {
        $this->db->select('*');
        $this->db->from($this->cat_table);
        $this->db->where('status', '1');
        $this->db->where('parent_id', $parentId);
        $this->db->order_by("category_name", "asc");
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get category by slug
     * @param type $slug
     * @return boolean
     */
    public function getCategoryBySlug($slug) {
        $data = $this->db->get_where($this->cat_table, array('slug' => $slug));
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Check slug
     * @param type $slug
     * @return boolean
     */
    public function checkCategorySlug($slug = '') {
        if (!empty($slug) || $slug != ''):
            $data = $this->db->get_where($this->cat_table, array('slug' => $slug));
            if ($data->num_rows() > 0):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            return FALSE;
        endif;
    }

    /**
     * Get category by ID
     * @param type $id
     * @return boolean
     */
    public function getCategoryById($id = '') {
        $data = $this->db->get_where($this->cat_table, array('id' => $id));
        if ($data->num_rows() > 0) {
            $data = $data->result();
            $data = $data[0];
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Get category by ID
     * @param type $id
     * @return boolean
     */
    public function getCategoryListById($id = '') {
        $data = $this->db->get_where($this->cat_table, array('id' => $id));
        if ($data->num_rows() > 0) {
            $data = $data->result();
            return $data;
        } else {
            return FALSE;
        }
    }

    /**
     * Update the Category
     * @param type $id
     * @return boolean
     */
    public function updateProjectcategory($id) {
        $parant = $this->input->post('category_parent');
        $update_project_array = array(
            'category_name' => $this->input->post('category_name', TRUE),
            'parent_id' => isset($parant) ? $parant : 0,
            'slug' => $this->create_slug($this->input->post('category_name', TRUE)),
            'status' => 1,
        );
        $this->db->where('id', $id);
        $return = $this->db->update($this->cat_table, $update_project_array);
        if ($return) {
            $this->uploadFile($id);
            return TRUE;
        } else {
            return FALSE;
        }
        return;
    }

    /**
     * Del categories  by id
     * @param type $catId
     * @return boolean
     */
    public function deleteCategory($catId) {
        $parent_cat = getHierarchicalCategories($catId, 0);
        if (!empty($parent_cat)):
            foreach ($parent_cat as $key => $value):
                $id = $key;
                $this->db->where('id', $id);
                $this->db->delete($this->cat_table);
            endforeach;
            $this->db->where('id', $catId);
            $data = $this->db->delete($this->cat_table);
            return TRUE;
        else:
            $this->db->where('id', $catId);
            $data = $this->db->delete($this->cat_table);
            if ($data):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }

    /**
     * Upload the file to the server
     * @param type $insert_id
     * @param type $name
     * @return boolean
     */
    public function uploadFile($insert_id = '', $name = 'attachment') {
        if ($insert_id != '' && isset($_FILES)):
            if (file_exists($_FILES['attachment']['tmp_name']) || is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                $config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]) . "/uploads/category/";
                $config['allowed_types'] = '*';
                $config['max_size'] = '10000';
                $config['max_width'] = '10000';
                $config['max_height'] = '10000';
                $config['encrypt_name'] = FALSE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload($name)) {
                    $error = array('error' => $this->upload->display_errors());
                    return FALSE;
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    if (isset($data['upload_data'])):
                        $upload_data_array = array(
                            'cat_image_name' => $data['upload_data']['file_name'],
                            'cat_image_type' => $data['upload_data']['file_type'],
                            'cat_image_location' => 'uploads/category/' . $data['upload_data']['file_name'],
                        );
                        $this->db->where('id', $insert_id);
                        $return = $this->db->update($this->cat_table, $upload_data_array);
                    endif;
                    return TRUE;
                }
            }
        endif; // End check Insert
    }

    /**
     * Get the count of all the posts
     * @return type
     */
    public function getAllDataCount($feed_user_category = '') {
        $parent_cat = getHierarchicalCategories($feed_user_category, 0);
        $array = array();
        if (!empty($parent_cat)):
            foreach ($parent_cat as $key => $value):
                $array[$key] = $key;
            endforeach;
            $list_id = join(',', $array);
            $list_id = join(',', $array);
            $categoryIn = $list_id . ',' . $feed_user_category;
            $sql = "SELECT * FROM (`feeds`) WHERE `feed_user_category` IN ($list_id)";
            $query = $this->db->query($sql);
            return $query->num_rows();
        else:
            $this->db->select('*');
            $this->db->from($this->feed_table);
            $this->db->where('feed_user_category', $feed_user_category);
            $query = $this->db->get();
            return $query->num_rows();
        endif;
    }

    /**
     * Return feeds data by limit and offset
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function getAllData($limit, $offset, $feed_user_category) {
        $parent_cat = getHierarchicalCategories($feed_user_category, 0);
//        pri($parent_cat);
//        die();
        $array = array();
        if (!empty($parent_cat)):
            foreach ($parent_cat as $key => $value):
                $array[$key] = $key;
            endforeach;
            $list_id = join(',', $array);
            $categoryIn = $list_id . ',' . $feed_user_category;

            $sql = "SELECT * FROM (`feeds`) WHERE `feed_user_category` IN ($categoryIn) AND `feed_filter_type` != 'news' LIMIT $limit OFFSET $offset";
            $query = $this->db->query($sql);
            return $query->result();
        else:
            $this->db->select('*');
            $this->db->from($this->feed_table);
            $this->db->limit($limit, $offset);
            $this->db->where('feed_user_category', $feed_user_category);
            $this->db->where('feed_filter_type !=', 'news');
            $this->db->order_by('feed_date', 'desc');
            $query = $this->db->get();
            return $query->result();
        endif;
    }

}

?>
