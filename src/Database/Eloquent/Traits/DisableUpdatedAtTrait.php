<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 23.09.2017
 * Time: 18:01
 */

namespace Ilnurshax\Era\Database\Eloquent\Traits;


trait DisableUpdatedAtTrait
{
    /**
     * Only for disable updating updated at column in a database
     *
     * @param mixed $value
     * @return $this
     */
    public function setUpdatedAt($value)
    {
        return $this;
    }

    public function getUpdatedAtColumn()
    {
        return null;
    }
}
