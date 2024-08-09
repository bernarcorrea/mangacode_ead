<?php
    
    namespace Source\App\Campus;
    
    use League\Plates\Engine;
    use Source\Models\Student;
    use Source\Models\Course;
    use Source\Models\Campus\AdminLogin;
    
    class Invoice
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
        
        public function index()
        {
            $arrInvoices = [];
            $invoices = (new \Source\Models\Invoice())->find("student = :s", "s={$this->student->id}")->order("created_at DESC")->fetch(true);
            if ($invoices):
                foreach ($invoices as $inv):
                    $course = (new Course())->findById($inv->course);
                    $inv->course_invoice = $course;
                    array_push($arrInvoices, $inv);
                endforeach;
            endif;
            
            echo $this->template->render('system/invoices', [
                "invoices" => $arrInvoices,
                "student" => $this->student
            ]);
        }
        
        public function invoice($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/campus&error=notfound');
            else:
                $hash = base64_decode($id);
                parse_str($hash, $arr);
                if ($arr['inv']):
                    $invoice = (new \Source\Models\Invoice())->findById($arr['invId']);
                    if (!$invoice):
                        header('Location:' . HOME . '/campus&error=notfound');
                    else:
                        if ($invoice->student != $this->student->id):
                            header('Location:' . HOME . '/campus&error=notpermission');
                        else:
                            $course = (new Course())->findById($invoice->course);
                            echo $this->template->render('system/invoice', [
                                "invoice" => $invoice,
                                "course" => $course
                            ]);
                        endif;
                    endif;
                endif;
            endif;
        }
    }