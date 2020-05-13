<?php

namespace App\Storage;

/**
 * Enumeration class that stores types of Users.
 *
 * @author Petyo Ruzhin
 */
abstract class UserEnum extends BaseEnum
{
    const LEGAL = 'LegalPerson';
    const NATURAL = 'NaturalPerson';
}
