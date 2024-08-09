<?php
    
    namespace Source\Models\Admin;
    
    use Source\Models\Module;
    use Source\Support\Helper;
    
    class AdminModule
    {
        private $data;
        private $module;
        private $id;
        private $result;
        private $error;
        
        public function create(array $data)
        {
            $this->data = $data;
            $this->module = new Module();
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar um módulo.";
                $this->result = false;
            else:
                /* EXECUTE */
                $this->uri();
                $this->checkOrder();
                if ($this->result):
                    $this->executeCreate();
                endif;
            endif;
        }
        
        public function update(array $data, int $id)
        {
            $this->id = $id;
            $this->data = $data;
            $this->module = (new Module())->findById($this->id);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa preencher todos os campos para atualizar um módulo.";
                $this->result = false;
            else:
                /* EXECUTE */
                $this->uri();
                $this->checkOrder();
                if ($this->result):
                    $this->executeUpdate();
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
            $this->module->uri = $this->data['uri'];
        }
        
        private function checkOrder()
        {
            $where = (isset($this->id) ? "AND id != {$this->id}" : null);
            $modules = (new Module())->find("ord = :o AND course = :c {$where}", "o={$this->data['ord']}&c={$this->data['course']}")->fetch();
            
            if ($modules):
                $this->error = "O módulo <b class='f-bold'>{$modules->title}</b> já está cadastrado na ordem selecionada.";
                $this->result = false;
            else:
                $this->result = true;
                $this->module->ord = $this->data['ord'];
            endif;
        }
        
        private function executeCreate()
        {
            $this->module->title = $this->data['title'];
            $this->module->course = $this->data['course'];
            
            $create = $this->module->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar o módulo.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O módulo <b class='f-bold'>{$this->data['title']}</b> foi cadastrado corretamente no sistema.";
                $this->result = true;
            endif;
        }
        
        private function executeUpdate()
        {
            $this->module->title = $this->data['title'];
            
            $create = $this->module->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Ocorreu um erro ao atualizar o módulo.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O módulo <b class='f-bold'>{$this->data['title']}</b> foi atualizado corretamente no sistema.";
                $this->result = true;
            endif;
        }
    }