<?php
/**
 * Заменяет ссылки на битые страницы
 */

namespace App\Helpers;

use phpQuery;
use phpQueryObject;

class Finder
{
    /* @var array|null $params */
    protected $params;
    /* @var array|null $urls */
    protected $urls;
    protected $siteUrl;
    /**
     * @var phpQueryObject|\QueryTemplatesParse|\QueryTemplatesSource|\QueryTemplatesSourceQuery
     */
    private $dom;

    public function __construct()
    {
        $StatusRequestClient = new RequestClient();
        $StatusRequestClient->onRedirect(); // Включение записи редиректов

        $this->StatusRequestClient = $StatusRequestClient;
    }

    public function statusCode(string $url)
    {
        return (int)$this->StatusRequestClient->statusRedirects($url);
    }

    public function setSite(string $url)
    {
        $this->siteUrl = $url;
        return $this;
    }

    public function addParam(string $field, $value)
    {
        $this->params[$field] = $value;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }


    public function createUrl(phpQueryObject $pq)
    {
        $href = $pq->attr('href');
        $class = $pq->attr('class');
        $this->urls[] = [
            'check_url' => $this->customUrl($href),
            'class' => $class,
            'outer' => $pq->htmlOuter(),
            'status' => null
        ];
        return $this;
    }

    public function urls()
    {
        return $this->urls;
    }

    public function reset()
    {
        $this->urls = null;
        return $this;
    }

    public function createDetour($key)
    {
        $this->reset();
        $this->hash = md5($key);
        return $this;
    }

    public function find(string $content)
    {
        $this->dom = phpQuery::newDocument($content);
        foreach ($this->dom->find("a[href]") as $key => $value) {
            $pq = pq($value);
            $this->createUrl($pq);
        }
        return $this;
    }

    public function customUrl(string $url)
    {
        $first = substr($url, 0, 4);

        // Для сторонних ссылок
        if ($first === 'http') {
            $url = $url;
        } else {
            $url = $this->siteUrl . ltrim($url, '/');
            $symbol = '?';
            if (strripos($url, '?') !== false) {
                $symbol = '&';
            }
            // Ускорят процесс загрузки
            $url .= $symbol . 'fdk_no_load_content_pages=1';

        }
        $url = str_ireplace('../', '', $url);
        return $url;
    }

    public function statusUrl(int $key, int $status)
    {
        if (array_key_exists($key, $this->urls)) {
            $this->urls[$key]['status'] = $status;
            return true;
        }
        return false;
    }

    /**
     * Проверка статуса у ссылки
     */
    public function status()
    {
        $urls = $this->urls();
        if (!empty($urls)) {
            foreach ($urls as $k => $row) {
                $check_url = $row['check_url'];
                $status = $this->statusCode($check_url);
                $this->statusUrl($k, $status);
            }
        }
        return $this;

    }

    /*
     * if ($status !== 200) {
                    $isReplace = true;
                    $pq->replaceWith('<span>' . $pq->html() . '</span>');
                }
    */

    /**
     * Закрываем документ
     */
    public function closed()
    {
        phpQuery::unloadDocuments();
    }


    /*public function replace(string $content, $callback)
    {
        $isReplace = false;
        $dom = phpQuery::newDocument($content);
        foreach ($dom->find("a[href]") as $key => $value) {
            $pq = pq($value);
            $href = $pq->attr('href');
            $url = $this->customUrl($href);
            $status = $callback($url);
            if ($status !== 200) {
                $isReplace = true;
                $pq->replaceWith('<span>' . $pq->html() . '</span>');
            }
        }

        $outer = !$isReplace ? null : $dom->htmlOuter();
        phpQuery::unloadDocuments();
        return $outer;
    }
    */

    public function updateHref(int $key, string $newUrl)
    {
        return $this->update($key, 'update', $newUrl);
    }

    /*  public function replaceTag(int $key, string $tag)
      {
          return $this->update($key, 'replace', $tag);
      }*/

    public function removeUrl(int $key)
    {
        return $this->update($key, 'remove');
    }

    private function update(int $key, string $action, $str = null)
    {

        $isReplace = false;

        $url = null;
        foreach ($this->dom->find("a[href]") as $k => $item) {
            if ($k === $key) {
                $url = $item;
            }
        }

        if (!$url) {
            throw new \Exception('Не удалось найти ссылку с ключем: ' . $key);
            return false;
        }

        $pq = pq($url);
        switch ($action) {
            case 'update':
                $pq->attr('href', $str);
                break;
            case 'remove':
                #$pq->replaceWith($pq->html());
                $pq->replaceWith('<span>' . $pq->html() . '</span>');
                break;
            default:
                break;
        }
        /*foreach ($this->dom->find("a[href]") as $key => $value) {
            $pq = pq($value);
            $href = $pq->attr('href');
            $url = $this->customUrl($href);
            $status = $callback($url);
            if ($status !== 200) {
                $isReplace = true;
                $pq->replaceWith('<span>' . $pq->html() . '</span>');
            }
        }*/
        return $pq;
    }

    public function htmlOuter()
    {
        return $this->dom->htmlOuter();
    }


}
