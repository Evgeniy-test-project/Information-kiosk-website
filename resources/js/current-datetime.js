
 // Скрипт для обновления даты-времени
setInterval(() => {
    const now = new Date();
    // Форматирование времени
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('currentTime').textContent = `${hours}:${minutes}`;

    // Форматирование даты
    const days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
    const months = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

    const day = days[now.getDay()];
    const month = months[now.getMonth()];
    const date = now.getDate();

    document.getElementById('currentDate').textContent = `${date} ${month}, ${day}`;

}, 1000);
