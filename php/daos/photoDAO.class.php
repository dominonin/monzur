<?php
require_once __DIR__ . "/../interfaces/CRUD.interface.php";

class photoDAO implements CRUD {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function Create($media) {
         $stmt = $this->conn->prepare("INSERT INTO photos (title, caption, year, path, type) VALUES (?,?,?,?,?);");
         return $stmt->execute(array($media->title, $media->caption, $media->year, $media->path, $media->type));
    }


    public function Update($media) {
        $stmt = $this->conn->prepare("UPDATE photos SET title = ?, caption = ?, year = ?  WHERE id = ?;");
        return $stmt->execute(array($media->title, $media->caption, $media->year, $media->id));
    }
    public function Delete($media) {
        $stmt = $this->conn->prepare("DELETE FROM photos WHERE id = ?;");
        return $stmt->execute(array($media->id));
    }

    public function getByYear($year) {
        $stmt = $this->conn->prepare("SELECT * FROM photos WHERE year = ?");
        $stmt->execute(array($year));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM photos ORDER BY position asc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getYears() {
        $stmt = $this->conn->prepare("SELECT DISTINCT year FROM photos ORDER BY year DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}