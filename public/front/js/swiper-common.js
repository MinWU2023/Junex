/**
 * Shared Swiper helpers: autoplay + junex-style prev/next (mobile-friendly).
 */
(() => {
  const PREV_SVG =
    '<svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M9 1L2 8l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
  const NEXT_SVG =
    '<svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1 1l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

  const AUTOPLAY = {
    delay: 3500,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
  };

  const SKIP_SELECTORS = [
    '.productThumbSwiper',
    '.swiper-thumbs',
    '[data-swiper-no-enhance]',
  ];

  function slideCount(el) {
    return el ? el.querySelectorAll('.swiper-slide').length : 0;
  }

  function shouldSkip(el) {
    if (!el) return true;
    return SKIP_SELECTORS.some((sel) => el.matches(sel) || el.closest(sel));
  }

  function autoplayOption(count) {
    return count > 1 ? { ...AUTOPLAY } : false;
  }

  function loopOptions(count, perViewHint) {
    const need = Math.max(2, (perViewHint || 1) + 1);
    if (count <= 1) return { loop: false, rewind: false };
    if (count > need + 1) return { loop: true, rewind: false };
    return { loop: false, rewind: true };
  }

  /**
   * Wrap swiper in a relative shell so nav can float L/R without squeezing width.
   */
  function ensureShell(swiperEl) {
    if (!swiperEl || !swiperEl.parentNode) return null;
    let shell = swiperEl.closest('.junex-swiper-shell');
    if (shell) return shell;
    shell = document.createElement('div');
    shell.className = 'junex-swiper-shell';
    swiperEl.parentNode.insertBefore(shell, swiperEl);
    shell.appendChild(swiperEl);
    return shell;
  }

  /**
   * Ensure a controls pair exists next to / around a swiper.
   * Newly created buttons float over the swiper (L/R, vertically centered).
   * @returns {{ prevEl: HTMLElement, nextEl: HTMLElement, controls: HTMLElement }}
   */
  function ensureNav(host, prefix, swiperEl) {
    const p = prefix || 'junex';
    const scope = host || document;
    let prevEl = scope.querySelector(`.${p}-prev`);
    let nextEl = scope.querySelector(`.${p}-next`);
    let controls =
      scope.querySelector(`.junex-swiper-controls[data-for="${p}"]`) ||
      scope.querySelector(`.${p}-controls`) ||
      (prevEl && prevEl.closest('.junex-swiper-controls, .exciting-updates-controls, .about-us-controls, .hot-styles-controls'));

    // Already had dedicated nav (not newly injected) — leave layout alone
    if (prevEl && nextEl && controls && !controls.classList.contains('junex-swiper-controls')) {
      prevEl.classList.add('junex-swiper-nav');
      nextEl.classList.add('junex-swiper-nav');
      return { prevEl, nextEl, controls };
    }
    if (prevEl && nextEl && controls && controls.classList.contains('junex-swiper-controls')) {
      prevEl.classList.add('junex-swiper-nav');
      nextEl.classList.add('junex-swiper-nav');
      return { prevEl, nextEl, controls };
    }

    const targetSwiper = swiperEl || (host && host.querySelector('.swiper')) || host;
    const shell = ensureShell(targetSwiper);
    const mount = shell || host;

    if (mount && mount.style) {
      // shell CSS handles position; keep host from collapsing
    }

    if (!controls) {
      controls = document.createElement('div');
      controls.className = 'junex-swiper-controls junex-swiper-controls--float';
      controls.setAttribute('data-for', p);
      if (shell) {
        shell.appendChild(controls);
      } else if (targetSwiper && targetSwiper.parentNode === host) {
        host.insertBefore(controls, targetSwiper.nextSibling);
      } else if (host) {
        host.appendChild(controls);
      }
    } else {
      controls.classList.add('junex-swiper-controls--float');
    }

    if (!prevEl) {
      prevEl = document.createElement('button');
      prevEl.type = 'button';
      prevEl.className = `${p}-prev junex-swiper-nav`;
      prevEl.setAttribute('aria-label', 'Previous');
      prevEl.innerHTML = PREV_SVG;
      controls.appendChild(prevEl);
    } else {
      prevEl.classList.add('junex-swiper-nav');
    }

    if (!nextEl) {
      nextEl = document.createElement('button');
      nextEl.type = 'button';
      nextEl.className = `${p}-next junex-swiper-nav`;
      nextEl.setAttribute('aria-label', 'Next');
      nextEl.innerHTML = NEXT_SVG;
      controls.appendChild(nextEl);
    } else {
      nextEl.classList.add('junex-swiper-nav');
    }

    return { prevEl, nextEl, controls };
  }

  function withAutoNav(options, el, host, prefix) {
    const count = slideCount(el);
    const loops = loopOptions(count, options.slidesPerView === 'auto' ? 1 : options.slidesPerView || 1);
    const navHost = host || el.parentElement || el;
    const nav = ensureNav(navHost, prefix || 'junex', el);

    return {
      watchOverflow: false,
      ...options,
      ...loops,
      autoplay: options.autoplay === false ? false : (options.autoplay || autoplayOption(count)),
      navigation: options.navigation || {
        prevEl: nav.prevEl,
        nextEl: nav.nextEl,
      },
    };
  }

  function startAutoplay(swiper) {
    if (!swiper || !swiper.autoplay) return;
    try {
      swiper.autoplay.start();
    } catch (e) {
      /* ignore */
    }
  }

  window.JunexSwiper = {
    AUTOPLAY,
    PREV_SVG,
    NEXT_SVG,
    slideCount,
    shouldSkip,
    autoplayOption,
    loopOptions,
    ensureNav,
    withAutoNav,
    startAutoplay,
  };
})();
