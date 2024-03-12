
// Функция для создания карточки погоды и добавления ее в HTML
function createWeatherCard(data) {
    const container = document.querySelector('.container');

    const card = document.createElement('div');
    card.className = 'weather-card';
    card.id = data.Service;

    const info = document.createElement('div');
    info.className = 'weather-info';

    const title = document.createElement('h2');
    title.textContent = data.ServiceFullName;

    const location = document.createElement('p');
    location.textContent = `Местоположение: ${data.Location}`;

    const temperature = document.createElement('p');
    temperature.textContent = `Температура: ${data.Temperature}°C`;

    const condition = document.createElement('p');
    condition.textContent = `Описание: ${data.Condition}`;

    const image = document.createElement('img');
    image.src = data.Image;
    image.alt = 'Погодная икона';

    info.appendChild(title);
    info.appendChild(location);
    info.appendChild(temperature);
    info.appendChild(condition);
    
    card.appendChild(info);
    card.appendChild(image);
    container.appendChild(card);
}

// Асинхронная функция для получения данных из API
async function fetchData() {
    try {
        const response = await fetch('https://otakuclique.ru/api/?from=allfromdb&token=eeb9a0ca6dfc7c20c89ece32178fb221e7c93723f4dd3ce10a60cc80333bc1bf');
        const data = await response.json();

        // Итерация по данным и создание карточек
        data.forEach(createWeatherCard);
    } catch (error) {
        console.error('Ошибка при получении данных из API:', error);
    }
}

// Вызываем функцию для получения данных из API
fetchData();