//ВАРИАНТ ОТ АЛИСЫ

(function() {
    'use strict';

    // 1. Проверка наличия контейнера
    const appContainer = document.querySelector('#app');
    if (!appContainer) {
        console.warn('App container not found. Keyboard will not be initialized.');
        return;
    }

    appContainer.innerHTML = `
      <main class="container">
        <div id="keyboard" class="keyboard" aria-label="Виртуальная клавиатура"></div>
      </main>
    `;

    const outputField = document.querySelector('#output');
    const keyboardContainer = document.querySelector('#keyboard');

    if (!outputField || !keyboardContainer) {
        console.error('Required elements (#output or #keyboard) not found.');
        return;
    }

    const layoutData = [
        [
            { kind: 'char', label: '`', ru: 'ё', en: '`' },
            { kind: 'char', label: '1', output: '1' },
            { kind: 'char', label: '2', output: '2' },
            { kind: 'char', label: '3', output: '3' },
            { kind: 'char', label: '4', output: '4' },
            { kind: 'char', label: '5', output: '5' },
            { kind: 'char', label: '6', output: '6' },
            { kind: 'char', label: '7', output: '7' },
            { kind: 'char', label: '8', output: '8' },
            { kind: 'char', label: '9', output: '9' },
            { kind: 'char', label: '0', output: '0' },
            { kind: 'char', label: '-', output: '-' },
            { kind: 'char', label: '=', output: '=' },
            { kind: 'backspace', label: 'Backspace', width: 'xl' }
        ],
        [
            { kind: 'tab', label: 'Tab', width: 'mmd' },
            { kind: 'char', label: 'q', ru: 'й', en: 'q' },
            { kind: 'char', label: 'w', ru: 'ц', en: 'w' },
            { kind: 'char', label: 'e', ru: 'у', en: 'e' },
            { kind: 'char', label: 'r', ru: 'к', en: 'r' },
            { kind: 'char', label: 't', ru: 'е', en: 't' },
            { kind: 'char', label: 'y', ru: 'н', en: 'y' },
            { kind: 'char', label: 'u', ru: 'г', en: 'u' },
            { kind: 'char', label: 'i', ru: 'ш', en: 'i' },
            { kind: 'char', label: 'o', ru: 'щ', en: 'o' },
            { kind: 'char', label: 'p', ru: 'з', en: 'p' },
            { kind: 'char', label: '[', ru: 'х', en: '[' },
            { kind: 'char', label: ']', ru: 'ъ', en: ']' },
            { kind: 'char', label: '\\', ru: '\\', en: '\\' }
        ],
        [
            { kind: 'caps', label: 'Caps', width: 'lg' },
            { kind: 'char', label: 'a', ru: 'ф', en: 'a' },
            { kind: 'char', label: 's', ru: 'ы', en: 's' },
            { kind: 'char', label: 'd', ru: 'в', en: 'd' },
            { kind: 'char', label: 'f', ru: 'а', en: 'f' },
            { kind: 'char', label: 'g', ru: 'п', en: 'g' },
            { kind: 'char', label: 'h', ru: 'р', en: 'h' },
            { kind: 'char', label: 'j', ru: 'о', en: 'j' },
            { kind: 'char', label: 'k', ru: 'л', en: 'k' },
            { kind: 'char', label: 'l', ru: 'д', en: 'l' },
            { kind: 'char', label: ';', ru: 'ж', en: ';' },
            { kind: 'char', label: "'", ru: 'э', en: "'" },
            { kind: 'enter', label: 'Enter', width: 'xl' }
        ],
        [
            { kind: 'shift', label: 'Shift', width: 'xl' },
            { kind: 'char', label: 'z', ru: 'я', en: 'z' },
            { kind: 'char', label: 'x', ru: 'ч', en: 'x' },
            { kind: 'char', label: 'c', ru: 'с', en: 'c' },
            { kind: 'char', label: 'v', ru: 'м', en: 'v' },
            { kind: 'char', label: 'b', ru: 'и', en: 'b' },
            { kind: 'char', label: 'n', ru: 'т', en: 'n' },
            { kind: 'char', label: 'm', ru: 'ь', en: 'm' },
            { kind: 'char', label: ',', ru: 'б', en: ',' },
            { kind: 'char', label: '.', ru: 'ю', en: '.' },
            { kind: 'char', label: '/', ru: '.', en: '/' },
            { kind: 'arrow', label: '←', output: 'left', width: 'sm' },
            { kind: 'arrow', label: '→', output: 'right', width: 'sm' }
        ],
        [
            { kind: 'switch', label: 'RU/EN', width: 'xl' },
            { kind: 'space', label: 'Пробел', width: 'xxl' }
        ]
    ];


    const state = {
        lang: 'ru',
        caps: false,
        shift: false
    };

    function getChar(key) {
        const useCaps = state.caps !== state.shift;
        if (key.kind !== 'char') return key.label;

        const char = state.lang === 'ru' ? (key.ru ?? key.label) : (key.en ?? key.label);

        // Безопасное переключение регистра без toUpperCase/toLowerCase
        if (!useCaps) return char;

        // Простая эмуляция заглавной буквы через маппинг (лучше добавить явно в данные)
        const upperMap = {
            'й': 'Й', 'ц': 'Ц', 'у': 'У', 'к': 'К', 'е': 'Е', 'н': 'Н', 'г': 'Г', 'ш': 'Ш', 'щ': 'Щ', 'з': 'З',
            'х': 'Х', 'ъ': 'Ъ', 'ф': 'Ф', 'ы': 'Ы', 'в': 'В', 'а': 'А', 'п': 'П', 'р': 'Р', 'о': 'О', 'л': 'Л',
            'д': 'Д', 'ж': 'Ж', 'э': 'Э', 'я': 'Я', 'ч': 'Ч', 'с': 'С', 'м': 'М', 'и': 'И', 'т': 'Т', 'ь': 'Ь',
            'б': 'Б', 'ю': 'Ю',
            'q': 'Q', 'w': 'W', 'e': 'E', 'r': 'R', 't': 'T', 'y': 'Y', 'u': 'U', 'i': 'I', 'o': 'O', 'p': 'P',
            'a': 'A', 's': 'S', 'd': 'D', 'f': 'F', 'g': 'G', 'h': 'H', 'j': 'J', 'k': 'K', 'l': 'L',
            'z': 'Z', 'x': 'X', 'c': 'C', 'v': 'V', 'b': 'B', 'n': 'N', 'm': 'M'
        };
        return upperMap[char] || char;
    }

    function insertText(text) {
        const start = outputField.selectionStart;
        const end = outputField.selectionEnd;
        outputField.setRangeText(text, start, end, 'end');
        outputField.dispatchEvent(new Event('input', { bubbles: true }));
        outputField.focus();
    }

    function handleBackspace() {
        const start = outputField.selectionStart;
        const end = outputField.selectionEnd;
        if (start !== end) {
            outputField.setRangeText('', start, end, 'start');
        } else if (start > 0) {
            outputField.setRangeText('', start - 1, start, 'end');
        }
        outputField.focus();
    }

    function moveCursor(direction) {
        const pos = outputField.selectionStart;
        const newPos = direction === 'left' ? Math.max(0, pos - 1) : Math.min(outputField.value.length, pos + 1);
        outputField.setSelectionRange(newPos, newPos);
        outputField.focus();
    }

    function renderKeyboard() {
        keyboardContainer.innerHTML = '';
        layoutData.forEach(row => {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'row';
            row.forEach(key => {
                const btn = document.createElement('button');
                btn.type = 'button';
                const sizeClass = key.width ? `key-${key.width}` : 'key-md';
                btn.className = `key ${sizeClass}`;
                btn.textContent = getChar(key);
                if ((key.kind === 'caps' && state.caps) ||
                    (key.kind === 'shift' && state.shift) ||
                    (key.kind === 'switch' && state.lang === 'en')) {
                    btn.classList.add('active');
                }
                btn.addEventListener('click', () => handleKey(key), { passive: true });
                btn.addEventListener('touchstart', (e) => e.preventDefault(), { passive: false });
                rowDiv.appendChild(btn);
            });
            keyboardContainer.appendChild(rowDiv);
        });
    }

    function handleKey(key) {
        switch (key.kind) {
            case 'char':
                insertText(getChar(key));
                state.shift = false;
                break;
            case 'space':
                insertText(' ');
                break;
            case 'tab':
                insertText('  ');
                break;
            case 'enter':
                insertText('\n');
                break;
            case 'backspace':
                handleBackspace();
                break;
            case 'caps':
                state.caps = !state.caps;
                break;
            case 'shift':
                state.shift = !state.shift;
                break;
            case 'switch':
                state.lang = state.lang === 'ru' ? 'en' : 'ru';
                break;
            case 'arrow':
                moveCursor(key.output === 'left' ? 'left' : 'right');
                break;
        }
        renderKeyboard();
        outputField.focus();
    }

    window.addEventListener('keydown', (e) => {
        if (e.altKey && e.shiftKey) {
            e.preventDefault();
            state.lang = state.lang === 'ru' ? 'en' : 'ru';
            renderKeyboard();
        }
    });

    renderKeyboard();
    outputField.focus();
})();
