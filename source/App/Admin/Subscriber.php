<?php
    
    namespace Source\App\Admin;
    
    use CoffeeCode\Paginator\Paginator;
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminSubscriber;
    use Source\Models\ClassStatus;
    use Source\Models\Invoice;
    use Source\Models\Student;
    use Source\Models\Course;
    use Source\Models\Classe;
    
    class Subscriber
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
            $arrSubscribers = [];
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
            $sub = new \Source\Models\Subscriber();
            /*
             * PAGINATOR
             */
            $paginator = new Paginator(HOME . '/admin/subscribers&page=', "Página", [
                "Primeira Página",
                "Primeira"
            ], [
                "Última Página",
                "Última"
            ]);
            $paginator->pager($sub->find()->count(), 80, $page, 2);
            $subscribers = $sub->find()->order("created_at DESC")->limit($paginator->limit())->offset($paginator->offset())->fetch(true);
            
            if ($subscribers):
                foreach ($subscribers as $s):
                    $student = (new Student())->findById($s->student);
                    $course = (new Course())->findById($s->course);
                    $s->course_title = $course->title;
                    $s->student_name = $student->name . ' ' . $student->lastname;
                    array_push($arrSubscribers, $s);
                endforeach;
            endif;
            
            echo $this->template->render("system/subscribers/index", [
                "subscribers" => $arrSubscribers,
                "paginator" => $paginator->render()
            ]);
        }
        
        public function view($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/tickets');
            else:
                $subscriber = (new \Source\Models\Subscriber())->findById($id);
                if (!$subscriber):
                    header('Location:' . HOME . '/admin/subscribers');
                else:
                    $student = (new Student())->findById($subscriber->student);
                    $course = (new Course())->findById($subscriber->course);
                    $invoices = (new Invoice())->find("course = :c AND student = :s", "c={$course->id}&s={$student->id}")->order("created_at ASC")->fetch(true);
                    /*
                     * STATUS CLASS
                     */
                    $arrStatusClass = [];
                    $statusClass = (new ClassStatus())->find("course = :c AND student = :s", "c={$course->id}&s={$student->id}")->order("updated_at DESC")->limit(5)->fetch(true);
                    if ($statusClass):
                        foreach ($statusClass as $st):
                            $class = (new Classe())->findById($st->class);
                            $st->class_title = $class->title;
                            array_push($arrStatusClass, $st);
                        endforeach;
                    endif;
                    
                    echo $this->template->render("system/subscribers/view", [
                        "subscriber" => $subscriber,
                        "course" => $course,
                        "student" => $student,
                        "invoices" => $invoices,
                        "statusClass" => $arrStatusClass
                    ]);
                endif;
            endif;
        }
        
        public function validate($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $id = ($post['id']);
            $adminSubscriber = new AdminSubscriber();
            
            $adminSubscriber->validate($post['end_date'], $id);
            if (!$adminSubscriber->result()):
                $json['error'] = $adminSubscriber->error();
            else:
                $json['accept'] = $adminSubscriber->error();
                $json['replace'] = "<i class=\"icon-arrow-down2\"></i> Expira em: <strong class=\"f-semibold j_replace\">{$post['end_date']}</strong>";
                $json['modal'] = true;
            endif;
            
            echo json_encode($json);
        }
    }