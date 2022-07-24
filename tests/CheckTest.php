<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 22.07.2022
 * Time: 22:23
 */

namespace Tests;

use App\Bot\Page;

class CheckTest extends TestCase
{

    public function additionProvider()
    {
        return SITES;
    }

    /**
     * @dataProvider additionProvider
     */
    public function testParser($domain, $page, $indexing, $title, $description, $keywords)
    {

        $Page = new Page($this->site($domain), $page);
        self::assertEquals($indexing, $Page->indexingAllowed());
        self::assertTrue($Page->elements()->status('title'));
        self::assertTrue($Page->elements()->status('description'));
        self::assertTrue($Page->elements()->status('keywords'));
        self::assertTrue($Page->elements()->status('h1'));


        $actual = $Page->title();
        $expected = $Page->elements()->expected($title, $actual);
        self::assertEquals($expected, $actual);

        $actual = $Page->description();
        $expected = $Page->elements()->expected($description, $actual);
        self::assertEquals($expected, $actual);

        $actual = $Page->keywords();
        $expected = $Page->elements()->expected($keywords, $actual);
        self::assertEquals($expected, $actual);
    }
}
