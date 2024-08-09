<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Classe extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("classes", [
                "course",
                "module",
                "title",
                "uri",
                "video",
                "cover",
                "time",
                "level",
                "ord"
            ]);
        }
    }