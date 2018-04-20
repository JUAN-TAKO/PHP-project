<?php
    class User{
        public $id;
        public $nom;
        public $reg_date;
        public function __construct()
        {
            $this->id = 0;
            $this->nom = 'undefined';
            $this->reg_date = 0;
        }
    }
?>