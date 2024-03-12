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
   {
       "geo": "Пермь",
       "temp": -7,
       "condition": "cloudy",
       "img": "https://yastatic.net/weather/i/icons/funky/light/bkn_d.svg"
   }
   ```
3. **OpenWeatherMap:**
   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=openweathermap&location=Саратов"
   ```
   Ответ
   ```json
   {
       "geo": "Саратов",
       "temp": -2.3,
       "condition": "Clouds",
       "img": "https://openweathermap.org/img/w/04d.png"
   }
   ```
5. **WeatherAPI:**
   Запрос
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=weatherapi"
   ```
   Ответ
   ```json
   {
       "geo": "Пермь",
       "temp": -7,
       "condition": "Небольшой снег",
       "img": "//cdn.weatherapi.com/weather/64x64/day/326.png"
   }
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
8. **Все данные из базы данных:**
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
## Примечание
- В случае успешного запроса, API вернет данные о погоде в формате JSON.
- В случае ошибки, API вернет соответствующий статус и сообщение об ошибке.
  
Пользуйтесь с удовольствием!
