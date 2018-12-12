<?php

namespace App\Interfaces;

/**
 * Интерфейс поиска
 *
 * Interface SearchableInterface
 * @package App\Interfaces
 */
interface SearchableInterface
{
    /**
     * Поиск по ключевым словам
     *
     * @param string $string
     * @return SearchableInterface
     */
    public static function search(string $string): SearchableInterface;

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
