(function () {
    'use strict';

    if (typeof window.SimpleKeyboard === 'undefined') {
        return;
    }

    var Keyboard = window.SimpleKeyboard.default;
    var activeInput = null;
    var keyboardMode = 'default';

    var layoutRussian = {
        default: [
            'й ц у к е н г ш щ з х ъ',
            'ф ы в а п р о л д ж э',
            '{shift} я ч с м и т ь б ю {backspace}',
            '{space} {enter}',
        ],
        shift: [
            'Й Ц У К Е Н Г Ш Щ З Х Ъ',
            'Ф Ы В А П Р О Л Д Ж Э',
            '{shift} Я Ч С М И Т Ь Б Ю {backspace}',
            '{space} {enter}',
        ],
    };

    var layoutNumeric = {
        default: ['1 2 3', '4 5 6', '7 8 9', '0 {backspace}'],
    };

    var keyboard = new Keyboard({
        onChange: function (input) {
            if (activeInput) {
                activeInput.value = input;
            }
        },
        onKeyPress: function (button) {
            if (button === '{shift}') {
                keyboardMode = keyboardMode === 'default' ? 'shift' : 'default';
                keyboard.setOptions({ layoutName: keyboardMode });
            }

            if (button === '{enter}' && activeInput && activeInput.tagName === 'TEXTAREA') {
                activeInput.value += '\n';
                keyboard.setInput(activeInput.value);
            }
        },
        layout: layoutRussian,
        layoutName: 'default',
        theme: 'hg-theme-default hg-layout-default',
        display: {
            '{backspace}': '⌫',
            '{shift}': '⇧',
            '{space}': 'Пробел',
            '{enter}': 'Ввод',
        },
    });

    function showKeyboard(input, mode) {
        activeInput = input;
        keyboardMode = 'default';

        if (mode === 'numeric') {
            keyboard.setOptions({
                layout: layoutNumeric,
                layoutName: 'default',
            });
        } else {
            keyboard.setOptions({
                layout: layoutRussian,
                layoutName: 'default',
            });
        }

        keyboard.setInput(input.value);
        document.getElementById('virtual-keyboard').style.display = 'block';
    }

    /**
     * Функция скрытия виртуальной клавиатуры.
     * Очищает ссылку на активное поле и скрывает элемент клавиатуры.
     */
    function hideKeyboard() {
        activeInput = null;
        document.getElementById('virtual-keyboard').style.display = 'none';
    }

    // Показываем клавиатуру при фокусе на поле ввода
    document.querySelectorAll('.kiosk-input').forEach(function (input) {
        input.addEventListener('focus', function () {
            var mode = input.id === 'phone' ? 'numeric' : 'default';
            showKeyboard(input, mode);
        });
        // Убираем обработчик blur — теперь не скрываем по потере фокуса
    });

    // Скрываем клавиатуру по клику вне её и вне полей ввода
    document.addEventListener('click', function (e) {
        var target = e.target;
        var isInput = target.closest('.kiosk-input');
        var isKeyboard = keyboardElement && keyboardElement.contains(target);

        if (!isInput && !isKeyboard && activeInput) {
            hideKeyboard();
        }
    }, true); // useCapture=true, чтобы ловить клики до того, как они «всплывут»

    hideKeyboard();
})();

/*// Находим все поля ввода с классом 'kiosk-input' и навешиваем на них обработчики событий.
    document.querySelectorAll('.kiosk-input').forEach(function (input) {
        // При получении фокуса полем ввода показываем клавиатуру.
        input.addEventListener('focus', function () {
            // Определяем режим клавиатуры: если ID поля 'phone', то цифровая, иначе — обычная.
            var mode = input.id === 'phone' ? 'numeric' : 'default';
            showKeyboard(input, mode);
        });

// При потере фокуса (blur) скрываем клавиатуру с небольшой задержкой.
        input.addEventListener('blur', function () {
            setTimeout(function () {
                // Проверяем, не переключился ли фокус на другое поле с тем же классом.
                // Если да, то не скрываем клавиатуру.
                if (document.activeElement && document.activeElement.classList.contains('kiosk-input')) {
                    return;
                }
                 hideKeyboard();
            }, 200); // Задержка 200 мс нужна, чтобы корректно обработать переключение фокуса между полями.
        });
    });
// Изначально скрываем клавиатуру при загрузке скрипта.
    hideKeyboard();
})();*/
