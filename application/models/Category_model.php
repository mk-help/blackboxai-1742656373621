<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
    protected $table = 'categories';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all categories
     */
    public function get_categories() {
        $this->db->select('categories.*, COUNT(DISTINCT courses.id) as total_courses');
        $this->db->from($this->table);
        $this->db->join('courses', 'courses.category_id = categories.id AND courses.status = "published"', 'left');
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.name', 'ASC');
        
        return $this->db->get()->result();
    }

    /**
     * Get category by ID
     */
    public function get_category($category_id) {
        return $this->db->get_where($this->table, ['id' => $category_id])->row();
    }

    /**
     * Get category by slug
     */
    public function get_category_by_slug($slug) {
        return $this->db->get_where($this->table, ['slug' => $slug])->row();
    }

    /**
     * Create new category
     */
    public function create_category($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        
        // Generate slug from name if not provided
        if (!isset($data['slug'])) {
            $data['slug'] = url_title($data['name'], '-', TRUE);
        }
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update category
     */
    public function update_category($category_id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        // Generate slug from name if name was updated and slug not provided
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = url_title($data['name'], '-', TRUE);
        }
        
        $this->db->where('id', $category_id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete category
     */
    public function delete_category($category_id) {
        $this->db->where('id', $category_id);
        return $this->db->delete($this->table);
    }

    /**
     * Check if category exists by slug
     */
    public function slug_exists($slug, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get_where($this->table, ['slug' => $slug])->num_rows() > 0;
    }

    /**
     * Get popular categories
     */
    public function get_popular_categories($limit = 5) {
        $this->db->select('categories.*, COUNT(DISTINCT courses.id) as total_courses');
        $this->db->from($this->table);
        $this->db->join('courses', 'courses.category_id = categories.id AND courses.status = "published"', 'left');
        $this->db->group_by('categories.id');
        $this->db->having('total_courses >', 0);
        $this->db->order_by('total_courses', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Get categories with course count
     */
    public function get_categories_with_stats($limit = null, $offset = null) {
        $this->db->select('
            categories.*,
            COUNT(DISTINCT courses.id) as total_courses,
            COUNT(DISTINCT CASE WHEN courses.status = "published" THEN courses.id END) as published_courses
        ');
        $this->db->from($this->table);
        $this->db->join('courses', 'courses.category_id = categories.id', 'left');
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.name', 'ASC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    /**
     * Search categories
     */
    public function search_categories($query, $limit = 10) {
        $this->db->select('categories.*, COUNT(DISTINCT courses.id) as total_courses');
        $this->db->from($this->table);
        $this->db->join('courses', 'courses.category_id = categories.id AND courses.status = "published"', 'left');
        $this->db->group_start();
        $this->db->like('categories.name', $query);
        $this->db->or_like('categories.description', $query);
        $this->db->group_end();
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.name', 'ASC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Get category tree (for nested categories if implemented)
     */
    public function get_category_tree() {
        $categories = $this->get_categories();
        $tree = [];
        
        foreach ($categories as $category) {
            if (!$category->parent_id) {
                $tree[$category->id] = $category;
                $tree[$category->id]->children = [];
            }
        }
        
        foreach ($categories as $category) {
            if ($category->parent_id && isset($tree[$category->parent_id])) {
                $tree[$category->parent_id]->children[] = $category;
            }
        }
        
        return array_values($tree);
    }

    /**
     * Get category breadcrumb
     */
    public function get_category_breadcrumb($category_id) {
        $breadcrumb = [];
        $category = $this->get_category($category_id);
        
        while ($category) {
            array_unshift($breadcrumb, $category);
            $category = $category->parent_id ? $this->get_category($category->parent_id) : null;
        }
        
        return $breadcrumb;
    }
}

/* End of file Category_model.php */
/* Location: ./application/models/Category_model.php */