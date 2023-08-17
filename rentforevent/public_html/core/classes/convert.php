<?php
class convert
{
    public static function prijs($bruto, $btw)
    {
        $netto = $bruto * (1 + ($btw / 100));
        $amount = new \NumberFormatter('nl_NL', \NumberFormatter::CURRENCY);
        return $amount->format($netto);
    }

    public static function toEuro($value)
    {
        $amount = new \NumberFormatter('nl_NL', \NumberFormatter::CURRENCY);
        return $amount->format($value);
    }
}
?>