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
        $Site = $this->site();
        self::assertEquals('https://' . SITE, $Site->url());
    }

    public function testPage()
    {
        $Site = $this->site();
        self::assertEquals('https://' . SITE . '/markdown/', $Site->page('/markdown/'));
    }

    public function testDomain()
    {
        self::assertEquals(SITE, $this->site()->domain());
    }

    public function testStatus()
    {
        self::assertEquals(200, $this->site()->service()->status());
    }

}
