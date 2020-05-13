<?php

namespace App;

use App\Services\ValidatorService;
use App\Entities\UserEntity;
use App\Entities\OperationEntity;

/**
 * Cash in operation.
 *
 * @author Petyo Ruzhin
 */
class CashInOperation extends OperationEntity
{
    public function __construct($date, $amount, $currency, UserEntity $user)
    {
        parent::__construct($date, $amount, $currency, $user);
    }

    /**
     * @desc For cash in operation the calculation of the commission fee is not
     *       user dependant.
     *
     * @return float Calculated commission fee.
     */
    public function calculate()
    {
        $user = $this->getUser();

        $amount = $this->getAmount();

        // Operation currency != Default currency
        $needsConvert = !isset($this->baseService->getDefaultCurrency()[$this->getCurrency()]);

        if ($needsConvert) {
            // Convert the amount to desired currency
            $amount = $this->converterService->convert(
                $amount,
                $this->getCurrency()
            );
        }

        // Commission fee
        $cf = BaseCalculator::bMultiply($amount, $user->getDefaultCf());

        // No more than
        $cfRes = ValidatorService::validateEval(
            $user->getAmountLimit(),
            [$cf, $user->getAmount()]
        );

        //
        if ($needsConvert) {
            // Reverse the conversion back to default currency.
            $cfRes = $this->converterService->convert(
                $cfRes,
                $this->getCurrency(),
                true
            );
        }

        return $cfRes;
    }
}
