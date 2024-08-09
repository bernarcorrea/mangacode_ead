<?php
    
    namespace Source\App\Campus;
    
    use League\Plates\Engine;
    use Source\Models\Campus\AdminAccount;
    use Source\Models\Campus\AdminLogin;
    use Source\Models\Student;
    
    class Account
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
            $this->student->birthday = (empty($this->student->birthday) || $this->student->birthday == '0000-00-00' ? null : date('d/m/Y', strtotime($this->student->birthday)));
            
            echo $this->template->render('system/account', [
                "student" => $this->student
            ]);
        }
        
        public function password()
        {
            echo $this->template->render('system/password');
        }
        
        public function manager($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminAccount = new AdminAccount();
            
            if ($post['type'] == 1):
                $adminAccount->personal($post);
                if (!$adminAccount->result()):
                    $json['error'] = $adminAccount->error();
                else:
                    $json['accept'] = $adminAccount->error();
                endif;
            elseif ($post['type'] == 2):
                $adminAccount->address($post);
                if (!$adminAccount->result()):
                    $json['error'] = $adminAccount->error();
                else:
                    $json['accept'] = $adminAccount->error();
                endif;
            elseif ($post['type'] == 3):
                $adminAccount->social($post);
                if (!$adminAccount->result()):
                    $json['error'] = $adminAccount->error();
                else:
                    $json['accept'] = $adminAccount->error();
                endif;
            elseif ($post['type'] == 4):
                $adminAccount->password($post);
                if (!$adminAccount->result()):
                    $json['error'] = $adminAccount->error();
                else:
                    $json['accept'] = $adminAccount->error();
                    $json['clear'] = true;
                endif;
            elseif ($post['type'] == 5):
                $adminAccount->cover($post);
                if (!$adminAccount->result()):
                    $json['error'] = $adminAccount->error();
                else:
                    $json['accept'] = $adminAccount->error();
                    $json['img'] = $adminAccount->result();
                endif;
            endif;
            
            echo json_encode($json);
        }
    
    }