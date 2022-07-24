<?php
/**
 * Проверяет разрешеная ли индексация страницы в robots.txt
 */

namespace App\Bot\Helpers;


use App\Bot\Page;
use App\Bot\Site;
use tomverran\Robot\RobotsTxt;

class IndexedRobots
{
    /**
     * @param Site $site
     * @param Page $page
     * @param string $userAgent - можно указать USER AGENT чтобы понять если ли запрос для индексации
     * @return bool|null
     */
    public static function get(Site $site, Page $page, $userAgent = 'my-user-agent')
    {
        if ($user = $site->userAgent()) {
            $userAgent = $user->name();
        }
        return (new RobotsTxt($site->robots()))->isAllowed($userAgent, $page->uri());
    }
}
