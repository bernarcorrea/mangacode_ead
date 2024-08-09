<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class ClassStatus extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("status_classes", [
                "class",
                "student",
                "status"
            ]);
        }
    }