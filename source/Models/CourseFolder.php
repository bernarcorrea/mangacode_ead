<?php
    
    namespace Source\Models;
    
    use CoffeeCode\DataLayer\DataLayer;
    
    class CourseFolder extends DataLayer
    {
        public function __construct()
        {
            parent::__construct("course_folder", [
                "title",
                "file",
                "course"
            ]);
        }
    }