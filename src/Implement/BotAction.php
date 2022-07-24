<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 22.07.2022
 * Time: 22:12
 */

namespace App\Implement;

interface BotAction
{
    public function process(): bool;
}
