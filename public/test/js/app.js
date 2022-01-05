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


/*
_game();
*/

var cardsField = document.querySelector('#cards');
var resetBlock = document.querySelector('#reset');
var resetBtn = document.querySelector('#reset-btn');


var countCards = 16;
var images = [
    1, 2, 3, 4, 5, 6, 7, 8,
    1, 2, 3, 4, 5, 6, 7, 8
];
var deletedCards = 0;
var selector = [];
var pause = false;

for (var i = 0; i < countCards; ++i) {

    var li = document.createElement('li');
    li.id = i;
    cardsField.appendChild(li);
}

cardsField.onclick = function (event) {
    if (pause == false) {
        var _element = event.target;
        if (_element.tagName == 'LI' && _element.className != 'active') {
            selector.push(_element)
            _element.className = 'active';
            var img = images[_element.id];
            _element.style.backgroundImage = 'url(test/image/' + img + '.png)';
            if (selector.length == 2) {
                pause = true;
                if (images[selector[0].id] == images[selector[1].id]) {
                    selector[0].style.visibility = 'hidden';
                    selector[1].style.visibility = 'hidden';
                    deletedCards = deletedCards + 2;
                }
                setTimeout(refreshCards, 600);
            }
        }
    }
}

function refreshCards() {
    for (var i = 0; i < countCards; i++) {
        cardsField.children[i].className = '';
        cardsField.children[i].style.backgroundImage = "";
    }
    if (deletedCards == countCards) {
        resetBlock.style.display = 'block'
    }
    selector = [];
    pause = false;
}

resetBtn.onclick = function () {
    location.reload();
}
