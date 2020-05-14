<?php

namespace App\Storage;

use App\Exceptions\NonExistingClassException;

/**
 * Enumeration class for reading constants of other enumeration classes.
 *
 * @author Petyo Ruzhin
 */
abstract class BaseEnum
{
    public function getConst($const)
    {
        $res = false;

        try {
            $reflectionClass = new \ReflectionClass(get_called_class());

            $res = $reflectionClass->getConstant($const);
        } catch (\ReflectionException $e) {
            throw new NonExistingClassException;
        }

        return $res;
    }
}
