<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Student extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("students", [
                "name",
                "lastname",
                "document",
                "email",
                "password",
                "phone",
                "cep",
                "address",
                "number",
                "district",
                "state",
                "city"
            ]);
        }
    }