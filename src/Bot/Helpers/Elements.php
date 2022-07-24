<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 23.07.2022
 * Time: 09:01
 */

namespace App\Bot\Helpers;


use App\Bot\Data\Description;
use App\Bot\Data\H1;
use App\Bot\Data\Keywords;
use App\Bot\Data\NoIndex;
use App\Bot\Data\Title;
use App\Bot\Page;

class Elements
{
    private $title;
    private $description;
    private $h1;
    private $keywords;
    private $noindex;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function title()
    {
        if (is_null($this->title)) {
            $this->title = Title::get($this->page);
        }
        return $this->title;
    }

    public function h1()
    {
        if (is_null($this->h1)) {
            $this->h1 = H1::get($this->page);
        }
        return $this->h1;
    }

    public function description()
    {
        if (is_null($this->description)) {
            $this->description = Description::get($this->page);
        }
        return $this->description;
    }

    public function keywords()
    {
        if (is_null($this->keywords)) {
            $this->keywords = Keywords::get($this->page);
        }
        return $this->keywords;
    }

    public function noindex()
    {
        if (is_null($this->noindex)) {
            $this->noindex = NoIndex::get($this->page);
        }
        return $this->noindex;
    }

    public function status($key)
    {
        $values = $this->$key();
        if (!is_array($values)) {
            return 'тег "' . $key . '" на странице не найден';
        }
        if (count($values) > 1) {
            return 'Массив "' . $key . '" содержит больше двух значений';
        }
        $value = trim($values[0]);
        if (empty($value)) {
            return 'Вернулось пустое значение в теге "' . $key . '"';
        }
        return true;
    }


    /**
     * Вернет true если строки совпадают
     * @param $expected
     * @param $actual
     * @return bool
     */
    public function diff($expected, $actual)
    {
        return $this->expected($expected) === $actual;
    }

    /**
     * Вернет true если строки совпадают
     * @param $expected
     * @param $actual
     * @return bool
     */
    public function expected($expected, $actual)
    {
        $array = explode('{%}', $expected);
        if (count($array) == 2) {
            $sep = $actual;
            foreach ($array as $item) {
                $sep = str_ireplace($item, '', $sep);
            }
            $expected = str_ireplace('{%}', $sep, $expected);

        }
        return $expected;
    }

}
