<?php

class Media {
    private $type;
    private $title;
    private $caption;
    private $year;
    private $id;
    private $path;

    public function __construct($mediatype, $mediatitle, $mediacaption, $mediayear, $mediaid, $mediapath) {
        $this->type = $mediatype;
        $this->title = $mediatitle;
        $this->caption = $mediacaption;
        $this->id = $mediaid;
        $this->path = $mediapath;
        $this->year = $mediayear;
    }

    public function __get($prop) {
        switch ($prop) {
            case "type":
                return $this->type;
            case "title":
                return $this->title;
            case "caption":
                return $this->caption;
            case "year":
                return $this->year;
            case "id":
                return $this->id;
            case "path":
                return $this->path;
            default: 
                throw new Exception("Not valid property");
        }
    }

    public function __set($prop, $val) {
        switch ($prop) {
            case "type":
                return $this->type = $val;
            case "title":
                return $this->title = $val;
            case "caption":
                return $this->caption = $val;
            case "year":
                return $this->year = $val;
            case "id":
                return $this->id = $val;
            case "path":
                return $this->path = $val;
            default: 
                throw new Exception("Not valid property");
        }
    }
}