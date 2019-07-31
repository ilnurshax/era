<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 02.10.2018
 * Time: 19:38
 */

namespace Ilnurshax\Era\Database;


class Connection
{

    public const DEFAULT = 'mysql';

    /**
     * Returns the all connection names
     *
     * @return array
     */
    public static function all()
    {
        return [
            static::DEFAULT,
        ];
    }

    /**
     * Returns the connections that can be dropped
     *
     * @return array
     */
    public static function connectionsCanBeDropped()
    {
        return [
            static::DEFAULT,
        ];
    }
}
