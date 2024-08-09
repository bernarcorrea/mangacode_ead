<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminCourse;
    use Source\Models\Admin\AdminDash;
    use Source\Models\CourseFolder;
    use Source\Models\Segment;
    use Source\Models\User;
    use Source\Support\Helper;
    
    class Course
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
            $arrCourses = [];
            $courses = (new \Source\Models\Course())->find()->order("title ASC")->fetch(true);
            if ($courses):
                foreach ($courses as $co):
                    $co->segment = (new Segment())->findById($co->segment);
                    $co->tutor = (new User())->findById($co->tutor);
                    array_push($arrCourses, $co);
                endforeach;
            endif;
            
            echo $this->template->render("system/courses/index", [
                "courses" => $arrCourses
            ]);
        }
        
        public function create()
        {
            $tutors = (new User())->find("nivel <= :nivel", "nivel=2")->order("name ASC")->fetch(true);
            $segments = (new Segment())->find()->order("title ASC")->fetch(true);
            
            echo $this->template->render("system/courses/create", [
                "tutors" => $tutors,
                "segments" => $segments
            ]);
        }
        
        public function update($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/courses');
            else:
                $course = (new \Source\Models\Course())->findById($id);
                $tutors = (new User())->find("id != :id AND nivel <= :nivel", "id={$course->tutor}&nivel=2")->order("name ASC")->fetch(true);
                $segments = (new Segment())->find("id != :id", "id={$course->segment}")->order("title ASC")->fetch(true);
                $courseFolder = (new CourseFolder())->find("course = :c", "c={$course->id}")->order("created_at DESC")->fetch(true);
                
                $tut = (new User())->findById($course->tutor);
                $seg = (new Segment())->findById($course->segment);
                $course->tutor_name = $tut->name;
                $course->segment_title = $seg->title;
                
                echo $this->template->render("system/courses/update", [
                    "course" => $course,
                    "tutors" => $tutors,
                    "segments" => $segments,
                    "courseFolder" => $courseFolder
                ]);
            endif;
            
            
        }
        
        public function manager($data)
        {
            $json = [];
            sleep(1);
            unset($data['callback']);
            
            $description = $data['description'];
            unset($data['description']);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $post['description'] = $description;
            $id = (isset($post['id']) ? $post['id'] : false);
            $adminCourse = new AdminCourse();
            
            if ($id):
                $adminCourse->update($post, $id);
                if (!$adminCourse->result()):
                    $json['error'] = $adminCourse->error();
                else:
                    $json['accept'] = $adminCourse->error();
                endif;
            else:
                $adminCourse->create($post);
                if (!$adminCourse->result()):
                    $json['error'] = $adminCourse->error();
                else:
                    $json['accept'] = $adminCourse->error();
                    $json['redirect'] = HOME . '/admin/courses';
                    $json['time'] = 2000;
                endif;
            endif;
            
            echo json_encode($json);
        }
        
        public function folderInsert($data)
        {
            $json = [];
            sleep(1);
            unset($data['callback']);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminCourse = new AdminCourse();
            $adminCourse->insertFile($post);
            if (!$adminCourse->result()):
                $json['error'] = $adminCourse->error();
            else:
                $json['accept'] = $adminCourse->error();
                $json['result'] = "
                    <article class=\"box box33\" id=\"{$adminCourse->result()->id}\">
                            <div class=\"box-full radius-p box-silver padding-total-low t-center\">
                                <span rel=\"{$adminCourse->result()->id}\" id=\"" . HOME . "/admin/courses/folder/delete\" class=\"j_delete delete btn btn-icon-low btn-red round\"><i class=\"icon-x\"></i></span>
                                <a href=\"" . HOME . "/{$adminCourse->result()->file}\" target=\"_blank\">
                                    <p class=\"f-silver mb-10\">
                                        <i class=\"icon-file-zip\" style=\"font-size: 25px;\"></i>
                                    </p>
                                    <h1 class=\"small-titulo f-black f-light\">" . Helper::lmWord($adminCourse->result()->title, 28) . "</h1>
                                </a>
                            </div>
                    </article>
                ";
            endif;
            
            echo json_encode($json);
        }
        
        public function folderDelete($data)
        {
            $json = [];
            sleep(1);
            unset($data['callback']);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminCourse = new AdminCourse();
            $adminCourse->deleteFile($post['id']);
            if (!$adminCourse->result()):
                $json['error'] = $adminCourse->error();
            else:
                $json['accept'] = $adminCourse->error();
            endif;
            
            echo json_encode($json);
        }
    }