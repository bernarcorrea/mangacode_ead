<?php
    
    namespace Source\Models\Admin;
    
    use Source\Models\Ticket;
    use Source\Models\TicketReply;
    
    class AdminTicket
    {
        private $data;
        private $ticket;
        private $ticketId;
        private $result;
        private $error;
    
        public function reply(array $data, int $ticket)
        {
            $this->data = $data;
            $this->ticketId = $ticket;
            $this->ticket = new TicketReply();
            
            $description = $this->data['description'];
            unset($this->data['description']);
    
            if (in_array('', $this->data)):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Você precisa preencher todos os campos para cadastrar uma resposta ao ticket.";
                $this->result = false;
            else:
                $this->data['description'] = $description;
                /* EXECUTE */
                $this->updateStatus();
                $this->execute();
            endif;
        }
    
        public function resolved(int $id)
        {
            $this->ticketId = $id;
            $this->ticket = (new Ticket())->findById($this->ticketId);
            $this->ticket->status = 4;
            $this->ticket->description = html_entity_decode($this->ticket->description);
            $update = $this->ticket->save();
            
            if (!$update):
                $this->error = "<b class='f-bold'>Erro ao atualizar:</b> Ocorreu um erro ao atualizar o status do ticket.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> O status do ticket foi atualizado com sucesso!";
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
            $ticket = (new Ticket())->findById($this->data['ticket']);
            $ticket->description = html_entity_decode($ticket->description);
            $ticket->status = 2;
            $ticket->save();
        }
    
        private function execute()
        {
            $this->ticket->description = $this->data['description'];
            $this->ticket->ticket = $this->data['ticket'];
            $this->ticket->author_type = $this->data['author_type'];
            $this->ticket->author = $this->data['author'];
    
            $create = $this->ticket->save();
            if (!$create):
                $this->error = "<b class='f-bold'>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar a resposta ao ticket.";
                $this->result = false;
            else:
                $this->error = "<b class='f-bold'>Tudo certo:</b> A resposta foi cadastrada ao ticket com sucesso!";
                $this->result = $this->ticket->data();
            endif;
        }
    }