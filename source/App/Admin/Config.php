<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminContact;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminSocial;
    use Source\Models\Contact;
    use Source\Models\Social;
    use Source\Models\User;
    
    class Config
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
            $users = (new User())->find("nivel = :n", "n=1")->order("created_at DESC")->fetch(true);
            $contact = (new Contact())->findById(1);
            $social = (new Social())->findById(1);
            
            echo $this->template->render("system/config/index", [
                /** Data Page */
                "users" => $users,
                "cont" => $contact,
                "social" => $social
            ]);
        }
    
        public function updateSocial($data)
        {
            sleep(1);
            $json = [];
            unset($data['callback']);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $id = (isset($post['id']) ? $post['id'] : '');
    
            if ($id):
                $adminSocial = new AdminSocial();
                $adminSocial->exeUpdate($post, $id);
                if (!$adminSocial->result()):
                    $json['error'] = $adminSocial->error()[0];
                else:
                    $json['accept'] = $adminSocial->error()[0];
                endif;
            else:
                $json['error'] = "Não foi possivel processar a operação";
            endif;
    
            echo json_encode($json);
        }
    
        public function updateContact($data)
        {
            sleep(1);
            $json = [];
            unset($data['callback']);
        
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
        
            $id = (isset($post['id']) ? $post['id'] : '');
        
            if ($id):
                $adminCont = new AdminContact();
                $adminCont->exeUpdate($post, $id);
                if (!$adminCont->result()):
                    $json['error'] = $adminCont->error()[0];
                else:
                    $json['accept'] = $adminCont->error()[0];
                endif;
            else:
                $json['error'] = "Não foi possivel processar a operação";
            endif;
        
            echo json_encode($json);
        }
    }