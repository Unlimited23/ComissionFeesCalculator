<?php

namespace App;

use App\Entities\UserEntity;

use App\Services\ValidatorService;

/**
 * Legal Person.
 *
 * @author Petyo Ruzhin
 */
class LegalPerson extends UserEntity
{
    public function __construct(
        $id,
        $defaultCf,
        $amount,
        $amountLimit,
        $operations,
        $operationsLimit
    ) {
        parent::__construct(
            $id,
            $defaultCf,
            $amount,
            $amountLimit,
            $operations,
            $operationsLimit
        );
    }

    /**
     * @param string $args[0] Date
     * @param string $args[1] Amount
     *
     * @return float The greater of either:
     *               Amount * commission fee or
     *               the amount limit
     */
    public function validate(...$args)
    {
        $amount = $args[1];

        // Calculate based on default values
        $this->setCurrCf($this->getDefaultCf());

        // Amount * commission fee
        $cf = BaseCalculator::bMultiply($amount, $this->getCurrCf());

        // No less than
        $res = ValidatorService::validateEval(
            $this->getAmountLimit(),
            [$cf, $this->getAmount()]
        );

        return $res;
    }
}
