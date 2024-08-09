<?php
    
    namespace Source\App\Campus;
    
    use Dompdf\Dompdf;
    use League\Plates\Engine;
    use Source\Models\ClassStatus;
    use Source\Models\Student;
    use Source\Models\Course;
    use Source\Models\Campus\AdminLogin;
    
    class Certificate
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
            $arrCert = [];
            $certificates = (new \Source\Models\Certificate())->find("student = :s", "s={$this->student->id}")->order("created_at DESC")->fetch(true);
            if ($certificates):
                foreach ($certificates as $cert):
                    $course = (new Course())->findById($cert->course);
                    $cert->course_certificate = $course;
                    array_push($arrCert, $cert);
                endforeach;
            endif;
            
            echo $this->template->render('system/certificates', [
                "certificates" => $arrCert,
                "student" => $this->student
            ]);
        }
        
        public function view($data)
        {
            $getHash = (!empty($data['hash']) ? $data['hash'] : false);
            if (!$getHash):
                header('Location:' . HOME . '/campus&error=notfound');
            else:
                $hash = base64_decode($getHash);
                parse_str($hash, $arr);
                if (!$arr['cert']):
                    header('Location:' . HOME . '/campus&error=notfound');
                else:
                    $certificate = (new \Source\Models\Certificate())->find("cod = :c", "c={$arr['certCode']}")->fetch();
                    if (!$certificate):
                        header('Location:' . HOME . '/campus&error=notfound');
                    else:
                        $student = (new Student())->findById($certificate->student);
                        if ($student->id != $this->student->id):
                            header('Location:' . HOME . '/campus&error=notpermission');
                        else:
                            $course = (new Course())->findById($certificate->course);
                            $start = (new ClassStatus())->find("course = :c AND student = :s", "c={$course->id}&s={$student->id}")->order("created_at ASC")->fetch();
                            $end = (new ClassStatus())->find("course = :c AND student = :s", "c={$course->id}&s={$student->id}")->order("created_at DESC")->fetch();
                            $certificate->start_view = $start->created_at;
                            $certificate->end_view = $end->created_at;
                            
                            ob_start();
                            echo $this->template->render('system/viewcertificate', [
                                "certificate" => $certificate,
                                "student" => $student,
                                "course" => $course,
                            ]);
                            
                            $dompdf = new Dompdf(["enable_remote" => true]);
                            $dompdf->loadHtml(ob_get_clean());
                            $dompdf->setPaper("A4", "landscape");
                            $dompdf->render();
                            $dompdf->stream("certificado-{$course->uri}.pdf");
                        endif;
                    endif;
                endif;
            endif;
        }
    }