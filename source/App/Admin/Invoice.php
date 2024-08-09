<?php
    
    namespace Source\App\Admin;
    
    use CoffeeCode\Paginator\Paginator;
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminInvoice;
    use Source\Models\Course;
    use Source\Models\Student;
    use Source\Models\Segment;
    use Source\Models\User;
    
    class Invoice
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
            $arrInvoices = [];
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
            $inv = new \Source\Models\Invoice();
            /*
             * PAGINATOR
             */
            $paginator = new Paginator(HOME . '/admin/invoices&page=', "Página", [
                "Primeira Página",
                "Primeira"
            ], [
                "Última Página",
                "Última"
            ]);
            $paginator->pager($inv->find()->count(), 80, $page, 2);
            $invoices = $inv->find()->order("created_at DESC")->limit($paginator->limit())->offset($paginator->offset())->fetch(true);
            
            if ($invoices):
                foreach ($invoices as $inv):
                    $student = (new Student())->findById($inv->student);
                    $course = (new Course())->findById($inv->course);
                    $inv->course_title = $course->title;
                    $inv->student_name = $student->name . ' ' . $student->lastname;
                    array_push($arrInvoices, $inv);
                endforeach;
            endif;
            
            echo $this->template->render("system/invoices/index", [
                "invoices" => $arrInvoices,
                "paginator" => $paginator->render()
            ]);
        }
        
        public function view($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/invoices');
            else:
                $invoice = (new \Source\Models\Invoice())->findById($id);
                if (!$invoice):
                    header('Location:' . HOME . '/admin/invoices');
                else:
                    $student = (new Student())->findById($invoice->student);
                    $course = (new Course())->findById($invoice->course);
                    $segment = (new Segment())->findById($course->segment);
                    $tutor = (new User())->findById($course->tutor);
                    
                    echo $this->template->render("system/invoices/view", [
                        "invoice" => $invoice,
                        "course" => $course,
                        "student" => $student,
                        "segment" => $segment,
                        "tutor" => $tutor,
                    ]);
                endif;
            endif;
        }
        
        public function status($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminInvoice = new AdminInvoice();
            $adminInvoice->status($post, $post['id']);
            
            if (!$adminInvoice->result()):
                $json['error'] = $adminInvoice->error();
            else:
                $json['accept'] = $adminInvoice->error();
                $json['replace'] = "<span class=\"j_replace\">" . getStatusPayment($post['status_pay']) . "</span>";
                $json['modal'] = true;
            endif;
            
            echo json_encode($json);
        }
    }