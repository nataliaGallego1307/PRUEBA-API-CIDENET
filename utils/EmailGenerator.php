<?php
class EmailGenerator {
    public static function generateEmail($firstName, $firstSurname, $country, $id = null) {
        $domain = $country == 'Colombia' ? EMAIL_DOMAIN_CO : EMAIL_DOMAIN_US;
        $baseEmail = strtolower($firstName) . '.' . strtolower($firstSurname);
        
        if($id !== null) {
            return $baseEmail . '.' . $id . '@' . $domain;
        }
        
        return $baseEmail . '@' . $domain;
    }
}