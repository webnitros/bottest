<?php
/**
 * Создание нового сайта
 */

namespace App\Bot;


use App\Bot\Helpers\UserAgent;
use App\Helpers\RequestClient;

class Site
{
    /**
     * @var string
     */
    private $domain;
    /**
     * @var bool|mixed
     */
    private $https;
    /**
     * @var RequestClient
     */
    private $client;
    /**
     * @var string|null
     */
    private $robots;
    /**
     * @var SiteService
     */
    private $service;
    /**
     * @var UserAgent
     */
    private $userAgent;

    public function __construct(string $domain, $https = true)
    {
        $this->domain = $domain;
        $this->https = $https;

        $this->client = new RequestClient([
            'base_uri' => $this->url(),
            'verify' => $https
        ]);

        if ($this->client->ping('/') !== 200) {
            throw new \Exception('Статус код сайта не равно 200. Тестирование не будет проводиться');
        }
        $this->service = new SiteService($this);
    }

    public function setUserAgent(UserAgent $userAgent)
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    public function userAgent()
    {
        return $this->userAgent;
    }

    public function domain()
    {
        return $this->domain;
    }

    public function url()
    {
        $protocol = $this->https ? 'https' : 'http';
        return $protocol . '://' . $this->domain;
    }

    public function page(string $uri)
    {
        $uri = ltrim($uri, '/');
        return $this->url() . '/' . $uri;
    }

    public function client()
    {
        return $this->client;
    }

    public function robots()
    {
        if (is_null($this->robots)) {
            $this->robots = $this->client()->content($this->page('robots.txt'));
        }
        return $this->robots;
    }

    public function service()
    {
        return $this->service;
    }
}
