<?php
require_once __DIR__ . "/../interfaces/CRUD.interface.php";

class accoladeDAO implements CRUD {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function Create($media) {
         $stmt = $this->conn->prepare("INSERT INTO accolades (title, caption, year, path, type) VALUES (?,?,?,?,?);");
         return $stmt->execute(array($media->title, $media->caption, $media->year, $media->path, $media->type));
    }


    public function Update($media) {
        $stmt = $this->conn->prepare("UPDATE accolades SET title = ?, caption = ?, year = ? WHERE id = ?;");
        return $stmt->execute(array($media->title, $media->caption, $media->year,  $media->id));
    }
    public function Delete($media) {
        $stmt = $this->conn->prepare("DELETE FROM accolades WHERE id = ?;");
        return $stmt->execute(array($media->id));
    }

    public function getByYear($year) {
        $stmt = $this->conn->prepare("SELECT * FROM accolades WHERE year = ?");
        $stmt->execute(array($year));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM accolades ORDER BY position asc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getYears() {
        $stmt = $this->conn->prepare("SELECT DISTINCT year FROM accolades ORDER BY year DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}