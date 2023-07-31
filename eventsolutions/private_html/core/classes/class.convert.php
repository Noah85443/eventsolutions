<?php
class convert {	   
    
    public static function toEuro(string $value) {
        $amount = new \NumberFormatter( 'nl_NL', \NumberFormatter::CURRENCY );
        return $amount->format($value);
    }
    
    public static function datumKort(string $datum) {
        return date_format(date_create($datum),"d-m-Y");
    }
        
    public static function tijdKort(string $tijd) {
        return date_format(date_create($tijd),"H:i");
    }
}