<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Subscriber extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("subscribers", [
                "course",
                "student",
                "start_date",
                "end_date",
                "status"
            ]);
        }
    }