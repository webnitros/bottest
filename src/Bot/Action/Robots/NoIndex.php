<?php
/**
 * Запрет индексации всего сайта
 */

namespace App\Bot\Action\Robots;


use App\Abstracts\Action;
use App\Helpers\Finder;
use App\Helpers\RequestClient;
use App\Implement\BotAction;

class NoIndex extends Action implements BotAction
{
    public function process(): bool
    {
        $body = $this->body('robots.txt');
        $arrays = explode(PHP_EOL, $body);
        if ($arrays[0] === 'User-Agent:*' && $arrays[1] === 'Disallow: /') {
            return true;
        }
        return false;
    }

    public function error()
    {
        return 'Сайт разрешен к индексации';
    }

    public function hint()
    {
        return 'В файл robots.txt необходимо добавить' . PHP_EOL . 'User-Agent:*' . PHP_EOL . 'Disallow: /';
    }
}
