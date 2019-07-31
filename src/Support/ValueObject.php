<?php

namespace Ilnurshax\Era\Support;

abstract class ValueObject
{

    abstract public function value();

    public function __toString()
    {
        return $this->value();
    }
}
