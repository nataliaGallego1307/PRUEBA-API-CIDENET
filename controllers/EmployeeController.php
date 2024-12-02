<?php
class EmployeeController {
    private $db;
    private $employee;
    private $employeeType;
    private $area;

    public function __construct($db) {
        $this->db = $db;
        $this->employee = new Employee($db);
        $this->employeeType = new EmployeeType($db);
        $this->area = new Area($db);
    }

    public function create($data) {
        // Validar que exista el tipo de identificación
        if(!$this->employeeType->exists($data->identification_type_id)) {
            return ["error" => "Tipo de identificación inválido"];
        }

        // Validar que exista el área
        if(!$this->area->exists($data->area_id)) {
            return ["error" => "Área inválida"];
        }

        // Validaciones existentes
        if(!Validator::validateName($data->first_surname) ||
           !Validator::validateName($data->second_surname) ||
           !Validator::validateName($data->first_name) ||
           !Validator::validateOtherNames($data->other_names) ||
           !Validator::validateCountry($data->country) ||
           !Validator::validateIdentificationNumber($data->identification_number) ||
           !Validator::validateAdmissionDate($data->admission_date)) {
            return ["error" => "Datos inválidos"];
        }

        // Verificar duplicado de identificación
        $this->employee->identification_type_id = $data->identification_type_id;
        $this->employee->identification_number = $data->identification_number;
        if($this->employee->checkDuplicateIdentification()) {
            return ["error" => "Ya existe un empleado con esta identificación"];
        }

        // Generar email
        $baseEmail = EmailGenerator::generateEmail(
            $data->first_name,
            $data->first_surname,
            $data->country
        );
        
        $lastId = $this->employee->getLastEmailId($baseEmail);
        $email = $lastId > 0 ? 
            EmailGenerator::generateEmail($data->first_name, $data->first_surname, $data->country, $lastId + 1) :
            $baseEmail;

        // Asignar valores
        $this->employee->first_surname = $data->first_surname;
        $this->employee->second_surname = $data->second_surname;
        $this->employee->first_name = $data->first_name;
        $this->employee->other_names = $data->other_names;
        $this->employee->country = $data->country;
        $this->employee->email = $email;
        $this->employee->admission_date = $data->admission_date;
        $this->employee->area_id = $data->area_id;

        if($this->employee->create()) {
            return [
                "message" => "Empleado creado exitosamente",
                "email" => $email
            ];
        }

        return ["error" => "No se pudo crear el empleado"];
    }

    // Método para obtener tipos de identificación
    public function getIdentificationTypes() {
        $result = $this->employeeType->getAll();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener áreas
    public function getAreas() {
        $result = $this->area->getAll();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}