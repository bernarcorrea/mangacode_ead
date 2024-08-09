<?php
    
    namespace Source\Models\Admin;
    
    use Source\Models\Subscriber;
    use Source\Models\Invoice;
    
    class AdminInvoice
    {
        private $data;
        private $invoice;
        private $id;
        private $result;
        private $error;
        
        public function status(array $data, int $id)
        {
            $this->data = $data;
            $this->id = $id;
            $this->invoice = (new Invoice())->findById($this->id);
            
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Você precisa selecionar um status para atualizar a fatura.";
                $this->result = false;
            else:
                $this->executeUpdate();
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
        
        private function createSubscriber()
        {
            $subscriber = new Subscriber();
            $today = date('Y-m-d');
            
            /* CÁLCULO DE VALIDADE */
            $subscriber->start_date = $today;
            $subscriber->end_date = date('Y-m-d', strtotime("+365 days", strtotime($today)));
            
            /* CURSO, ALUNO E STATUS */
            $subscriber->course = $this->invoice->course;
            $subscriber->student = $this->invoice->student;
            $subscriber->status = 1;
            $subscriber->save();
        }
        
        private function executeUpdate()
        {
            if ($this->data['status_pay'] == 'paid'):
                $subscriber = (new Subscriber())->find("course = :c AND student = :s", "c={$this->invoice->course}&s={$this->invoice->student}")->fetch();
                if (!$subscriber):
                    /* CRIA A ASSINATURA */
                    $this->createSubscriber();
                endif;
            endif;
            
            $this->invoice->status_pay = $this->data['status_pay'];
            $update = $this->invoice->save();
            if (!$update):
                $this->error = "<b>Ocorreu um erro:</b> Não foi possível atualizar o status da fatura.";
                $this->result = false;
            else:
                $this->error = "<b>Tudo certo:</b> O status da fatura foi atualizado com sucesso.";
                $this->result = true;
            endif;
        }
    }