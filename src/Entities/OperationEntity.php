<?php

namespace App\Entities;

use App\Services\BaseService;
use App\Services\ConverterService;
use App\Services\ValidatorService;

/**
 * Operation Entity.
 *
 * @author Petyo Ruzhin
 */
abstract class OperationEntity
{
    /**
     * @var string
     */
    private $date;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var string
     */
    private $currency;
    /**
     * @var UserEntity
     */
    private $user = null;

    /**
     * @var BaseService
     */
    public $baseService = null;

    /**
     * @var ConverterService
     */
    public $converterService = null;


    public function __construct(
        $date,
        $amount,
        $currency,
        UserEntity $user
    ) {
        $this->setDate($date);
        $this->setAmount($amount);
        $this->setCurrency($currency);
        $this->setUser($user);

        $this->baseService = new BaseService();
        $this->converterService = new ConverterService();
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getUser(): UserEntity
    {
        return $this->user;
    }

    protected function setDate($date)
    {
        $this->date = date('Y-m-d', strtotime($date));
    }

    protected function setAmount($amount)
    {
        $this->amount = $amount;
    }

    protected function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    protected function setUser(UserEntity $user)
    {
        $this->user = $user;
    }
}
