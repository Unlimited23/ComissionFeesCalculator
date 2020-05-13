<?php

namespace App;

use App\Entities\UserEntity;

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

    public function validate(...$args)
    {
        $date = $args[0];
        $amount = $args[1];
        $currency = $args[2];

        // Calculate based on default values
        $res = $amount;
        $this->setCurrCf($this->getDefaultCf());

        return $res;
    }
}
