<?php
class Area {
    private $conn;
    private $table_name = "areas";
    
    public $id;
    public $name;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Obtener todas las áreas
    public function getAll() {
        $query = "SELECT id, name FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Verificar si existe un área
    public function exists($id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
}