<?php
    
    namespace Source\Support;
    
    use Exception;
    use stdClass;
    use PHPMailer\PHPMailer\PHPMailer;
    
    class Email
    {
        /** @var PHPMailer */
        private $mail;
        
        /** @var stdClass */
        private $data;
        
        /** @var Exception */
        private $error;
        
        public function __construct()
        {
            $this->mail = new PHPMailer();
            $this->data = new stdClass();
            
            $this->mail->isSMTP();
            $this->mail->isHTML();
            $this->mail->setLanguage('br');
            
            $this->mail->SMTPAuth = true;
            $this->mail->SMTPSecure = MAIL_SMTP['secure'];
            $this->mail->CharSet = "utf-8";
            
            $this->mail->Host = MAIL_SMTP['host'];
            $this->mail->Port = MAIL_SMTP['port'];
            $this->mail->Username = MAIL_SMTP['user'];
            $this->mail->Password = MAIL_SMTP['pass'];
        }
        
        public function add(string $subject, string $body, string $recipient_name, string $recipient_email): Email
        {
            $this->data->subject = $subject;
            $this->data->body = $body;
            $this->data->recipient_name = $recipient_name;
            $this->data->recipient_email = $recipient_email;
            return $this;
        }
        
        public function attach(string $filePath, string $fileName): Email
        {
            $this->data->attach[$filePath] = $fileName;
            return $this;
        }
        
        public function send(string $from_name = null, string $from_email = null): bool
        {
            $fromName = (empty($from_name) ? MAIL_SMTP['from_name'] : $from_name);
            $fromEmail = (empty($from_email) ? MAIL_SMTP['from_email'] : $from_email);
            $this->data->body = "
                <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
                <html xmlns=\"http://www.w3.org/1999/xhtml\">
                <head>
                    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
                    <title>{$this->data->subject}</title>
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
                </head>
                <body style=\"margin: 0; padding: 0;\">
                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\" style=\"border-collapse: collapse; max-width: 90%;\">
                        <tr>
                            <td bgcolor=\"#333333\" align=\"center\" style=\"padding: 30px 10px 40px 10px;\">
                                <img src='" . HOME . "/" . CAMPUS . "/images/logo.png' alt='" . COMPANY_NAME . "' style='width: 70%;'>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor=\"#ffffff\" style=\"padding: 40px 40px 40px 40px; color: #333333; font-family: Arial, sans-serif; font-size: 14px;\">
                                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                    {$this->data->body}
                                    <tr><td style='padding: 25px 0 0 0'><small style='color: #777;'>Recebida em: " . date('d/m/Y H:i') . "</small></td></tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor=\"#333333\" align=\"center\" style=\"padding: 30px 30px 30px 30px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;\">
                                <b>&reg; " . COMPANY_NAME . "</b> - TODOS OS DIREITOS RESERVADOS
                            </td>
                        </tr>
                    </table>
                </body>
                </html>
            ";
            
            try {
                $this->mail->Subject = $this->data->subject;
                $this->mail->msgHTML($this->data->body);
                $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
                $this->mail->setFrom($fromEmail, $fromName);
                
                if (!empty($this->data->attach)):
                    foreach ($this->data->attach as $path => $name):
                        $this->mail->addAttachment($path, $name);
                    endforeach;
                endif;
                
                $this->mail->send();
                $this->mail->clearAllRecipients();
                return true;
            }
            catch (Exception $exception) {
                $this->error = $exception;
                return false;
            }
        }
        
        public function error(): ?Exception
        {
            return $this->error;
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    