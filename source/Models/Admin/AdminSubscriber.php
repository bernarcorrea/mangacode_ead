<?php
    
    namespace Source\Models\Admin;
    
    use Source\Models\Subscriber;
    use Source\Support\Helper;
    
    class AdminSubscriber
    {
        private $data;
        private $subscriber;
        private $id;
        private $result;
        private $error;
        
        public function validate(string $data, int $id)
        {
            $this->data = $data;
            $this->id = $id;
            $this->subscriber = (new Subscriber())->findById($this->id);
            
            if (empty($this->data)):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa informar a data de expiração para atualizar a validade.";
                $this->result = false;
            else:
                $this->date();
                $this->executeValidate();
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
    
        private function date()
        {
            $this->data = Helper::date($this->data);
            $this->subscriber->end_date = $this->data;
        }
    
        private function executeValidate()
        {
            $update = $this->subscriber->save();
            if (!$update):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Ocorreu um erro ao atualizar a data de expiração.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> A data de expiração da assinatura foi atualizada corretamente no sistema.";
                $this->result = true;
            endif;
        }
    }