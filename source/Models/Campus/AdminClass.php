<?php
    
    namespace Source\Models\Campus;
    
    use Source\Models\Certificate;
    use Source\Models\Classe;
    use Source\Models\ClassStatus;
    use Source\Models\Course;
    use Source\Models\Student;
    use Source\Models\Subscriber;
    use Source\Support\Email;
    use Source\Support\Helper;
    
    class AdminClass
    {
        private $data;
        private $student;
        private $class;
        private $result;
        
        /** TASK */
        private $progress;
        
        public function managerClass(int $class, int $student)
        {
            $this->class = $class;
            $this->student = $student;
            $this->data['class'] = (new Classe())->findById($this->class);
            
            /* CRIA VISUALIZAÇÃO OU ATUALIZA A AULA */
            $this->data['statusClass'] = (new ClassStatus())->find("class = :c AND student = :s", "c={$this->class}&s={$this->student}")->fetch();
            if (!$this->data['statusClass']):
                $this->createStatusClass();
            else:
                $this->updateStatusClass();
            endif;
            /*
             * ATUALIZA ÚLTIMA AULA DA ASSINATURA
             */
            $this->updateLastClass();
            /*
             * INICIA SESSÃO DE AULA
             */
            $this->startTask();
        }
        
        public function checkTask(int $stundent)
        {
            $this->student = (!empty($stundent) ? $stundent : false);
            $this->class = (!empty($_SESSION['campusClass']) ? $_SESSION['campusClass'] : false);
            $startTime = (!empty($_SESSION['campusTaskClass']) ? $_SESSION['campusTaskClass'] : false);
            
            if ($this->student && $this->class && $startTime):
                $class = (new Classe())->findById($this->class);
                if ($class):
                    /* BUSCA STATUS CLASS */
                    $statusClass = (new ClassStatus())->find("class = :c AND student = :s", "c={$class->id}&s={$this->student}")->fetch();
                    if ($statusClass && $statusClass->status != 2):
                        if (EAD['auto_check']):
                            $endTime = ceil(($startTime + ($class->time * 60) * (EAD['class_percent'] / 100)));
                            /* VERIFICA SE O TEMPO DECORRIDO É MENOR QUE O TEMPO ATUAL */
                            if (time() > $endTime):
                                $this->result = true;
                                $this->progress = 100;
                                /* UPDATE STATUS CLASS */
                                $stClass = (new ClassStatus())->findById($statusClass->id);
                                $stClass->status = 2;
                                $stClass->save();
                                /*
                                 * VERIFICA PROGRESSO DO ALUNO
                                 */
                                $progressStudent = courseProgress($class->course, $this->student);
                                if ($progressStudent >= EAD['certificate_percent']):
                                    /* CRIA CERTIFICADO DO ALUNO */
                                    $this->createCertificate();
                                endif;
                            else:
                                $this->result = false;
                                /* PROGRESS REAL TIME */
                                $totalTime = $endTime - $startTime;
                                $reserveTime = $endTime - time();
                                $percentEnd = (time() >= $endTime ? 1 : $reserveTime / $totalTime);
                                $percentPresent = 1 - $percentEnd;
                                
                                $this->progress = $percentPresent * 100;
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        }
        
        public function result()
        {
            return $this->result;
        }
        
        public function progress()
        {
            return $this->progress;
        }
        
        private function createStatusClass()
        {
            $statusClass = new ClassStatus();
            $statusClass->course = $this->data['class']->course;
            $statusClass->module = $this->data['class']->module;
            $statusClass->class = $this->data['class']->id;
            $statusClass->student = $this->student;
            $statusClass->status = 1;
            /* CREATE */
            $statusClass->save();
        }
        
        private function updateStatusClass()
        {
            $statusClass = (new ClassStatus())->findById($this->data['statusClass']->id);
            $statusClass->updated_at = date('Y-m-d H:i:s');
            /* UPDATE */
            $statusClass->save();
        }
        
        private function updateLastClass()
        {
            $subscriber = (new Subscriber())->find("course = :c AND student = :s", "c={$this->data['class']->course}&s={$this->student}")->fetch();
            if ($subscriber):
                $subs = (new Subscriber())->findById($subscriber->id);
                $subs->last_class = $this->class;
                /* UPDATE */
                $subs->save();
            endif;
        }
        
        private function startTask()
        {
            $_SESSION['campusClass'] = $this->class;
            $_SESSION['campusTaskClass'] = time();
        }
        
        private function createCertificate()
        {
            $class = (new Classe())->findById($this->class);
            if ($class):
                $student = (new Student())->findById($this->student);
                $course = (new Course())->findById($class->course);
                $certificate = new Certificate();
                $certificate->course = $course->id;
                $certificate->student = $student->id;
                $certificate->status = 1;
                $certificate->cod = Helper::code();
                $certificate->save();
                /*
                 * E-MAIL
                 */
                $email = new Email();
                $message = "
                    <tr>
                        <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 24px;\">
                            <b>Parabéns, {$student->name}!</b>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"color: #333; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; padding: 20px 0 20px 0\">
                            Você concluiu o nosso treinamento de <b>{$course->title}</b> e já pode imprimir o seu certificado em nossa plataforma.
                            <br><br>
                            
                            Para imprimir o seu certificado, <a href='" . HOME . "/campus' target='_blank'>clique aqui</a>, faça o seu login e navegue até o menu <b>Certificados</b>.
                            <br><br>
                            
                            Mais uma vez <b>desejamos todo o sucesso</b> para você, {$student->name}.
                            <br><br>
                            
                            <b>ATÉ A PRÓXIMA!</b>
                        </td>
                    </tr>
                ";
                
                $email->add(
                    "Parabéns! Seu certificado foi gerado! - " . COMPANY_NAME,
                    "{$message}",
                    "{$student->name} {$student->lastname}",
                    "{$student->email}",
                    )->send();
            endif;
        }
    }
    