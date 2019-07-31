<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 02.11.2017
 * Time: 8:25
 */

namespace Ilnurshax\Era\Validation;

use Illuminate\Contracts\Support\Arrayable;

class ValidationFailed implements Arrayable
{

    protected $messages;
    protected $status;

    public function __construct($status = 422)
    {
        $this->status = $status;
    }

    /**
     * Prepare a message bug for one input and one message by this input
     *
     * @param $field
     * @param $message
     * @return $this
     */
    public function one($field, $message)
    {
        $this->many([$field => [$message]]);

        return $this;
    }

    /**
     * Prepare a message bug for many error messages and inputs
     *
     * @param $errors
     * @return $this
     */
    public function many($errors)
    {
        $this->messages = [
            'message' => 'The given data was invalid.',
            'errors'  => $errors
        ];

        return $this;
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

    /**
     * Returns error messages as array
     *
     * @return mixed
     */
    public function toArray()
    {
        return $this->messages;
    }
}
