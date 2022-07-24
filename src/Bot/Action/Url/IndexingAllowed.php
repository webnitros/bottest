<?php
/**
 * Проверяет разрешена ли индексация
 */

namespace App\Bot\Action\Url;


use App\Abstracts\Action;
use App\Implement\BotAction;
use \tomverran\Robot\RobotsTxt;

class IndexingAllowed extends Action implements BotAction
{
    public function process(): bool
    {
        $res = $this->site()->robots();
        return (new RobotsTxt($res))->isAllowed('my-user-agent', '/');
    }
}
