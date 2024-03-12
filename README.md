# Погодное приложение "Weather API"

Этот репозиторий содержит простой API-сервис для получения данных о погоде из различных источников. Для использования сервиса необходимо получить API-ключ на [otakuclique.ru](https://otakuclique.ru/api/home/).

## Получение API-ключа

Перейдите по ссылке [otakuclique.ru/api/home/](https://otakuclique.ru/api/home/) и получите свой уникальный API-ключ, который необходимо использовать при каждом запросе к API.

## Использование API

API доступно по адресу [https://otakuclique.ru/api/](https://otakuclique.ru/api/). Для получения данных о погоде необходимо отправить GET-запрос с определенными параметрами.

### Параметры запроса

1. **token** (обязательный): Ваш API-ключ, полученный на [otakuclique.ru/api/home/](https://otakuclique.ru/api/home/).

2. **from** (обязательный): Откуда брать данные. Доступные варианты:
   - yandex
   - openweathermap
   - weatherapi
   - all
   - allfromdb

   Пример запроса и ответа для каждого варианта приведен ниже.

3. **location** (необязательный): Город, для которого требуется получить данные о погоде.

### Примеры запросов и ответов

1. **Яндекс.Погода:**

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
3. **OpenWeatherMap:**

   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=openweathermap&location=Москва"
   ```
   Ответ
   ```json
   [
    {
        "ID": "2",
        "Date": "2024-03-11 15:28:42",
        "Location": "Москва",
        "Temperature": "0.96",
        "Service": "openweathermap",
        "ServiceFullName": "Open Weater Map",
        "Condition": "Clouds",
        "Image": "https://openweathermap.org/img/w/04d.png"
    }
   ]
   ```
5. **WeatherAPI:**

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
7. **Все данные:**

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
9. **Все данные из базы данных:**
   
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
10. **Среднее значение по всем сервисам:**
   
   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=avg"
   ```
   
   Ответ
   ```json
   {
    "Location": "Пермь",
    "AVG": -7.02
   }
   ```
   
## Примечание
- В случае успешного запроса, API вернет данные о погоде в формате JSON.
- В случае ошибки, API вернет соответствующий статус и сообщение об ошибке.
  
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
На написание дополнительных задач потребовалось **70 минут**.

1. Экспорт данных в csv - **15 минут**
2. Анализ данных (расчет средней температуры по всем источникам) - **25 минут**
3. Ограничение на использование (не более 2000 запросов в сутки) API одним ключом - **30 минут**
