<?php
    
    namespace Source\Models\Campus;
    
    use Source\Models\Ticket;
    use Source\Models\TicketReply;
    use Source\Support\Helper;
    
    class AdminTicket
    {
        private $data;
        private $ticket;
        private $result;
        private $error;
        
        public function create(array $data)
        {
            $this->data = $data;
            if (in_array('', $this->data)):
                $this->result = false;
                $this->error = "<b>Erro ao cadastrar:</b> Você precisa preencher todos os campos.";
            else:
                $this->execute();
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
        
        private function execute()
        {
            /* CADASTRA RESPOSTA */
            if (isset($this->data['ticket'])):
                $this->ticket = new TicketReply();
                $this->ticket->ticket = $this->data['ticket'];
                $this->ticket->author = $this->data['student'];
                $this->ticket->author_type = 1;
                $this->ticket->description = $this->data['description'];
                $create = $this->ticket->save();
                if (!$create):
                    $this->result = false;
                    $this->error = "<b>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar a sua resposta ao ticket.";
                else:
                    $this->result = $this->ticket->data();
                    $this->error = "<b>Tudo certo:</b> A sua resposta foi cadastrada com sucesso ao ticket.";
                    /* ATUALIZA STATUS DO TICKET */
                    $ticket = (new Ticket())->findById($this->data['ticket']);
                    $ticket->description = html_entity_decode($ticket->description);
                    $ticket->status = 1;
                    $ticket->save();
                endif;
            else:
                /* CADASTRA TICKET */
                $this->ticket = new Ticket();
                $this->ticket->student = $this->data['student'];
                $this->ticket->title = $this->data['title'];
                $this->ticket->uri = Helper::uri($this->data['title']);
                $this->ticket->description = $this->data['description'];
                $this->ticket->priority = $this->data['priority'];
                $this->ticket->status = 1;
                $create = $this->ticket->save();
                if (!$create):
                    $this->result = false;
                    $this->error = "<b>Erro ao cadastrar:</b> Ocorreu um erro ao cadastrar o seu ticket.";
                else:
                    $this->result = $this->ticket->data();
                    $this->error = "<b>Tudo certo:</b> O seu ticket foi cadastrado com sucesso.";
                endif;
            endif;
        }
    }