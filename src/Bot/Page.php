<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 22.07.2022
 * Time: 23:22
 */

namespace App\Bot;


use App\Bot\Data\Description;
use App\Bot\Data\H1;
use App\Bot\Data\Keywords;
use App\Bot\Data\Title;
use App\Bot\Helpers\Elements;
use App\Bot\Helpers\Headers;
use App\Bot\Helpers\IndexedRobots;
use phpQuery;

class Page
{

    /**
     * @var \phpQueryObject|\QueryTemplatesParse|\QueryTemplatesSource|\QueryTemplatesSourceQuery
     */
    private $dom;
    /**
     * @var Elements
     */
    private $elements;
    /**
     * @var string
     */
    private $uri;

    /**
     * @var bool|null
     */
    private $indexed_robots;
    /**
     * @var Headers
     */
    private $headers;


    public function __construct(Site $site, string $uri)
    {
        $this->site = $site;
        $this->get($uri);
    }

    public function get(string $uri)
    {
        $this->uri = $uri;
        $client = $this->site->client();
        $content = $this->site->client()->content($this->url());
        $status = $client->statusCode();

        if ($status !== 200 && $status !== 404 && $status !== 302) {
            throw new \Exception('Вернулся неизвестный статус ' . $status);
        }

        $this->dom = phpQuery::newDocument($content);
        $this->elements = new Elements($this);
        $this->headers = new Headers($this, $client->headers());
    }

    public function dom()
    {
        return $this->dom;
    }

    public function title()
    {
        return $this->callback(__FUNCTION__);
    }

    public function h1()
    {
        return $this->callback(__FUNCTION__);
    }

    public function keywords()
    {
        return $this->callback(__FUNCTION__);
    }

    public function description()
    {
        return $this->callback(__FUNCTION__);
    }


    public function noindex()
    {
        return $this->callback(__FUNCTION__);
    }


    /**
     * Вернут true если страница индексируется
     * @return bool
     */
    public function indexedRobots()
    {
        if (is_null($this->indexed_robots)) {
            $this->indexed_robots = IndexedRobots::get($this->site, $this);
        }
        return $this->indexed_robots;
    }

    /**
     * Вернут true если страница разрешена индексация по отданым заголвокам индексации
     * @return bool
     */
    public function indexedHeader()
    {
        return $this->headers()->indexed();
    }

    private function callback($key)
    {
        $title = $this->elements()->{$key}();
        if (is_array($title)) {
            return $title[0];
        }
        return null;
    }

    public function elements()
    {
        return $this->elements;
    }

    public function headers()
    {
        return $this->headers;
    }

    public function uri()
    {
        return $this->uri;
    }


    /**
     * Возвращает статус разрешения индексации по 3-м параметрам
     * - с учетом запретов индексации через robots.txt
     * - headers - переданным тегам
     * - через meta тег на странице <meta name="robots" content="noindex"/>
     * @return bool
     */
    public function indexingAllowed()
    {
        $this->causes = null;
        if (!$this->indexedHeader()) {
            $this->causes[] = 'Запрет на индексацию из header';
        }

        if (!$this->indexedRobots()) {
            $this->causes[] = 'Запрет на индексацию из robots.txt';
        }

        if ($this->noindex() === 'noindex') {
            $this->causes[] = 'Запрет на индексацию из мета тега  <meta name="robots" content="noindex"/>';
        }
        if ($this->causes) {
            return false;
        }
        return true;
    }

    public function causes()
    {
        return $this->causes;
    }

    public function url()
    {
        return $this->site->page($this->uri);
    }

}
