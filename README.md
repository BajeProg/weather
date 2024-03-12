# Погодное приложение "Weather API"

Этот репозиторий содержит простой API-сервис для получения данных о погоде из различных источников. Для использования сервиса необходимо получить API-ключ на [otakuclique.ru](https://otakuclique.ru/api/home/).

## Получение API-ключа

Перейдите по ссылке [otakuclique.ru/api/home/](https://otakuclique.ru/api/home/) и получите свой уникальный API-ключ, который необходимо использовать при каждом запросе к API.

## Использование API

API доступно по адресу [https://otakuclique.ru/api/](https://otakuclique.ru/api/). Для получения данных о погоде необходимо отправить GET-запрос с определенными параметрами.

### Параметры запроса

Всего 3 параметра: [token](#token), [from](#from) и [analytics_type](#analytics_type). 

---
1. <a id="token"></a>**token** (обязательный): Ваш API-ключ, полученный на [otakuclique.ru/api/home/](https://otakuclique.ru/api/home/).
---
2. <a id="from"></a>**from** (не обязательный если указан analytics_type): Откуда брать данные. Доступные варианты:
   - yandex
   - openweathermap
   - weatherapi
   - all
   - allfromdb

#### Примеры запросов и ответов с параметром from

- **Яндекс.Погода:**

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=yandex"
   ```
   Ответ
   ```json
   [
    {
        "ID": "64",
        "Date": "2024-03-12 13:00:13",
        "Location": "Пермь",
        "Temperature": "-7",
        "Service": "yandex",
        "ServiceFullName": "Яндекс.Погода",
        "Condition": "cloudy",
        "Image": "https://yastatic.net/weather/i/icons/funky/light/bkn_d.svg"
    }
   ]
   ```
- **OpenWeatherMap:**

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=openweathermap"
   ```
   Ответ
   ```json
   [
    {
        "ID": "80",
        "Date": "2024-03-12 18:00:12",
        "Location": "Пермь",
        "Temperature": "-9.03",
        "Service": "openweathermap",
        "ServiceFullName": "Open Weater Map",
        "Condition": "Snow",
        "Image": "https://openweathermap.org/img/w/13n.png"
    }
   ]
   ```
- **WeatherAPI:**

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=weatherapi"
   ```
   Ответ
   ```json
   [
    {
        "ID": "66",
        "Date": "2024-03-12 13:00:13",
        "Location": "Пермь",
        "Temperature": "-7",
        "Service": "weatherapi",
        "ServiceFullName": "Weather API",
        "Condition": "Небольшой снег",
        "Image": "//cdn.weatherapi.com/weather/64x64/day/326.png"
    }
   ]
   ```
- **Все данные:**

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=all"
   ```
   Ответ
   ```json
   [
    {
        "from": "yandex",
        "full": "Яндекс.Погода",
        "data": {
            "geo": "Пермь",
            "temp": -7,
            "condition": "cloudy",
            "img": "https://yastatic.net/weather/i/icons/funky/light/bkn_d.svg"
        }
    },
    {
        "from": "openweathermap",
        "full": "Open Weater Map",
        "data": {
            "geo": "Пермь",
            "temp": -7.06,
            "condition": "Snow",
            "img": "https://openweathermap.org/img/w/13d.png"
        }
    },
    {
        "from": "weatherapi",
        "full": "Weather API",
        "data": {
            "geo": "Пермь",
            "temp": -7,
            "condition": "Небольшой снег",
            "img": "//cdn.weatherapi.com/weather/64x64/day/326.png"
        }
    }
   ]
   ```
- **Все данные из базы данных:**
   
   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=allfromdb"
   ```
   
   Ответ
   ```json
   [
    {
        "ID": "61",
        "Date": "2024-03-12 12:00:09",
        "Location": "Пермь",
        "Temperature": "-7",
        "Service": "yandex",
        "ServiceFullName": "Яндекс.Погода",
        "Condition": "cloudy",
        "Image": "https://yastatic.net/weather/i/icons/funky/light/bkn_d.svg"
    },
    {
        "ID": "62",
        "Date": "2024-03-12 12:00:09",
        "Location": "Пермь",
        "Temperature": "-7.06",
        "Service": "openweathermap",
        "ServiceFullName": "Open Weater Map",
        "Condition": "Snow",
        "Image": "https://openweathermap.org/img/w/13d.png"
    },
    {
        "ID": "63",
        "Date": "2024-03-12 12:00:09",
        "Location": "Пермь",
        "Temperature": "-7",
        "Service": "weatherapi",
        "ServiceFullName": "Weather API",
        "Condition": "Небольшой снег",
        "Image": "//cdn.weatherapi.com/weather/64x64/day/326.png"
    }
   ]
   ```
---
3. <a id="analytics_type"></a>**analytics_type** (не обязательный если указан from): Тип анализа. Доступные варианты:
   - avghour
   - avgday
   - avgmonth

#### Примеры запросов и ответов с параметром analytics_type

- **avghour:**

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&analytics_type=avghour"
   ```
   Ответ
   ```json
   {
    "Location": "Пермь",
    "AVG": -11.343333333333334,
    "Date_from": "2024-03-12 19:00:00",
    "Date_to": "2024-03-12 20:00:00"
   }
   ```
- **avgday:**

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&analytics_type=avgday"
   ```
   Ответ
   ```json
   {
    "Location": "Пермь",
    "AVG": -10.439074074074075,
    "Date_from": "2024-03-12 00:00:00",
    "Date_to": "2024-03-13 00:00:00"
   }
   ```
- **WeatherAPI:**

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&analytics_type=avgmonth"
   ```
   Ответ
   ```json
   {
    "Location": "Пермь",
    "AVG": -10.451153846153842,
    "Date_from": "2024-03-01 00:00:00",
    "Date_to": "2024-04-01 00:00:00"
   }
   ```

   
## Примечание
- В случае успешного запроса, API вернет данные о погоде в формате JSON.
- В случае ошибки, API вернет соответствующий статус и сообщение об ошибке.

#### Пример ошибки

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY"
   ```
   Ответ
   ```json
   {
    "error": true,
    "type": "ERROR",
    "title": "Ошибка!",
    "desc": "Не указан ни один параметр.",
    "other": null,
    "datetime": {
        "Y": "2024",
        "m": "03",
        "d": "12",
        "H": "20",
        "i": "07",
        "s": "32",
        "full": "2024-03-12 20:07:32"
    }
   }
   ```
  
Пользуйтесь с удовольствием!

-----

# Этапы

## Покупка и настройка хостинга
На покупку и настройку хостинга потребовалось **3 часа**. Возникли проблемы с SSL сертификатом, он дается бесплатно на 6 месяцев, а я пытался получить его повторно для моего домена **anigeek.space**. Пришлось регистрировать новый домен.

## Проектирование базы данных
На проектирование базы данных потребовалось **40 минут**. Были добавлены таблицы: 
|Таблица|Описание|
|:----:|:----|
|Weater|Таблица с данными о погоде. Заполняется автоматически каждый час благодоря **крон операции**|
|API_keys|Таблица с **API ключами** пользователей. Также хранит информацию о количестве запросов в сутки. Счетчик обнуляется автоматически ежедневно благодоря **крон операции**|
|Users|Таблица с данными о пользователях|
|Sessions|Таблица с данными об активных сессиях пользователей|

## Написание API сервиса
На написание API сервиса потребовалось **6 часов**.

1. Получение всех API ключей от сервисов, предоставляющих данные о погоде и чтение документации - **2 часа**
2. Написание своего API сервиса, который агрегирует погодные данные из выбранных API сервисов и сохранять их в собственной базе данных - **2 часа**
3. Написание простого интерфейса для удобства проверки работы и регистрации API ключей пользователями - **1 час**
4. Тестирование продукта и написание документации  - **1 час**

## Дополнительные задачи
На написание дополнительных задач потребовалось **1 час 45 минут**.

1. Экспорт данных в csv - **15 минут**
2. Анализ данных (расчет средней температуры по всем источникам за час, день и месяц) - **1 час**
3. Ограничение на использование (не более 2000 запросов в сутки) API одним ключом - **30 минут**
