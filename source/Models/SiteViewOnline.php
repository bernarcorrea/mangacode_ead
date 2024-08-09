<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;

    class SiteViewOnline extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("siteviews_online", []);
        }
    }