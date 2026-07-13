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

    function hideKeyboard() {
        activeInput = null;
        document.getElementById('virtual-keyboard').style.display = 'none';
    }

    document.querySelectorAll('.kiosk-input').forEach(function (input) {
        input.addEventListener('focus', function () {
            var mode = input.id === 'phone' ? 'numeric' : 'default';
            showKeyboard(input, mode);
        });

        input.addEventListener('blur', function () {
            setTimeout(function () {
                if (document.activeElement && document.activeElement.classList.contains('kiosk-input')) {
                    return;
                }
                hideKeyboard();
            }, 200);
        });
    });

    hideKeyboard();
})();
