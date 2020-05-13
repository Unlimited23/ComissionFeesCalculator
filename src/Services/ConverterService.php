<?php

namespace App\Services;

use App\BaseCalculator;

/**
 * Service for converting currencies.
 *
 * @author Petyo Ruzhin
 */
class ConverterService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function convert($amount, $currency, $reversed = false)
    {
        // Different currency from the default
        if (isset($this->getConversionRates()[$currency])) {
            $curr = $this->getConversionRates()[$currency];

            if ($reversed) {
                return BaseCalculator::bMultiply($amount, $curr);
            }

            return BaseCalculator::bDivide($amount, $curr);
        }
    }
}
