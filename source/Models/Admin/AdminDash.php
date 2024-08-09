<?php
    
    namespace Source\Models\Admin;
    
    class AdminDash
    {
        public function checkSession()
        {
            if (!isset($_SESSION['acesso']['permitido'])):
                return false;
            else:
                return true;
            endif;
        }
    }