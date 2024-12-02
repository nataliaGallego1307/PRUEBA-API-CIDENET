<?php
class Validator {
    public static function validateName($name) {
        return preg_match('/^[A-Z]{1,20}$/', $name);
    }

    public static function validateOtherNames($names) {
        if(empty($names)) return true;
        return preg_match('/^[A-Z ]{1,50}$/', $names);
    }

    public static function validateCountry($country) {
        return in_array($country, ['Colombia', 'Estados Unidos']);
    }

    public static function validateIdentificationNumber($number) {
        return preg_match('/^[a-zA-Z0-9-]{1,20}$/', $number);
    }

    public static function validateAdmissionDate($date) {
        $admissionDate = new DateTime($date);
        $currentDate = new DateTime();
        $minDate = (new DateTime())->modify('-1 month');
        
        return $admissionDate <= $currentDate && $admissionDate >= $minDate;
    }
}