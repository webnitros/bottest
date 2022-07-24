## Looking

Пакет для тестирования страниц сайта и выявления проблем с индексаций и SEO заголовками

## Возможности

### Проверка индексации

```php
<?php

// Создаем сайт
$Site = new Site($domain);
//$Site->set

// Записываем User agent - опционало
$Site->setUserAgent(new UserAgent('searchBot'));
        

// Создаем страницу с указанием сайта
$Site = new Page($Site,'/about');

// Проверка статус тега title.
// - проверяет существование на странцие
// - проверяется что заголовков на странице только один тег
// - проверяется на пустату
$Page->elements()->status('title')
// вернет заголовок
$Page->title()

// Вернет true если страница разрешена к индексации 
// Проверяется robots.txt, headers, тег на странице noindex
$Page->indexingAllowed()

// Сравнение загловков     
$actual = $Page->title(); // пример: Мой блок с 2002 года
$expected = $Page->elements()->expected('Мой блок с {%} года', $actual); // вернет: Мой блок с 2002 года
// Проверяем что заголовки равны
$diff = $actual === $expected;

```

### Для mac

Утилита

```bash
brew install gh
```

Публикация нового релиза вместе с тегом через утилиту gh

```bash
gh release create "v0.0.8" --generate-notes
```

### Настройка папокыы

В phpStorm настроить "Directories" для папок

```http request
src = App\
tests = Tests\
```

## Подключения в composer.json

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/webnitros/app"
    }
  ],
  "require": {
    "webnitros/app": "^1.0.0"
  }
}
```

# phpunit

Переменные для env задаются в файле phpunit.xml
