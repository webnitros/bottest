<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.07.2022
 * Time: 11:00
 */

namespace Tests\Bot\Helpers;

use App\Bot\Helpers\UserAgent;
use App\Bot\Page;
use Tests\TestCase;

class UserAgentTest extends TestCase
{

    public function testName()
    {

        $UserAgent = new UserAgent('searchBot');
        $Site = $this->site();
        $Site->setUserAgent($UserAgent);


        $Page = new Page($Site, '/');
        self::assertTrue($Page->indexedRobots());

    }
}
