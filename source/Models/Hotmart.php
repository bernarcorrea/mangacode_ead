<?php
    
    namespace Source\Models;
    
    use Source\Support\Email;
    use Source\Support\Hash;
    use Source\Support\Helper;
    
    class Hotmart
    {
        private $hotmart;
        private $result;
        private $error;
        private $data;
        private $email;
        
        /** student */
        private $student;
        
        /** course */
        private $course;
        
        /** subscriber */
        private $subscriber;
        
        /** invoice */
        private $invoice;
        
        public function __construct(array $data)
        {
            $this->hotmart = $data;
            $this->email = new Email();
            $this->data['transaction'] = $this->hotmart['transaction'];
            /* * BUSCA CURSO */
            $this->getCourse();
            if ($this->result):
                /* BUSCA ALUNO */
                $this->getStudent();
                if ($this->result):
                    /* BUSCA FATURA */
                    $this->getInvoice();
                    if ($this->result):
                        /* TRANSACTION STATUS */
                        $this->transactionStatus();
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
        
        private function getCourse()
        {
            $this->course = (new Course())->find("hotmart_prod = :prod", "prod={$this->hotmart['prod']}")->fetch();
            if (!$this->course):
                $this->result = false;
            else:
                $this->result = true;
                $this->data['course'] = $this->course;
            endif;
        }
        
        private function getStudent()
        {
            /* email test */
            $this->hotmart['email'] = ($this->hotmart['email'] == "testeComprador271101postman15@example.com" ? HOTMART['user_test']['email'] : $this->hotmart['email']);
            
            $this->student = (new Student())->find("email = :email", "email={$this->hotmart['email']}")->fetch();
            if (!$this->student):
                /* CREATE NEW STUDENT */
                $this->data['password_generate'] = Helper::code();
                $student = new Student();
                $student->name = $this->hotmart['first_name'];
                $student->lastname = $this->hotmart['last_name'];
                $student->document = (empty($this->hotmart['doc']) ? HOTMART['user_test']['document'] : $this->hotmart['doc']);
                $student->phone = "({$this->hotmart['phone_checkout_number']}) " . $this->hotmart['phone_checkout_local_code'];
                $student->cep = (empty($this->hotmart['address_zip_code']) ? HOTMART['user_test']['cep'] : $this->hotmart['address_zip_code']);
                $student->address = (empty($this->hotmart['address']) ? HOTMART['user_test']['address'] : $this->hotmart['address']);
                $student->complement = $this->hotmart['address_comp'];
                $student->number = (empty($this->hotmart['address_number']) ? HOTMART['user_test']['number'] : $this->hotmart['address_number']);
                $student->district = (empty($this->hotmart['address_district']) ? HOTMART['user_test']['district'] : $this->hotmart['address_district']);
                $student->city = (empty($this->hotmart['address_city']) ? HOTMART['user_test']['city'] : $this->hotmart['address_city']);
                $student->state = (empty($this->hotmart['address_state']) ? HOTMART['user_test']['state'] : $this->hotmart['address_state']);
                $student->email = $this->hotmart['email'];
                $student->password = Hash::hash($this->data['password_generate']);
                $student->status = 1;
                $create = $student->save();
                if (!$create):
                    $this->result = false;
                else:
                    $this->data['student'] = $student->data();
                    $this->result = true;
                    $this->sendMailNewStudent();
                endif;
            else:
                $this->data['student'] = $this->student;
                $this->result = true;
            endif;
        }
        
        private function getInvoice()
        {
            $this->invoice = (new Invoice())->find("cod = :c AND student = :s", "c={$this->data['transaction']}&s={$this->data['student']->id}")->fetch();
            if (!$this->invoice):
                /* CREATE NEW INVOICE */
                $invoice = new Invoice();
                $invoice->cod = $this->data['transaction'];
                $invoice->student = $this->data['student']->id;
                $invoice->course = $this->data['course']->id;
                $invoice->price = $this->hotmart['price'];
                $invoice->method_pay = $this->hotmart['payment_type'];
                $invoice->installments = ($this->hotmart['payment_type'] == 'credit_card' ? $this->hotmart['installments_number'] : null);
                $invoice->code_billet = ($this->hotmart['payment_type'] == 'billet' ? $this->hotmart['billet_barcode'] : null);
                $invoice->link_billet = ($this->hotmart['payment_type'] == 'billet' ? $this->hotmart['billet_url'] : null);
                $invoice->status_pay = $this->hotmart['status'];
                $invoice->payment_date = date('Y-m-d H:i:s');
                $create = $invoice->save();
                if (!$create):
                    $this->result = false;
                else:
                    $this->data['invoice'] = $invoice->data();
                    $this->result = true;
                    $this->sendMailNewInvoice();
                endif;
            else:
                $this->data['invoice'] = $this->invoice;
                $this->result = true;
            endif;
        }
        
        private function transactionStatus()
        {
            /* ATUALIZA STATUS DA FATURA */
            $this->updateInvoice($this->hotmart['status']);
            
            switch ($this->hotmart['status']):
                /* COMPRA CANCELADA */
                case 'canceled':
                    $this->deleteSubscriber();
                    break;
                
                /* REEMBOLSO */
                case 'refunded':
                    $this->deleteSubscriber();
                    break;
                
                /* COMPRA APROVADA */
                case 'approved':
                    $this->createSubscriber();
                    break;
            endswitch;
        }
        
        private function updateInvoice(string $status)
        {
            $invoice = (new Invoice())->findById($this->data['invoice']->id);
            $invoice->status_pay = $status;
            $invoice->save();
        }
        
        private function createSubscriber()
        {
            $today = date('Y-m-d');
            $this->subscriber = new Subscriber();
            $subscriber = $this->subscriber->find("course = :c AND student = :s", "c={$this->data['course']->id}&s={$this->data['student']->id}")->fetch();
            if (!$subscriber):
                $this->subscriber->student = $this->data['student']->id;
                $this->subscriber->course = $this->data['course']->id;
                $this->subscriber->start_date = $today;
                $this->subscriber->end_date = date('Y-m-d', strtotime("+" . HOTMART['expiration_days'] . " days", strtotime($today)));
                $this->subscriber->status = 1;
                $create = $this->subscriber->save();
                if (!$create):
                    $this->result = false;
                else:
                    $this->data['subscriber'] = $this->subscriber->data();
                    $this->result = true;
                    $this->sendMailNewSubscriber();
                endif;
            else:
                $this->result = false;
            endif;
        }
        
        private function deleteSubscriber()
        {
            $this->subscriber = new Subscriber();
            $subscriber = $this->subscriber->find("course = :c AND student = :s", "c={$this->data['course']->id}&s={$this->data['student']->id}")->fetch();
            if (!$subscriber):
                $this->result = false;
            else:
                $subs = $this->subscriber->findById($subscriber->id);
                $subs->destroy();
                $this->result = true;
            endif;
        }
        
        private function sendMailNewStudent()
        {
            $message = "
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 24px;\">
                        <b>Recebemos a sua inscrição, {$this->data['student']->name}!</b>
                    </td>
                </tr>
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 20px 0 20px 0\">
                        Tudo certo, <b>{$this->data['student']->name}</b>! O Seu cadastro foi finalizado com sucesso em nosso sistema.
                        <br><br>
                        
                        Para acessar o nosso ambiente do aluno, <a href='" . HOME . "/campus' target='_blank'>clique aqui</a> e informe os dados de acesso logo abaixo, ok?
                        <br><br>
                        
                        <b>DADOS DE ACESSO:</b><br>
                        <b>E-mail:</b> {$this->data['student']->email}<br>
                        <b>Senha:</b> {$this->data['password_generate']}
                        <br><br>
                        
                        <b>OBS:</b><br>
                        A sua senha foi criada automaticamente pelo nosso sistema. Para a sua segurança, recomendamos que você redefina sua senha no seu ambiente de cadastro.
                    </td>
                </tr>
            ";
            
            $this->email->add(
                "Inscrição realizada com sucesso - " . COMPANY_NAME,
                "{$message}",
                "{$this->data['student']->name} {$this->data['student']->lastname}",
                "{$this->data['student']->email}",
                )->send();
        }
        
        private function sendMailNewInvoice()
        {
            if ($this->data['invoice']->method_pay == 'billet'):
                $message = "
                    <tr>
                        <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 24px;\">
                            <b>Nova fatura gerada, {$this->data['student']->name}!</b>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 20px 0 20px 0\">
                            Identificamos que você gerou uma nova fatura em sua conta, seguem os dados abaixo:
                            <br><br>

                            <b>Cód:</b> {$this->data['invoice']->cod}<br>
                            <b>Curso:</b> {$this->data['course']->title}<br>
                            <b>Preço:</b> R$ " . Helper::real($this->data['invoice']->price) . "
                            <br><br>

                            <b>PAGAMENTO:</b><br>
                            <b>Método de pagamento:</b> " . getTypePayment($this->data['invoice']->method_pay) . "<br>
                            <b>Cód. do boleto:</b> {$this->data['invoice']->code_billet}<br>
                            <b>Link do boleto:</b> <a target='_blank' href='{$this->data['invoice']->link_billet}'>Imprimir boleto</a><br><br>

                            <b>Atenção:</b>
                            Pagamentos no boleto bancário podem levar até 72 horas para serem processados.
                        </td>
                    </tr>
                ";
            elseif ($this->data['invoice']->method_pay == 'credit_card'):
                $message = "
                    <tr>
                        <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 24px;\">
                            <b>Nova fatura gerada, {$this->data['student']->name}!</b>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 20px 0 20px 0\">
                            Identificamos que você gerou uma nova fatura em sua conta, seguem os dados abaixo:
                            <br><br>

                            <b>Cód:</b> {$this->data['invoice']->cod}<br>
                            <b>Curso:</b> {$this->data['course']->title}<br>
                            <b>Preço:</b> R$ " . Helper::real($this->data['invoice']->price) . "
                            <br><br>

                            <b>PAGAMENTO:</b><br>
                            <b>Método de pagamento:</b> " . getTypePayment($this->data['invoice']->method_pay) . "<br>
                            <b>Parcelamento:</b> {$this->data['invoice']->installments}x R$ " . Helper::real($this->data['invoice']->price / $this->data['invoice']->installments) . "
                        </td>
                    </tr>
                ";
            endif;
            
            $this->email->add(
                "Uma nova fatura foi gerada em sua conta - " . COMPANY_NAME,
                "{$message}",
                "{$this->data['student']->name} {$this->data['student']->lastname}",
                "{$this->data['student']->email}",
                )->send();
        }
        
        private function sendMailNewSubscriber()
        {
            $message = "
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 24px;\">
                        <b>Seu curso foi liberado, {$this->data['student']->name}!</b>
                    </td>
                </tr>
                <tr>
                    <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 20px 0 20px 0\">
                        Opa, <b>{$this->data['student']->name}</b>! O seu pagamento foi aprovado e seu curso já está liberado para você iniciar os seus estudos!
                        <br><br>
                        
                        Para acessar o nosso ambiente do aluno, <a href='" . HOME . "/campus' target='_blank'>clique aqui</a> e inicie sua jornada agora mesmo.
                        <br><br>
                        
                        <b>BONS ESTUDOS!</b>
                    </td>
                </tr>
            ";
            
            $this->email->add(
                "Seu curso foi liberado - " . COMPANY_NAME,
                "{$message}",
                "{$this->data['student']->name} {$this->data['student']->lastname}",
                "{$this->data['student']->email}",
                )->send();
        }
    }