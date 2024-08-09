<?php
    
    namespace Source\Models\Admin;
    
    use Source\Models\ClassDoubt;
    use Source\Models\ClassDoubtReply;
    
    class AdminDoubt
    {
        private $data;
        private $doubt;
        private $result;
        private $error;
    
        public function reply(array $data)
        {
            $this->data = $data;
        
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar uma resposta para esta dúvida.";
                $this->result = false;
            else:
                /* EXECUTE */
                $this->updateStatus();
                $this->execute();
            endif;
        }
    
        public function resolved(int $id)
        {
            $this->data = $id;
            $this->doubt = (new ClassDoubt())->findById($this->data);
            $this->doubt->status = 3;
            $this->doubt->description = html_entity_decode($this->doubt->description);
            $update = $this->doubt->save();
        
            if (!$update):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Ocorreu um erro ao atualizar o status da dúvida.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O status da dúvida foi atualizado com sucesso!";
                $this->result = true;
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
            $doubt = (new ClassDoubt())->findById($this->data['doubt']);
            $doubt->description = html_entity_decode($doubt->description);
            $doubt->status = 2;
            $doubt->save();
        }
    
        private function execute()
        {
            $this->doubt = new ClassDoubtReply();
            $this->doubt->description = $this->data['description'];
            $this->doubt->doubt = $this->data['doubt'];
            $this->doubt->author_type = $this->data['author_type'];
            $this->doubt->author = $this->data['author'];
        
            $create = $this->doubt->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar a resposta para a dúvida.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> A resposta foi cadastrada à dúvida com sucesso!";
                $this->result = $this->doubt->data();
            endif;
        }
    }