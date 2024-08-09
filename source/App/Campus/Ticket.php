<?php
    
    namespace Source\App\Campus;
    
    use League\Plates\Engine;
    use Source\Models\Campus\AdminTicket;
    use Source\Models\Student;
    use Source\Models\Campus\AdminLogin;
    use Source\Models\Course;
    use Source\Models\TicketReply;
    use Source\Models\User;
    use CoffeeCode\Cropper\Cropper;
    use Source\Support\Helper;
    
    class Ticket
    {
        private $template;
        private $student;
        
        public function __construct()
        {
            $this->template = Engine::create(CAMPUS, FILE_EXT);
            $adminLogin = new AdminLogin();
            $adminLogin->check();
            if (!$adminLogin->result()):
                header('Location:' . HOME . '/campus&error=notpermission');
            endif;
            
            $this->student = (new Student())->findById($_SESSION['campusmanga']['id']);
        }
        
        public function index()
        {
            $tickets = (new \Source\Models\Ticket())->find("student = :s", "s={$this->student->id}")->order("created_at DESC")->fetch(true);
            echo $this->template->render('system/tickets', [
                "tickets" => $tickets,
                "student" => $this->student
            ]);
        }
        
        public function create()
        {
            echo $this->template->render('system/newticket', [
                "student" => $this->student
            ]);
        }
        
        public function ticket($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/campus&error=notfound');
            else:
                $hash = base64_decode($id);
                parse_str($hash, $arr);
                if ($arr['tk']):
                    $ticket = (new \Source\Models\Ticket())->findById($arr['tkId']);
                    if (!$ticket):
                        header('Location:' . HOME . '/campus&error=notfound');
                    else:
                        if ($ticket->student != $this->student->id):
                            header('Location:' . HOME . '/campus&error=notpermission');
                        else:
                            $arrReplys = [];
                            $replys = (new TicketReply())->find("ticket = :t", "t={$ticket->id}")->order("created_at ASC")->fetch(true);
                            if ($replys):
                                foreach ($replys as $rl):
                                    if ($rl->author_type == 1):
                                        $rl->author_name = $this->student->name . ' ' . $this->student->lastname;
                                        $rl->author_cover = (empty($this->student->cover) ? CAMPUS . '/images/user.jpg' : $this->student->cover);
                                    else:
                                        $user = (new User())->findById($rl->author);
                                        $rl->author_name = $user->name;
                                        $rl->author_cover = CAMPUS . '/images/user.jpg';
                                    endif;
                                    array_push($arrReplys, $rl);
                                endforeach;
                                $ticket->replys = $arrReplys;
                            endif;
                            
                            echo $this->template->render('system/ticket', [
                                "ticket" => $ticket,
                                "student" => $this->student
                            ]);
                        endif;
                    endif;
                endif;
            endif;
        }
        
        public function createTicket($data)
        {
            sleep(1);
            $json = [];
            
            $desc = $data['description'];
            unset($data['description']);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            $post['description'] = $desc;
            
            $student = (new Student())->findById($post['student']);
            
            $c = new Cropper("cache");
            $adminTicket = new AdminTicket();
            
            $adminTicket->create($post);
            if (!$adminTicket->result()):
                $json['error'] = $adminTicket->error();
            else:
                $json['accept'] = $adminTicket->error();
                
                if (isset($post['ticket'])):
                    $json['replace'] = "<p class=\"subtitle-page f-primary f-light j_replace\">" . getTicketStatus(1) . "</p>";
                    $json['result2'] = '#reply' . $post['ticket'];
                    $json['reply'] = "
                        <article class=\"flex-container flex-itens-start\">
                            <div class=\"photo round\">
                                " . Helper::image($c->make((!empty($student->cover) ? $student->cover : CAMPUS . '/images/user.jpg'), 300, 300), $student->name . ' ' . $student->lastname, 'img round') . "
                            </div>
                            <header class=\"flex100\">
                                <h4 class=\"f-primary f-semibold mb-10\">{$student->name} {$student->lastname}</h4>
                                <div class=\"desc\">
                                    " . html_entity_decode($post['description']) . "
                                </div>
                                <p class=\"date f-light f-primary\">Em " . date('d/m/Y') . " às " . date('H:i') . "h</p>
                            </header>
                        </article>
                    ";
                else:
                    $hash = base64_encode("tk=true&tkId={$adminTicket->result()->id}");
                    $json['redirect'] = HOME . "/campus/tickets/t/{$hash}";
                    $json['time'] = 2000;
                endif;
            endif;
            
            echo json_encode($json);
        }
    }