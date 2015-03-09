<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin/Project is the Controller that is executed by accessing "/Admin/Project".
 * 
 * @author Calvin Rempel
 */
class Project extends Application {

    /**
     * Controller for "Admin/Project" page.
     */
    public function index() {
        $this->data['mode'] = 'admin';
        $this->data['pagebody'] = 'admin/project';
        
        $this->data['entry'] = $this->projects->getPaginated(1,
                                                             PHP_INT_MAX,
                                                             '',
                                                             'title',
                                                             'asc');
        
        $this->render();
    }
    
    /**
     * Controller for creating a new Project
     */
    public function create() {
        $this->data['mode'] = 'admin';
        $this->data['pagebody'] = 'admin/project-edit';
        
        // Load dropzone
        $this->data['styles'][] = array('style'=>'/assets/css/dropzone.css');
        $this->data['scripts'][] = array('script'=>"/assets/js/dropzone.js");
        $this->data['scripts'][] = array('script'=>"/assets/js/dropzoneconfig.js");
        
        // Load MCE
        $this->data['scripts'][] = array('script'=>"//tinymce.cachefly.net/4.1/tinymce.min.js");
        $this->data['components'][] = array('component'=>$this->parser->parse('components/tinymce', array('selector'=>'.editor'), true));
        $this->render();
    }
    
    /**
     * Controller for editting an existing Project
     * 
     * @param int $id the id of the existing project
     */
    public function edit($id) {
        $this->data['mode'] = 'admin';
        $this->data['pagebody'] = 'admin/project-edit';
        $this->data['action'] == 'edit/' . $id;
        
        $project = $this->projects()->getById($id);
        $this->data['id'] = $project['id'];
        $this->data['title'] = $project['title'];
        $this->data['description'] = $project['description'];
        
        
        $this->presentForm();
        $this->submit();
        $this->render();
    }
    
    
    /**
     * Validate input data and create or edit a project.
     */
    public function submit()
    {
        if($this->input->post('Save', TRUE) != false)
        {
            $images = $this->input->post('image', true);
            
            $this->data['id'] = $this->input->post('id', true);
        }
        
    }
}
