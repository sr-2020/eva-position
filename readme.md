[![Build Status](https://travis-ci.org/gurkalov/eva-position.svg?branch=master)](https://travis-ci.org/gurkalov/eva-position)
# Eva Position Platform

Swagger OpenAPI 3 documentaton: http://position.evarun.ru/api/documentation

- [Пользователи](#users)
	- [Регистрация](#registration)
	- [Авторизация](#authorization)
	- [Авторизационный токен](#authtoken)
	- [Профиль](#profile)
	- [Список пользователей с местоположением и статусами](#usersList)
- [Позиционирование](#position)
	- [Маячки](#beacons)
	- [Локации](#locations)
	- [Отправка слышимости маячков](#positions)
	- [Пути](#paths)

## <a name="users"></a> Пользователи
#### <a name="registration"></a> Регистрация
Регистрация осуществляется через POST запрос на http://position.evarun.ru/api/v1/register

Тело запроса:
```
{
  "email": "example@example.com",
  "password": "hunter2",
  "name": "John Doe"
}
```
Тело ответа:
```
{
  "id": 1,
  "api_key": "MmVDellSdUpKa0h5MFBDdjN1QnlVbEVC"
}
```

Пример:
```
curl -X POST "http://position.evarun.ru/api/v1/register" -H "Content-Type: application/json" -d "{\"email\":\"example@example.com\",\"password\":\"hunter2\",\"name\":\"John Doe\"}"
```


#### <a name="authorization"></a> Авторизация
Авторизация осуществляется через POST запрос на http://position.evarun.ru/api/v1/login

Тело запроса:
```
{
  "email": "example@example.com",
  "password": "hunter2"
}
```
Тело ответа:
```
{
  "id": 1,
  "api_key": "MmVDDllSdUpKa0h5MFBDdjN1QnlVbEVC"
}
```

Пример:
```
curl -X POST "http://position.evarun.ru/api/v1/login" -H "Content-Type: application/json" -d "{\"email\":\"example@example.com\",\"password\":\"hunter2\"}"
```

#### <a name="authtoken"></a> Авторизационный токен
Авторизационный токен `api_key` необходим для отправки сообщения об окрестных BLE устройствах на сервер.

В каждый момент для конкретного пользователя валиден только один токен (полученный при последнем логине или сразу после регистрации).

К каждому запросу, требующему авторизацию должен добавляться заголовок `Authorization` формата Bearer Token:

```Authorization: Bearer <api_key>```

Авторизационный токен пользователя не являющегося администратором позволяет выполнять действия связанные только с изменением его профиля и определением его местоположения.

Все действия для получения общей информации не требуют использования авторизационного токена.

#### <a name="profile"></a> Профиль
Получение информации о текущем пользователе осуществляется через GET запрос на http://position.evarun.ru/api/v1/profile с авторизационным токеном `api_key`.

Этот кейс может быть полезен, когда нужно получить информацию только по одному конкретному авторизованному пользователю, вместо того, чтобы грузить весь список пользователей.

Так же данные в этом роуте не кэшируются.

Тело ответа:
```
{
  "id": 1,
  "admin": true,
  "router_id": null,
  "beacon_id": null,
  "name": "Api Tim Cook",
  "status": "free",
  "updated_at": "2019-03-24 21:08:30",
  "location_id": 1,
  "beacon": null,
  "location": {
    "id": 1,
    "label": "Танц-фойе Рим, 2 этаж"
  }
}
```

Пример:
```
curl -X GET "http://position.evarun.ru/api/v1/profile" -H "Authorization: Bearer MmVDDllSdUpKa0h5MFBDdjN1QnlVbEVC"
```

Редактирование информации о текущем пользователе осуществляется через PUT запрос на http://position.evarun.ru/api/v1/profile с авторизационным токеном `api_key`

Тело запроса:
```
{
  "email": "api-test@email.com",
  "password": "secret",
  "name": "Api Tim Cook",
  "status": "free"
}
```
Тело ответа:
```
{
  "id": 1,
  "admin": true,
  "router_id": null,
  "beacon_id": null,
  "name": "Api Tim Cook",
  "status": "free",
  "updated_at": "2019-03-24 21:08:30",
  "location_id": 1,
  "beacon": null,
  "location": {
    "id": 1,
    "label": "Танц-фойе Рим, 2 этаж"
  }
}
```

Пример:
```
curl -X PUT "http://position.evarun.ru/api/v1/profile" -H "Authorization: Bearer MmVDDllSdUpKa0h5MFBDdjN1QnlVbEVC" -H "Content-Type: application/json" -d "{\"email\":\"api-test@email.com\",\"password\":\"secret\",\"name\":\"Api Tim Cook\",\"status\":\"free\"}"```
```

#### <a name="usersList"></a> Список пользователей с местоположением и статусами

Получение информации о текущем местоположении и статусах всех пользователей осуществляется через GET запрос на http://position.evarun.ru/api/v1/users

Данные в этом списке кэшируются на 1 секунду методом автоматического прогревания кэша крон-скриптом.

Полезные поля которые можно отобразить:
 - `name` (имя указанное при регистрации)
 - `status` (статус выбранный пользователем)
 - `updated_at` (время когда от пользователя в последний раз пришел непустой набор BLE-устройств)
 - `location.label` (человеко-читаемое название локации)

Тело ответа:
```
[
    {
      "id": 1,
      "admin": true,
      "router_id": null,
      "beacon_id": null,
      "name": "Api Tim Cook",
      "status": "free",
      "updated_at": "2019-03-24 21:08:30",
      "location_id": 1,
      "beacon": null,
      "location": {
        "id": 1,
        "label": "Танц-фойе Рим, 2 этаж"
      }
    },
    ...
]
```

Пример:
```
curl -X GET "http://position.evarun.ru/api/v1/users"
```

## <a name="position"></a> Позиционирование
#### <a name="beacons"></a> Маячки

#### <a name="locations"></a> Локации

#### <a name="positions"></a> Отправка слышимости маячков

#### <a name="paths"></a> Пути
