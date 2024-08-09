<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Ticket extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("tickets", [
                "student",
                "title",
                "uri",
                "description",
                "priority",
                "status"
            ]);
        }
    }