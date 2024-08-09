<?php
    
    namespace Source\App\Campus;
    
    use League\Plates\Engine;
    use Source\Models\Campus\AdminLogin;
    use Source\Models\ClassStatus;
    use Source\Models\Module;
    use Source\Models\Segment;
    use Source\Models\Student;
    use Source\Models\Subscriber;
    use Source\Models\Classe;
    use Source\Models\User;
    use CoffeeCode\Cropper\Cropper;
    use Source\Support\Helper;
    
    class Course
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
            $co = new \Source\Models\Course();
            
            /* TODOS OS CURSOS*/
            $arrCourses = [];
            $courses = $co->find("status = :s", "s=1")->order("created_at DESC")->fetch(true);
            if ($courses):
                foreach ($courses as $course):
                    $segment = (new Segment())->findById($course->segment);
                    $tutor = (new User())->findById($course->tutor);
                    $course->segment_title = $segment->title;
                    $course->tutor_name = $tutor->name;
                    array_push($arrCourses, $course);
                endforeach;
            endif;
            
            /* SUBSCRIBERS */
            $arrSubs = [];
            $subscribers = (new Subscriber())->find("student = :s", "s={$this->student->id}")->order("updated_at DESC")->fetch(true);
            if ($subscribers):
                foreach ($subscribers as $sub):
                    /* INSERE ARRAY DO CURSO DA ASSINATURA */
                    $course = $co->findById($sub->course);
                    $segment = (new Segment())->findById($course->segment);
                    $tutor = (new User())->findById($course->tutor);
                    $sub->lastcourse = $course;
                    $sub->segment = $segment->title;
                    $sub->tutor = $tutor->name;
                    
                    /* EXIBE A ÚLTIMA AULA CASO EXISTA */
                    $class = (new Classe())->find("course = :c", "c={$sub->course}")->fetch();
                    if ($class):
                        if (!empty($sub->last_class)):
                            $lastClass = (new Classe())->findById($sub->last_class);
                            if ($lastClass):
                                $sub->lastclass = $lastClass;
                            endif;
                        endif;
                    endif;
                    array_push($arrSubs, $sub);
                endforeach;
            endif;
            
            echo $this->template->render('system/courses', [
                "subscribers" => $arrSubs,
                "courses" => $arrCourses
            ]);
        }
        
        public function open($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $uri = (!empty($post['id']) ? $post['id'] : false);
            $c = new Cropper("cache");
            
            if ($uri):
                $course = (new \Source\Models\Course())->find("uri = :uri", "uri={$uri}")->fetch();
                if ($course):
                    $arrModules = [];
                    $arrProgressClass = [];
                    
                    $segment = (new Segment())->findById($course->segment);
                    $tutor = (new User())->findById($course->tutor);
                    $course->segment_title = $segment->title;
                    $course->tutor_name = $tutor->name;
                    
                    /* BUSCA MÓDULOS, AULAS E STATUS DE AULAS */
                    $modules = (new Module())->find("course = :c", "c={$course->id}")->order("ord ASC")->fetch(true);
                    if ($modules):
                        foreach ($modules as $mod):
                            $classes = (new Classe())->find("course = :c AND module = :m", "c={$course->id}&m={$mod->id}")->order("ord ASC")->fetch(true);
                            if ($classes):
                                foreach ($classes as $class):
                                    /* VERIFICA STATUS DA AULA */
                                    $statusClass = (new ClassStatus())->find("course = :c AND class = :cla AND student = :s", "c={$course->id}&cla={$class->id}&s={$this->student->id}")->fetch();
                                    if ($statusClass):
                                        $class->status_class = $statusClass->status;
                                    else:
                                        $class->status_class = 1;
                                    endif;
                                    array_push($arrProgressClass, $class);
                                endforeach;
                                $mod->classes = $classes;
                                array_push($arrModules, $mod);
                            endif;
                        endforeach;
                    endif;
                    
                    /* MODAL */
                    $json['result'] = null;
                    $json['result'] .= "
                        <div class=\"content-modal\">
                            <div class=\"modal\" id=\"modal1\">
                            <span class='close_modal btn btn-icon-medio btn-red round'><i class='icon-x'></i></span>
                                <div class=\"container radius-p bg-primary\">
                                    <div class=\"content-single-course\">
                                        <div class=\"course-title wall\" style=\"background-image: url(" . HOME . "/{$course->cover})\">
                                            <div class=\"cover\"></div>
                                            <header class=\"shadow-title\">
                                                <h1 class=\"f-white f-semibold mb-15\">{$course->title}</h1>
                                                <div class=\"course-resume flex-container flex-wrap flex-itens-center\">
                                                    <div class=\"item mr-20 flex-container\">
                                                        <i class=\"icon-user1 f-orange\"></i>
                                                        <h3 class=\"f-white f-light ml-10\">Tutor:
                                                            <strong class=\"f-semibold\">{$course->tutor_name}</strong>
                                                        </h3>
                                                    </div>
                        
                                                    <div class=\"item mr-20 flex-container\">
                                                        <i class=\"icon-link1 f-orange\"></i>
                                                        <h3 class=\"f-white f-light ml-10\">Segmento:
                                                            <strong class=\"f-semibold\">{$course->segment_title}</strong>
                                                        </h3>
                                                    </div>
                        
                                                    <div class=\"item flex-container\">
                                                        <i class=\"icon-clock f-orange\"></i>
                                                        <h3 class=\"f-white f-light ml-10\">Carga horária:
                                                            <strong class=\"f-semibold\">" . classHours($course->id) . " Horas/aula</strong>
                                                        </h3>
                                                    </div>
                        
                                                    <div class=\"flex100 bar-progress bg-primary radius-p mt-20\">
                                                        <div class=\"progress radius-p f-bold f-white\" style=\"width: " . courseProgress($course->id, $this->student->id) . "%;\">" . courseProgress($course->id, $this->student->id) . "%</div>
                                                    </div>
                                                </div>
                                            </header>
                                        </div>
                                    
                                    <div class=\"container bg-primary padding-total-normal\">
                                        <div class=\"content-last-class list-class flex-container flex-wrap\">
                    ";
                    
                    if ($arrModules):
                        foreach ($arrModules as $md):
                            $json['result'] .= "
                                <div class=\"flex100 padding-total-low radius-p bg-secondary title-mod\">
                                    <h3 class=\"subtitle-page t-upper f-secondary f-semibold\">{$md->ord} - {$md->title}</h3>
                                </div>
                            ";
                            
                            if ($md->classes):
                                foreach ($md->classes as $cl):
                                    $json['result'] .= "
                                        <article class=\"flex flex25 transition\">
                                            <a href=\"" . HOME . "/campus/aulas/{$cl->uri}\">
                                                <picture>
                                                    <source media=\"(max-width: 500px)\" srcset='" . HOME . "/" . $c->make($cl->cover, 800, 350) . "'>
                                                    " . Helper::image($c->make($cl->cover, 800, 460), $cl->title, "img radius-p") . "
                                                </picture>
                                            
                                                <div class=\"cover\"></div>
                                                <div class=\"class-check " . ($cl->status_class != 1 ? 'bg-green' : 'bg-black') . " round j_tooltip\" title=\"" . ($cl->status_class != 1 ? 'Aula concluída' : 'Aula pendente') . "\">
                                                    <i class=\"icon-" . ($cl->status_class != 1 ? 'check' : 'clock') . " f-white\"></i>
                                                </div>
                                                <div class=\"play round transition\">
                                                    <i class=\"icon-play f-orange\"></i>
                                                </div>
                                                <header class=\"shadow-title radius-p transition\">
                                                    <h1 class=\"f-white f-semibold mb-5\">{$cl->title}</h1>
                                                    <div class=\"flex-container flex-itens-center\">
                                                        <p class=\"f-orange f-light mr-10 star j_tooltip\" title=\"Nível " . getLevel($cl->level) . "\">
                                                            " . ($cl->level == 1 ? '<i class="icon-star"></i>' : ($cl->level == 2 ? '<i class="icon-star"></i><i class="icon-star"></i>' : '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>')) . "
                                                        </p>
                                                        <p class=\"f-white f-semibold\">{$cl->time} min</p>
                                                    </div>
                                                </header>
                                            </a>
                                        </article>
                                    ";
                                endforeach;
                            endif;
                        endforeach;
                    endif;
                    
                    $json['result'] .= "
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                else:
                    $json['error'] = "<b class='f-bold'>Nada encontrado:</b> O curso que você selecionou não foi encontrado.";
                endif;
            else:
                $json['error'] = "<b class='f-bold'>Erro ao processar:</b> Ocorreu um erro ao processar sua solicitação.";
            endif;
            
            echo json_encode($json);
        }
    }