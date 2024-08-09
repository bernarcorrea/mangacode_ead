<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\Admin\AdminLogin;
    use Source\Models\SiteViewAgent;
    use Source\Models\SiteViewOnline;
    use Source\Models\SiteView;
    
    class Dash
    {
        private $template;
        
        public function __construct()
        {
            $this->template = Engine::create(ADMIN, FILE_EXT);
        }
        
        public function dash()
        {
            $session = new AdminDash();
            $validate = $session->checkSession();
            
            if (!$validate):
                echo $this->template->render("index");
            else:
                $now = date('Y-m-d H:i:s');
                $today = date('Y-m-d');
                /*
                 * NUMBER RESUME
                 */
                $clients = 20;
                $contracts = 20;
                $invoices = 20;
                $billets = 20;
                /*
                 * GRAPHIC HISTORY
                 */
                $graphic = (new SiteView())->find("date <= :date", "date={$today}")->order("date DESC")->limit(8)->fetch(true);
                /*
                 * USERS ONLINE
                 */
                $lastUsersOnline = (new SiteViewOnline())->find("endview >= :end", "end={$now}")->order("startview DESC")->limit(5)->fetch(true);
                /*
                 * BROWSER
                 */
                $viewBrowsers = (new SiteViewAgent())->find()->fetch(true);
                $totalViewBrowsers = 0;
                foreach ($viewBrowsers as $vb):
                    $totalViewBrowsers += $vb->views;
                endforeach;
                $browsers = (new SiteViewAgent())->find()->order("views DESC")->fetch(true);
                
                echo $this->template->render("painel", [
                    "numberClients" => $clients,
                    "numberContracts" => $contracts,
                    "numberInvoices" => $invoices,
                    "numberBillets" => $billets,
                    "graphic" => $graphic,
                    "lastUserOnline" => $lastUsersOnline,
                    "browsers" => $browsers,
                    "totalViewBrowsers" => $totalViewBrowsers,
                ]);
            endif;
        }
        
        public function login($data)
        {
            sleep(1);
            $json = [];
            unset($data['callback']);
            
            $setPost = array_map("strip_tags", $data);
            $post = array_map("trim", $setPost);
            
            $login = new AdminLogin();
            $login->setLogin($post);
            
            if (!$login->result()):
                $json['error'] = $login->error()[0];
            else:
                $json['accept'] = $login->error()[0];
                $json['redirect'] = HOME . "/admin";
                $json['time'] = 2000;
            endif;
            
            echo json_encode($json);
        }
        
        public function logout($data)
        {
            sleep(1);
            $json = [];
            unset($data['callback']);
            
            $logout = new AdminLogin();
            $logout->logout();
            if ($logout->result()):
                $json['accept'] = $logout->error()[0];
                $json['redirect'] = HOME . "/admin";
                $json['time'] = 2000;
            endif;
            
            echo json_encode($json);
        }
    }