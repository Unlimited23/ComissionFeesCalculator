<?php

namespace App\Services;

/**
 * Service for validating inputs.
 *
 * @author Petyo Ruzhin
 */
class ValidatorService extends BaseService
{
    const DATE_FORMAT = 'Y-m-d';
    
    public function __construct($defaultCurrency, $conversionRates, $validCurrencies)
    {
        parent::__construct($defaultCurrency, $conversionRates, $validCurrencies);
    }

    public function validateInputs($inputs)
    {
    }

    public static function isDateValid($date)
    {
        $valid = date(self::DATE_FORMAT, strtotime($date));

        return $valid !== false;
    }

    /**
     * @desc Validates limit from input.ini
     *       The logic here is reversed:
     *       e.g In real life we say "no more than 1" which means Maximum 1 so
     *       it is intuitive to set the value of limit as "max" in the .ini file;
     *       But here we need to check if the result from the calculations is
     *       LESS than the limit and return it and for that we need the Php "min"
     *       function.
     *
     *
     * @param string $limit
     * @return string The reversed function name
     * @throws \InvalidArgumentException
     *
     */
    public static function validateLimit($limit)
    {
        switch ($limit) {
            case 'max':
                return 'min';
            case 'min':
                return 'max';
            default:
                throw new \InvalidArgumentException('Wrong configuration for limit in .ini file');
        }
    }

    public static function validateEval($limit, $arr, $validateLimit = true)
    {
        $validFunctions = ['min', 'max'];
        
        if (!in_array($limit, $validFunctions)) {
            throw new \InvalidArgumentException('Wrong configuration for limit in .ini file');
        }

        // Min or Max
        $func = $validateLimit ? self::validateLimit($limit) : $limit;

        $res = eval('return '. $func($arr) .';');

        return $res;
    }
}
