<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;

    class SiteViewAgent extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("siteviews_agent", []);
        }
    }