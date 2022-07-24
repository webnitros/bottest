<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 23.07.2022
 * Time: 09:59
 */

namespace Tests\Bot\Helpers;

use App\Bot\Helpers\IndexedRobots;
use Tests\TestCase;
use tomverran\Robot\RobotsTxt;

class IndexedRobotsTest extends TestCase
{

    public function testGet()
    {
        $res = (new RobotsTxt($this->site()->robots()))->isAllowed('CopyRightCheck', '/');
        self::assertTrue($res);
    }
}
