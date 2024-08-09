<?php
    
    namespace Source\App\Campus;
    
    use League\Plates\Engine;
    use Source\Models\Campus\AdminLogin;
    use Source\Models\Campus\AdminRegister;
    use Source\Models\Classe;
    use Source\Models\Student;
    use Source\Models\Invoice;
    use Source\Models\Certificate;
    use Source\Models\Course;
    use Source\Models\Subscriber;
    use Source\Support\Email;

    class Dash
    {
        private $template;
        
        public function __construct()
        {
//            $email = new Email();
//            $email->add(
//                "Teste de assunto",
//                "Olá, mundo! Este é meu primeiro e-mail utilizando sendgrid",
//                "Bernardo Corrêa",
//                "bernarcorrea@gmail.com"
//                )->send();
            
            $this->template = Engine::create(CAMPUS, FILE_EXT);
        }
        
        public function dash()
        {
            $adminLogin = new AdminLogin();
            $adminLogin->check();
            
            if (!$adminLogin->result()):
                echo $this->template->render('login');
            else:
                /* COURSES */
                $courses = (new Course())->find("status = :s", "s=1")->order("created_at DESC")->fetch(true);
                /* STUDENT */
                $student = (new Student())->findById($_SESSION['campusmanga']['id']);
                /* LAST CLASSES */
                $classes = (new Classe())->find()->order("created_at DESC")->limit(8)->fetch(true);
                
                /* INVOICES */
                $arrInvoices = [];
                $invoices = (new Invoice())->find("student = :s", "s={$student->id}")->order("created_at DESC")->limit(5)->fetch(true);
                if ($invoices):
                    foreach ($invoices as $inv):
                        $course = (new Course())->findById($inv->course);
                        $inv->course_title = $course->title;
                        $inv->course_cover = $course->cover;
                        array_push($arrInvoices, $inv);
                    endforeach;
                endif;
                
                /* CERTIFICATES */
                $arrCert = [];
                $certificates = (new Certificate())->find("student = :s", "s={$student->id}")->order("created_at DESC")->limit(4)->fetch(true);
                if ($certificates):
                    foreach ($certificates as $cert):
                        $course = (new Course())->findById($cert->course);
                        $cert->course = $course;
                        array_push($arrCert, $cert);
                    endforeach;
                endif;
                
                /* SUBSCRIBERS */
                $arrSubs = [];
                $subscribers = (new Subscriber())->find("student = :s", "s={$student->id}")->order("updated_at DESC")->fetch();
                if ($subscribers):
                    /* INSERE ARRAY DO CURSO DA ASSINATURA */
                    $course = (new Course())->findById($subscribers->course);
                    $subscribers->lastcourse = $course;
                    
                    /* EXIBE A ÚLTIMA AULA CASO EXISTA */
                    $class = (new Classe())->find("course = :c", "c={$subscribers->course}")->fetch();
                    if ($class):
                        if (!empty($subscribers->last_class)):
                            $lastClass = (new Classe())->findById($subscribers->last_class);
                            if ($lastClass):
                                $subscribers->lastclass = $lastClass;
                            endif;
                        endif;
                    endif;
                    array_push($arrSubs, $subscribers);
                endif;
    
                $student->birthday = (empty($student->birthday) || $student->birthday == '0000-00-00' ? '----' : date('d/m/Y', strtotime($student->birthday)));
                
                echo $this->template->render('dashboard', [
                    "student" => $student,
                    "classes" => $classes,
                    "invoices" => $arrInvoices,
                    "courses" => $courses,
                    "certificates" => $certificates,
                    "subscribers" => $arrSubs,
                ]);
            endif;
        }
        
        public function theme()
        {
            $json = [];
            
            if (!isset($_SESSION['theme_user'])):
                $_SESSION['theme_user'] = "dark";
                $json['theme'] = 'dark';
            else:
                if ($_SESSION['theme_user'] == "dark"):
                    $_SESSION['theme_user'] = "light-mode";
                    $json['theme'] = 'light';
                else:
                    $_SESSION['theme_user'] = "dark";
                    $json['theme'] = 'dark';
                endif;
            endif;
            
            echo json_encode($json);
        }
        
        public function register()
        {
            if (isset($_SESSION['student_register'])):
                unset($_SESSION['student_register']);
            endif;
            
            echo $this->template->render('register');
        }
        
        public function forgotPassword()
        {
            echo $this->template->render('forgotpassword');
        }
        
        public function updatePassword($data)
        {
            $getHash = (!empty($data['hash']) ? $data['hash'] : false);
            if (!$getHash):
                header('Location:' . HOME . '/campus&error=notfound');
            else:
                $hash = base64_decode($getHash);
                parse_str($hash, $arr);
                if (!$arr['forgot']):
                    header('Location:' . HOME . '/campus&error=notfound');
                else:
                    $student = (new Student())->findById($arr['student']);
                    if (!$student):
                        header('Location:' . HOME . '/campus&error=notfound');
                    else:
                        echo $this->template->render('updatepassword', [
                            "student" => $student
                        ]);
                    endif;
                endif;
            endif;
        }
        
        public function executeRegister($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminRegister = new AdminRegister();
            
            if ($post['step'] == 1):
                $adminRegister->personal($post);
                if (!$adminRegister->result()):
                    $json['error'] = $adminRegister->error();
                else:
                    $json['accept'] = $adminRegister->error();
                    $json['prev'] = '#step1';
                    $json['next'] = '#step2';
                endif;
            elseif ($post['step'] == 2):
                $adminRegister->address($post);
                if (!$adminRegister->result()):
                    $json['error'] = $adminRegister->error();
                else:
                    $json['accept'] = $adminRegister->error();
                    $json['prev'] = '#step2';
                    $json['next'] = '#step3';
                endif;
            elseif ($post['step'] == 3):
                $adminRegister->access($post);
                if (!$adminRegister->result()):
                    $json['error'] = $adminRegister->error();
                else:
                    $json['accept'] = $adminRegister->error();
                    $json['redirect'] = HOME . '/campus';
                    $json['time'] = 3000;
                endif;
            endif;
            
            echo json_encode($json);
        }
        
        public function executeLogin($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminLogin = new AdminLogin();
            $adminLogin->login($post);
            
            if (!$adminLogin->result()):
                $json['error'] = $adminLogin->error();
            else:
                $json['accept'] = $adminLogin->error();
                $json['redirect'] = HOME . '/campus';
                $json['time'] = 2000;
            endif;
            
            echo json_encode($json);
        }
        
        public function executeLogout()
        {
            $json = [];
            sleep(1);
            
            $adminLogin = new AdminLogin();
            $adminLogin->logout();
            
            if (!$adminLogin->result()):
                $json['error'] = $adminLogin->error();
            else:
                $json['accept'] = $adminLogin->error();
                $json['redirect'] = HOME . '/campus';
                $json['time'] = 2000;
            endif;
            
            echo json_encode($json);
        }
        
        public function executeForgout($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminLogin = new AdminLogin();
            $adminLogin->forgot($post);
            
            if (!$adminLogin->result()):
                $json['error'] = $adminLogin->error();
            else:
                $json['accept'] = $adminLogin->error();
            endif;
            
            echo json_encode($json);
        }
        
        public function executeUpdatePassword($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminLogin = new AdminLogin();
            $adminLogin->updatePassword($post);
            
            if (!$adminLogin->result()):
                $json['error'] = $adminLogin->error();
            else:
                $json['accept'] = $adminLogin->error();
                $json['redirect'] = HOME . '/campus';
                $json['time'] = 2000;
            endif;
            
            echo json_encode($json);
        }
    }