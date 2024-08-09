<?php
    
    namespace Source\Models\Campus;
    
    use Source\Support\Email;
    use Source\Support\Helper;
    use Source\Support\Hash;
    use Source\Models\Student;
    
    class AdminRegister
    {
        private $data;
        private $result;
        private $error;
        private $student;
        
        public function personal(array $data)
        {
            $this->data = $data;
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher todos os campos para prosseguir para próxima etapa.";
            else:
                $this->checkDocument();
                if ($this->result):
                    /* SAVE SESSION */
                    $_SESSION['student_register']['name'] = $this->data['name'];
                    $_SESSION['student_register']['lastname'] = $this->data['lastname'];
                    $_SESSION['student_register']['document'] = $this->data['document'];
                    $_SESSION['student_register']['birthday'] = $this->data['birthday'];
                    $_SESSION['student_register']['phone'] = $this->data['phone'];
                    $_SESSION['student_register']['genre'] = $this->data['genre'];
                    /* MESSAGE */
                    $this->error = "<b class='f-bold'>Tudo certo, {$this->data['name']}!</b> Preencha os seus dados de endereço para que continuar o seu cadastro.";
                endif;
            endif;
        }
        
        public function address(array $data)
        {
            $this->data = $data;
            
            $complement = $this->data['complement'];
            unset($this->data['complement']);
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher todos os campos para prosseguir para próxima etapa. (Complemento não é obrigatório)";
            else:
                $this->data['complement'] = $complement;
                /* SAVE SESSION */
                $_SESSION['student_register']['cep'] = $this->data['cep'];
                $_SESSION['student_register']['address'] = $this->data['address'];
                $_SESSION['student_register']['complement'] = $this->data['complement'];
                $_SESSION['student_register']['number'] = $this->data['number'];
                $_SESSION['student_register']['district'] = $this->data['district'];
                $_SESSION['student_register']['city'] = $this->data['city'];
                $_SESSION['student_register']['state'] = $this->data['state'];
                /* MESSAGE */
                $this->result = true;
                $this->error = "<b class='f-bold'>Perfeito, {$_SESSION['student_register']['name']}!</b> Agora preencha seus dados de acesso para finalizar o seu cadastro.";
            endif;
        }
        
        public function access(array $data)
        {
            $this->data = $data;
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher todos os campos para prosseguir para próxima etapa.";
            else:
                $this->checkEmail();
                if ($this->result):
                    $this->password();
                    if ($this->result):
                        $this->executeRegister();
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
        
        private function password()
        {
            if ($this->data['password'] != $this->data['password_confirm']):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> As senhas que você informou não coincidem, tente novamente!";
            else:
                if (strlen($this->data['password']) < 6):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você deve informar uma senha com no mínimo 6 caracteres.";
                else:
                    $this->result = true;
                    $this->data['password'] = Hash::hash($this->data['password']);
                endif;
            endif;
        }
        
        private function checkDocument()
        {
            $student = (new Student())->find("document = :d", "d={$this->data['document']}")->fetch();
            
            if (!Helper::cpf($this->data['document'])):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher um CPF com formato válido.";
            elseif ($student):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> O CPF que você informou já está cadastrado na plataforma.";
            else:
                $this->result = true;
            endif;
        }
        
        private function checkEmail()
        {
            $student = (new Student())->find("email = :e", "e={$this->data['email']}")->fetch();
            
            if (!Helper::email($this->data['email'])):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher um e-mail com formato válido.";
            elseif ($student):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> O e-mail que você informou já está cadastrado na plataforma.";
            else:
                $this->result = true;
            endif;
        }
        
        private function executeRegister()
        {
            /* PREPARA DADOS */
            $this->student = new Student();
            
            /* PERSONAL */
            $this->student->name = $_SESSION['student_register']['name'];
            $this->student->lastname = $_SESSION['student_register']['lastname'];
            $this->student->document = $_SESSION['student_register']['document'];
            $this->student->birthday = Helper::date($_SESSION['student_register']['birthday']);
            $this->student->phone = $_SESSION['student_register']['phone'];
            $this->student->genre = $_SESSION['student_register']['genre'];
            /* ADDRESS */
            $this->student->cep = $_SESSION['student_register']['cep'];
            $this->student->address = $_SESSION['student_register']['address'];
            $this->student->number = $_SESSION['student_register']['number'];
            $this->student->complement = $_SESSION['student_register']['complement'];
            $this->student->district = $_SESSION['student_register']['district'];
            $this->student->city = $_SESSION['student_register']['city'];
            $this->student->state = $_SESSION['student_register']['state'];
            /* ACCESS */
            $this->student->email = $this->data['email'];
            $this->student->password = $this->data['password'];
            $this->student->status = 1;
            
            $create = $this->student->save();
            if (!$create):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível cadastrar finalizar o cadastro do aluno.";
            else:
                $this->result = $this->student->data();
                /* EXCLUI SESSÃO DE CADASTRO */
                unset($_SESSION['student_register']);
                /* LOGIN */
                if (isset($_SESSION['campusmanga'])):
                    unset($_SESSION['campusmanga']);
                endif;
                $_SESSION['campusmanga']['check'] = 'check';
                $_SESSION['campusmanga']['name'] = $this->student->data()->name . ' ' . $this->student->data()->lastname;
                $_SESSION['campusmanga']['id'] = $this->student->data()->id;
                $_SESSION['campusmanga']['cover'] = null;
                
                $this->error = "<b class='f-bold'>Pronto, {$this->student->data()->name}!</b> Seu cadastro foi finalizado com sucesso! Você será redirecionado ao ambiente do aluno.";
                $this->sendMailRegister();
            endif;
        }
    
        private function sendMailRegister()
        {
            $student = $this->result;
            $email = new Email();
    
            $message = "
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 24px;\">
                        <b>Recebemos a sua inscrição, {$student->name}!</b>
                    </td>
                </tr>
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 20px 0 20px 0\">
                        Tudo certo, <b>{$student->name}</b>! O Seu cadastro foi finalizado com sucesso em nosso sistema.
                        <br><br>
                        
                        Para acessar o nosso ambiente do aluno, <a href='" . HOME . "/campus' target='_blank'>clique aqui</a> e informe os seus dados cadastrais, ok?
                        <br><br>
                        
                         <b>NOS VEMOS EM BREVE!</b>
                    </td>
                </tr>
            ";
    
            $email->add(
                "Inscrição realizada com sucesso - " . COMPANY_NAME,
                "{$message}",
                "{$student->name} {$student->lastname}",
                "{$student->email}",
                )->send();
        }
    }