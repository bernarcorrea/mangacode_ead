<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class Segment extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("segments", [
                "title",
                "uri"
            ]);
        }
    }