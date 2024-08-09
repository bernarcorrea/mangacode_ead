<?php
    
    namespace Source\App\Web;
    
    class Home
    {
        public function home()
        {
            header('Location:' . HOME . '/campus');
        }
    }