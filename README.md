# Throttle
Компонент служит для ограничения количества запросов/операций за единицу времени.

## Конфигурация
|Имя|     Тип|       Описание| Значение по-умолчанию|
|:-------:|:---:|:--------------:|:---------------------:|
|type|string| Тип хранилища |Redis

## Пример использования

```php
$pool = $this->app->factory('Throttle');
$user = $pool->item('user.' . $userId)->setCallback(function (Item $item) use ($userId) {
  $item
  ->expiresAfter(60 * 60 * 24)
  ->set(getUserFromDatabase($userId))
  ->save();
})->get();
```
