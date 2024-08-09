<?php
    
    namespace Source\Models\Campus;
    
    use Source\Models\ClassDoubt;
    use Source\Models\ClassDoubtReply;
    use Source\Models\Student;
    
    class AdminDoubt
    {
        private $data;
        private $id;
        private $doubt;
        private $result;
        private $error;
        
        public function create(array $data)
        {
            $this->data = $data;
            $this->id = (isset($this->data['id']) ? $this->data['id'] : false);
            $this->data['student'] = (new Student())->findById($this->data['student']);
            
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b>Erro ao enviar:</b> Você precisa preencher o campo de texto para enviar a sua dúvida.";
            else:
                if (!$this->id):
                    $this->insertDoubt();
                else:
                    $this->insertReply();
                    if ($this->result):
                        $this->updateStatus();
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
    
        private function updateStatus()
        {
            $doubt = (new ClassDoubt())->findById($this->id);
            $doubt->description = html_entity_decode($doubt->description);
            $doubt->status = 1;
            $doubt->save();
        }
        
        private function insertDoubt()
        {
            $this->doubt = new ClassDoubt();
            $this->doubt->class = $this->data['class'];
            $this->doubt->student = $this->data['student']->id;
            $this->doubt->description = $this->data['description'];
            $this->doubt->status = 1;
            
            $create = $this->doubt->save();
            if (!$create):
                $this->result = false;
                $this->error = "<b>Erro ao enviar:</b> Não foi possível enviar a sua dúvida.";
            else:
                $this->result = true;
                $this->error = "<b>Tudo certo, {$this->data['student']->name}!</b> Sua dúvida foi cadastrada com sucesso! Em breve nossa equipe irá te responder, ok?";
            endif;
        }
        
        private function insertReply()
        {
            $this->doubt = new ClassDoubtReply();
            $this->doubt->doubt = $this->id;
            $this->doubt->author = $this->data['student']->id;
            $this->doubt->author_type = 1;
            $this->doubt->description = $this->data['description'];
            
            $create = $this->doubt->save();
            if (!$create):
                $this->result = false;
                $this->error = "<b>Erro ao enviar:</b> Não foi possível enviar a sua resposta para esta dúvida, {$this->data['student']->name}.";
            else:
                $this->result = true;
                $this->error = "<b>Tudo certo, {$this->data['student']->name}!</b> Sua resposta foi cadastrada com sucesso! Em breve nossa equipe irá te responder, ok?";
            endif;
        }
    }