<?php
    
    namespace Source\App\Admin;
    
    use CoffeeCode\Paginator\Paginator;
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminStudent;
    use Source\Models\ClassStatus;
    use Source\Models\Course;
    use Source\Models\Subscriber;
    use Source\Models\Classe;
    use Source\Models\Module;
    use Source\Models\Segment;
    use Source\Models\User;
    
    class Student
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
        
        public function index()
        {
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
            $stud = new \Source\Models\Student();
            /*
             * PAGINATOR
             */
            $paginator = new Paginator(HOME . '/admin/students&page=', "Página", [
                "Primeira Página",
                "Primeira"
            ], [
                "Última Página",
                "Última"
            ]);
            $paginator->pager($stud->find()->count(), 80, $page, 2);
            $students = $stud->find()->order("created_at DESC")->limit($paginator->limit())->offset($paginator->offset())->fetch(true);
            
            echo $this->template->render("system/students/index", [
                "students" => $students,
                "paginator" => $paginator->render()
            ]);
        }
        
        public function create()
        {
            echo $this->template->render("system/students/create");
        }
        
        public function update($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/students');
            else:
                $student = (new \Source\Models\Student())->findById($id);
                if (!$student):
                    header('Location:' . HOME . '/admin/students');
                else:
                    echo $this->template->render("system/students/update", [
                        "student" => $student
                    ]);
                endif;
            endif;
        }
        
        public function history($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/students');
            else:
                $student = (new \Source\Models\Student())->findById($id);
                if (!$student):
                    header('Location:' . HOME . '/admin/students');
                else:
                    $arrSubscribers = [];
                    $subscribers = (new Subscriber())->find("student = :s", "s={$student->id}")->order("created_at DESC")->fetch(true);
                    if ($subscribers):
                        foreach ($subscribers as $sub):
                            $course = (new Course())->findById($sub->course);
                            $segment = (new Segment())->findById($course->segment);
                            $tutor = (new User())->findById($course->tutor);
                        
                            $sub->course_title = $course->title;
                            $sub->course_cover = $course->cover;
                            $sub->segment_title = $segment->title;
                            $sub->tutor_name = $tutor->name;
                            array_push($arrSubscribers, $sub);
                        endforeach;
                    endif;
                    
                    echo $this->template->render("system/students/history", [
                        "student" => $student,
                        "subscribers" => $arrSubscribers
                    ]);
                endif;
            endif;
        }
        
        public function progress($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/students');
            else:
                /* BUSCA ALUNO */
                $student = (new \Source\Models\Student())->findById($id);
                if (!$student):
                    header('Location:' . HOME . '/admin/students');
                else:
                    $idCourse = (isset($data['course']) ? $data['course'] : false);
                    if (!$id):
                        header('Location:' . HOME . '/admin/students');
                    else:
                        /* BUSCA CURSO */
                        $course = (new Course())->findById($idCourse);
                        if (!$course):
                            header('Location:' . HOME . '/admin/students');
                        else:
                            /* BUSCA ASSINATURA */
                            $subscriber = (new Subscriber())->find("course = :c AND student = :s", "c={$course->id}&s={$student->id}")->fetch();
                            if (!$subscriber):
                                header('Location:' . HOME . '/admin/students/history/' . $student->id);
                            else:
                                /* BUSCA MODULOS E AULAS DO CURSO */
                                $arrModules = [];
                                $arrProgressClass = [];
                                
                                $modules = (new Module())->find("course = :c", "c={$course->id}")->order("ord ASC")->fetch(true);
                                if ($modules):
                                    foreach ($modules as $md):
                                        $classes = (new Classe())->find("course = :c AND module = :m", "c={$course->id}&m={$md->id}")->order("ord ASC")->fetch(true);
                                        if ($classes):
                                            foreach ($classes as $class):
                                                /* VERIFICA STATUS DA AULA */
                                                $statusClass = (new ClassStatus())->find("course = :c AND class = :cla AND student = :s", "c={$course->id}&cla={$class->id}&s={$student->id}")->fetch();
                                                if ($statusClass):
                                                    $class->status_class = $statusClass->status;
                                                    $class->date_open = date('d/m/Y H:i', strtotime($statusClass->created_at)) . 'h';
                                                    $class->date_updated = date('d/m/Y H:i', strtotime($statusClass->updated_at)) . 'h';
                                                else:
                                                    $class->status_class = 1;
                                                    $class->date_open = 'Não visualizada';
                                                    $class->date_updated = '-';
                                                endif;
                                                array_push($arrProgressClass, $class);
                                            endforeach;
                                            $md->classes = $classes;
                                            array_push($arrModules, $md);
                                        endif;
                                    endforeach;
                                endif;
                                
                                echo $this->template->render("system/students/progress", [
                                    "student" => $student,
                                    "course" => $course,
                                    "modules" => $arrModules,
                                    "subscriber" => $subscriber
                                ]);
                            endif;
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
            $adminStudent = new AdminStudent();
            
            if ($id):
                $adminStudent->update($post, $id);
                if (!$adminStudent->result()):
                    $json['error'] = $adminStudent->error();
                else:
                    $json['accept'] = $adminStudent->error();
                endif;
            else:
                $adminStudent->create($post);
                if (!$adminStudent->result()):
                    $json['error'] = $adminStudent->error();
                else:
                    $json['accept'] = $adminStudent->error();
                    $json['redirect'] = HOME . "/admin/students";
                    $json['time'] = 2000;
                endif;
            endif;
            
            echo json_encode($json);
        }
    }