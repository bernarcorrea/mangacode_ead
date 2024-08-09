<?php
    
    namespace Source\App\Campus;
    
    use CoffeeCode\Cropper\Cropper;
    use League\Plates\Engine;
    use Source\Models\Campus\AdminClass;
    use Source\Models\Campus\AdminDoubt;
    use Source\Models\Campus\AdminLogin;
    use Source\Models\ClassDoubt;
    use Source\Models\ClassDoubtReply;
    use Source\Models\ClassStatus;
    use Source\Models\CourseFolder;
    use Source\Models\Student;
    use Source\Models\Classe;
    use Source\Models\Course;
    use Source\Models\Module;
    use Source\Models\Subscriber;
    use Source\Models\User;
    use Source\Support\Helper;
    
    class ClassCourse
    {
        private $template;
        private $student;
        
        public function __construct()
        {
            $this->template = Engine::create(CAMPUS, FILE_EXT);
            $adminLogin = new AdminLogin();
            $adminLogin->check();
            if (!$adminLogin->result()):
                header('Location:' . HOME . '/campus&error=notpermission');
            endif;
            
            $this->student = (new Student())->findById($_SESSION['campusmanga']['id']);
        }
        
        public function class($data)
        {
            $classUri = $data['class'];
            $class = (new Classe())->find("uri = :uri", "uri={$classUri}")->fetch();
            /* BUSCA AULA */
            if (!$class):
                header('Location:' . HOME . '/campus&error=notfound');
            else:
                $prev = $class->ord - 1;
                $next = $class->ord + 1;
                
                $classes = (new Classe())->find("course = :c", "c={$class->course}")->order("ord ASC")->fetch(true);
                $course = (new Course())->findById($class->course);
                $module = (new Module())->findById($class->module);
                $prevClass = (new Classe())->find("ord = :o", "o={$prev}")->fetch();
                $nextClass = (new Classe())->find("ord = :o", "o={$next}")->fetch();
                $class->prevclass = ($prevClass ? $prevClass : false);
                $class->nextclass = ($nextClass ? $nextClass : false);
                
                /* VERIFICA SE O ALUNO TEM PERMISSÃO PARA ASSISTIR */
                $subscriber = (new Subscriber())->find("student = :s AND course = :c", "s={$this->student->id}&c={$class->course}")->fetch();
                if (!$subscriber):
                    header('Location:' . HOME . '/campus&error=notpermission');
                else:
                    /* VERIFICA SE A ASSINATURA ESTÁ ATIVA */
                    if ($subscriber->status != 1):
                        header('Location:' . HOME . '/campus&error=expiry');
                    else:
                        /* STATUS DA AULA */
                        $statusClass = (new ClassStatus())->find("student = :s AND class = :c", "s={$this->student->id}&c={$class->id}")->fetch();
                        if ($statusClass):
                            $class->statusclass = $statusClass;
                        endif;
                        
                        /* EXECUTA GERENCIAMENTO DA AULA */
                        $adminClass = new AdminClass();
                        $adminClass->managerClass($class->id, $this->student->id);
                        
                        /* BUSCA DÚVIDAS DA AULA */
                        $arrDoubt = [];
                        $classDoubt = (new ClassDoubt())->find("class = :c", "c={$class->id}")->order("created_at DESC")->fetch(true);
                        if ($classDoubt):
                            foreach ($classDoubt as $doub):
                                /* BUSCA ALUNO */
                                $student = (new Student())->findById($doub->student);
                                $doub->stud = $student;
                                /* BUSCA RESPOSTAS */
                                $classDoubtReply = (new ClassDoubtReply())->find("doubt = :d", "d={$doub->id}")->order("created_at ASC")->fetch(true);
                                if ($classDoubtReply):
                                    foreach ($classDoubtReply as $doubReply):
                                        if ($doubReply->author_type == 1):
                                            $doubReply->author_name = $student->name . ' ' . $student->lastname;
                                            $doubReply->author_cover = (!empty($student->cover) ? $student->cover : CAMPUS . '/images/user.jpg');
                                        else:
                                            $user = (new User())->findById($doubReply->author);
                                            $doubReply->author_name = $user->name;
                                            $doubReply->author_cover = CAMPUS . '/images/user.jpg';
                                        endif;
                                    endforeach;
                                    $doub->replys = $classDoubtReply;
                                endif;
                                array_push($arrDoubt, $doub);
                            endforeach;
                        endif;
                        
                        /* PASTA DO CURSO */
                        $courseFolder = (new CourseFolder())->find("course = :c", "c={$course->id}")->order("created_at DESC")->fetch(true);
                        
                        echo $this->template->render("system/class", [
                            "class" => $class,
                            "classes" => $classes,
                            "course" => $course,
                            "module" => $module,
                            "student" => $this->student,
                            "doubts" => $arrDoubt,
                            "courseFolder" => $courseFolder
                        ]);
                    endif;
                endif;
            endif;
        }
        
        public function autoCheck()
        {
            $json = [];
            $adminClass = new AdminClass();
            $adminClass->checkTask($this->student->id);
            
            if (!$adminClass->result()):
                $json['progress'] = $adminClass->progress();
            else:
                $json['stop'] = true;
                $json['replace'] = "<span class=\"btn btn-icon-larg bg-green radius-p j_tooltip\" title=\"Aula concluída!\"><i class=\"icon-check\"></i></span>";
                $json['progress'] = $adminClass->progress();
            endif;
            
            echo json_encode($json);
        }
        
        public function loadClass($data)
        {
            $json = [];
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $class = (new Classe())->find("uri = :uri", "uri={$post['uri']}")->fetch();
            if ($class):
                $json['classcod'] = "https://drive.google.com/uc?id=" . $class->video;
            endif;
            
            echo json_encode($json);
        }
        
        public function createDoubt($data)
        {
            sleep(1);
            $json = [];
            
            $desc = $data['description'];
            unset($data['description']);
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            $post['description'] = $desc;
            
            $adminDoubt = new AdminDoubt();
            $adminDoubt->create($post);
            
            if (!$adminDoubt->result()):
                $json['error'] = $adminDoubt->error();
            else:
                $c = new Cropper("cache");
                $student = (new Student())->findById($post['student']);
                $json['accept'] = $adminDoubt->error();
                if (isset($post['id'])):
                    $json['result2'] = '#reply' . $post['id'];
                    $json['reply'] = "
                        <article class=\"flex-container flex-itens-start\">
                            <div class=\"photo round\">
                                " . Helper::image($c->make((!empty($student->cover) ? $student->cover : CAMPUS . '/images/user.jpg'), 300, 300), $student->name . ' ' . $student->lastname, 'img round') . "
                            </div>
                            <header class=\"flex100\">
                                <h4 class=\"f-primary f-semibold mb-10\">{$student->name} {$student->lastname}</h4>
                                <div class=\"desc\">
                                    " . html_entity_decode($post['description']) . "
                                </div>
                                <p class=\"date f-light f-primary\">Em " . date('d/m/Y') . " às " . date('H:i') . "h</p>
                            </header>
                        </article>
                    ";
                else:
                    $json['result'] = "
                    <article class=\"flex-container flex-itens-start\">
                        <div class=\"photo round\">
                            " . Helper::image($c->make((!empty($student->cover) ? $student->cover : CAMPUS . '/images/user.jpg'), 300, 300), $student->name . ' ' . $student->lastname, 'img round') . "
                        </div>
                        <header class=\"flex100\">
                            <h4 class=\"f-primary f-semibold mb-10\">{$student->name} {$student->lastname}</h4>
                            <div class=\"desc\">
                                " . html_entity_decode($post['description']) . "
                            </div>
                            <div class=\"flex-container flex-itens-center\">
                                <p class=\"f-light f-primary date mr-20\">Em " . date('d/m/Y') . " às " . date('H:i') . "h</p>
                            </div>
                        </header>
                    </article>
                ";
                endif;
            endif;
            
            echo json_encode($json);
        }
        
        public function downloadFile($data)
        {
            $getData = (!empty($data['hash']) ? $data['hash'] : false);
            if (!$getData):
                header('Location:' . HOME . '/campus&error=notfound');
            else:
                $hash = base64_decode($getData);
                parse_str($hash, $arr);
                if (!$arr['down']):
                    header('Location:' . HOME . '/campus&error=notfound');
                else:
                    $id = base64_decode($arr['cfId']);
                    $file = (new CourseFolder())->findById($id);
                    if (!$file && !empty($file->file)):
                        header('Location:' . HOME . '/campus&error=notfound');
                    else:
                        header('Location:' . HOME . "/{$file->file}");
                    endif;
                endif;
            endif;
        }
    }