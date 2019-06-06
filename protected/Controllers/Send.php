<?php

namespace App\Controllers;

use T4\Http\E404Exception;
use T4\Mvc\Controller;

/**
 * Class Send
 * @package App\Controllers
 */
class Send extends Controller
{
    /**
     * Обращение
     *
     * @param null $url
     * @throws E404Exception
     */
    public function actionDefault($url = null)
    {
        $this->data->query = $url;

        if ('send' === $url || 'corruption' === $url || 'collective-send' === $url) {
            switch ($url) {
                case 'send':
                    $this->data->query = 'send';
                    break;
                case 'corruption':
                    $this->data->query = 'corruption';
                    break;
                case 'collective-send':
                    $this->data->query = 'collective-send';
                    break;
            }
        } else {
            throw new E404Exception;
        }
    }
}
