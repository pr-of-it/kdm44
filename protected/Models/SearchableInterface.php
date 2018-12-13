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
     * @return SearchableInterface[]
     */
    public static function search(string $string): array;

    /**
     * Получение заголовка
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Получение лида
     *
     * @return string
     */
    public function getLead(): string;

    /**
     * Получение URL
     *
     * @return string
     */
    public function getUrl(): string;
}
