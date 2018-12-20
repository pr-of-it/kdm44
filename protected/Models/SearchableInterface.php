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
     * @param null $limit
     */
    public static function search(string $string, $limit = null);

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
     * @return string
     */
    public function getUrl(): string;
}
