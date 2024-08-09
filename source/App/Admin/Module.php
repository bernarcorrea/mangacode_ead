<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminModule;
    use Source\Models\Course;
    use Source\Models\Segment;
    use Source\Models\Classe;
    
    class Module
    {
        private $template;
        
        public function __construct()
        {
            $this->template = Engine::create(ADMIN, FILE_EXT);
            
            $session = new AdminDash();
            $validate = $session->checkSession();
            if (!$validate):
                header('Location:' . HOME . "/admin");
            endif;
        }
        
        public function index($data)
        {
            $idCourse = (isset($data['course']) ? $data['course'] : false);
            if (!$idCourse):
                header('Location:' . HOME . '/admin/courses');
            else:
                $course = (new Course())->findById($idCourse);
                if (!$course):
                    header('Location:' . HOME . '/admin/courses');
                else:
                    $segment = (new Segment())->findById($course->segment);
                    $course->segment_title = $segment->title;
                    
                    $mod = new \Source\Models\Module();
                    $modules = $mod->find("course = :c", "c={$course->id}")->order("ord ASC")->fetch(true);
                    $arrModules = [];
                    
                    if ($modules):
                        foreach ($modules as $m):
                            $classes = (new Classe())->find("module = :m AND course = :c", "m={$m->id}&c={$m->course}")->count();
                            $m->classes = $classes;
                            array_push($arrModules, $m);
                        endforeach;
                    endif;
                    
                    echo $this->template->render("system/modules/index", [
                        "course" => $course,
                        "modules" => $arrModules
                    ]);
                endif;
            endif;
        }
        
        public function create($data)
        {
            $idCourse = (isset($data['course']) ? $data['course'] : false);
            if (!$idCourse):
                header('Location:' . HOME . '/admin/courses');
            else:
                $course = (new Course())->findById($idCourse);
                if (!$course):
                    header('Location:' . HOME . '/admin/courses');
                else:
                    echo $this->template->render("system/modules/create", [
                        "course" => $course,
                    ]);
                endif;
            endif;
        }
        
        public function update($data)
        {
            $idCourse = (isset($data['course']) ? $data['course'] : false);
            if (!$idCourse):
                header('Location:' . HOME . '/admin/courses');
            else:
                $course = (new Course())->findById($idCourse);
                if (!$course):
                    header('Location:' . HOME . '/admin/courses');
                else:
                    $id = (isset($data['id']) ? $data['id'] : false);
                    if (!$id):
                        header('Location:' . HOME . "/admin/modules/{$course->id}");
                    else:
                        $module = (new \Source\Models\Module())->findById($id);
                        if (!$module):
                            header('Location:' . HOME . "/admin/modules/{$course->id}");
                        else:
                            echo $this->template->render("system/modules/update", [
                                "course" => $course,
                                "module" => $module,
                            ]);
                        endif;
                    endif;
                endif;
            endif;
        }
        
        public function manager($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $id = (isset($post['id']) ? $post['id'] : false);
            $adminModule = new AdminModule();
            
            if ($id):
                $adminModule->update($post, $id);
                if (!$adminModule->result()):
                    $json['error'] = $adminModule->error();
                else:
                    $json['accept'] = $adminModule->error();
                endif;
            else:
                $adminModule->create($post);
                if (!$adminModule->result()):
                    $json['error'] = $adminModule->error();
                else:
                    $json['accept'] = $adminModule->error();
                    $json['redirect'] = HOME . "/admin/modules/{$post['course']}";
                    $json['time'] = 2000;
                endif;
            endif;
            
            echo json_encode($json);
        }
    }