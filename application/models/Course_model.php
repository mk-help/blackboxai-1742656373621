<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {
    protected $table = 'courses';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get featured courses
     */
    public function get_featured_courses($limit = 5) {
        $this->db->select('courses.*, categories.name as category_name, users.name as instructor_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = courses.category_id');
        $this->db->join('users', 'users.id = courses.instructor_id');
        $this->db->where('courses.status', 'published');
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Get courses by category
     */
    public function get_courses_by_category($category_id, $limit = 10) {
        $this->db->select('courses.*, categories.name as category_name, users.name as instructor_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = courses.category_id');
        $this->db->join('users', 'users.id = courses.instructor_id');
        $this->db->where('courses.category_id', $category_id);
        $this->db->where('courses.status', 'published');
        $this->db->order_by('courses.created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Get continue watching courses
     */
    public function get_continue_watching($user_id, $limit = 10) {
        $this->db->select('courses.*, categories.name as category_name, users.name as instructor_name, progress.progress_time');
        $this->db->from('progress');
        $this->db->join('lessons', 'lessons.id = progress.lesson_id');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->join($this->table, 'courses.id = modules.course_id');
        $this->db->join('categories', 'categories.id = courses.category_id');
        $this->db->join('users', 'users.id = courses.instructor_id');
        $this->db->where('progress.user_id', $user_id);
        $this->db->where('progress.status', 'started');
        $this->db->where('courses.status', 'published');
        $this->db->order_by('progress.updated_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Get recommended courses based on user's interests
     */
    public function get_recommended_courses($user_id, $limit = 10) {
        // Get user's watched categories
        $this->db->select('DISTINCT(courses.category_id)');
        $this->db->from('progress');
        $this->db->join('lessons', 'lessons.id = progress.lesson_id');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->join($this->table, 'courses.id = modules.course_id');
        $this->db->where('progress.user_id', $user_id);
        
        $categories = $this->db->get()->result();
        $category_ids = array_column($categories, 'category_id');

        if (empty($category_ids)) {
            // If no watched categories, return random courses
            return $this->get_featured_courses($limit);
        }

        // Get courses from watched categories
        $this->db->select('courses.*, categories.name as category_name, users.name as instructor_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = courses.category_id');
        $this->db->join('users', 'users.id = courses.instructor_id');
        $this->db->where('courses.status', 'published');
        $this->db->where_in('courses.category_id', $category_ids);
        $this->db->order_by('RAND()');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Get recent courses
     */
    public function get_recent_courses($limit = 10) {
        $this->db->select('courses.*, categories.name as category_name, users.name as instructor_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = courses.category_id');
        $this->db->join('users', 'users.id = courses.instructor_id');
        $this->db->where('courses.status', 'published');
        $this->db->order_by('courses.created_at', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    /**
     * Search courses
     */
    public function search_courses($filters = [], $limit = 12, $offset = 0) {
        $this->db->select('courses.*, categories.name as category_name, users.name as instructor_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = courses.category_id');
        $this->db->join('users', 'users.id = courses.instructor_id');
        $this->db->where('courses.status', 'published');

        if (!empty($filters['query'])) {
            $this->db->group_start();
            $this->db->like('courses.title', $filters['query']);
            $this->db->or_like('courses.description', $filters['query']);
            $this->db->group_end();
        }

        if (!empty($filters['category'])) {
            $this->db->where('courses.category_id', $filters['category']);
        }

        if (!empty($filters['level'])) {
            $this->db->where('courses.level', $filters['level']);
        }

        $this->db->order_by('courses.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        return $this->db->get()->result();
    }

    /**
     * Count search results
     */
    public function count_search_results($filters = []) {
        $this->db->from($this->table);
        $this->db->where('status', 'published');

        if (!empty($filters['query'])) {
            $this->db->group_start();
            $this->db->like('title', $filters['query']);
            $this->db->or_like('description', $filters['query']);
            $this->db->group_end();
        }

        if (!empty($filters['category'])) {
            $this->db->where('category_id', $filters['category']);
        }

        if (!empty($filters['level'])) {
            $this->db->where('level', $filters['level']);
        }

        return $this->db->count_all_results();
    }

    /**
     * Get user's courses
     */
    public function get_user_courses($user_id, $limit = 12, $offset = 0) {
        $this->db->select('DISTINCT(courses.*), categories.name as category_name, users.name as instructor_name');
        $this->db->from('progress');
        $this->db->join('lessons', 'lessons.id = progress.lesson_id');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->join($this->table, 'courses.id = modules.course_id');
        $this->db->join('categories', 'categories.id = courses.category_id');
        $this->db->join('users', 'users.id = courses.instructor_id');
        $this->db->where('progress.user_id', $user_id);
        $this->db->where('courses.status', 'published');
        $this->db->order_by('progress.updated_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        return $this->db->get()->result();
    }

    /**
     * Count user's courses
     */
    public function count_user_courses($user_id) {
        $this->db->select('DISTINCT(courses.id)');
        $this->db->from('progress');
        $this->db->join('lessons', 'lessons.id = progress.lesson_id');
        $this->db->join('modules', 'modules.id = lessons.module_id');
        $this->db->join($this->table, 'courses.id = modules.course_id');
        $this->db->where('progress.user_id', $user_id);
        $this->db->where('courses.status', 'published');
        
        return $this->db->get()->num_rows();
    }

    /**
     * Get course details
     */
    public function get_course($course_id) {
        $this->db->select('courses.*, categories.name as category_name, users.name as instructor_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = courses.category_id');
        $this->db->join('users', 'users.id = courses.instructor_id');
        $this->db->where('courses.id', $course_id);
        
        return $this->db->get()->row();
    }

    /**
     * Get course modules
     */
    public function get_course_modules($course_id) {
        $this->db->select('modules.*, COUNT(lessons.id) as total_lessons');
        $this->db->from('modules');
        $this->db->join('lessons', 'lessons.module_id = modules.id', 'left');
        $this->db->where('modules.course_id', $course_id);
        $this->db->group_by('modules.id');
        $this->db->order_by('modules.order', 'ASC');
        
        return $this->db->get()->result();
    }
}

/* End of file Course_model.php */
/* Location: ./application/models/Course_model.php */