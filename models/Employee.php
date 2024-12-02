// models/Employee.php
<?php
class Employee {
    private $conn;
    private $table_name = "employees";
    
    // Propiedades
    public $id;
    public $first_surname;
    public $second_surname;
    public $first_name;
    public $other_names;
    public $country;
    public $identification_type_id;
    public $identification_number;
    public $email;
    public $admission_date;
    public $area_id;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (first_surname, second_surname, first_name, other_names, 
                country, identification_type_id, identification_number, 
                email, admission_date, area_id, status)
                VALUES
                (:first_surname, :second_surname, :first_name, :other_names,
                :country, :identification_type_id, :identification_number,
                :email, :admission_date, :area_id, 'Activo')";

        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->first_surname = htmlspecialchars(strip_tags($this->first_surname));
        $this->second_surname = htmlspecialchars(strip_tags($this->second_surname));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->other_names = htmlspecialchars(strip_tags($this->other_names));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->identification_number = htmlspecialchars(strip_tags($this->identification_number));
        
        // Vincular valores
        $stmt->bindParam(":first_surname", $this->first_surname);
        $stmt->bindParam(":second_surname", $this->second_surname);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":other_names", $this->other_names);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":identification_type_id", $this->identification_type_id);
        $stmt->bindParam(":identification_number", $this->identification_number);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":admission_date", $this->admission_date);
        $stmt->bindParam(":area_id", $this->area_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function checkDuplicateIdentification() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . "
                 WHERE identification_number = :identification_number";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":identification_number", $this->identification_number);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    public function getLastEmailId($baseEmail) {
        $query = "SELECT email FROM " . $this->table_name . "
                 WHERE email LIKE :base_email
                 ORDER BY email DESC LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $baseEmailSearch = $baseEmail . "%";
        $stmt->bindParam(":base_email", $baseEmailSearch);
        $stmt->execute();
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            preg_match('/\.(\d+)@/', $row['email'], $matches);
            return isset($matches[1]) ? (int)$matches[1] : 0;
        }
        return 0;
    }
}