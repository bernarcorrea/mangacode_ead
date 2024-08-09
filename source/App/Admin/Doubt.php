<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminDoubt;
    use Source\Models\Student;
    use Source\Models\Course;
    use CoffeeCode\Paginator\Paginator;
    use Source\Models\ClassDoubt;
    use Source\Models\ClassDoubtReply;
    use Source\Models\Classe;
    use Source\Models\User;
    use CoffeeCode\Cropper\Cropper;
    use Source\Support\Helper;
    
    class Doubt
    {
        private $template;
        private $user;
        
        public function __construct()
        {
            $this->template = Engine::create(ADMIN, FILE_EXT);
            
            $session = new AdminDash();
            $validate = $session->checkSession();
            if (!$validate):
                header('Location:' . HOME . "/admin");
            endif;
            
            $this->user = (new User())->findById($_SESSION['acesso']['id']);
        }
        
        public function index()
        {
            $arrDoubts = [];
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
            $doub = new ClassDoubt();
            /*
             * PAGINATOR
             */
            $paginator = new Paginator(HOME . '/admin/doubts&page=', "Página", [
                "Primeira Página",
                "Primeira"
            ], [
                "Última Página",
                "Última"
            ]);
            $paginator->pager($doub->find()->count(), 80, $page, 2);
            $doubts = $doub->find()->order("status ASC, updated_at DESC")->limit($paginator->limit())->offset($paginator->offset())->fetch(true);
            
            if ($doubts):
                foreach ($doubts as $do):
                    $do->student = (new Student())->findById($do->student);
                    $do->class = (new Classe())->findById($do->class);
                    $do->course = (new Course())->findById($do->class->course);
                    array_push($arrDoubts, $do);
                endforeach;
                
                echo $this->template->render("system/doubts/index", [
                    "doubts" => $arrDoubts,
                    "paginator" => $paginator->render(),
                ]);
            endif;
        }
        
        public function view($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/doubts');
            else:
                $doubt = (new ClassDoubt())->findById($id);
                if (!$doubt):
                    header('Location:' . HOME . '/admin/doubts');
                else:
                    $doubt->class = (new Classe())->findById($doubt->class);
                    $doubt->course = (new Course())->findById($doubt->class->course);
                    $doubt->student = (new Student())->findById($doubt->student);
                    $arrDoubtReply = [];
                    /*
                     * REPLY
                     */
                    $doubtReply = (new ClassDoubtReply())->find("doubt = :d", "d={$doubt->id}")->order("created_at ASC")->fetch(true);
                    if ($doubtReply):
                        foreach ($doubtReply as $do):
                            if ($do->author_type == 1):
                                $author = (new Student())->findById($do->author);
                                $do->author_name = $author->name . ' ' . $author->lastname;
                                $do->author_cover = (!empty($author->cover) ? $author->cover : ADMIN . '/images/user.jpg');
                            else:
                                $author = (new User())->findById($do->author);
                                $do->author_name = $author->name;
                                $do->author_cover = ADMIN . '/images/user.jpg';
                            endif;
                            array_push($arrDoubtReply, $do);
                        endforeach;
                    endif;
                    
                    echo $this->template->render("system/doubts/view", [
                        "doubt" => $doubt,
                        "doubtReply" => $arrDoubtReply
                    ]);
                endif;
            endif;
        }
        
        public function reply($data)
        {
            sleep(1);
            $json = [];
    
            $description = $data['description'];
            unset($data['description']);
    
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            $post['description'] = $description;
    
            $adminDoubt = new AdminDoubt();
            $c = new Cropper("cache");
    
            $adminDoubt->reply($post);
            if (!$adminDoubt->result()):
                $json['error'] = $adminDoubt->error();
            else:
                $json['clear'] = true;
                $json['accept'] = $adminDoubt->error();
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
    
            $adminDoubt = new AdminDoubt();
    
            $adminDoubt->resolved($post['id']);
            if (!$adminDoubt->result()):
                $json['error'] = $adminDoubt->error();
            else:
                $json['clear'] = true;
                $json['accept'] = $adminDoubt->error();
                $json['replace'] = "Status: <strong class=\"f-semibold j_replace\"><span class=\"f-green\">Resolvido</span></strong>";
            endif;
        
            echo json_encode($json);
        }
    }