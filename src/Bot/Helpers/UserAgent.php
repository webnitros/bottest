<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.07.2022
 * Time: 10:56
 */

namespace App\Bot\Helpers;


class UserAgent
{

    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }
}
