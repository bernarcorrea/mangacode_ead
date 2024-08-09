<?php
    
    namespace Source\App\Admin;

    use League\Plates\Engine;
    use Source\Models\Admin\AdminClass;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Module;
    use Source\Models\Course;
    use Source\Models\Segment;
    
    class Classe
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
            $idModule = (isset($data['module']) ? $data['module'] : false);
            if (!$idModule):
                header('Location:' . HOME . '/admin/courses');
            else:
                $module = (new Module())->findById($idModule);
                if (!$module):
                    header('Location:' . HOME . '/admin/courses');
                else:
                    $course = (new Course())->findById($module->course);
                    $segment = (new Segment())->findById($course->segment);
                    $course->segment_title = $segment->title;
                    $classes = (new \Source\Models\Classe())->find("course = :c AND module = :m", "c={$course->id}&m={$module->id}")->fetch(true);
            
                    echo $this->template->render("system/classes/index", [
                        "course" => $course,
                        "module" => $module,
                        "classes" => $classes
                    ]);
                endif;
            endif;
        }
    
        public function create($data)
        {
            $idModule = (isset($data['module']) ? $data['module'] : false);
            if (!$idModule):
                header('Location:' . HOME . '/admin/courses');
            else:
                $module = (new Module())->findById($idModule);
                if (!$module):
                    header('Location:' . HOME . '/admin/courses');
                else:
                    $course = (new Course())->findById($module->course);
                    echo $this->template->render("system/classes/create", [
                        "module" => $module,
                        "course" => $course
                    ]);
                endif;
            endif;
        }
    
        public function update($data)
        {
            $idModule = (isset($data['module']) ? $data['module'] : false);
            if (!$idModule):
                header('Location:' . HOME . '/admin/courses');
            else:
                $module = (new Module())->findById($idModule);
                if (!$module):
                    header('Location:' . HOME . '/admin/courses');
                else:
                    $course = (new Course())->findById($module->course);
                    $id = (isset($data['id']) ? $data['id'] : false);
                    if (!$id):
                        header('Location:' . HOME . "/admin/classes/{$module->id}");
                    else:
                        $class = (new \Source\Models\Classe())->findById($id);
                        if (!$class):
                            header('Location:' . HOME . "/admin/classes/{$module->id}");
                        else:
                            echo $this->template->render("system/classes/update", [
                                "course" => $course,
                                "module" => $module,
                                "class" => $class
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
            $adminClass = new AdminClass();
    
            if ($id):
                $adminClass->update($post, $id);
                if (!$adminClass->result()):
                    $json['error'] = $adminClass->error();
                else:
                    $json['accept'] = $adminClass->error();
                endif;
            else:
                $adminClass->create($post);
                if (!$adminClass->result()):
                    $json['error'] = $adminClass->error();
                else:
                    $json['accept'] = $adminClass->error();
                    $json['redirect'] = HOME . "/admin/classes/{$post['module']}";
                    $json['time'] = 2000;
                endif;
            endif;
            
            echo json_encode($json);
        }
    }