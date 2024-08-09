<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Module extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("modules", [
                "course",
                "title",
                "uri",
                "ord"
            ]);
        }
    }