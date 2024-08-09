<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminUser;
    
    class User
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
            $users = (new \Source\Models\User())->find()->order("created_at DESC")->fetch(true);
            
            echo $this->template->render("system/users/index", [
                /** Data Page */
                "users" => $users
            ]);
        }
        
        public function create($data)
        {
            echo $this->template->render("system/users/create", [
                /** Data Page */
            ]);
        }
        
        public function update($data)
        {
            $users = new \Source\Models\User();
            $user = $users->findById($data['id']);
            
            echo $this->template->render("system/users/update", [
                /** Data Page */
                "user" => $user
            ]);
        }
        
        public function managerUser($data)
        {
            sleep(1);
            $json = [];
            unset($data['callback']);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $id = (isset($post['id']) ? $post['id'] : '');
            $adminUser = new AdminUser();
            
            if (!empty($id)):
                $adminUser->exeUpdate($post, $id);
                if (!$adminUser->result()):
                    $json['error'] = $adminUser->error()[0];
                else:
                    $json['accept'] = $adminUser->error()[0];
                endif;
            else:
                $adminUser->exeCreate($post);
                if (!$adminUser->result()):
                    $json['error'] = $adminUser->error()[0];
                else:
                    $json['accept'] = $adminUser->error()[0];
                    $json['redirect'] = HOME . "/admin/users";
                    $json['time'] = 2000;
                endif;
            endif;
            
            echo json_encode($json);
        }
        
        public function delete($data)
        {
            sleep(1);
            $json = [];
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $id = (isset($post['id']) ? $post['id'] : false);
            
            if ($id):
                $adminUser = new AdminUser();
                $adminUser->exeDelete($id);
                if (!$adminUser->result()):
                    $json['error'] = $adminUser->error()[0];
                else:
                    $json['accept'] = $adminUser->error()[0];
                    $json['redirect'] = HOME . "/admin/users";
                    $json['time'] = 2000;
                endif;
            else:
                $json['error'] = "Não foi possivel processar a operação";
            endif;
            
            echo json_encode($json);
        }
    }