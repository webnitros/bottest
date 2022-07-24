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
        return [
            0 => [
                'domain' => 'dev2.massive.ru',
                'page' => '/',
                'indexing' => false,
                'title' => 'Интернет-магазин светильников и люстр Fandeco. {%} по России! | Fandeco.ru в Москве',
                'description' => 'Крупнейший магазин светильников и люстр в Москве с {%} по стране. В каталоге более 100 000 товаров для освещения помещений. Доставка по всей России в магазины и пункты выдачи. Звоните и заказывайте 8 (800) 222-16-89.',
                'keywords' => 'Свет,Москва',
            ],
            1 => [
                'domain' => 'fandeco.ru',
                'page' => '/',
                'indexing' => true,
                'title' => 'Интернет-магазин люстр и светильников в Москве Fandeco | {%} по России',
                'description' => 'Крупнейший магазин светильников и люстр в Москве с {%} по стране. В каталоге более 100 000 товаров для освещения помещений. Доставка по всей России в магазины и пункты выдачи. Звоните и заказывайте 8 (800) 222-16-89.',
                'keywords' => 'Свет,Москва',
            ]
        ];
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
