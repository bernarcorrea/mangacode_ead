<?php
    
    namespace Source\Models\Admin;
    
    use Source\Models\Classe;
    use Source\Support\Helper;
    use CoffeeCode\Uploader\Image;
    
    class AdminClass
    {
        private $data;
        private $class;
        private $id;
        private $result;
        private $error;
        
        public function create(array $data)
        {
            $this->data = $data;
            $this->class = new Classe();
            
            $cover = (isset($_FILES['cover']) ? $_FILES['cover'] : false);
            unset($this->data['cover']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar uma aula.";
                $this->result = false;
            else:
                $this->data['cover'] = $cover;
                /* EXECUTE */
                $this->uri();
                $this->checkOrder();
                if ($this->result):
                    $this->cover();
                    if ($this->result):
                        $this->executeCreate();
                    endif;
                endif;
            endif;
        }
        
        public function update(array $data, int $id)
        {
            $this->id = $id;
            $this->data = $data;
            $this->class = (new Classe())->findById($this->id);
            
            $cover = (isset($_FILES['cover']) ? $_FILES['cover'] : false);
            unset($this->data['cover']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa preencher todos os campos para atualizar uma aula.";
                $this->result = false;
            else:
                $this->data['cover'] = $cover;
                /* EXECUTE */
                $this->uri();
                $this->checkOrder();
                if ($this->result):
                    $this->cover();
                    if ($this->result):
                        $this->executeUpdate();
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
        
        private function uri()
        {
            $this->data['uri'] = Helper::uri($this->data['title']);
            $this->class->uri = $this->data['uri'];
        }
        
        private function checkOrder()
        {
            $where = (isset($this->id) ? "AND id != {$this->id}" : null);
            $class = (new Classe())->find("ord = :o AND course = :c {$where}", "o={$this->data['ord']}&c={$this->data['course']}")->fetch();
            
            if ($class):
                $this->error = "A aula <b class='f-bold'>{$class->title}</b> já está cadastrada na ordem selecionada.";
                $this->result = false;
            else:
                $this->result = true;
                $this->class->ord = $this->data['ord'];
            endif;
        }
        
        private function cover()
        {
            $image = new Image("upload", "classes");
            $imageCurrent = (isset($this->id) ? $this->data['image_current'] : null);
            unset($this->data['image_current']);
            
            if (isset($this->id)):
                if (!$this->data['cover']):
                    $this->data['cover'] = $imageCurrent;
                    $this->class->cover = $this->data['cover'];
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
                        $class = (new Classe())->findById($this->id);
                        if (!empty($class->cover)):
                            unlink($class->cover);
                        endif;
                        
                        $imgName = $this->data['uri'] . '-' . time();
                        $upload = $image->upload($this->data['cover'], $imgName, 1150);
                        $this->data['cover'] = $upload;
                        $this->class->cover = $this->data['cover'];
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
                    $this->class->cover = $this->data['cover'];
                    $this->result = true;
                endif;
            endif;
        }
        
        private function executeCreate()
        {
            $this->class->title = $this->data['title'];
            $this->class->course = $this->data['course'];
            $this->class->module = $this->data['module'];
            $this->class->time = $this->data['time'];
            $this->class->level = $this->data['level'];
            $this->class->video = $this->data['video'];
            
            $create = $this->class->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar a aula.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> A aula <b class='f-bold'>{$this->data['title']}</b> foi cadastrada corretamente no sistema.";
                $this->result = true;
            endif;
        }
        
        private function executeUpdate()
        {
            $this->class->title = $this->data['title'];
            $this->class->course = $this->data['course'];
            $this->class->module = $this->data['module'];
            $this->class->time = $this->data['time'];
            $this->class->level = $this->data['level'];
            $this->class->video = $this->data['video'];
            
            $create = $this->class->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Ocorreu um erro ao atualizar a aula.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> A aula <b class='f-bold'>{$this->data['title']}</b> foi atualizada corretamente no sistema.";
                $this->result = true;
            endif;
        }
    }