<?php

namespace App\Models;

/**
 * Интерфейс поиска
 *
 * Interface SearchableInterface
 * @package App\Models
 */
interface SearchableInterface
{
    /**
     * Поиск по ключевым словам
     *
     * @param string $string
     */
    public static function search(string $string);

    /**
     * Получение заголовка
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Получение лида
     *
     * @return string|null
     */
    public function getLead();

    /**
     * Получение URL
     *
     * @return string|null
     */
    public function getUrl();
}
