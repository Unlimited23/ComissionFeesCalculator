<?php

namespace App;

use App\Storage\UserEnum;
use App\Storage\OperationEnum;
use App\Storage\UserStorage;

use App\Services\FileService;
use App\Services\ValidatorService;

use App\Entities\OperationEntity;

/**
 * Commission fees calculator.
 *
 * @author Petyo Ruzhin
 */
class CFCalculator
{
    /**
     * @var array Data from the input.csv file.
     */
    private $data = null;

    /**
     *
     * @var array Data from the input.ini file.
     */
    private $config = null;

    /**
     * @var OperationEntity
     */
    private $operations = null;

    /**
     * @var UserStorage
     */
    private $userStorage = null;

    
    public function __construct()
    {
        $this->setData(FileService::readDataInput());
        $this->setConfig(FileService::readConfigInput());
        
        $this->setUserStorage(new UserStorage());
    }

    public function init()
    {
        $data = $this->getData();

        // Valid Currencies
        $vc =   isset($this->getConfig()['ValidCurrencies']) ?
                $this->getConfig()['ValidCurrencies'] :
                [];

        // Validator Service
        $vs = new ValidatorService(null, null, $vc);

        // Calculated commission fees
        $cfs = [];

        foreach ($data as $k => $prop) {
            if (!$vs->validateInputs($prop)) {
            }
            /**
             * @var OperationEntity Operation
             */
            $operation = $this->createOperation($prop);

            if (!is_null($operation)) {
                $cfs[] = $this->round(
                    $operation->calculate(),
                    $operation->getCurrency()
                );
            }
        }

        return $cfs;
    }

    /**
     * @param array $prop
     *        $prop[0] => Date,
     *        $prop[1] => User id,
     *        $prop[2] => User type,
     *        $prop[3] => Operation type,
     *        $prop[4] => Amount,
     *        $prop[5] => Currency,
     *
     * @return CashInOperation|CashOutOperation New class instance
     */
    private function createOperation($prop)
    {
        $oClass = null;

        // Type of operation
        $oper = mb_strtoupper($prop[3]);

        // If such const exists
        if (OperationEnum::getConst($oper) !== '') {
            /**
             * @var OperationEntity Operation
             */
            $operClass = 'App\\'. OperationEnum::getConst($oper);

            try {
                if (class_exists($operClass)) {
                    $user = $this->createUser($prop[1], $prop[2], $oper);

                    if (!is_null($user)) {
                        $oClass = new $operClass(
                            $prop[0],
                            $prop[4],
                            $prop[5],
                            $user
                        );
                    }
                }
            } catch (Exception $e) {
                throw new Exception('No such class found');
            }
        }

        return $oClass;
    }

    /**
     * @desc Creates a new user.
     *
     * @param type $userId
     * @param type $userType
     * @param type $oper
     *
     * @return NaturalPerson|LegalPerson
     */
    private function createUser($userId, $userType, $oper)
    {
        $uClass = $conf = null;
        $defaultCf = $amountLimit = $operationsLimit = null;

        // If such const exists
        if (UserEnum::getConst(mb_strtoupper($userType)) !== '') {
            /**
             * @var OperationEntity Operation
             */
            $userClass = 'App\\'. UserEnum::getConst(mb_strtoupper($userType));

            if (class_exists($userClass) &&
                isset($this->getConfig()[$oper][$userType])
            ) {
                $conf = $this->getConfig()[$oper][$userType];
                    
                $defaultCf = isset($conf['default-cf']) ? $conf['default-cf'] : 0;
                $amount = isset($conf['amount']) ? $conf['amount'] : 0;
                $amountLimit = isset($conf['amount-limit']) ? $conf['amount-limit'] : null;
                $operations = isset($conf['operations']) ? $conf['operations'] : 0;
                $operationsLimit = isset($conf['operations-limit']) ? $conf['operations-limit'] : null;

                /** @var UserEntity $user */
                $user = $this->getUserStorage()->getUser($userId);

                // Get user from UserStorage
                if ($user !== false) {
                    // Setting properties in case operation type has changed
                    $user->setDefaultCf($defaultCf);
                    $user->setAmount($amount);
                    $user->setAmountLimit($amountLimit);
                    $user->setOperations($operations);
                    $user->setOperationsLimit($operationsLimit);

                    $uClass = $user;
                } else {
                    // Create new user
                    $uClass = new $userClass(
                                $userId,
                                $defaultCf,
                                $amount,
                                $amountLimit,
                                $operations,
                                $operationsLimit
                            );
                    // Save it to the UserStorage
                    $this->getUserStorage()->setUser($userId, $uClass);
                }
            }
        }

        return $uClass;
    }

    /**
     * @desc Rounds the amount to the precision of the selected currency.
     *
     * @param float $amount
     * @param string $currency
     *
     * @return string Rounded amount
     */
    public function round($amount, $currency)
    {
        // Default precision
        $dp = $this->getConfig()['DefaultPrecision'][$currency];

        if ($dp == 0) {
            // Straightforward - round to the upper bound and format with precision.
            return number_format(ceil($amount), $dp, '.', '');
        }

        // Precision multiplier
        $precMul = BaseCalculator::bPow(10, $dp);

        // Removing the decimal part and then rounding to the upper bound
        $amount = ceil(BaseCalculator::bMultiply($amount, $precMul));
        // Returning the decimal part and then formatting with precision.
        return number_format(BaseCalculator::bDivide($amount, $precMul), $dp, '.', '');
    }

    public function getData()
    {
        return $this->data;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getOperations(): OperationEntity
    {
        return $this->operations;
    }

    public function getUserStorage(): UserStorage
    {
        return $this->userStorage;
    }

    private function setData($data)
    {
        $this->data = $data;
    }

    private function setConfig($config)
    {
        $this->config = $config;
    }

    private function setOperations(OperationEntity $operations)
    {
        $this->operations = $operations;
    }

    private function setUserStorage($userStorage)
    {
        $this->userStorage = $userStorage;
    }
}
