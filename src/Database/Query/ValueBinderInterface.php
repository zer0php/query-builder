<?php

namespace Zero\Database\Query;

/**
 * Interface ValueBinderInterface
 * @package Zero\Database\Query
 */
interface ValueBinderInterface
{
    /**
     * @param $key
     * @param $value
     * @param string $type [optional] default: string
     */
    public function bind($key, $value, $type = 'string');

    /**
     * @param $key
     * @return string|null
     */
    public function getPlaceholder($key);

    /**
     * @param $key
     * @return mixed|null
     */
    public function getValue($key);
}