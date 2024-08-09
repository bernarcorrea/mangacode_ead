<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Certificate extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("certificates", [
                "course",
                "student",
                "status"
            ]);
        }
    }