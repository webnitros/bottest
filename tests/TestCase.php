<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.03.2021
 * Time: 22:49
 */

namespace Tests;

use App\Bot\Site;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class TestCase extends MockeryTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function site($domain = SITE)
    {
        return new Site($domain);
    }
}
