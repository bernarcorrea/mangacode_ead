<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminSegment;
    
    class Segment
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
            $segments = (new \Source\Models\Segment())->find()->order("title ASC")->fetch(true);
            echo $this->template->render("system/segments/index", [
                "segments" => $segments
            ]);
        }
        
        public function create()
        {
            echo $this->template->render("system/segments/create");
        }
        
        public function update($data)
        {
            $id = (isset($data['id']) ? $data['id'] : false);
            if (!$id):
                header('Location:' . HOME . '/admin/segments');
            else:
                $segment = (new \Source\Models\Segment())->findById($id);
                if (!$segment):
                    header('Location:' . HOME . '/admin/segments');
                else:
                    echo $this->template->render("system/segments/update", [
                        "segment" => $segment
                    ]);
                endif;
            endif;
        }
        
        public function manager($data)
        {
            $json = [];
            sleep(1);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $id = (isset($post['id']) ? $post['id'] : false);
            $adminSegment = new AdminSegment();
            
            if ($id):
                $adminSegment->update($post, $id);
                if (!$adminSegment->result()):
                    $json['error'] = $adminSegment->error();
                else:
                    $json['accept'] = $adminSegment->error();
                endif;
            else:
                $adminSegment->create($post);
                if (!$adminSegment->result()):
                    $json['error'] = $adminSegment->error();
                else:
                    $json['accept'] = $adminSegment->error();
                    $json['redirect'] = HOME . "/admin/segments";
                    $json['time'] = 2000;
                endif;
            endif;
            
            echo json_encode($json);
        }
    }