<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Course extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("courses", [
                "title",
                "uri",
                "subtitle",
                "segment",
                "tutor",
                "price",
                "price_billet",
                "cover",
                "certificate"
            ]);
        }
    }