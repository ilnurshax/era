<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 02.11.2017
 * Time: 8:25
 */

namespace Ilnurshax\Era\Validation;


use Illuminate\Contracts\Support\Arrayable;

class ValidationFailedMessageOneField implements Arrayable
{

    protected $messages;
    protected $status;

    public function __construct($field, $message, $status = 422)
    {
        $this->messages = [
            'message' => 'The given data was invalid.',
            'errors'  => [
                $field => [
                    $message,
                ],
            ],
        ];
        $this->status = $status;
    }

    /**
     * Make response with errors
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function response()
    {
        return response($this->messages, $this->status);
    }

    public function toArray()
    {
        return $this->messages;
    }
}
