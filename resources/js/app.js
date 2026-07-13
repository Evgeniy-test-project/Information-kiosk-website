



(function () {
    'use strict';

    var timeout = window.KIOSK_IDLE_TIMEOUT || 120;
    var idleTimer = null;
    var remaining = timeout;
    var indicator = document.getElementById('idle-indicator');
    var homeUrl = document.querySelector('.kiosk-btn--home');

    if (homeUrl) {
        homeUrl = homeUrl.getAttribute('href');
    }

    function isHomePage() {
        return window.location.pathname === '/' || window.location.pathname === '';
    }

    function updateIndicator() {
        if (!indicator) {
            return;
        }

        var progress = (remaining / timeout) * 100;
        indicator.style.setProperty('--idle-progress', progress + '%');
    }

    function resetIdleTimer() {
        remaining = timeout;
        updateIndicator();

        if (idleTimer) {
            clearInterval(idleTimer);
        }

        if (isHomePage()) {
            return;
        }

        idleTimer = setInterval(function () {
            remaining -= 1;
            updateIndicator();

            if (remaining <= 0) {
                clearInterval(idleTimer);
                window.location.href = homeUrl || '/';
            }
        }, 1000);
    }

    ['click', 'touchstart', 'keydown', 'mousemove', 'scroll'].forEach(function (event) {
        document.addEventListener(event, resetIdleTimer, { passive: true });
    });

    document.addEventListener('contextmenu', function (event) {
        event.preventDefault();
    });

    resetIdleTimer();
})();


import Keyboard from 'simple-keyboard';
import 'simple-keyboard/build/css/index.css';

const keyboard = new Keyboard({
    onChange: input => onChange(input),
    onKeyPress: button => onKeyPress(button)
});

function onChange(input){
    document.querySelector(".input").value = input;
    console.log("Input changed", input);
}

function onKeyPress(button){
    console.log("Button pressed", button);
}
