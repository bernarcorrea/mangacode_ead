<?php
    date_default_timezone_set('America/Belem');
    /*
     * HOME ROUTER & CACHE
     */
    if ($_SERVER['HTTP_HOST'] == 'localhost'):
        define("HOME", "https://localhost/mangaead");
        define("CACHE_VERSION", time());
    else:
        define("HOME", "");
        define("CACHE_VERSION", "1.1.1");
    endif;
    
    /*
     * DATABASE CREDENTIALS
     */
    if ($_SERVER['HTTP_HOST'] == 'localhost'):
        define("DATA_LAYER_CONFIG", [
            "driver" => "mysql",
            "host" => "mariadb",
            "port" => "3306",
            "dbname" => "mangacode",
            "username" => "root",
            "passwd" => "123",
            "options" => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_CASE => PDO::CASE_NATURAL
            ]
        ]);
    else:
        define("DATA_LAYER_CONFIG", [
            "driver" => "mysql",
            "host" => "localhost",
            "port" => "3306",
            "dbname" => "",
            "username" => "",
            "passwd" => '',
            "options" => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_CASE => PDO::CASE_NATURAL
            ]
        ]);
    endif;
    
    /*
     * CSS CONSTANTS :: ERRO
     */
    define('ACCEPT', 'accept');
    define('INFO', 'info');
    define('ALERT', 'alert');
    define('ERROR', 'error');
    
    /*
     * ERROR
     */
    function error(string $description, string $error)
    {
        $title = ($error == INFO ? 'Informativo:' : ($error == ALERT ? 'Atenção:' : ($error == ERROR ? 'Ocorreu um erro:' : 'Tudo certo:')));
        $icon = ($error == INFO ? 'wink' : ($error == ALERT ? 'shocked' : ($error == ERROR ? 'sad' : 'happy')));
        
        return "
            <div class=\"trigger-box radius-m {$error}\">
                <div class=\"icon\">
                    <i class=\"icon-{$icon} f-black\"></i>
                </div>
                <header>
                    <h4 class=\"f-semibold f-black mb-5\">{$title}</h4>
                    <p class=\"f-regular f-black\">{$description}</p>
                </header>
            </div>
        ";
    }
    
    /*
     * COURSE PROGRESS
     */
    function courseProgress(int $course, int $student)
    {
        /* TOTAL DE AULAS DO CURSO */
        $classes = (new \Source\Models\Classe())->find("course = :c", "c={$course}")->count();
        if ($classes):
            /* TOTAL DE AULAS ASSISTIDAS */
            $statusClasses = (new \Source\Models\ClassStatus())->find("course = :c AND student = :s AND status = :st", "c={$course}&s={$student}&st=2")->count();
            /* CÁLCULO DE PROGRESSO */
            $calcProgress = ($statusClasses / $classes) * 100;
            $resultProgress = ($calcProgress > 99 ? substr($calcProgress, 0, 3) : substr($calcProgress, 0, 2));
            return $resultProgress;
        endif;
    }
    
    /*
     * CLASS HOURS
     */
    function classHours(int $course)
    {
        /* CURSO */
        $course = (new \Source\Models\Course())->findById($course);
        $totalTime = 0;
        
        if ($course):
            /* AULAS DO CURSO */
            $classes = (new \Source\Models\Classe())->find("course = :c", "c={$course->id}")->fetch(true);
            if ($classes):
                foreach ($classes as $class):
                    /* SOMA TEMPO DE TODAS AS AULAS */
                    $totalTime += $class->time;
                endforeach;
                
                $totalSeconds = $totalTime * 60;
                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds - ($hours * 3600)) / 60);
                
                $hours = ($hours < 10 ? '0' . $hours : $hours);
                $minutes = ($minutes < 10 ? '0' . $minutes : $minutes);
                
                return $hours . ':' . $minutes;
            endif;
        endif;
    }
    
    /*
     * THEMES
     */
    define("THEME", "themes/Default");
    define("CAMPUS", "themes/Campus");
    define("ADMIN", "themes/Dashboard");
    
    /*
     * DOMAIN & COMPANY_NAME
     */
    define("DOMAIN", "www.mangacode.com.br");
    define("COMPANY_NAME", "MangaCode");
    
    /*
     * MANGACODE CREDENTIALS
     */
    define("MANGACODE", [
        'company' => 'MangaCode - Desenvolvimento & Cursos Web',
        'cnpj' => '',
        'responsible' => 'Bernardo Araújo Corrêa'
    ]);
    
    /*
     * INCLUDE_PATH & SITE_KIT
     */
    define("INCLUDE_PATH", HOME . "/" . THEME);
    define("SITE_KIT", INCLUDE_PATH . "/images/sitekit");
    
    /*
     * URL
     */
    define("GET_URL", strip_tags(trim(filter_input(INPUT_GET, 'route', FILTER_DEFAULT))));
    define("SET_URL", (empty(GET_URL) ? '' : GET_URL));
    define("URL", explode('/', SET_URL));
    
    /*
     * SITE INFORMATIONS
     */
    define("SITE_TITLE", "MangaCode - Desenvolvimento & Cursos Web");
    define("SITE_DESC", "");
    
    /*
     * FILE VIEW EXTENSION
     */
    define("FILE_EXT", "php");
    
    /*
     * SITE CONTACT
     */
    define("ADDRESS", "");
    define("EMAIL", "");
    define("PHONE", "");
    
    /*
     * SITE SOCIAL
     */
    define('FACEBOOK', "");
    define('INSTAGRAM', "");
    define('GOOGLE', "");
    define('YOUTUBE', "");
    define('TWITTER', "");
    
    define("FACEBOOK_APP", "992137740853314");
    
    define('FACEBOOK_LINK', 'https://facebook.com/' . FACEBOOK);
    define('INSTAGRAM_LINK', 'https://instagram.com/' . INSTAGRAM);
    define('GOOGLE_LINK', 'https://plus.google.com/' . GOOGLE);
    define('YOUTUBE_LINK', 'https://youtube.com/channel/' . YOUTUBE);
    define('TWITTER_LINK', 'https://twitter.com/' . TWITTER);
    
    /*
     * MAIL CREDENTIALS
     */
    define("MAIL_SMTP", [
        "host" => "smtp.sendgrid.net",
        "port" => "465",
        "secure" => "ssl",
        "user" => "apikey",
        "pass" => "",
        "from_name" => "Suporte MangaCode",
        "from_email" => ""
    ]);
    
    define('MAIL_RECIPIENT', [
        "name" => "Bernardo Corrêa",
        "email" => ""
    ]);
    
    /*
     * EAD CONFIG
     */
    define('EAD', [
        'auto_check' => 1,
        'class_percent' => 80,
        'certificate_percent' => 80
    ]);
    
    /*
     * EAD CHECKOUT
     * hotmart | pagarme
     */
    define('EAD_CHECKOUT', 'hotmart');
    
    /*
     * HOTMART CREDENTIAS
     */
    define('HOTMART', [
        'token' => "",
        'expiration_days' => 730,
        'user_test' => [
            "email" => "",
            "document" => "",
            "cep" => "00000-000",
            "address" => "Endereço teste",
            "number" => "000",
            "district" => "Bairro teste",
            "city" => "Cidade teste",
            "state" => "Estado teste",
        ]
    ]);
    
    /*
     * LIST MOHTH
     */
    function getMonth(string $month = null)
    {
        $arrMounth = [
            '00' => 'Nenhum',
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];
        
        if (empty($month)):
            return $arrMounth;
        else:
            return $arrMounth[$month];
        endif;
    }
    
    /*
     * CLASS LEVEL
     */
    function getLevel(int $level = null)
    {
        $arr = [
            1 => 'Iniciante',
            2 => 'Intermediário',
            3 => 'Avançado'
        ];
        
        if (empty($level)):
            return $arr;
        else:
            return $arr[$level];
        endif;
    }
    
    /*
     * GENRE
     */
    function getGenre(int $genre = null)
    {
        $arr = [
            1 => 'Masculino',
            2 => 'Feminino'
        ];
        
        if (empty($genre)):
            return $arr;
        else:
            return $arr[$genre];
        endif;
    }
    
    /*
     * TICKET PRIORITY
     */
    function getTicketPriority(int $data = null)
    {
        $arr = [
            1 => 'Baixa',
            2 => 'Média',
            3 => 'Alta'
        ];
        
        if (empty($data)):
            return $arr;
        else:
            return $arr[$data];
        endif;
    }
    
    /*
     * TICKET STATUS
     */
    function getTicketStatus(int $data = null)
    {
        $arr = [
            1 => '<span class="f-silver">Aguardando resposta</span>',
            2 => '<span class="f-orange">Respondido pelo suporte</span>',
            3 => '<span class="f-red">Não resolvido</span>',
            4 => '<span class="f-green">Resolvido</span>'
        ];
        
        if (empty($data)):
            return $arr;
        else:
            return $arr[$data];
        endif;
    }
    
    /*
     * DOUBT STATUS
     */
    function getDoubtStatus(int $data = null)
    {
        $arr = [
            1 => '<span class="f-silver">Aguardando resposta</span>',
            2 => '<span class="f-orange">Respondido</span>',
            3 => '<span class="f-green">Resolvido</span>',
        ];
        
        if (empty($data)):
            return $arr;
        else:
            return $arr[$data];
        endif;
    }
    
    /*
     * SUBSCRIBER STATUS
     */
    function getSubscriberStatus(int $data = null)
    {
        $arr = [
            1 => '<span class="f-green">Ativo</span>',
            2 => '<span class="f-red">Expirado</span>'
        ];
        
        if (empty($data)):
            return $arr;
        else:
            return $arr[$data];
        endif;
    }
    
    /*
     * TYPE PAYMENT
     */
    function getTypePayment(string $data = null)
    {
        $arr = [
            "credit_card" => '<i class="icon-credit-card"></i> Cartão de crédito',
            "billet" => '<i class="icon-barcode"></i> Boleto bancário'
        ];
        
        if (empty($data)):
            return $arr;
        else:
            return $arr[$data];
        endif;
    }
    
    /*
     * STATUS PAYMENT
     */
    function getStatusPayment(string $data = null)
    {
        $arr = [
            'canceled' => '<span class="f-red">Cancelado</span>',
            'approved' => '<span class="f-green">Aprovado</span>',
            'billet_printed' => '<span class="f-primary">Boleto impresso</span>',
            'refunded' => '<span class="f-primary">Reembolsado</span>',
            'completed' => '<span class="f-green">Completo</span>',
            'expired' => '<span class="f-red">Expirado</span>',
        ];
        
        if (empty($data)):
            return $arr;
        else:
            return $arr[$data];
        endif;
    }
    
    /*
     * STATUS CLASS
     */
    function getStatusClass(string $data = null)
    {
        $arr = [
            1 => '<span class="f-silver"><i class="icon-clock"></i> Pendente</span>',
            2 => '<span class="f-green"><i class="icon-checkmark"></i> Concluído</span>'
        ];
        
        if (empty($data)):
            return $arr;
        else:
            return $arr[$data];
        endif;
    }