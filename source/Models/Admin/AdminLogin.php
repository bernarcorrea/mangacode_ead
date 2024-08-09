<?php
    
    namespace Source\Models\Admin;
    
    use Source\Models\User;
    use Source\Support\Helper;
    use Source\Support\Hash;
    
    class AdminLogin
    {
        private $data;
        private $result;
        private $error;
        
        public function setLogin(array $data)
        {
            $this->data = $data;
            if (in_array('', $this->data)):
                $this->error = [
                    'Por favor, preencha todos os campos!',
                    INFO
                ];
                $this->result = false;
            else:
                $this->getLogin();
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
        
        public function request($Data)
        {
            //            $Read = new Read;
            //            $this->Data = $Data;
            //
            //            $Read->ExeRead(self::Tabela, "WHERE user_email = :email", "email={$this->Data['user_email']}");
            //            if (!$Read->getResult()):
            //                $this->Result = false;
            //                $this->Error = [
            //                    "Desculpe, o e-mail informado é inválido!",
            //                    ALERT
            //                ];
            //            else:
            //                $this->sendMail();
            //                if ($this->Result != false):
            //                    $this->Error = [
            //                        "Tudo certo, um link de redefinição de senha foi enviado para o seu e-mail!",
            //                        ACCEPT
            //                    ];
            //                else:
            //                    $this->Error = [
            //                        "Não foi possível enviar um e-mail de redefinição de senha, tente novamente mais tarde!",
            //                        ALERT
            //                    ];
            //                endif;
            //            endif;
        }
        
        public function updatePass($Data)
        {
            //            $Read = new Read;
            //            $Update = new Update;
            //            $this->Data = $Data;
            //
            //            $Read->ExeRead(self::Tabela, "WHERE user_id = :id", "id={$this->Data['user_id']}");
            //            if ($Read->getResult()):
            //                $this->Data['user_password'] = Criptog::hash($this->Data['user_password']);
            //                $Update->ExeUpdate(self::Tabela, $this->Data, "WHERE user_id = :id", "id={$this->Data['user_id']}");
            //                if (!$Update->getResult()):
            //                    $this->Result = false;
            //                    $this->Error = ["Não foi possível redefinir sua senha!", ERROR];
            //                else:
            //                    $this->Result = true;
            //                    $this->Error = ["<b class='f-bold'>Tudo certo, {$Read->getResult()[0]['user_nome']}!</b> Sua senha foi redefinida com sucesso no sistema!", ERROR];
            //                endif;
            //            else:
            //                $this->Result = false;
            //                $this->Error = ["Desculpe! Nenhum usuário foi encontrado!", ERROR];
            //            endif;
        }
        
        public function logout()
        {
            unset($_SESSION['acesso']);
            $this->result = true;
            $this->error = [
                "<b class='f-bold'>Você saiu do sistema.</b> Esperamos você de volta em breve!",
                ACCEPT
            ];
        }
        
        private function getLogin()
        {
            $login = new User();
            $users = $login->find("email = :e", "e={$this->data['email']}")->fetch(true);
            
            if ($users):
                foreach ($users as $user):
                    if (Hash::check($this->data['password'], $user->password)):
                        $_SESSION['acesso']['permitido'] = "permitido";
                        $_SESSION['acesso']['nome'] = $user->name;
                        $_SESSION['acesso']['id'] = $user->id;
                        $_SESSION['acesso']['nivel'] = $user->nivel;
                        
                        $this->error = [
                            "Olá, <span class='f-bold'>{$user->name}</span>, você será redirecionado!",
                            ACCEPT
                        ];
                        $this->result = true;
                    else:
                        $this->error = [
                            "Sua senha é inválida, {$user->name}!",
                            ERROR
                        ];
                        $this->result = false;
                    endif;
                endforeach;
            else:
                $this->error = [
                    'Desculpe, o e-mail informado é inválido!',
                    ERROR
                ];
                $this->result = false;
            endif;
        }
    }