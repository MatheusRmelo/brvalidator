<?php 

namespace Matheusrmelo;

class Validator 
{
    /**
     * value Receive
     * @var string
     */
    public $value;

    /**
     * Create Instance of Class
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;    
    }

    /**
     * Make validation if value is CNPJ VALID
     * @return bool
     */
    public function validCNPJ()
    {
        $cnpj = preg_replace( '/[^0-9]/is', '', $this->value);

        if (strlen($cnpj) != 14)
            return false;
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++){
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $rest = $sum % 11;

        if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest))
            return false;

        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++){
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
    }
    
    /**
     * Make validation if value is CPF VALID
     * @return bool
     */
    public function validCPF()
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $this->value);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

}