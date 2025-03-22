<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->_require_login();
        
        $this->load->model([
            'course_model',
            'category_model',
            'subscription_model'
        ]);
    }

    /**
     * Course details page
     */
    public function detail($course_id) {
        // Check if user has active subscription
        if (!$this->subscription_model->is_subscription_active($this->user->id)) {
            $this->session->set_flashdata('error', 'Você precisa de uma assinatura ativa para acessar os cursos.');
            redirect('subscription/choose_plan');
        }

        // Get course details
        $course = $this->course_model->get_course($course_id);
        if (!$course) {
            show_404();
        }

        // Get course modules and lessons
        $modules = $this->course_model->get_course_modules($course_id);
        foreach ($modules as &$module) {
            $module->lessons = $this->course_model->get_module_lessons($module->id);
        }

        // Get user's progress
        $progress = $this->course_model->get_user_course_progress($this->user->id, $course_id);

        // Get related courses
        $related_courses = $this->course_model->get_related_courses($course_id, 4);

        $this->data['page_title'] = $course->title . ' - ' . $this->data['site_name'];
        $this->data['course'] = $course;
        $this->data['modules'] = $modules;
        $this->data['progress'] = $progress;
        $this->data['related_courses'] = $related_courses;
        
        $this->_render_page('course/detail');
    }

    /**
     * Watch course lesson
     */
    public function watch($course_id, $lesson_id = null) {
        // Check if user has active subscription
        if (!$this->subscription_model->is_subscription_active($this->user->id)) {
            $this->session->set_flashdata('error', 'Você precisa de uma assinatura ativa para assistir as aulas.');
            redirect('subscription/choose_plan');
        }

        // Get course details
        $course = $this->course_model->get_course($course_id);
        if (!$course) {
            show_404();
        }

        // Get course modules and lessons
        $modules = $this->course_model->get_course_modules($course_id);
        foreach ($modules as &$module) {
            $module->lessons = $this->course_model->get_module_lessons($module->id);
        }

        // If no lesson specified, get first or last watched lesson
        if (!$lesson_id) {
            $progress = $this->course_model->get_user_course_progress($this->user->id, $course_id);
            if ($progress && $progress->last_lesson_id) {
                $lesson_id = $progress->last_lesson_id;
            } else {
                // Get first lesson
                $lesson_id = $modules[0]->lessons[0]->id;
            }
        }

        // Get current lesson
        $current_lesson = $this->course_model->get_lesson($lesson_id);
        if (!$current_lesson) {
            show_404();
        }

        // Update progress
        $this->course_model->update_progress($this->user->id, $lesson_id);

        $this->data['page_title'] = $current_lesson->title . ' - ' . $course->title;
        $this->data['course'] = $course;
        $this->data['modules'] = $modules;
        $this->data['current_lesson'] = $current_lesson;
        
        $this->_render_page('course/watch');
    }

    /**
     * Mark lesson as complete
     */
    public function complete_lesson() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $lesson_id = $this->input->post('lesson_id');
        if (!$lesson_id) {
            $this->output->set_status_header(400)->set_output(json_encode([
                'status' => 'error',
                'message' => 'ID da aula não fornecido'
            ]));
            return;
        }

        try {
            $this->course_model->complete_lesson($this->user->id, $lesson_id);
            
            // Check if course is completed
            $lesson = $this->course_model->get_lesson($lesson_id);
            $progress = $this->course_model->get_user_course_progress($this->user->id, $lesson->course_id);
            
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => 'success',
                'message' => 'Aula marcada como concluída',
                'progress' => $progress->percentage,
                'completed' => $progress->percentage == 100
            ]));
        } catch (Exception $e) {
            $this->output->set_status_header(500)->set_output(json_encode([
                'status' => 'error',
                'message' => 'Erro ao marcar aula como concluída'
            ]));
        }
    }

    /**
     * Update lesson progress time
     */
    public function update_progress_time() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $lesson_id = $this->input->post('lesson_id');
        $time = $this->input->post('time');
        
        if (!$lesson_id || !isset($time)) {
            $this->output->set_status_header(400)->set_output(json_encode([
                'status' => 'error',
                'message' => 'Parâmetros inválidos'
            ]));
            return;
        }

        try {
            $this->course_model->update_progress_time($this->user->id, $lesson_id, $time);
            
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'status' => 'success',
                'message' => 'Progresso atualizado'
            ]));
        } catch (Exception $e) {
            $this->output->set_status_header(500)->set_output(json_encode([
                'status' => 'error',
                'message' => 'Erro ao atualizar progresso'
            ]));
        }
    }

    /**
     * Download course material
     */
    public function download_material($material_id) {
        // Check if user has active subscription
        if (!$this->subscription_model->is_subscription_active($this->user->id)) {
            $this->session->set_flashdata('error', 'Você precisa de uma assinatura ativa para baixar materiais.');
            redirect('subscription/choose_plan');
        }

        $material = $this->course_model->get_material($material_id);
        if (!$material) {
            show_404();
        }

        // Log download
        $this->course_model->log_material_download($this->user->id, $material_id);

        // Force download
        $this->load->helper('download');
        force_download($material->filename, file_get_contents($material->filepath));
    }

    /**
     * Search courses
     */
    public function search() {
        $query = $this->input->get('q');
        $category = $this->input->get('category');
        $level = $this->input->get('level');
        $page = $this->input->get('page', 1);
        
        $per_page = 12;
        $offset = ($page - 1) * $per_page;
        
        $filters = array_filter([
            'query' => $query,
            'category' => $category,
            'level' => $level
        ]);

        $courses = $this->course_model->search_courses($filters, $per_page, $offset);
        $total_courses = $this->course_model->count_search_results($filters);
        
        $this->data['page_title'] = 'Buscar Cursos - ' . $this->data['site_name'];
        $this->data['courses'] = $courses;
        $this->data['total_courses'] = $total_courses;
        $this->data['current_page'] = $page;
        $this->data['total_pages'] = ceil($total_courses / $per_page);
        $this->data['search_query'] = $query;
        $this->data['selected_category'] = $category;
        $this->data['selected_level'] = $level;
        $this->data['categories'] = $this->category_model->get_categories();
        
        $this->_render_page('course/search');
    }
}

/* End of file Course.php */
/* Location: ./application/controllers/Course.php */