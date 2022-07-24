<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 22.07.2022
 * Time: 22:07
 */

namespace Tests\Bot;

use App\Bot\Site;
use Tests\TestCase;

class SiteTest extends TestCase
{
    public function testUrl()
    {
        $Site = new Site('bustep.ru');
        self::assertEquals('https://bustep.ru', $Site->url());
    }

    public function testPage()
    {
        $Site = new Site('bustep.ru');
        self::assertEquals('https://bustep.ru/markdown/', $Site->page('/markdown/'));
    }

    public function testDomain()
    {
        $Site = new Site('bustep.ru');
        self::assertEquals('bustep.ru', $Site->domain());
    }

    public function testStatus()
    {
        $Site = new Site('bustep.ru');
        self::assertEquals(200, $Site->service()->status());
    }

    public function testRobotsIndexMain()
    {
        $Site = new Site('bustep.ru');
        self::assertTrue($Site->service()->robotsIndexMain());
    }

    public function testRobotsNoIndexMain()
    {
        $Site = new Site('dev2.massive.ru');
        self::assertFalse($Site->service()->robotsIndexMain());
    }
}
