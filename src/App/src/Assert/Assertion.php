<?php
declare(strict_types=1);

namespace App\Assert;

use Assert\Assertion as BaseAssertion;

/**
 * Subclass of upstream Assertion class to protect against BC breaks and allow customisations
 */
class Assertion extends BaseAssertion
{
    protected static $exceptionClass = 'Assert\InvalidArgumentException';
}
