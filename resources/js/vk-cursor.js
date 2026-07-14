//ВАРИАНТ ОТ CURSOR

(function() {
        let e = document.createElement(`link`).relList;
        if (e && e.supports && e.supports(`modulepreload`))
            return;
        for (let e of document.querySelectorAll(`link[rel="modulepreload"]`))
            n(e);
        new MutationObserver(e => {
                for (let t of e)
                    if (t.type === `childList`)
                        for (let e of t.addedNodes)
                            e.tagName === `LINK` && e.rel === `modulepreload` && n(e)
            }
        ).observe(document, {
            childList: !0,
            subtree: !0
        });
        function t(e) {
            let t = {};
            return e.integrity && (t.integrity = e.integrity),
            e.referrerPolicy && (t.referrerPolicy = e.referrerPolicy),
                e.crossOrigin === `use-credentials` ? t.credentials = `include` : e.crossOrigin === `anonymous` ? t.credentials = `omit` : t.credentials = `same-origin`,
                t
        }
        function n(e) {
            if (e.ep)
                return;
            e.ep = !0;
            let n = t(e);
            fetch(e.href, n)
        }
    }
)();
var e = [[{
    kind: `char`,
    label: "`",
    ru: `ё`,
    en: "`"
}, {
    kind: `char`,
    label: `1`,
    output: `1`
}, {
    kind: `char`,
    label: `2`,
    output: `2`
}, {
    kind: `char`,
    label: `3`,
    output: `3`
}, {
    kind: `char`,
    label: `4`,
    output: `4`
}, {
    kind: `char`,
    label: `5`,
    output: `5`
}, {
    kind: `char`,
    label: `6`,
    output: `6`
}, {
    kind: `char`,
    label: `7`,
    output: `7`
}, {
    kind: `char`,
    label: `8`,
    output: `8`
}, {
    kind: `char`,
    label: `9`,
    output: `9`
}, {
    kind: `char`,
    label: `0`,
    output: `0`
}, {
    kind: `char`,
    label: `-`,
    output: `-`
}, {
    kind: `char`,
    label: `=`,
    output: `=`
}, {
    kind: `backspace`,
    label: `Backspace`,
    width: `xl`
}], [{
    kind: `tab`,
    label: `Tab`,
    width: `md`
}, {
    kind: `char`,
    label: `q`,
    ru: `й`,
    en: `q`
}, {
    kind: `char`,
    label: `w`,
    ru: `ц`,
    en: `w`
}, {
    kind: `char`,
    label: `e`,
    ru: `у`,
    en: `e`
}, {
    kind: `char`,
    label: `r`,
    ru: `к`,
    en: `r`
}, {
    kind: `char`,
    label: `t`,
    ru: `е`,
    en: `t`
}, {
    kind: `char`,
    label: `y`,
    ru: `н`,
    en: `y`
}, {
    kind: `char`,
    label: `u`,
    ru: `г`,
    en: `u`
}, {
    kind: `char`,
    label: `i`,
    ru: `ш`,
    en: `i`
}, {
    kind: `char`,
    label: `o`,
    ru: `щ`,
    en: `o`
}, {
    kind: `char`,
    label: `p`,
    ru: `з`,
    en: `p`
}, {
    kind: `char`,
    label: `[`,
    ru: `х`,
    en: `[`
}, {
    kind: `char`,
    label: `]`,
    ru: `ъ`,
    en: `]`
}, {
    kind: `char`,
    label: `\\`,
    ru: `\\`,
    en: `\\`
}], [{
    kind: `caps`,
    label: `Caps`,
    width: `lg`
}, {
    kind: `char`,
    label: `a`,
    ru: `ф`,
    en: `a`
}, {
    kind: `char`,
    label: `s`,
    ru: `ы`,
    en: `s`
}, {
    kind: `char`,
    label: `d`,
    ru: `в`,
    en: `d`
}, {
    kind: `char`,
    label: `f`,
    ru: `а`,
    en: `f`
}, {
    kind: `char`,
    label: `g`,
    ru: `п`,
    en: `g`
}, {
    kind: `char`,
    label: `h`,
    ru: `р`,
    en: `h`
}, {
    kind: `char`,
    label: `j`,
    ru: `о`,
    en: `j`
}, {
    kind: `char`,
    label: `k`,
    ru: `л`,
    en: `k`
}, {
    kind: `char`,
    label: `l`,
    ru: `д`,
    en: `l`
}, {
    kind: `char`,
    label: `;`,
    ru: `ж`,
    en: `;`
}, {
    kind: `char`,
    label: `'`,
    ru: `э`,
    en: `'`
}, {
    kind: `enter`,
    label: `Enter`,
    width: `xl`
}], [{
    kind: `shift`,
    label: `Shift`,
    width: `xl`
}, {
    kind: `char`,
    label: `z`,
    ru: `я`,
    en: `z`
}, {
    kind: `char`,
    label: `x`,
    ru: `ч`,
    en: `x`
}, {
    kind: `char`,
    label: `c`,
    ru: `с`,
    en: `c`
}, {
    kind: `char`,
    label: `v`,
    ru: `м`,
    en: `v`
}, {
    kind: `char`,
    label: `b`,
    ru: `и`,
    en: `b`
}, {
    kind: `char`,
    label: `n`,
    ru: `т`,
    en: `n`
}, {
    kind: `char`,
    label: `m`,
    ru: `ь`,
    en: `m`
}, {
    kind: `char`,
    label: `,`,
    ru: `б`,
    en: `,`
}, {
    kind: `char`,
    label: `.`,
    ru: `ю`,
    en: `.`
}, {
    kind: `char`,
    label: `/`,
    ru: `.`,
    en: `/`
}, {
    kind: `arrow`,
    label: `←`,
    output: `left`,
    width: `sm`
}, {
    kind: `arrow`,
    label: `→`,
    output: `right`,
    width: `sm`
}], [{
    kind: `switch`,
    label: `RU/EN`,
    width: `md`
}, {
    kind: `space`,
    label: `Пробел`,
    width: `xl`
}]]
    , t = document.querySelector(`#app`);
if (!t)
    throw Error(`App container not found`);
t.innerHTML = `
  <main class="container">

<!--    <div class="status">
      <span id="langStatus">Язык: RU</span>
      <span id="capsStatus">Caps: OFF</span>
      <span id="shiftStatus">Shift: OFF</span>
    </div>-->
    <div id="keyboard" class="keyboard" aria-label="Виртуальная клавиатура"></div>
  </main>
`;
var n = document.querySelector(`#output`)
    , r = document.querySelector(`#keyboard`)
;

if (!n || !r)
    throw Error(`Keyboard elements not found`);
var c = {
        lang: `ru`,
        caps: !1,
        shift: !1
    }
    , l = (e, t=e) => {
        n.focus(),
            n.setSelectionRange(e, t)
    }
    , u = e => {
        let t = n.selectionStart
            , r = n.selectionEnd;
        n.setRangeText(e, t, r, `end`),
            n.dispatchEvent(new Event(`input`,{
                bubbles: !0
            }))
    }
    , d = () => {
        let e = n.selectionStart
            , t = n.selectionEnd;
        if (e !== t) {
            n.setRangeText(``, e, t, `start`);
            return
        }
        e !== 0 && n.setRangeText(``, e - 1, e, `end`)
    }
    , f = e => {
        let t = n.selectionStart;
        l(e === `left` ? Math.max(0, t - 1) : Math.min(n.value.length, t + 1))
    }
    , p = e => {
        let t = c.caps !== c.shift;
        return /[a-zа-яё]/i.test(e) ? t ? e.toUpperCase() : e.toLowerCase() : e
    }
    , m = e => e.output ? e.output : p(c.lang === `ru` ? e.ru ?? e.label : e.en ?? e.label)

    , g = e => {
        switch (e.kind) {
            case `char`:
                u(m(e)),
                    c.shift = !1;
                break;
            case `space`:
                u(` `);
                break;
            case `tab`:
                u(`  `);
                break;
            case `enter`:
                u(`
`);
                break;
            case `backspace`:
                d();
                break;
            case `caps`:
                c.caps = !c.caps;
                break;
            case `shift`:
                c.shift = !c.shift;
                break;
            case `switch`:
                c.lang = c.lang === `ru` ? `en` : `ru`;
                break;
            case `arrow`:
                f(e.output === `left` ? `left` : `right`);
                break;
            default:
                break
        }
        y(),
            n.focus()
    }
    , _ = e => {
        switch (e) {
            case `sm`:
                return `key-sm`;
            case `md`:
                return `key-md`;
            case `lg`:
                return `key-lg`;
            case `xl`:
                return `key-xl`;
            default:
                return ``
        }
    }
    , v = e => e.kind === `char` ? m(e) : e.label
    , y = () => {
        r.innerHTML = ``,
            e.forEach(e => {
                    let t = document.createElement(`div`);
                    t.className = `row`,
                        e.forEach(e => {
                                let n = document.createElement(`button`);
                                n.type = `button`,
                                    n.className = `key ${_(e.width)}`.trim(),
                                    n.textContent = v(e),
                                (e.kind === `caps` && c.caps || e.kind === `shift` && c.shift || e.kind === `switch` && c.lang === `en`) && n.classList.add(`active`),
                                    n.addEventListener(`click`, () => g(e)),
                                    t.appendChild(n)
                            }
                        ),
                        r.appendChild(t)
                }
            )

    }
;
window.addEventListener(`keydown`, e => {
        e.altKey && e.shiftKey && (e.preventDefault(),
            c.lang = c.lang === `ru` ? `en` : `ru`,
            y())
    }
),

    y(),
    n.focus();
