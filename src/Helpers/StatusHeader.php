<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 08.07.2022
 * Time: 14:38
 */

namespace App;


class StatusHeader
{

    /**
     * Проверка кода ответа страницы
     * @param $url
     * @return bool|int
     */
    public static function status($url)
    {
        $StatusRequestClient = new RequestClient();
        $StatusRequestClient->onRedirect(); // Включение записи редиректов
        // Return http status code
        return (int)$StatusRequestClient->statusRedirects($url);
    }

}
