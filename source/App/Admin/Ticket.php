<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use CoffeeCode\Paginator\Paginator;
    use Source\Models\Admin\AdminTicket;
    use Source\Models\Student;
    use Source\Models\TicketReply;
    use Source\Models\User;
    use CoffeeCode\Cropper\Cropper;
    use Source\Support\Helper;
    
    class Ticket
    {
        private $template;
        
        public function __construct()
        {
            $this->template = Engine::create(ADMIN, FILE_EXT);
            
            $session = new AdminDash();
            $validate = $session->checkSession();
            if (!$validate):
                header('Location:' . HOME . "/admin");
            endif;
        }
        
        public function index()
        {
            $arrTickets = [];
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
            $tick = new \Source\Models\Ticket();
            /*
             * PAGINATOR
             */
            $paginator = new Paginator(HOME . '/admin/tickets&page=', "Página", [
                "Primeira Página",
                "Primeira"
            ], [
                "Última Página",
                "Última"
            ]);
            $paginator->pager($tick->find()->count(), 80, $page, 2);
            $tickets = $tick->find()->order("created_at DESC")->limit($paginator->limit())->offset($paginator->offset())->fetch(true);
            foreach ($tickets as $t):
                $student = (new Student())->findById($t->student);
                $t->student_name = $student->name . ' ' . $student->lastname;
                array_push($arrTickets, $t);
            endforeach;
            
            echo $this->template->render("system/tickets/index", [
                "tickets" => $arrTickets,
                "paginator" => $paginator->render()
            ]);
        }
        
        public function view($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/tickets');
            else:
                $ticket = (new \Source\Models\Ticket())->findById($id);
                if (!$ticket):
                    header('Location:' . HOME . '/admin/tickets');
                else:
                    $arrTicketReply = [];
                    $student = (new Student())->findById($ticket->student);
                    /*
                     * REPLY
                     */
                    $ticketReply = (new TicketReply())->find("ticket = :t", "t={$ticket->id}")->order("created_at ASC")->fetch(true);
                    if ($ticketReply):
                        foreach ($ticketReply as $tr):
                            if ($tr->author_type == 1):
                                $author = (new Student())->findById($tr->author);
                                $tr->author_name = $author->name . ' ' . $author->lastname;
                                $tr->author_cover = (!empty($author->cover) ? $author->cover : ADMIN . '/images/user.jpg');
                            else:
                                $author = (new User())->findById($tr->author);
                                $tr->author_name = $author->name;
                                $tr->author_cover = ADMIN . '/images/user.jpg';
                            endif;
                            array_push($arrTicketReply, $tr);
                        endforeach;
                    endif;
                    
                    echo $this->template->render("system/tickets/view", [
                        "ticket" => $ticket,
                        "student" => $student,
                        "ticketReply" => $arrTicketReply
                    ]);
                endif;
            endif;
        }
        
        public function reply($data)
        {
            $json = [];
            sleep(1);
            
            $description = $data['description'];
            unset($data['description']);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            $post['description'] = $description;
            
            $ticket = $post['ticket'];
            $adminTicket = new AdminTicket();
            $c = new Cropper("cache");
            
            $adminTicket->reply($post, $ticket);
            if (!$adminTicket->result()):
                $json['error'] = $adminTicket->error();
            else:
                $json['clear'] = true;
                $json['accept'] = $adminTicket->error();
                $json['result'] = "
                    <article class=\"mb-50 j_new\">
                        <div class=\"photo\">
                            " . Helper::image($c->make(ADMIN . '/images/user.jpg', 800, 800), "", "img round") . "
                        </div>
                        <header>
                            <div class=\"details pb-10 mb-10\">
                                <p class=\"f-black f-light mr-30\">Por:
                                    <strong class=\"f-semibold\">{$_SESSION['acesso']['nome']}</strong>
                                </p>
                                <p class=\"f-black f-light\">Enviado em:
                                    <strong class=\"f-semibold\">" . date('d/m/Y H:i') . "</strong>
                                </p>
                            </div>
                            <div class=\"text\">".html_entity_decode($post['description'])."</div>
                        </header>
                    </article>
                ";
            endif;
            
            echo json_encode($json);
        }
        
        public function resolved($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $adminTicket = new AdminTicket();
            
            $adminTicket->resolved($post['id']);
            if (!$adminTicket->result()):
                $json['error'] = $adminTicket->error();
            else:
                $json['clear'] = true;
                $json['accept'] = $adminTicket->error();
                $json['replace'] = "Status: <strong class=\"f-semibold j_replace\"><span class=\"f-green\">Resolvido</span></strong>";
            endif;
            
            echo json_encode($json);
        }
    }