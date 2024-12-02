// models/EmployeeType.php
<?php
class EmployeeType {
    private $conn;
    private $table_name = "employee_types";
    
    public $id;
    public $name;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Obtener todos los tipos de identificación
    public function getAll() {
        $query = "SELECT id, name FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Verificar si existe un tipo de identificación
    public function exists($id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
}