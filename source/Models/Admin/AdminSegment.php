<?php
    
    namespace Source\Models\Admin;
    
    use Source\Support\Helper;
    use Source\Models\Segment;
    
    class AdminSegment
    {
        private $data;
        private $segment;
        private $id;
        private $result;
        private $error;
        
        public function create(array $data)
        {
            $this->data = $data;
            $this->segment = new Segment();
            
            $description = $this->data['description'];
            unset($this->data['description']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar um segmento.";
                $this->result = false;
            else:
                $this->data['description'] = $description;
                /* EXECUTE */
                $this->uri();
                $this->executeCreate();
            endif;
        }
        
        public function update(array $data, int $id)
        {
            $this->id = $id;
            $this->data = $data;
            $this->segment = (new Segment())->findById($this->id);
    
            $description = $this->data['description'];
            unset($this->data['description']);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa preencher todos os campos para atualizar um segmento.";
                $this->result = false;
            else:
                $this->data['description'] = $description;
                /* EXECUTE */
                $this->uri();
                $this->executeUpdate();
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
            $this->segment->uri = $this->data['uri'];
        }
        
        private function executeCreate()
        {
            $this->segment->title = $this->data['title'];
            $this->segment->description = $this->data['description'];
            
            $create = $this->segment->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar o segmento.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O segmento <b class='f-bold'>{$this->data['title']}</b> foi cadastrado corretamente no sistema.";
                $this->result = true;
            endif;
        }
        
        private function executeUpdate()
        {
            $this->segment->title = $this->data['title'];
            $this->segment->description = $this->data['description'];
            
            $create = $this->segment->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Ocorreu um erro ao atualizar o segmento.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O segmento <b class='f-bold'>{$this->data['title']}</b> foi atualizado corretamente no sistema.";
                $this->result = true;
            endif;
        }
    }