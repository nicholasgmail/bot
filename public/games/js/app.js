/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/assets/js/app.js":
/*!******************************!*\
  !*** ./src/assets/js/app.js ***!
  \******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _component_game__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./component/game */ "./src/assets/js/component/game.js");

/*
_game();
*/

var cardsField = document.querySelector('#cards');
var resetBlock = document.querySelector('#reset');
var resetBtn = document.querySelector('#reset-btn');
var countCards = 16;
var images = [1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8];
var deletedCards = 0;
var selector = [];
var pause = false;

for (var i = 0; i < countCards; i++) {
  var li = document.createElement('li');
  li.id = i;
  cardsField.appendChild(li);
}

cardsField.onclick = function (event) {
  if (pause == false) {
    var _element = event.target;

    if (_element.tagName == 'LI' && _element.className != 'active') {
      selector.push(_element);
      _element.className = 'active';
      var img = images[_element.id];
      _element.style.backgroundImage = 'url(assets/image/' + img + '.png)';

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
};

function refreshCards() {
  for (var i = 0; i < countCards; i++) {
    cardsField.children[i].className = '';
    cardsField.children[i].style.backgroundImage = "";
  }

  if (deletedCards == countCards) {
    resetBlock.style.display = 'block';
  }

  selector = [];
  pause = false;
}

resetBtn.onclick = function () {
  location.reload();
};

/***/ }),

/***/ "./src/assets/js/component/game.js":
/*!*****************************************!*\
  !*** ./src/assets/js/component/game.js ***!
  \*****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
var _game = function _game() {
  var cardsField = document.querySelector('#cards');
  var countCards = 16;

  for (var i = 0; i < countCards; i++) {
    var li = document.createElement('li');
    cardsField.appendChild(li);
  }

  cardsField.onclick = function () {
    alert('hello');
  };
};

/* harmony default export */ __webpack_exports__["default"] = (_game);

/***/ }),

/***/ 0:
/*!************************************!*\
  !*** multi ./src/assets/js/app.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Poject-html-css\curses\sample_game\src\assets\js\app.js */"./src/assets/js/app.js");


/***/ })

/******/ });
//# sourceMappingURL=app.js.map
