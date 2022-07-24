<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 23.07.2022
 * Time: 08:33
 */

namespace App\Bot\Data;


use App\Abstracts\Data;
use App\Bot\Page;
use App\Template\Elements;

class H1 extends Data
{
    public static function get(Page $page)
    {
        return Elements::get($page->dom(), "body h1");
    }
}
