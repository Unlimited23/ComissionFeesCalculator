<?php

namespace App\Entities;

use App\BaseCalculator;
use App\Entities\Interfaces\UserInterface;

/**
 * User Entity.
 *
 * @author Petyo Ruzhin
 */
abstract class UserEntity implements UserInterface
{
    /**
     * @var int User id from configuration
     */
    private $id;

    /**
     * @var int Default commission fee from configuration
     */
    private $defaultCf;

    /**
     * @var int Current commission fee
     */
    private $currCf;

    /**
     * @var int Amount from configuration
     */
    private $amount;

    /**
     * @var int Amount limit from configuration
     */
    private $amountLimit;

    /**
     * @var int Operations from configuration
     */
    private $operations;

    /**
     * @var int Operations limit from configuration
     */
    private $operationsLimit;

    /**
     * @var array Current operations
     */
    private $usedOperations;

    /**
     * @var array Current amount
     */
    private $usedAmount;

    public function __construct(
        $id,
        $defaultCf,
        $amount,
        $amountLimit,
        $operations,
        $operationsLimit
    ) {
        $this->setId($id);
        $this->setDefaultCf($defaultCf);
        $this->setAmount($amount);
        $this->setAmountLimit($amountLimit);
        $this->setOperations($operations);
        $this->setOperationsLimit($operationsLimit);
    }

    /**
     * @desc Builds a string of
     *       full year plus the number of the week that the date is within.
     *
     * @param string $date Date string in 'Y-m-d' format.
     *
     * @return string Year + week
     */
    public function getWeekByDate($date)
    {
        return date('oW', strtotime($date));
    }

    /**
     * @desc Calculates a percentage
     * @param type $amount
     * @return type
     */
    private function div($amount)
    {
        $res = BaseCalculator::bDivide($amount, 100);

        return $res;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDefaultCf()
    {
        return $this->defaultCf;
    }

    public function getCurrCf()
    {
        return $this->currCf;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getAmountLimit()
    {
        return $this->amountLimit;
    }

    public function getOperations()
    {
        return $this->operations;
    }

    public function getOperationsLimit()
    {
        return $this->operationsLimit;
    }

    public function getUsedOperations($dateWeek)
    {
        return isset($this->usedOperations[$dateWeek]) ?
               $this->usedOperations[$dateWeek] :
               0;
    }

    public function getUsedAmount($dateWeek)
    {
        return isset($this->usedAmount[$dateWeek]) ?
               $this->usedAmount[$dateWeek] :
               0;
    }

    protected function setId($id)
    {
        $this->id = $id;
    }

    public function setDefaultCf($defaultCf)
    {
        $this->defaultCf = $this->div($defaultCf);
    }

    public function setCurrCf($currCf)
    {
        $this->currCf = $currCf;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setAmountLimit($amountLimit)
    {
        $this->amountLimit = $amountLimit;
    }

    public function setOperations($operations)
    {
        $this->operations = $operations;
    }

    public function setOperationsLimit($operationsLimit)
    {
        $this->operationsLimit = $operationsLimit;
    }

    public function setUsedOperations($dateWeek, $usedOperations)
    {
        $this->usedOperations[$dateWeek] = $usedOperations;
    }

    public function setUsedAmount($dateWeek, $usedAmount)
    {
        $this->usedAmount[$dateWeek] = $usedAmount;
    }
}
