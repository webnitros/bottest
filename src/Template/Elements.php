<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 23.07.2022
 * Time: 08:40
 */

namespace App\Template;


class Elements
{

    public static function get($dom, $key, $attr = false)
    {
        $arrays = null;
        foreach ($dom->find($key) as $k => $value) {
            $pq = pq($value);
            if ($attr) {
                $arrays[] = $pq->attr('content');
            } else {
                $arrays[] = $pq->text();
            }
        }
        return $arrays;
    }
}
