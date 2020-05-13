<?php

namespace App\Storage;

/**
 * Enumeration class for reading constants of other enumeration classes.
 *
 * @author Petyo Ruzhin
 */
abstract class BaseEnum
{
    public function getConst($const)
    {
        $res = '';

        try {
            $reflectionClass = new \ReflectionClass(get_called_class());

            $res = $reflectionClass->getConstant($const);
        } catch (Exception $e) {
            throw new Exception('No such class found');
        }

        return $res;
    }
}
