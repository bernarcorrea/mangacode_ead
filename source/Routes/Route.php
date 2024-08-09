<?php
    
    namespace Source\Routes;
    
    use CoffeeCode\Router\Router;
    
    class Route
    {
        private $router;
        
        public function __construct()
        {
            $this->router = new Router(HOME);
            
            /*
             * CONTROLLERS
             */
            $this->router->namespace("Source\App\Web");
            
            /*
             * HOME
             * home
             */
            $this->router->group(null);
            $this->router->get("/", "Home:home");
            $this->router->post("/hotmart", "Hotmart:request");
            
            /*
             * ERROS
             */
            $this->router->group("ooops");
            $this->router->get("/{errcode}", "Home:error");
            
            /*
             * CAMPUS
             * dash
             */
            $this->router->group("campus")->namespace("Source\App\Campus");
            $this->router->get("/", "Dash:dash");
            $this->router->post("/changetheme", "Dash:theme");
    
            /*
            * CAMPUS
            * login / register
            */
            $this->router->get("/login", "Dash:dash");
            $this->router->get("/register", "Dash:register");
            $this->router->get("/forgot-password", "Dash:forgotPassword");
            $this->router->get("/update-password/{hash}", "Dash:updatePassword");
            $this->router->post("/login/execute", "Dash:executeLogin");
            $this->router->post("/register/execute", "Dash:executeRegister");
            $this->router->post("/logout", "Dash:executeLogout");
            $this->router->post("/forgot-password/execute", "Dash:executeForgout");
            $this->router->post("/update-password/execute", "Dash:executeUpdatePassword");
            
            /*
             * CAMPUS
             * account
             */
            $this->router->get("/minha-conta", "Account:index");
            $this->router->get("/alterar-senha", "Account:password");
            $this->router->post("/account/update", "Account:manager");
            
            /*
             * CAMPUS
             * course
             */
            $this->router->get("/meus-cursos", "Course:index");
            $this->router->post("/opencourse", "Course:open");
            $this->router->post("/meus-cursos/openhash", "Course:open");
            
            /*
             * CAMPUS
             * class
             */
            $this->router->get("/aulas/{class}", "ClassCourse:class");
            $this->router->post("/loadclass", "ClassCourse:loadClass");
            $this->router->post("/autocheck", "ClassCourse:autoCheck");
            $this->router->post("/createdoubt", "ClassCourse:createDoubt");
            $this->router->get("/download-file/{hash}", "ClassCourse:downloadFile");
            
            /*
             * CAMPUS
             * invoice
             */
            $this->router->get("/faturas", "Invoice:index");
            $this->router->get("/faturas/{id}", "Invoice:invoice");
            
            /*
             * CAMPUS
             * certificate
             */
            $this->router->get("/certificados", "Certificate:index");
            $this->router->get("/certificados/{hash}", "Certificate:view");
            
            /*
             * CAMPUS
             * ticket
             */
            $this->router->get("/tickets", "Ticket:index");
            $this->router->get("/tickets/novo-ticket", "Ticket:create");
            $this->router->get("/tickets/t/{id}", "Ticket:ticket");
            $this->router->post("/tickets/create", "Ticket:createTicket");
            
            /*
             * ADMIN
             * dash
             */
            $this->router->group("admin")->namespace("Source\App\Admin");
            $this->router->get("/", "Dash:dash");
            $this->router->post("/login", "Dash:login");
            $this->router->post("/logout", "Dash:logout");
    
            /*
             * ADMIN
             * segments
             */
            $this->router->get("/segments", "Segment:index");
            $this->router->get("/segments/create", "Segment:create");
            $this->router->get("/segments/update/{id}", "Segment:update");
            $this->router->post("/segments/manager", "Segment:manager");
            
            /*
             * ADMIN
             * courses
             */
            $this->router->get("/courses", "Course:index");
            $this->router->get("/courses/create", "Course:create");
            $this->router->get("/courses/update/{id}", "Course:update");
            $this->router->post("/courses/manager", "Course:manager");
            $this->router->post("/courses/folder/insert", "Course:folderInsert");
            $this->router->post("/courses/folder/delete", "Course:folderDelete");
    
            /*
             * ADMIN
             * modules
             */
            $this->router->get("/modules/{course}", "Module:index");
            $this->router->get("/modules/{course}/create", "Module:create");
            $this->router->get("/modules/{course}/update/{id}", "Module:update");
            $this->router->post("/modules/manager", "Module:manager");
    
            /*
             * ADMIN
             * classes
             */
            $this->router->get("/classes/{module}", "Classe:index");
            $this->router->get("/classes/{module}/create", "Classe:create");
            $this->router->get("/classes/{module}/update/{id}", "Classe:update");
            $this->router->post("/classes/manager", "Classe:manager");
    
            /*
             * ADMIN
             * students
             */
            $this->router->get("/students", "Student:index");
            $this->router->get("/students/create", "Student:create");
            $this->router->get("/students/update/{id}", "Student:update");
            $this->router->get("/students/history/{id}", "Student:history");
            $this->router->get("/students/progress/{id}/course/{course}", "Student:progress");
            $this->router->post("/students/manager", "Student:manager");
    
            /*
             * ADMIN
             * tickets
             */
            $this->router->get("/tickets", "Ticket:index");
            $this->router->get("/tickets/view/{id}", "Ticket:view");
            $this->router->post("/tickets/reply", "Ticket:reply");
            $this->router->post("/tickets/resolved", "Ticket:resolved");
    
            /*
             * ADMIN
             * invoices
             */
            $this->router->get("/invoices", "Invoice:index");
            $this->router->get("/invoices/view/{id}", "Invoice:view");
            $this->router->post("/invoices/status", "Invoice:status");
            
            /*
             * ADMIN
             * subscribers
             */
            $this->router->get("/subscribers", "Subscriber:index");
            $this->router->get("/subscribers/view/{id}", "Subscriber:view");
            $this->router->post("/subscribers/validate", "Subscriber:validate");
    
            /*
             * ADMIN
             * certificates
             */
            $this->router->get("/certificates", "Certificate:index");
            $this->router->get("/certificates/view/{id}", "Certificate:view");
    
            /*
             * ADMIN
             * doubts
             */
            $this->router->get("/doubts", "Doubt:index");
            $this->router->get("/doubts/view/{id}", "Doubt:view");
            $this->router->post("/doubts/reply", "Doubt:reply");
            $this->router->post("/doubts/resolved", "Doubt:resolved");
    
            /*
             * CRON TABS
             * notify
             */
            $this->router->group("cron")->namespace("Source\App\Cron");
            $this->router->post("/subscribers", "Cron:subscribers");
            
            $this->router->dispatch();
            
            if ($this->router->error()):
                $this->router->redirect("/ooops/{$this->router->error()}");
            endif;
            
        }
    }