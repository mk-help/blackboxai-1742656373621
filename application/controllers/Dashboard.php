<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
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
     * Dashboard index page
     */
    public function index() {
        // Check if user has active subscription
        $subscription = $this->subscription_model->get_active_subscription($this->user->id);
        if (!$subscription) {
            redirect('subscription/choose_plan');
        }

        // Get featured courses
        $featured_courses = $this->course_model->get_featured_courses();

        // Get courses by categories
        $categories = $this->category_model->get_categories();
        $courses_by_category = [];
        
        foreach ($categories as $category) {
            $courses = $this->course_model->get_courses_by_category($category->id, 10);
            if (!empty($courses)) {
                $courses_by_category[] = [
                    'category' => $category,
                    'courses' => $courses
                ];
            }
        }

        // Get continue watching courses
        $continue_watching = $this->course_model->get_continue_watching($this->user->id);

        // Get recommended courses based on user's interests
        $recommended_courses = $this->course_model->get_recommended_courses($this->user->id);

        // Get recently added courses
        $new_courses = $this->course_model->get_recent_courses();

        $this->data['page_title'] = 'Início - ' . $this->data['site_name'];
        $this->data['featured_courses'] = $featured_courses;
        $this->data['courses_by_category'] = $courses_by_category;
        $this->data['continue_watching'] = $continue_watching;
        $this->data['recommended_courses'] = $recommended_courses;
        $this->data['new_courses'] = $new_courses;
        
        $this->_render_page('dashboard/index');
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
        
        $this->_render_page('dashboard/search');
    }

    /**
     * My courses page
     */
    public function my_courses() {
        $page = $this->input->get('page', 1);
        $per_page = 12;
        $offset = ($page - 1) * $per_page;

        $courses = $this->course_model->get_user_courses($this->user->id, $per_page, $offset);
        $total_courses = $this->course_model->count_user_courses($this->user->id);

        $this->data['page_title'] = 'Meus Cursos - ' . $this->data['site_name'];
        $this->data['courses'] = $courses;
        $this->data['total_courses'] = $total_courses;
        $this->data['current_page'] = $page;
        $this->data['total_pages'] = ceil($total_courses / $per_page);

        $this->_render_page('dashboard/my_courses');
    }

    /**
     * My profile page
     */
    public function profile() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nome', 'required|trim');
            $this->form_validation->set_rules('current_password', 'Senha Atual', 'required_with[new_password]');
            $this->form_validation->set_rules('new_password', 'Nova Senha', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmar Nova Senha', 'matches[new_password]');

            if ($this->form_validation->run()) {
                $data = ['name' => $this->input->post('name')];

                // Check if password change was requested
                if ($this->input->post('new_password')) {
                    if (!$this->user_model->verify_password($this->user->id, $this->input->post('current_password'))) {
                        $this->session->set_flashdata('error', 'Senha atual incorreta.');
                        redirect('dashboard/profile');
                    }
                    $data['password'] = $this->input->post('new_password');
                }

                if ($this->user_model->update_user($this->user->id, $data)) {
                    $this->session->set_flashdata('success', 'Perfil atualizado com sucesso!');
                    redirect('dashboard/profile');
                } else {
                    $this->session->set_flashdata('error', 'Erro ao atualizar perfil. Tente novamente.');
                }
            }
        }

        $this->data['page_title'] = 'Meu Perfil - ' . $this->data['site_name'];
        $this->_render_page('dashboard/profile');
    }

    /**
     * Update notification preferences
     */
    public function notifications() {
        if ($this->input->post()) {
            $preferences = [
                'email_new_courses' => $this->input->post('email_new_courses') ? 1 : 0,
                'email_course_updates' => $this->input->post('email_course_updates') ? 1 : 0,
                'email_promotions' => $this->input->post('email_promotions') ? 1 : 0
            ];

            if ($this->user_model->update_notification_preferences($this->user->id, $preferences)) {
                $this->session->set_flashdata('success', 'Preferências de notificação atualizadas com sucesso!');
            } else {
                $this->session->set_flashdata('error', 'Erro ao atualizar preferências. Tente novamente.');
            }
            redirect('dashboard/notifications');
        }

        $this->data['page_title'] = 'Notificações - ' . $this->data['site_name'];
        $this->data['preferences'] = $this->user_model->get_notification_preferences($this->user->id);
        $this->_render_page('dashboard/notifications');
    }
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */