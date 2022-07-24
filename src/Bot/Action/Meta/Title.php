<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 22.07.2022
 * Time: 23:17
 */

namespace App\Bot\Action\Meta;


use App\Abstracts\Action;
use App\Implement\BotAction;

class Title extends Action implements BotAction
{

    public function process(): bool
    {
        $value = $this->value();
        $this->site()->robots();
        return false;
    }
}
