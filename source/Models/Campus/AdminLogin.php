<?php
    
    namespace Source\Models\Campus;
    
    use Source\Models\Student;
    use Source\Support\Email;
    use Source\Support\Hash;
    use Source\Support\Helper;
    
    class AdminLogin
    {
        private $data;
        private $error;
        private $result;
        
        public function login(array $data)
        {
            $this->data = $data;
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Erro ao acessar:</b> Você precisa preencher todos os campos para acessar o campus.";
            else:
                $this->getStudent();
                if ($this->result):
                    $this->checkPassword();
                    if ($this->result):
                        $this->executeLogin();
                    endif;
                endif;
            endif;
        }
        
        public function logout()
        {
            if (isset($_SESSION['campusmanga'])):
                $student = (new Student())->findById($_SESSION['campusmanga']['id']);
                $this->result = true;
                $this->error = "<b class='f-bold'>Tudo certo, {$student->name}.</b> Esperamos ver você em breve!";
                unset($_SESSION['campusmanga']);
            else:
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível identificar uma sessão aberta!";
            endif;
        }
        
        public function check()
        {
            if (isset($_SESSION['campusmanga']) && $_SESSION['campusmanga']['check'] == 'check'):
                $this->result = true;
            else:
                $this->result = false;
            endif;
        }
        
        public function forgot(array $data)
        {
            $this->data = $data;
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher todos os campos para redefinir a sua senha.";
            else:
                $student = (new Student())->find("email = :e", "e={$this->data['email']}")->fetch();
                if (!Helper::email($this->data['email'])):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa informar um e-mail com formato válido.";
                elseif (!$student):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> O e-mail que você informou não foi encontrado em nosso sistema.";
                else:
                    $this->data['student'] = $student;
                    $this->sendMailForgot();
                endif;
            endif;
        }
        
        public function updatePassword(array $data)
        {
            $this->data = $data;
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher todos os campos para redefinir a sua senha.";
            else:
                $getHash = (!empty($this->data['id']) ? $this->data['id'] : false);
                if ($getHash):
                    $hash = base64_decode($getHash);
                    parse_str($hash, $arr);
                    
                    if ($arr['updatepass']):
                        $student = (new Student())->findById($arr['st']);
                        if (!$student):
                            $this->result = false;
                            $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Cadastro não encontrado em nossa base de dados.";
                        else:
                            if (strlen($this->data['password']) < 6):
                                $this->result = false;
                                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Digite uma senha com no mínimo 6 dígitos.";
                            elseif ($this->data['password'] != $this->data['password_confirm']):
                                $this->result = false;
                                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> As senhas que você digitou não coincidem.";
                            else:
                                $student->password = Hash::hash($this->data['password']);
                                $update = $student->save();
                                if (!$update):
                                    $this->result = false;
                                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível redenifir a sua senha.";
                                else:
                                    $this->data['student'] = $student;
                                    $this->sendMailUpdatePassword();
                                endif;
                            endif;
                        endif;
                    endif;
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
        
        private function getStudent()
        {
            $this->data['student'] = (new Student())->find("email = :email", "email={$this->data['email']}")->fetch();
            
            if (!Helper::email($this->data['email'])):
                $this->result = false;
                $this->error = "<b class='f-bold'>Erro ao acessar:</b> Você precisa preencher um e-mail com formato válido.";
            elseif (!$this->data['student']):
                $this->result = false;
                $this->error = "<b class='f-bold'>Erro ao acessar:</b> Não foram encontrados alunos cadastrados com este e-mail.";
            else:
                $this->result = true;
            endif;
        }
        
        private function checkPassword()
        {
            if (!Hash::check($this->data['password'], $this->data['student']->password)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Senha inválida:</b> A senha que você informou é inválida, {$this->data['student']->name}.";
            else:
                $this->result = true;
            endif;
        }
        
        private function executeLogin()
        {
            $_SESSION['campusmanga']['check'] = 'check';
            $_SESSION['campusmanga']['name'] = $this->data['student']->name . ' ' . $this->data['student']->lastname;
            $_SESSION['campusmanga']['id'] = $this->data['student']->id;
            $_SESSION['campusmanga']['cover'] = $this->data['student']->cover;
            /*
             * SUCCESS
             */
            $this->error = "<b class='f-bold'>Bem-vindo de volta, {$this->data['student']->name}.</b> Vamos voltar aos estudos?";
        }
        
        private function sendMailForgot()
        {
            $email = new Email();
            $hash = base64_encode("forgot=true&student_name={$this->data['student']->name}&student={$this->data['student']->id}");
            
            $message = "
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 24px;\">
                        <b>Olá, {$this->data['student']->name}!</b>
                    </td>
                </tr>
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 20px 0 20px 0\">
                        Identificamos que você solicitou um pedido de redefinição da sua senha de acesso.
                        <br><br>
                        
                        <b>Caso você não reconheça esse pedido, <span style='color: #cc0000; display: block'>DESCONSIDERE ESTE E-MAIL!</span></b>
                        <br>
                        
                        Clique no botão abaixo para redefinir a sua senha:
                        <br>
                        <a href='" . HOME . "/campus/update-password/{$hash}' target='_blank' style='font-size: 14px; padding: 10px 15px; color: #fff; background-color: #ffa11b; border-radius: 5px; cursor: pointer; margin-top: 10px; display: inline-block; text-decoration: none;'>Redefinir minha senha</a>
                        <br><br>
                        
                        <b>ATÉ A PRÓXIMA!</b>
                    </td>
                </tr>
            ";
            
            $email->add(
                "Redefinição de senha - " . COMPANY_NAME,
                "{$message}",
                "{$this->data['student']->name} {$this->data['student']->lastname}",
                "{$this->data['student']->email}",
                )->send();
            
            if (!$email):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível enviar o e-mail de redefinição de senha.";
            else:
                $this->result = true;
                $this->error = "<b class='f-bold'>Tudo certo!</b> O e-mail de redefinição de senha foi enviado para o seu e-mail com sucesso.";
            endif;
        }
        
        private function sendMailUpdatePassword()
        {
            $email = new Email();
            
            $message = "
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 24px;\">
                        <b>Olá, {$this->data['student']->name}!</b>
                    </td>
                </tr>
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 20px 0 20px 0\">
                        Informamos que sua senha foi redefinida com sucesso.
                        <br><br>
                        
                        Para acessar o nosso ambiente do aluno, clique no botão abaixo:
                        <br>
                        <a href='" . HOME . "/campus' target='_blank' style='font-size: 14px; padding: 10px 15px; color: #fff; background-color: #ffa11b; border-radius: 5px; cursor: pointer; margin-top: 10px; display: inline-block; text-decoration: none;'>Acessar ambiente do aluno</a>
                        <br><br>
                        
                        <b>ATÉ A PRÓXIMA!</b>
                    </td>
                </tr>
            ";
            
            $email->add(
                "Senha redefinida com sucesso - " . COMPANY_NAME,
                "{$message}",
                "{$this->data['student']->name} {$this->data['student']->lastname}",
                "{$this->data['student']->email}",
                )->send();
            
            if (!$email):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível enviar o e-mail de redefinição de senha.";
            else:
                $this->result = true;
                $this->error = "<b class='f-bold'>Tudo certo!</b> Sua senha foi redefinida com sucesso.";
            endif;
        }
    }