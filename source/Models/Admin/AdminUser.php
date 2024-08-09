<?php
    
    namespace Source\Models\Admin;
    
    use Source\Models\User;
    use Source\Support\Hash;
    use Source\Support\Helper;
    
    class AdminUser
    {
        private $data;
        private $user;
        private $result;
        private $error;
        private $id;
        
        public function exeCreate(array $data)
        {
            $this->data = $data;
            
            if (in_array('', $this->data)):
                $this->error = [
                    "<b>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar um usuário!",
                    INFO
                ];
                $this->result = false;
            else:
                $this->user = new User();
                $this->checkEmail();
                if ($this->result):
                    $this->password();
                    $this->create();
                endif;
            endif;
        }
        
        public function exeUpdate(array $data, int $id)
        {
            $this->data = $data;
            $this->id = $id;
            $password = $this->data['password'];
            unset($this->data['password']);
            
            if (in_array('', $this->data)):
                $this->error = [
                    "<b>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar um usuário!",
                    INFO
                ];
                $this->result = false;
            elseif (!Helper::email($this->data['email'])):
                $this->error = [
                    "<b>Erro ao cadastrar:</b> Você precisa preencher um e-mail com formato válido!",
                    INFO
                ];
            else:
                $this->data['password'] = $password;
                $this->user = (new User())->findById($this->id);
                $this->checkEmail();
                if (!$this->result):
                    $this->error = [
                        "<b>Erro ao cadastrar:</b> O e-mail que você informou já está cadastrado no sistema.",
                        INFO
                    ];
                else:
                    $this->password();
                    $this->update();
                endif;
            endif;
        }
        
        public function exeDelete(int $id)
        {
            $this->id = $id;
            $this->checkUser();
            
            if ($this->result):
                $this->user = (new User())->findById($this->id);
                $delete = $this->user->destroy();
                
                if (!$delete):
                    $this->result = false;
                    $this->error = [
                        "<b>Erro ao excluir:</b> O Usuário não pôde ser excluído do sistema!",
                        ERROR
                    ];
                else:
                    $this->result = true;
                    $this->error = [
                        "<b>Tudo certo:</b> O Usuário foi excluído com sucesso do sistema!",
                        ACCEPT
                    ];
                endif;
            endif;
        }
        
        public function result()
        {
            return $this->result;
        }
        
        public function error()
        {
            return $this->error;
        }
        
        private function checkEmail()
        {
            $where = (isset($this->id) ? "id != {$this->id} AND" : null);
            $user = (new User())->find("{$where} email = :email", "email={$this->data['email']}")->fetch(true);
            
            if (!Helper::email($this->data['email'])):
                $this->error = [
                    "<b>Erro ao cadastrar:</b> Você precisa preencher um e-mail com formato válido!",
                    INFO
                ];
                $this->result = false;
            elseif ($user):
                $this->error = [
                    "<b>Erro ao cadastrar:</b> Já existe um usuário cadastrado com este e-mail! Tente novamente.",
                    INFO
                ];
                $this->result = false;
            else:
                $this->result = true;
            endif;
        }
        
        public function checkUser()
        {
            $user = (new User())->findById($this->id);
            
            if (!$user):
                $this->result = false;
                $this->error = [
                    "<b>Erro ao excluir:</b> O Usuário não pôde ser encontrado no sistema!",
                    ERROR
                ];
            else:
                if ($this->id == $_SESSION['acesso']['id']):
                    $this->result = false;
                    $this->error = [
                        "<b>Erro ao excluir:</b> Você não pode excluir o seu próprio usuário!",
                        ERROR
                    ];
                else:
                    $this->result = true;
                endif;
            endif;
        }
        
        private function password()
        {
            if (!isset($this->id)):
                $this->data['password'] = Hash::hash($this->data['password']);
            else:
                $user = (new User())->findById($this->id);
                if (empty($this->data['password'])):
                    $this->data['password'] = $user->password;
                else:
                    $this->data['password'] = Hash::hash($this->data['password']);
                endif;
            endif;
        }
        
        private function create()
        {
            $this->user->name = $this->data['name'];
            $this->user->email = $this->data['email'];
            $this->user->password = $this->data['password'];
            $this->user->nivel = $this->data['nivel'];
            $create = $this->user->save();
            
            if (!$create):
                $this->error = [
                    "<b>Erro ao cadastrar:</b> Não foi possível cadastrar o usuário no sistema!",
                    ERROR
                ];
                $this->result = false;
            else:
                $this->error = [
                    "<b>Tudo certo:</b> O usuário foi cadastrado com sucesso no sistema!",
                    ACCEPT
                ];
                $this->result = $this->user->data()->id;
            endif;
        }
        
        private function update()
        {
            $this->user->name = $this->data['name'];
            $this->user->email = $this->data['email'];
            $this->user->password = $this->data['password'];
            $this->user->nivel = $this->data['nivel'];
            $update = $this->user->save();
            
            if (!$update):
                $this->error = [
                    "<b>Erro ao atualizar:</b> Não foi possível atualizar o usuário no sistema!",
                    ERROR
                ];
                $this->result = false;
            else:
                $this->error = [
                    "<b>Tudo certo:</b> O usuário foi atualizado com sucesso no sistema!",
                    ACCEPT
                ];
                $this->result = true;
            endif;
        }
    }