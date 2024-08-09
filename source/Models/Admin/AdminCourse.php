<?php
    
    namespace Source\Models\Admin;
    
    use CoffeeCode\Uploader\File;
    use Source\Models\Course;
    use Source\Models\CourseFolder;
    use Source\Support\Helper;
    use CoffeeCode\Uploader\Image;
    
    class AdminCourse
    {
        private $data;
        private $course;
        private $id;
        private $result;
        private $error;
        
        public function create(array $data)
        {
            $this->data = $data;
            $this->course = new Course();
            
            $description = $this->data['description'];
            $cover = (isset($_FILES['cover']) ? $_FILES['cover'] : false);
            //$certificate = (isset($_FILES['certificate']) ? $_FILES['certificate'] : false);
            //unset($this->data['certificate']);
            unset($this->data['description']);
            unset($this->data['cover']);
            unset($this->data['title_cover']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar um curso.";
                $this->result = false;
            else:
                //$this->data['certificate'] = $certificate;
                $this->data['cover'] = $cover;
                $this->data['description'] = $description;
                $this->course->description = $this->data['description'];
                /* EXECUTE */
                $this->uri();
                $this->price();
                $this->status();
                $this->cover();
                if ($this->result):
                    //$this->certificate();
                    //if ($this->result):
                    $this->executeCreate();
                    //endif;
                endif;
            endif;
        }
        
        public function update(array $data, int $id)
        {
            $this->id = $id;
            $this->data = $data;
            $this->course = (new Course())->findById($this->id);
            
            $description = $this->data['description'];
            $cover = (isset($_FILES['cover']) ? $_FILES['cover'] : false);
            //$certificate = (isset($_FILES['certificate']) ? $_FILES['certificate'] : false);
            //unset($this->data['certificate']);
            unset($this->data['description']);
            unset($this->data['cover']);
            unset($this->data['title_cover']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa preencher todos os campos para atualizar um curso.";
                $this->result = false;
            else:
                //$this->data['certificate'] = $certificate;
                $this->data['cover'] = $cover;
                $this->data['description'] = $description;
                $this->course->description = $this->data['description'];
                /* EXECUTE */
                $this->uri();
                $this->price();
                $this->status();
                $this->cover();
                if ($this->result):
                    //$this->certificate();
                    //if ($this->result):
                    $this->executeUpdate();
                    //endif;
                endif;
            endif;
        }
        
        public function delete(int $id)
        {
            $this->id = $id;
        }
        
        public function insertFile(array $data)
        {
            $this->data = $data;
            $file = (isset($_FILES['file']) ? $_FILES['file'] : false);
            unset($this->data['file']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar um arquivo.";
                $this->result = false;
            else:
                $course = (new Course())->findById($this->data['course']);
                
                $files = new File("upload", "folder_course");
                $this->data['file'] = $file;
                if (empty($this->data['file']['type']) || !in_array($this->data['file']['type'], $files::isAllowed())):
                    $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa enviar arquivos do tipo ZIP, RAR, PDF ou DOC.";
                    $this->result = false;
                else:
                    $fileName = Helper::uri($this->data['title']) . '-' . time();
                    $upload = $files->upload($this->data['file'], $fileName);
                    if (!$upload):
                        $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Não foi possível fazer o upload do arquivo.";
                        $this->result = false;
                    else:
                        $courseFolder = new CourseFolder();
                        $courseFolder->course = $course->id;
                        $courseFolder->title = $this->data['title'];
                        $courseFolder->file = $upload;
                        $create = $courseFolder->save();
                        if (!$create):
                            $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Não foi possível cadastrar o arquivo na pasta.";
                            $this->result = false;
                        else:
                            $this->error = "<b class='f-bold'>Tudo certo!</b> O arquivo foi cadastrado na pasta do curso com sucesso.";
                            $this->result = $courseFolder->data();
                        endif;
                    endif;
                endif;
            endif;
        }
        
        public function deleteFile(int $id)
        {
            $this->id = $id;
            $courseFolder = (new CourseFolder())->findById($this->id);
            if (!$courseFolder):
                $this->error = "<b class='f-bold'>Erro ao excluir:</b> Não foi possível encontrar o arquivo na pasta.";
                $this->result = false;
            else:
                /* EXCLUI ARQUIVO DA PASTA */
                if (!empty($courseFolder->file)):
                    unlink($courseFolder->file);
                endif;
                $delete = $courseFolder->destroy();
                if (!$delete):
                    $this->error = "<b class='f-bold'>Erro ao excluir:</b> Não foi possível excluir o arquivo da pasta.";
                    $this->result = false;
                else:
                    $this->error = "<b class='f-bold'>Tudo certo!</b> O arquivo foi excluído da pasta do curso com sucesso.";
                    $this->result = true;
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
        
        private function uri()
        {
            $this->data['uri'] = Helper::uri($this->data['title']);
            $this->course->uri = $this->data['uri'];
        }
        
        private function price()
        {
            $this->data['price'] = str_replace("R$ ", '', Helper::dollar($this->data['price']));
            $this->data['price_billet'] = str_replace("R$ ", '', Helper::dollar($this->data['price_billet']));
            $this->course->price = $this->data['price'];
            $this->course->price_billet = $this->data['price_billet'];
        }
        
        private function status()
        {
            if (isset($this->data['status'])):
                $this->data['status'] = '1';
            else:
                $this->data['status'] = '0';
            endif;
            
            $this->course->status = $this->data['status'];
        }
        
        private function cover()
        {
            $image = new Image("upload", "courses");
            $imageCurrent = (isset($this->id) ? $this->data['image_current'] : null);
            unset($this->data['image_current']);
            
            if (isset($this->id)):
                if (!$this->data['cover']):
                    $this->data['cover'] = $imageCurrent;
                    $this->course->cover = $this->data['cover'];
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
                        $course = (new Course())->findById($this->id);
                        if (!empty($course->cover)):
                            unlink($course->cover);
                        endif;
                        
                        $imgName = $this->data['uri'] . '-' . time();
                        $upload = $image->upload($this->data['cover'], $imgName, 1150);
                        $this->data['cover'] = $upload;
                        $this->course->cover = $this->data['cover'];
                        $this->result = true;
                    endif;
                endif;
            else:
                if (empty($this->data['cover']['type']) || !in_array($this->data['cover']['type'], $image::isAllowed())):
                    $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa enviar uma imagem nos formatos JPG ou PNG.";
                    $this->result = false;
                else:
                    $imgName = $this->data['uri'] . '-' . time();
                    $upload = $image->upload($this->data['cover'], $imgName, 1150);
                    $this->data['cover'] = $upload;
                    $this->course->cover = $this->data['cover'];
                    $this->result = true;
                endif;
            endif;
        }
        
        private function certificate()
        {
            $image = new Image("upload", "certificados");
            $imageCurrent = (isset($this->id) ? $this->data['image_cert_current'] : null);
            unset($this->data['image_cert_current']);
            
            if (isset($this->id)):
                if (!$this->data['certificate']):
                    $this->data['certificate'] = $imageCurrent;
                    $this->course->certificate = $this->data['certificate'];
                    $this->result = true;
                else:
                    /*
                     * AUTENTICA TIPOS DE ARQUIVOS
                     */
                    if (empty($this->data['certificate']['type']) || !in_array($this->data['certificate']['type'], $image::isAllowed())):
                        $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa enviar uma imagem de certificado nos formatos JPG ou PNG.";
                        $this->result = false;
                    else:
                        /*
                         * EXCLUI A IMAGEM ANTERIOR
                         */
                        $course = (new Course())->findById($this->id);
                        unlink($course->certificate);
                        
                        $imgName = 'certificado-' . $this->data['uri'] . '-' . time();
                        $upload = $image->upload($this->data['certificate'], $imgName, 1920);
                        $this->data['certificate'] = $upload;
                        $this->course->certificate = $this->data['certificate'];
                        $this->result = true;
                    endif;
                endif;
            else:
                if (empty($this->data['certificate']['type']) || !in_array($this->data['certificate']['type'], $image::isAllowed())):
                    $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa enviar uma imagem de certificado nos formatos JPG ou PNG.";
                    $this->result = false;
                else:
                    $imgName = 'certificado-' . $this->data['uri'] . '-' . time();
                    $upload = $image->upload($this->data['certificate'], $imgName, 1920);
                    $this->data['certificate'] = $upload;
                    $this->course->certificate = $this->data['certificate'];
                    $this->result = true;
                endif;
            endif;
        }
        
        private function executeCreate()
        {
            $this->course->title = $this->data['title'];
            $this->course->subtitle = $this->data['subtitle'];
            $this->course->tutor = $this->data['tutor'];
            $this->course->segment = $this->data['segment'];
            $this->course->hotmart_prod = $this->data['hotmart_prod'];
            $this->course->hotmart_link = $this->data['hotmart_link'];
            
            $create = $this->course->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar o curso.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O curso <b class='f-bold'>{$this->data['title']}</b> foi cadastrado corretamente no sistema.";
                $this->result = true;
            endif;
        }
        
        private function executeUpdate()
        {
            $this->course->title = $this->data['title'];
            $this->course->subtitle = $this->data['subtitle'];
            $this->course->tutor = $this->data['tutor'];
            $this->course->segment = $this->data['segment'];
            $this->course->hotmart_prod = $this->data['hotmart_prod'];
            $this->course->hotmart_link = $this->data['hotmart_link'];
            
            $create = $this->course->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Ocorreu um erro ao atualizar o curso.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O curso <b class='f-bold'>{$this->data['title']}</b> foi atualizado corretamente no sistema.";
                $this->result = true;
            endif;
        }
    }