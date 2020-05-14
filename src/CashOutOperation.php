<?php

namespace App;

use App\Services\ValidatorService;

use App\Entities\UserEntity;
use App\Entities\OperationEntity;
use App\Entities\Interfaces\OperationInterface;

/**
 * Cash out operation
 *
 * @author Petyo Ruzhin
 */
class CashOutOperation extends OperationEntity implements OperationInterface
{
    public function __construct($date, $amount, $currency, UserEntity $user)
    {
        parent::__construct($date, $amount, $currency, $user);
    }

    /**
     * @desc For cash out operation the calculation of the commission fee is
     *       user dependant so we do $user->validate() which applies user
     *       specific rules.
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

        // User specific validation
        $cfRes = $user->validate(
            $this->getDate(),
            $amount
        );

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
