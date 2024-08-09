<?php
    
    namespace Source\App\Admin;
    
    use League\Plates\Engine;
    use Source\Models\Admin\AdminDash;
    use Source\Models\SiteViewAgent;
    use Source\Models\SiteViewOnline;
    use Source\Models\SiteView;
    use Source\Models\Client;
    use Source\Models\Contract;
    use Source\Models\Invoice;
    use Source\Models\Billet;
    
    class Analytic
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
        
        public function index($data)
        {
            $now = date('Y-m-d H:i:s');
            $today = date('Y-m-d');
            /*
             * NUMBER RESUME
             */
            $clients = (new Client())->find();
            $contracts = (new Contract())->find("status = :s", "s=1");
            $invoices = (new Invoice())->find("status = :s", "s=2");
            $billets = (new Billet())->find();
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
            
            echo $this->template->render("system/analytics/index", [
                "numberClients" => $clients->count(),
                "numberContracts" => $contracts->count(),
                "numberInvoices" => $invoices->count(),
                "numberBillets" => $billets->count(),
                "graphic" => $graphic,
                "lastUserOnline" => $lastUsersOnline,
                "browsers" => $browsers,
                "totalViewBrowsers" => $totalViewBrowsers,
            ]);
        }
        
        public function usersOnline($data)
        {
            $now = date('Y-m-d H:i:s');
            /*
             * USERS ONLINE
             */
            $lastUsersOnline = (new SiteViewOnline())->find("endview >= :end", "end={$now}")->order("startview DESC")->fetch(true);
            
            echo $this->template->render("system/analytics/usersonline", [
                "lastUserOnline" => $lastUsersOnline
            ]);
        }
        
        public function month($data)
        {
            $postMonth = filter_input(INPUT_POST, 'search', FILTER_DEFAULT);
            $monthNow = (isset($postMonth) ? $postMonth : date('m'));
            /*
             * TOTAL VIEW/PAGES MONTH
             */
            $siteView = (new SiteView())->find("month(date) = :m", "m={$monthNow}")->order("date DESC")->fetch(true);
            $sumView = 0;
            $sumPages = 0;
            if ($siteView):
                foreach ($siteView as $sv):
                    $sumView += $sv->views;
                    $sumPages += $sv->pages;
                endforeach;
            endif;
            
            echo $this->template->render("system/analytics/listmonth", [
                "monthNow" => $monthNow,
                "totalView" => $sumView,
                "totalPages" => $sumPages,
                "views" => $siteView
            ]);
        }
    }