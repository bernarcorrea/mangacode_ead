<?php
    
    namespace Source\Models;
    
    use Source\Models\SiteView;
    use Source\Models\SiteViewOnline;
    use Source\Models\SiteViewAgent;
    
    class Session
    {
        private $date;
        private $cache;
        private $traffic;
        private $browser;
        
        function __construct($cache = null)
        {
            session_start();
            $this->checkSession($cache);
        }
        
        //CHECK AND EXECUTE ALL METHODS
        private function checkSession($cache = null)
        {
            $this->date = date('Y-m-d');
            $this->cache = ((int)$cache ? $cache : 20);
            
            if (empty($_SESSION['useronline'])):
                $this->setTraffic();
                $this->setSession();
                $this->checkBrowser();
                $this->setUser();
                $this->browserUpdate();
            else:
                $this->trafficUpdate();
                $this->sessionUpdate();
                $this->checkBrowser();
                $this->userUpdate();
            endif;
            
            $this->date = null;
        }
        
        /*
         * USER SECTION
         */
        
        //START SESSION USER
        private function setSession()
        {
            $_SESSION['useronline'] = [
                "online_session" => session_id(),
                "online_startview" => date('Y-m-d H:i:s'),
                "online_endview" => date('Y-m-d H:i:s', strtotime("+{$this->cache}minutes")),
                "online_ip" => filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP),
                "online_url" => filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT),
                "online_agent" => filter_input(INPUT_SERVER, "HTTP_USER_AGENT", FILTER_DEFAULT)
            ];
        }
        
        //UPDATE SESSION USER
        private function sessionUpdate()
        {
            $_SESSION['useronline']['online_endview'] = date('Y-m-d H:i:s', strtotime("+{$this->cache}minutes"));
            $_SESSION['useronline']['online_url'] = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
        }
        
        /*
         * USERS, VISITES AND UPDATES
         */
        
        //CHECK AND INSERT TRAFFIC ON TABLE
        private function setTraffic()
        {
            $this->getTraffic();
            if (!$this->traffic):
                $siteViews = new SiteView();
                $siteViews->date = $this->date;
                $siteViews->users = 1;
                $siteViews->views = 1;
                $siteViews->pages = 1;
                $siteViews->save();
            else:
                $siteViews = (new SiteView())->findById($this->traffic->id);
                if (!$this->getCookie()):
                    $siteViews->users = $this->traffic->users + 1;
                    $siteViews->views = $this->traffic->views + 1;
                    $siteViews->pages = $this->traffic->pages + 1;
                else:
                    $siteViews->views = $this->traffic->views + 1;
                    $siteViews->pages = $this->traffic->pages + 1;
                endif;
                $siteViews->save();
            endif;
        }
        
        //CHECK AND UPDATE PAGEVIEWS
        private function trafficUpdate()
        {
           $this->getTraffic();
            $siteViews = (new SiteView())->find("date = :date", "date={$this->date}")->fetch(true);
            if ($siteViews):
                foreach ($siteViews as $v):
                    $views = (new SiteView())->findById($v->id);
                    $views->pages = $this->traffic->pages + 1;
                    $views->save();
                endforeach;
            endif;
            
            $this->traffic = null;
        }
        
        //GET DATA ON TABLE [ HELPER TRAFFIC ]
        private function getTraffic()
        {
            $siteViews = (new SiteView())->find("date = :date", "date={$this->date}")->fetch(true);
            if ($siteViews):
                foreach ($siteViews as $view):
                    $this->traffic = $view;
                endforeach;
            endif;
        }
        
        //CHECK, INSERT AND UPDATE USER COOKIE [ HELPER TRAFFIC ]
        private function getCookie()
        {
            $Cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
            setcookie("useronline", base64_encode("mangacode"), time() + 86400);
            if (!$Cookie):
                return false;
            else:
                return true;
            endif;
        }
        
        /*
         * BROWSERS
         */
        
        //CHECK USER BROWSER
        private function checkBrowser()
        {
            $this->browser = $_SESSION['useronline']['online_agent'];
            if (strpos($this->browser, 'Chrome')):
                $this->browser = 'Chrome';
            elseif (strpos($this->browser, 'Firefox')):
                $this->browser = 'Firefox';
            elseif (strpos($this->browser, 'MSIE') || strpos($this->browser, 'Trident/')):
                $this->browser = 'Internet Explorer';
            else:
                $this->browser = 'Outros';
            endif;
        }
        
        //UPDATE TABLE ON DATA BROWSERS
        private function browserUpdate()
        {
            $agent = new SiteViewAgent();
            $agg = $agent->find("name = :name", "name={$this->browser}")->fetch(true);
            
            if (!$agg):
                $agent->name = $this->browser;
                $agent->views = 1;
                $agent->save();
            else:
                foreach ($agg as $ag):
                    $a = (new SiteViewAgent())->findById($ag->id);
                    $a->views = $ag->views + 1;
                    $a->save();
                endforeach;
            endif;
        }
        
        /*
         * ONLINE USERS
         */
        
        //INSERT ONLINE USER ON TABLE
        private function setUser()
        {
            $userOnline = new SiteViewOnline();
            $userOnline->name = $this->browser;
            $userOnline->agent = $_SESSION['useronline']['online_agent'];
            $userOnline->session = $_SESSION['useronline']['online_session'];
            $userOnline->endview = $_SESSION['useronline']['online_endview'];
            $userOnline->ip = $_SESSION['useronline']['online_ip'];
            $userOnline->url = $_SESSION['useronline']['online_url'];
            $userOnline->save();
        }
        
        //UPDATE USER NAVIGATION ON TABLE
        private function userUpdate()
        {
            $userOnline = (new SiteViewOnline())->find("session = :ses", "ses={$_SESSION['useronline']['online_session']}")->fetch(true);
            
            foreach ($userOnline as $user):
                $u = (new SiteViewOnline())->findById($user->id);
                $u->endview = $_SESSION['useronline']['online_endview'];
                $u->url = $_SESSION['useronline']['online_url'];
                $u->save();
            endforeach;
            
            if (!$userOnline):
                $this->setUser();
            endif;
        }
    }