<?php

namespace AppBundle\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class ActionValidationFailedException extends ActionFailedException
{
    /**
     * @var ConstraintViolationList
     */
    protected $validationErrors;

    public function __construct(
        ConstraintViolationList $validationErrors = null,
        $message = "",
        $code = 0,
        \Exception $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->validationErrors = $validationErrors;
    }

    /**
     * @return ConstraintViolationList
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}
