<?php
/**
 * Возвращает заголовки страницы
 */

namespace App\Bot\Helpers;


use App\Bot\Page;

class Headers
{
    public function __construct(Page $page, array $headers)
    {
        $this->page = $page;
        $this->headers = $headers;
    }

    public function indexed()
    {
        if (!empty($this->headers['X-Robots-Tag'][0])) {
            $value = $this->headers['X-Robots-Tag'][0];
            $value = explode(',', $value);
            if (!empty($value)) {
                $value = array_map('trim', $value);
                $value = array_flip($value);
                if (array_key_exists('noindex', $value)) {
                    return false;
                }
            }
        }
        return true;
    }
}
