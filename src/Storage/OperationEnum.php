<?php

namespace App\Storage;

/**
 * Enumeration class that stores types of Operations.
 *
 * @author Petyo Ruzhin
 */
abstract class OperationEnum extends BaseEnum
{
    const CASH_IN = 'CashInOperation';
    const CASH_OUT = 'CashOutOperation';
}
