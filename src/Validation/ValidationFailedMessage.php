<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 02.11.2017
 * Time: 8:25
 */

namespace Ilnurshax\Era\Validation;


use Illuminate\Contracts\Support\Arrayable;

class ValidationFailedMessage implements Arrayable
{

    protected $messages;
    protected $status;

    public function __construct(array $errors, $status = 422)
    {
        $this->messages = [
            'message' => 'The given data was invalid.',
            'errors'  => $errors
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
