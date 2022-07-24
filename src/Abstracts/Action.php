<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 22.07.2022
 * Time: 22:11
 */

namespace App\Abstracts;


use App\Bot\Site;
use App\Helpers\RequestClient;

class Action
{
    /**
     * @var Site
     */
    private $site;


    public function __construct(Site $Site)
    {
        $this->site = $Site;
    }

    public function site()
    {
        return $this->site;
    }

    public function body(string $uri)
    {
        return (new RequestClient())->content($this->site()->page($uri));
    }


}
