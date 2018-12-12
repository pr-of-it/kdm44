<?php

namespace App\Interfaces;

/**
 * Interface SearchableInterface
 * @package App\Interfaces
 */
interface SearchableInterface
{
    /**
     * @param string $string
     * @return mixed
     */
    public static function search(string $string);
}
