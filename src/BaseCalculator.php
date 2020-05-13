<?php

namespace App;

/**
 * Basic math operations.
 *
 * @author Petyo Ruzhin
 */
class BaseCalculator
{
    /**
     * @var int Initially set to 14 places after the decimal separator
     */
    const SCALE = 14;

    /**
     * @desc Basic add
     *
     * @param string $leftAmount
     * @param string $rightAmount
     *
     * @return string The sum of the two operands, as a string.
     */
    public function bAdd($leftAmount, $rightAmount)
    {
        return bcadd($leftAmount, $rightAmount, self::SCALE);
    }

    /**
     * @desc Basic compare
     *
     * @param string $leftAmount
     * @param string $rightAmount
     *
     * @return int 0 if the two operands are equal, =
     *             1 if the $leftAmount is larger than the $rightAmount, >
     *             -1 otherwise. <
     */
    public function bCompare($leftAmount, $rightAmount)
    {
        return bccomp($leftAmount, $rightAmount, self::SCALE);
    }

    /**
     * @desc Basic subtract
     *
     * @param $leftAmount
     * @param $rightAmount
     *
     * @return The result of the subtraction, as a string.
     */
    public function bSubtract($leftAmount, $rightAmount)
    {
        return bcsub($leftAmount, $rightAmount, self::SCALE);
    }

    /**
     * @desc Basic multiply
     *
     * @param string $leftAmount
     * @param string $rightAmount
     *
     * @return string
     */
    public function bMultiply($leftAmount, $rightAmount)
    {
        return bcmul($leftAmount, $rightAmount, self::SCALE);
    }

    /**
     * @desc Basic divide
     *
     * @param string $leftAmount
     * @param string $rightAmount
     *
     * @return string the result of the division as a string,
     *         or NULL if $rightAmount is 0.
     */
    public function bDivide($leftAmount, $rightAmount)
    {
        return bcdiv($leftAmount, $rightAmount, self::SCALE);
    }

    /**
     * @desc Basic to the power of
     *
     * @param string $leftAmount
     * @param string $rightAmount
     *
     * @return string the result as a string
     */
    public function bPow($leftAmount, $rightAmount)
    {
        return bcpow($leftAmount, $rightAmount, self::SCALE);
    }
}
