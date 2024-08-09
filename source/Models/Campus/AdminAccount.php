<?php
    
    namespace Source\Models\Campus;
    
    use Source\Models\Student;
    use Source\Support\Hash;
    use Source\Support\Helper;
    use CoffeeCode\Uploader\Image;
    use CoffeeCode\Cropper\Cropper;
    
    class AdminAccount
    {
        private $data;
        private $id;
        private $error;
        private $result;
        private $student;
        
        public function personal(array $data)
        {
            $this->data = $data;
            $this->id = $_SESSION['campusmanga']['id'];
            $this->student = (new Student())->findById($this->id);
            
            $telephone = $this->data['telephone'];
            unset($this->data['telephone']);
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher todos os campos obrigatórios.";
            else:
                $this->data['telephone'] = $telephone;
                $this->checkEmail();
                if ($this->result):
                    $this->executePersonal();
                endif;
            endif;
        }
        
        public function address(array $data)
        {
            $this->data = $data;
            $this->id = $_SESSION['campusmanga']['id'];
            $this->student = (new Student())->findById($this->id);
            
            $complement = $this->data['complement'];
            unset($this->data['complement']);
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher todos os campos obrigatórios.";
            else:
                $this->data['complement'] = $complement;
                $this->executeAddress();
            endif;
        }
        
        public function social(array $data)
        {
            $this->data = $data;
            $this->id = $_SESSION['campusmanga']['id'];
            $this->student = (new Student())->findById($this->id);
            /* Data */
            $this->student->faceboook = $this->data['facebook'];
            $this->student->instagram = $this->data['instagram'];
            $this->student->twitter = $this->data['twitter'];
            $this->student->youtube = $this->data['youtube'];
            /* Execute */
            $update = $this->student->save();
            if (!$update):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível atualizar as suas redes sociais.";
            else:
                $this->result = true;
                $this->error = "<b class='f-bold'>Tudo certo, {$this->student->name}!</b> Suas redes sociais foram atualizadas com sucesso.";
            endif;
        }
        
        public function password(array $data)
        {
            $this->data = $data;
            $this->id = $_SESSION['campusmanga']['id'];
            $this->student = (new Student())->findById($this->id);
            
            if (!empty($this->data['password']) && !empty($this->data['password_confirm'])):
                if ($this->data['password'] != $this->data['password_confirm']):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> As senhas que você informou não coincidem, tente novamente!";
                elseif (strlen($this->data['password']) < 6):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você deve informar uma senha com no mínimo 6 caracteres.";
                else:
                    $this->data['password'] = Hash::hash($this->data['password']);
                    $this->executePassword();
                endif;
            else:
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa digitar alguma senha para definir uma nova.";
            endif;
        }
        
        public function cover(array $data)
        {
            $this->data = $data;
            $this->data['cover'] = (isset($_FILES['cover']) ? $_FILES['cover'] : false);
            $this->id = $_SESSION['campusmanga']['id'];
            $this->student = (new Student())->findById($this->id);
            $c = new Cropper("cache");
            
            if (!$this->data['cover']):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa enviar uma imagem para atualizar.";
            else:
                $image = new Image("upload", "students");
                if (empty($this->data['cover']['type']) || !in_array($this->data['cover']['type'], $image::isAllowed())):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa enviar uma imagem no formato JPG ou PNG.";
                else:
                    /*
                     * EXCLUI A IMAGEM ANTERIOR
                     */
                    if (!empty($this->student->cover)):
                        unlink($this->student->cover);
                    endif;
                    $imgName = Helper::uri($this->student->name . ' ' . $this->student->lastname) . '-' . time();
                    $upload = $image->upload($this->data['cover'], $imgName, 500);
                    if (!$upload):
                        $this->result = false;
                        $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa enviar uma imagem no formato JPG ou PNG.";
                    else:
                        $this->student->cover = $upload;
                        $_SESSION['campusmanga']['cover'] = $upload;
                        $this->student->save();
                        /* RESULT */
                        $this->result = Helper::image($c->make($upload, 500, 500), $this->student->name . ' ' . $this->student->lastname, "img round");
                        $this->error = "<b class='f-bold'>Tudo certo, {$this->student->name}!</b> Sua imagem foi cadastrada com sucesso na plataforma.";
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
        
        private function checkEmail()
        {
            $students = (new Student())->find("email = :e AND id != :id", "e={$this->data['email']}&id={$this->id}")->fetch(true);
            
            if (!Helper::email($this->data['email'])):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa preencher um e-mail com formato válido.";
            elseif ($students):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> O e-mail que você informou já está cadastrado na plataforma.";
            else:
                $this->result = true;
            endif;
        }
        
        private function executePersonal()
        {
            $this->student->name = $this->data['name'];
            $this->student->lastname = $this->data['lastname'];
            $this->student->email = $this->data['email'];
            $this->student->genre = $this->data['genre'];
            $this->student->birthday = Helper::date($this->data['birthday']);
            $this->student->telephone = $this->data['telephone'];
            $this->student->phone = $this->data['phone'];
            /* Execute */
            $update = $this->student->save();
            if (!$update):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível atualizar os seus dados.";
            else:
                $this->result = true;
                $this->error = "<b class='f-bold'>Tudo certo, {$this->student->name}!</b> Seus dados foram atualizados com sucesso.";
                $_SESSION['campusmanga']['name'] = $this->student->name . ' ' . $this->student->lastname;
            endif;
        }
        
        private function executeAddress()
        {
            $this->student->cep = $this->data['cep'];
            $this->student->address = $this->data['address'];
            $this->student->complement = $this->data['complement'];
            $this->student->number = $this->data['number'];
            $this->student->district = $this->data['district'];
            $this->student->city = $this->data['city'];
            $this->student->state = $this->data['state'];
            /* Execute */
            $update = $this->student->save();
            if (!$update):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível atualizar os seus dados de endereço.";
            else:
                $this->result = true;
                $this->error = "<b class='f-bold'>Tudo certo, {$this->student->name}!</b> Seus dados de endereço foram atualizados com sucesso.";
            endif;
        }
        
        private function executePassword()
        {
            $this->student->password = $this->data['password'];
            /* Execute */
            $update = $this->student->save();
            if (!$update):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Não foi possível redefinir a sua senha.";
            else:
                $this->result = true;
                $this->error = "<b class='f-bold'>Tudo certo, {$this->student->name}!</b> Sua senha foi redefinida com sucesso.";
            endif;
        }
    }