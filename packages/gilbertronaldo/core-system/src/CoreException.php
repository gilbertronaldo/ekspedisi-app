<?php
/**
 * Created by PhpStorm.
 * User: gilbertronaldo
 * Date: 8/25/18
 * Time: 6:44 PM
 */

namespace GilbertRonaldo\CoreSystem;

use Exception;
use Throwable;

/**
 * Class CoreException
 * @package GilbertRonaldo\CoreSystem
 */
class CoreException extends Exception
{
    /**
     * CoreException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
