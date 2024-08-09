<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Invoice extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("invoices", [
                "course",
                "student",
                "price",
                "method_pay",
                "status_pay",
            ]);
        }
    }