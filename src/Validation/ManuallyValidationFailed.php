<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 11.09.2018
 * Time: 12:30
 */

namespace Ilnurshax\Era\Validation;


use Ilnurshax\Era\Validation\ValidationFailedMessage;

class ManuallyValidationFailed extends \Exception
{

    /**
     * @var string
     */
    private $attribute;

    /**
     * ManuallyValidationFailed constructor.
     * @param string $attribute
     * @param string $message
     */
    public function __construct(string $attribute, string $message)
    {
        $this->attribute = $attribute;

        $this->message = str_replace(":attribute", str_replace("_", ' ', $this->attribute), $message);
    }

    /**
     * Returns the Exception as a Response
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function toResponse()
    {
        return response(new ValidationFailedMessage([$this->attribute => [$this->message]]), 422);
    }

}
