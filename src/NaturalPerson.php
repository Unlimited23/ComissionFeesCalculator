<?php

namespace App;

use App\Entities\UserEntity;
use App\Services\ValidatorService;

/**
 * Natural Person.
 *
 * @author Petyo Ruzhin
 */
class NaturalPerson extends UserEntity
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
     * @param string $args[0] Currency
     */
    public function validate(...$args)
    {
        $date = $args[0];
        $amount = $args[1];
        $currency = $args[2];

        // Calculate based on default values
        $res = $amount;
        $this->setCurrCf($this->getDefaultCf());

        $dateWeek = $this->getWeekByDate($date);

        // Add current amount to the computed amount
        $this->addUsedAmount($dateWeek, $amount);
        // Increment weekly operations by 1
        $this->addUsedOperations($dateWeek);

        // Operations limit
        $opLimit = ValidatorService::validateEval(
            $this->getOperationsLimit(),
            [0, $this->getOperations()],
            false
        );

        // Amount limit
        $amLimit = ValidatorService::validateEval(
            $this->getAmountLimit(),
            [0, $this->getAmount()],
            false
        );

        // Used amount
        $usam = $this->getUsedAmount($dateWeek);
        // Used operations
        $usop = $this->getUsedOperations($dateWeek);

        // Used operations limit not exceeded
        if ($usop <= $opLimit) {
            // Used amount limit not exceeded
            if ($usam <= $amLimit) {
                // Free of charge
                $this->setCurrCf(0);
            } elseif (
                BaseCalculator::bCompare(
                    BaseCalculator::bSubtract($usam, $amount),
                    $amLimit
                ) === 1
            ) { // Used amount limit already exceeded
                // Calculate based on the default (No actions required)
            } elseif (BaseCalculator::bCompare($usam, $amLimit) === 1) { // First time exceed of amount limit
                // Calculate based on the amount that is exceeded
                $res = BaseCalculator::bSubtract($usam, $amLimit);
            }
        }

        return $res;
    }

    public function addUsedAmount($dateWeek, $amount)
    {
        $this->setUsedAmount(
            $dateWeek,
            BaseCalculator::bAdd($this->getUsedAmount($dateWeek), $amount)
        );
    }

    public function addUsedOperations($dateWeek)
    {
        $this->setUsedOperations(
            $dateWeek,
            BaseCalculator::bAdd($this->getUsedOperations($dateWeek), 1)
        );
    }
}
