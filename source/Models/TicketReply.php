<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class TicketReply extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("tickets_reply", [
                "ticket",
                "author",
                "author_type",
                "description"
            ]);
        }
    }