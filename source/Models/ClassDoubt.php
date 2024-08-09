<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class ClassDoubt extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("class_doubts", [
                "class",
                "student",
                "description"
            ]);
        }
    }