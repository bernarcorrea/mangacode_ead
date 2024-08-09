<?php
    
    namespace Source\Models\Admin;
    
    use Source\Support\Hash;
    use Source\Support\Helper;
    use Source\Models\Student;
    use CoffeeCode\Uploader\Image;
    
    class AdminStudent
    {
        private $data;
        private $student;
        private $id;
        private $result;
        private $error;
        
        public function create(array $data)
        {
            $this->data = $data;
            $this->student = new Student();
            
            $cover = (isset($_FILES['cover']) ? $_FILES['cover'] : false);
            $complement = $this->data['complement'];
            $telephone = $this->data['telephone'];
            $facebook = $this->data['facebook'];
            $instagram = $this->data['instagram'];
            $twitter = $this->data['twitter'];
            $youtube = $this->data['youtube'];
            unset($this->data['cover']);
            unset($this->data['complement']);
            unset($this->data['telephone']);
            unset($this->data['facebook']);
            unset($this->data['instagram']);
            unset($this->data['twitter']);
            unset($this->data['youtube']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa preencher todos os campos obrigatórios para cadastrar um aluno.";
                $this->result = false;
            else:
                $this->data['complement'] = $complement;
                $this->data['telephone'] = $telephone;
                $this->data['facebook'] = $facebook;
                $this->data['instagram'] = $instagram;
                $this->data['twitter'] = $twitter;
                $this->data['youtube'] = $youtube;
                $this->data['cover'] = $cover;
                /* EXECUTE */
                $this->checkDocument();
                if ($this->result):
                    $this->checkEmail();
                    if ($this->result):
                        $this->password();
                        if ($this->result):
                            $this->cover();
                            if ($this->result):
                                $this->executeCreate();
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        }
        
        public function update(array $data, int $id)
        {
            $this->id = $id;
            $this->data = $data;
            $this->student = (new Student())->findById($this->id);
            
            $cover = (isset($_FILES['cover']) ? $_FILES['cover'] : false);
            $imageCurrent = $this->data['image_current'];
            $complement = $this->data['complement'];
            $telephone = $this->data['telephone'];
            $facebook = $this->data['facebook'];
            $instagram = $this->data['instagram'];
            $twitter = $this->data['twitter'];
            $youtube = $this->data['youtube'];
            $password = $this->data['password'];
            $password_confirm = $this->data['password_confirm'];
            unset($this->data['cover']);
            unset($this->data['complement']);
            unset($this->data['telephone']);
            unset($this->data['facebook']);
            unset($this->data['instagram']);
            unset($this->data['twitter']);
            unset($this->data['youtube']);
            unset($this->data['password']);
            unset($this->data['password_confirm']);
            unset($this->data['image_current']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa preencher todos os campos obrigatórios para atualizar um aluno.";
                $this->result = false;
            else:
                $this->data['complement'] = $complement;
                $this->data['telephone'] = $telephone;
                $this->data['facebook'] = $facebook;
                $this->data['instagram'] = $instagram;
                $this->data['twitter'] = $twitter;
                $this->data['youtube'] = $youtube;
                $this->data['cover'] = $cover;
                $this->data['password'] = $password;
                $this->data['password_confirm'] = $password_confirm;
                $this->data['image_current'] = $imageCurrent;
                /* EXECUTE */
                $this->checkDocument();
                if ($this->result):
                    $this->checkEmail();
                    if ($this->result):
                        $this->password();
                        if ($this->result):
                            $this->cover();
                            if ($this->result):
                                $this->executeUpdate();
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        }
        
        public function delete(int $id)
        {
            $this->id = $id;
        }
        
        public function result()
        {
            return $this->result;
        }
        
        public function error()
        {
            return $this->error;
        }
        
        private function checkDocument()
        {
            $where = (isset($this->id) ? "AND id != {$this->id}" : null);
            if (!Helper::cpf($this->data['document'])):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa fornecer um CPF válido.";
            else:
                $student = (new Student())->find("document = :doc {$where}", "doc={$this->data['document']}")->fetch();
                if ($student):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Já existe um aluno cadastrado com este CPF.";
                else:
                    $this->student->document = $this->data['document'];
                    $this->result = true;
                endif;
            endif;
        }
        
        private function checkEmail()
        {
            $where = (isset($this->id) ? "AND id != {$this->id}" : null);
            if (!Helper::email($this->data['email'])):
                $this->result = false;
                $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Você precisa fornecer um e-mail com formato válido.";
            else:
                $student = (new Student())->find("email = :email {$where}", "email={$this->data['email']}")->fetch();
                if ($student):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> Já existe um aluno cadastrado com este e-mail.";
                else:
                    $this->student->email = $this->data['email'];
                    $this->result = true;
                endif;
            endif;
        }
        
        private function password()
        {
            if (isset($this->id)):
                if (empty($this->data['password'])):
                    $student = (new Student())->findById($this->id);
                    $this->data['password'] = $student->password;
                    $this->student->password = $this->data['password'];
                    $this->result = true;
                else:
                    if ($this->data['password'] != $this->data['password_confirm']):
                        $this->result = false;
                        $this->error = "<b class='f-bold'>Ocorreu um erro:</b> As senhas que você digitou não coincidem, tente novamente.";
                    else:
                        unset($this->data['password_confirm']);
                        $this->data['password'] = Hash::hash($this->data['password']);
                        $this->student->password = $this->data['password'];
                        $this->result = true;
                    endif;
                endif;
            else:
                if ($this->data['password'] != $this->data['password_confirm']):
                    $this->result = false;
                    $this->error = "<b class='f-bold'>Ocorreu um erro:</b> As senhas que você digitou não coincidem, tente novamente.";
                else:
                    unset($this->data['password_confirm']);
                    $this->data['password'] = Hash::hash($this->data['password']);
                    $this->student->password = $this->data['password'];
                    $this->result = true;
                endif;
            endif;
        }
        
        private function cover()
        {
            $image = new Image("upload", "students");
            $imageCurrent = (isset($this->id) ? $this->data['image_current'] : null);
            unset($this->data['image_current']);
            
            if (isset($this->id)):
                if (!$this->data['cover']):
                    $this->data['cover'] = $imageCurrent;
                    $this->student->cover = $this->data['cover'];
                    $this->result = true;
                else:
                    /*
                     * AUTENTICA TIPOS DE ARQUIVOS
                     */
                    if (empty($this->data['cover']['type']) || !in_array($this->data['cover']['type'], $image::isAllowed())):
                        $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa enviar uma imagem nos formatos JPG ou PNG.";
                        $this->result = false;
                    else:
                        /*
                         * EXCLUI A IMAGEM ANTERIOR
                         */
                        $student = (new Student())->findById($this->id);
                        if (!empty($student->cover)):
                            unlink($student->cover);
                        endif;
                        
                        $imgName = Helper::uri($this->data['name'] . ' ' . $this->data['lastname']) . '-' . time();
                        $upload = $image->upload($this->data['cover'], $imgName, 800);
                        $this->data['cover'] = $upload;
                        $this->student->cover = $this->data['cover'];
                        $this->result = true;
                    endif;
                endif;
            else:
                if (!$this->data['cover']):
                    $this->data['cover'] = null;
                    $this->student->cover = $this->data['cover'];
                    $this->result = true;
                else:
                    if (empty($this->data['cover']['type']) || !in_array($this->data['cover']['type'], $image::isAllowed())):
                        $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa enviar uma imagem nos formatos JPG ou PNG.";
                        $this->result = false;
                    else:
                        $imgName = Helper::uri($this->data['name'] . ' ' . $this->data['lastname']) . '-' . time();
                        $upload = $image->upload($this->data['cover'], $imgName, 800);
                        $this->data['cover'] = $upload;
                        $this->student->cover = $this->data['cover'];
                        $this->result = true;
                    endif;
                endif;
            endif;
        }
        
        private function executeCreate()
        {
            $this->student->name = $this->data['name'];
            $this->student->lastname = $this->data['lastname'];
            $this->student->birthday = Helper::date($this->data['birthday']);
            $this->student->genre = $this->data['genre'];
            $this->student->telephone = $this->data['telephone'];
            $this->student->phone = $this->data['phone'];
            $this->student->cep = $this->data['cep'];
            $this->student->address = $this->data['address'];
            $this->student->number = $this->data['number'];
            $this->student->complement = $this->data['complement'];
            $this->student->district = $this->data['district'];
            $this->student->state = $this->data['state'];
            $this->student->city = $this->data['city'];
            $this->student->facebook = $this->data['facebook'];
            $this->student->instagram = $this->data['instagram'];
            $this->student->twitter = $this->data['twitter'];
            $this->student->youtube = $this->data['youtube'];
            $this->student->status = $this->data['status'];
            
            $create = $this->student->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar o aluno.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O aluno <b class='f-bold'>{$this->data['name']} {$this->data['lastname']}</b> foi cadastrado corretamente no sistema.";
                $this->result = true;
            endif;
        }
        
        private function executeUpdate()
        {
            $this->student->name = $this->data['name'];
            $this->student->lastname = $this->data['lastname'];
            $this->student->birthday = Helper::date($this->data['birthday']);
            $this->student->genre = $this->data['genre'];
            $this->student->telephone = $this->data['telephone'];
            $this->student->phone = $this->data['phone'];
            $this->student->cep = $this->data['cep'];
            $this->student->address = $this->data['address'];
            $this->student->number = $this->data['number'];
            $this->student->complement = $this->data['complement'];
            $this->student->district = $this->data['district'];
            $this->student->state = $this->data['state'];
            $this->student->city = $this->data['city'];
            $this->student->facebook = $this->data['facebook'];
            $this->student->instagram = $this->data['instagram'];
            $this->student->twitter = $this->data['twitter'];
            $this->student->youtube = $this->data['youtube'];
            $this->student->status = $this->data['status'];
            
            $create = $this->student->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Ocorreu um erro ao atualizar o aluno.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O aluno <b class='f-bold'>{$this->data['name']} {$this->data['lastname']}</b> foi atualizado corretamente no sistema.";
                $this->result = true;
            endif;
        }
    }