<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 22.07.2022
 * Time: 23:09
 */

namespace App\Bot;


use App\Bot\Action\Url\IndexingAllowed;
use tomverran\Robot\RobotsTxt;

class SiteService
{
    /**
     * @var Site
     */
    private $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    protected function site()
    {
        return $this->site;
    }

    /**
     * Отвечает однозначно что сайт индексируется
     * @return bool|null
     */
    public function robotsIndexMain()
    {
        $res = $this->site()->robots();
        return (new RobotsTxt($res))->isAllowed('my-user-agent', '/');
    }

    /**
     * Вернет код статуса
     * @return int
     */
    public function status()
    {
        return $this->site()->client()->statusCode();
    }
}
