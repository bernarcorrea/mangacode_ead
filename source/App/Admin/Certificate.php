<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Student;
    use Source\Models\Course;
    use CoffeeCode\Paginator\Paginator;
    use Source\Models\Segment;
    use Source\Models\User;
    
    class Certificate
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
            $arrCert = [];
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
            $cert = new \Source\Models\Certificate();
            /*
             * PAGINATOR
             */
            $paginator = new Paginator(HOME . '/admin/certificates&page=', "Página", [
                "Primeira Página",
                "Primeira"
            ], [
                "Última Página",
                "Última"
            ]);
            
            $paginator->pager($cert->find()->count(), 80, $page,2 );
            $certificates = $cert->find()->order("created_at DESC")->limit($paginator->limit())->offset($paginator->offset())->fetch(true);
            if ($certificates):
                foreach ($certificates as $ce):
                    $ce->student = (new Student())->findById($ce->student);
                    $ce->course = (new Course())->findById($ce->course);
                    array_push($arrCert, $ce);
                endforeach;
            endif;
    
            echo $this->template->render("system/certificates/index", [
                "certificates" => $arrCert,
                "paginator" => $paginator->render(),
            ]);
        }
        
        public function view($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/certificates');
            else:
                $certificate = (new \Source\Models\Certificate())->findById($id);
                if (!$certificate):
                    header('Location:' . HOME . '/admin/certificates');
                else:
                    $certificate->student = (new Student())->findById($certificate->student);
                    $certificate->course = (new Course())->findById($certificate->course);
                    $certificate->course->segment = (new Segment())->findById($certificate->course->segment);
                    $certificate->course->tutor = (new User())->findById($certificate->course->tutor);
                    
                    echo $this->template->render("system/certificates/view", [
                        "certificate" => $certificate
                    ]);
                endif;
            endif;
        }
    }