/**
 * Slider Posts Home 1 tanpa library: geser per kartu, putar otomatis,
 * berhenti saat kursor/fokus di dalam slider atau tab tidak terlihat.
 */
document.querySelectorAll('.vb-slider').forEach(function (slider) {
    var track = slider.querySelector('.vb-slider-track');
    var prev = slider.querySelector('.vb-slider-prev');
    var next = slider.querySelector('.vb-slider-next');
    var delay = parseInt(slider.getAttribute('data-autoplay'), 10) || 0;
    var paused = false;

    if (!track || track.children.length < 2) {
        if (prev) prev.hidden = true;
        if (next) next.hidden = true;
        return;
    }

    function step() {
        var slide = track.children[0];
        var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
        return slide.getBoundingClientRect().width + gap;
    }

    function go(dir) {
        var max = track.scrollWidth - track.clientWidth - 2;
        if (dir > 0 && track.scrollLeft >= max) {
            track.scrollTo({ left: 0 });
        } else if (dir < 0 && track.scrollLeft <= 2) {
            track.scrollTo({ left: track.scrollWidth });
        } else {
            track.scrollBy({ left: dir * step() });
        }
    }

    prev.addEventListener('click', function () { go(-1); });
    next.addEventListener('click', function () { go(1); });

    if (!delay || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    ['mouseenter', 'focusin', 'touchstart'].forEach(function (ev) {
        slider.addEventListener(ev, function () { paused = true; }, { passive: true });
    });
    ['mouseleave', 'focusout'].forEach(function (ev) {
        slider.addEventListener(ev, function () { paused = false; });
    });

    setInterval(function () {
        if (!paused && !document.hidden && track.scrollWidth > track.clientWidth) {
            go(1);
        }
    }, delay);
});
