<?php
    class Video{
        public $id;
        public $title;
        public $description;
        public $pub_date;
        public $channel_id;
        public $channel_name;
        public $views;

        public function __construct()
        {
            $this->id = 0;
            $this->title = 'undefined';
            $this->description = 'undefined';
            $this->pub_date = 0;
            $this->channel_id = 0;
            $this->channel_name = 'undefined';
            $this->views = 0;
        }
    }
?>