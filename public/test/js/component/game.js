/*
1. Выбрать поле для игры - done
2. Заполнить игровое поле карточками( тег li)
3. Сделать клик по карточкам
4. Сделать переворачивание карточек
    4.1 Размещаем картинки для каждой карточки
    4.2 Показываем картинки
5. Если выбрано 2 карточки проверяем на совпадение
    5.1 Если картинки совпадают то удаляем карточки
    5.2 Перевернуть все выбраные карточки
6. Если все карточки удалены вывести окно с перезапуском игры
7. При клике  на кнопку перезагруить и обновить страничку
 */


const _game = function () {

    var cardsField = document.querySelector('#cards');



    var countCards = 16;

    for (var i = 0; i < countCards; i++) {

        var li = document.createElement('li');
        cardsField.appendChild(li);
    }
    cardsField.onclick = function () {
        alert('hello')
    }

}

export default _game;