<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class ClassDoubtReply extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("class_doubts_reply", [
                "doubt",
                "author",
                "author_type",
                "description"
            ]);
        }
    }