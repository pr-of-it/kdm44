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
    public function getSearchableItemTitle();

    /**
     * Получение лида
     *
     * @return string|null
     */
    public function getSearchableItemLead();

    /**
     * Получение URL
     *
     * @return string
     */
    public function getSearchableItemUrl(): string;
}
