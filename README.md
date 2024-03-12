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
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=yandex"
   ```
2. **OpenWeatherMap:**
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=openweathermap"
   ```
3. **WeatherAPI:**
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=weatherapi"
   ```
4. **Все данные:**
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=all"
   ```
5. **Все данные из базы данных:**
   ```bash
   curl -X GET "https://otakuclique.ru/api/?token=YOUR_API_KEY&from=allfromdb"
   ```

## Примечание
- В случае успешного запроса, API вернет данные о погоде в формате JSON.
- В случае ошибки, API вернет соответствующий статус и сообщение об ошибке.
  
Пользуйтесь с удовольствием!
