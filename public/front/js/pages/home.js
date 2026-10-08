(() => {
  const J = () => window.JunexSwiper;

  const initBannersSwiper = () => {
    if (typeof window.Swiper === 'undefined') return;
    const els = document.querySelectorAll('.banners-swiper');
    if (!els.length) return;

    els.forEach((el) => {
      if (el.swiper) return;
      const paginationEl =
        el.querySelector('.banners-pagination') ||
        (el.parentElement && el.parentElement.querySelector('.banners-pagination'));

      const swiper = new window.Swiper(el, {
        loop: true,
        speed: 700,
        slidesPerView: 1,
        spaceBetween: 0,
        watchOverflow: false,
        autoplay: {
          delay: 4500,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        pagination: paginationEl
          ? {
              el: paginationEl,
              clickable: true,
            }
          : undefined,
        a11y: { enabled: true },
      });
      if (J()) J().startAutoplay(swiper);
    });
  };

  const initOdmSwiper = () => {
    const roots = document.querySelectorAll('.custom_serrvices .odm-swiper, section.custom_serrvices .odm-swiper');
    const list = roots.length ? roots : document.querySelectorAll('.odm-swiper');
    list.forEach((el) => {
      if (!el || el.swiper) return;
      if (typeof window.Swiper === 'undefined') return;
      const host = el.closest('.mt-5') || el.parentElement || el;
      if (host && host.style) host.style.position = 'relative';
      const base = {
        loop: true,
        speed: 500,
        slidesPerView: 1,
        spaceBetween: 0,
        watchOverflow: true,
        pagination: {
          el: el.querySelector('.odm-pagination') || el.parentElement.querySelector('.odm-pagination'),
          clickable: true,
        },
      };
      const opts = J() ? J().withAutoNav(base, el, host, 'odm') : base;
      const swiper = new window.Swiper(el, opts);
      if (J()) J().startAutoplay(swiper);
    });
  };

  const initOemSwiper = () => {
    const roots = document.querySelectorAll('.custom_serrvices .oem-swiper, section.custom_serrvices .oem-swiper');
    const list = roots.length ? roots : document.querySelectorAll('.oem-swiper');
    list.forEach((el) => {
      if (!el || el.swiper) return;
      if (typeof window.Swiper === 'undefined') return;
      const host = el.closest('.mt-5') || el.parentElement || el;
      if (host && host.style) host.style.position = 'relative';
      const base = {
        loop: true,
        speed: 500,
        slidesPerView: 1,
        spaceBetween: 0,
        watchOverflow: true,
        pagination: {
          el: el.querySelector('.oem-pagination') || el.parentElement.querySelector('.oem-pagination'),
          clickable: true,
        },
      };
      const opts = J() ? J().withAutoNav(base, el, host, 'oem') : base;
      const swiper = new window.Swiper(el, opts);
      if (J()) J().startAutoplay(swiper);
    });
  };

  const initHotStylesSwiper = () => {
    if (typeof window.Swiper === 'undefined') return;

    const section = document.querySelector('.hot_styles');
    if (!section) return;

    const swiperMap = {};
    let activeKey = null;
    const prevBtn = section.querySelector('.hot-styles-prev');
    const nextBtn = section.querySelector('.hot-styles-next');
    const MOBILE_MAX = 991;

    const isMobileGrid = () => window.innerWidth <= MOBILE_MAX;

    const tabButtons = () => Array.from(section.querySelectorAll('.hot-styles-tab'));

    /**
     * 手机端 Tab 过多时：点击后把当前 Tab 滚到左侧，露出后面的 Tab；
     * 点前面的 Tab 时同理滚回，露出被藏住的前项。
     */
    const scrollTabIntoReveal = (activeTab) => {
      const scroller = section.querySelector('.hot-styles-tabs');
      if (!scroller || !activeTab) return;

      // 桌面端一般能完整展示，无需强制滚动
      if (window.innerWidth > MOBILE_MAX) return;

      const pad = 18;
      const maxScroll = Math.max(0, scroller.scrollWidth - scroller.clientWidth);
      if (maxScroll <= 0) return;

      const tabs = tabButtons();
      const idx = tabs.indexOf(activeTab);
      if (idx < 0) return;

      // 当前 Tab 贴左，自然露出右侧后续 Tab
      let target = Math.max(0, activeTab.offsetLeft - pad);

      // 若存在下一项，尽量保证下一项至少露出一部分（提示还有更多）
      const next = tabs[idx + 1];
      if (next) {
        const peek = Math.min(48, Math.floor(next.offsetWidth * 0.45));
        const needEnd = next.offsetLeft + peek + pad;
        const visibleEnd = target + scroller.clientWidth;
        if (needEnd > visibleEnd) {
          target = Math.max(0, needEnd - scroller.clientWidth);
        }
      }

      // 若存在上一项且当前贴左会把它完全藏掉时，略留一点左侧 peek
      const prev = tabs[idx - 1];
      if (prev && idx > 0 && !next) {
        // 最后一项：尽量同时露出前一项，提示可回退
        target = Math.min(target, Math.max(0, prev.offsetLeft - pad));
      }

      target = Math.max(0, Math.min(target, maxScroll));
      if (typeof scroller.scrollTo === 'function') {
        scroller.scrollTo({ left: target, behavior: 'smooth' });
      } else {
        scroller.scrollLeft = target;
      }
    };

    const syncNav = (swiper) => {
      if (!prevBtn || !nextBtn) return;
      if (isMobileGrid()) {
        const tabs = tabButtons();
        const idx = tabs.findIndex((t) => t.getAttribute('data-hot-tab') === activeKey);
        const atStart = idx <= 0;
        const atEnd = idx < 0 || idx >= tabs.length - 1;
        prevBtn.classList.toggle('swiper-button-disabled', atStart);
        nextBtn.classList.toggle('swiper-button-disabled', atEnd);
        prevBtn.setAttribute('aria-disabled', atStart ? 'true' : 'false');
        nextBtn.setAttribute('aria-disabled', atEnd ? 'true' : 'false');
        return;
      }
      const locked = !swiper || !!swiper.isLocked;
      const atStart = locked || !swiper || swiper.isBeginning;
      const atEnd = locked || !swiper || swiper.isEnd;
      prevBtn.classList.toggle('swiper-button-disabled', atStart);
      nextBtn.classList.toggle('swiper-button-disabled', atEnd);
      prevBtn.setAttribute('aria-disabled', atStart ? 'true' : 'false');
      nextBtn.setAttribute('aria-disabled', atEnd ? 'true' : 'false');
    };

    const swiperOptions = {
      loop: false,
      speed: 500,
      slidesPerView: 2,
      spaceBetween: 12,
      watchOverflow: false,
      // 关闭自适应高度，避免切 Tab 时出现从上到下的高度展开动画
      autoHeight: false,
      observer: true,
      observeParents: true,
      allowTouchMove: true,
      // 桌面端自动播；手机端是网格展示，不走轮播高度计算
      autoplay: false,
      breakpoints: {
        480: { slidesPerView: 2.2, spaceBetween: 12 },
        600: { slidesPerView: 3, spaceBetween: 14 },
        768: { slidesPerView: 4, spaceBetween: 14 },
        992: {
          slidesPerView: 5,
          spaceBetween: 16,
          autoplay: J()
            ? { ...J().AUTOPLAY }
            : { delay: 3500, disableOnInteraction: false, pauseOnMouseEnter: true },
          rewind: true,
        },
        1200: { slidesPerView: 6, spaceBetween: 16 },
      },
      on: {
        init(sw) { syncNav(sw); },
        slideChange(sw) { syncNav(sw); },
        resize(sw) { syncNav(sw); },
        update(sw) { syncNav(sw); },
        lock(sw) { syncNav(sw); },
        unlock(sw) { syncNav(sw); },
      },
    };

    const applyMobileMode = (swiper) => {
      if (!swiper) return;
      if (isMobileGrid()) {
        swiper.allowTouchMove = false;
        swiper.el.classList.add('is-mobile-grid');
        if (typeof swiper.setTranslate === 'function') {
          swiper.setTranslate(0);
        }
        if (swiper.autoplay && typeof swiper.autoplay.stop === 'function') {
          swiper.autoplay.stop();
        }
        // 避免 Swiper 把高度算成 0，导致下一板块叠上来
        swiper.el.style.height = 'auto';
        if (swiper.wrapperEl) {
          swiper.wrapperEl.style.transform = 'none';
          swiper.wrapperEl.style.height = 'auto';
        }
      } else {
        swiper.allowTouchMove = true;
        swiper.el.classList.remove('is-mobile-grid');
        swiper.el.style.height = '';
        if (swiper.autoplay && typeof swiper.autoplay.start === 'function') {
          swiper.autoplay.start();
        }
      }
      swiper.update();
      syncNav(swiper);
    };

    const ensureSwiper = (key) => {
      if (swiperMap[key]) {
        applyMobileMode(swiperMap[key]);
        return swiperMap[key];
      }
      const el = section.querySelector('[data-hot-swiper="' + key + '"]');
      if (!el) return null;
      swiperMap[key] = new window.Swiper(el, swiperOptions);
      applyMobileMode(swiperMap[key]);
      return swiperMap[key];
    };

    const firstTab = section.querySelector('.hot-styles-tab');
    activeKey = firstTab ? firstTab.getAttribute('data-hot-tab') : null;

    const setActiveTab = (key, options = {}) => {
      const { scrollTab = true } = options;
      activeKey = key;

      let activeTabEl = null;
      section.querySelectorAll('.hot-styles-tab').forEach((tab) => {
        const isActive = tab.getAttribute('data-hot-tab') === key;
        tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        tab.classList.toggle('is-active', isActive);
        tab.classList.toggle('bg-brand-dark', isActive);
        tab.classList.toggle('text-white', isActive);
        tab.classList.toggle('bg-brand-gray-light', !isActive);
        tab.classList.toggle('text-brand-navy', !isActive);
        if (isActive) activeTabEl = tab;
      });

      section.querySelectorAll('.hot-styles-panel').forEach((panel) => {
        const match = panel.getAttribute('data-hot-panel') === key;
        panel.classList.toggle('hidden', !match);
      });

      if (scrollTab && activeTabEl) {
        scrollTabIntoReveal(activeTabEl);
      }

      window.requestAnimationFrame(() => {
        const swiper = ensureSwiper(key);
        if (swiper) {
          // 切 Tab 时立刻更新，不要带高度过渡
          swiper.el.style.transitionDuration = '0ms';
          if (swiper.wrapperEl) {
            swiper.wrapperEl.style.transitionDuration = '0ms';
          }
          if (typeof swiper.updateSize === 'function') swiper.updateSize();
          if (typeof swiper.updateSlides === 'function') swiper.updateSlides();
          swiper.update();
          swiper.el.style.height = 'auto';
          if (swiper.wrapperEl) swiper.wrapperEl.style.height = 'auto';
        }
        syncNav(swiper);
      });
    };

    section.querySelectorAll('.hot-styles-tab').forEach((tab) => {
      tab.addEventListener('click', () => {
        const key = tab.getAttribute('data-hot-tab');
        setActiveTab(key);
      });
    });

    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        if (prevBtn.classList.contains('swiper-button-disabled')) return;
        if (isMobileGrid()) {
          const tabs = tabButtons();
          const idx = tabs.findIndex((t) => t.getAttribute('data-hot-tab') === activeKey);
          if (idx > 0) setActiveTab(tabs[idx - 1].getAttribute('data-hot-tab'));
          return;
        }
        const swiper = activeKey ? ensureSwiper(activeKey) : null;
        if (swiper) swiper.slidePrev();
      });
    }
    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        if (nextBtn.classList.contains('swiper-button-disabled')) return;
        if (isMobileGrid()) {
          const tabs = tabButtons();
          const idx = tabs.findIndex((t) => t.getAttribute('data-hot-tab') === activeKey);
          if (idx >= 0 && idx < tabs.length - 1) setActiveTab(tabs[idx + 1].getAttribute('data-hot-tab'));
          return;
        }
        const swiper = activeKey ? ensureSwiper(activeKey) : null;
        if (swiper) swiper.slideNext();
      });
    }

    let resizeTimer = null;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (activeKey && swiperMap[activeKey]) {
          applyMobileMode(swiperMap[activeKey]);
        }
      }, 150);
    });

    // 首次进入不强制滚动，避免页面加载时 Tab 条跳动
    if (activeKey) setActiveTab(activeKey, { scrollTab: false });
  };

  const initExcitingUpdatesSwiper = () => {
    const section = document.querySelector('.exciting_updates');
    if (!section) return;
    const el = section.querySelector('.exciting-updates-swiper');
    if (!el) return;
    if (typeof window.Swiper === 'undefined') return;

    const host = section.querySelector('.exciting-updates-layout') || section;
    const base = {
      speed: 500,
      slidesPerView: 1,
      spaceBetween: 20,
      autoHeight: true,
      breakpoints: {
        600: { slidesPerView: 2, spaceBetween: 16 },
        992: { slidesPerView: 3, spaceBetween: 20 },
      },
      navigation: {
        prevEl: section.querySelector('.exciting-updates-prev'),
        nextEl: section.querySelector('.exciting-updates-next'),
      },
    };
    const opts = J() ? J().withAutoNav(base, el, host, 'exciting-updates') : { ...base, autoplay: { delay: 3500, disableOnInteraction: false } };
    const swiper = new window.Swiper(el, opts);
    if (J()) J().startAutoplay(swiper);
  };

  const initVideoRecommendsSwiper = () => {
    const el = document.querySelector('.video-recommends-swiper');
    if (!el) return;
    if (typeof window.Swiper === 'undefined') return;

    const section = el.closest('section') || el.parentElement;
    const host = section;
    const base = {
      speed: 500,
      slidesPerView: 1,
      spaceBetween: 20,
      autoHeight: true,
      breakpoints: {
        600: { slidesPerView: 2, spaceBetween: 16 },
        992: { slidesPerView: 3, spaceBetween: 20 },
      },
    };
    const opts = J() ? J().withAutoNav(base, el, host, 'video-recommends') : { ...base, autoplay: { delay: 3500, disableOnInteraction: false } };
    const swiper = new window.Swiper(el, opts);
    if (J()) J().startAutoplay(swiper);
  };

  const initAboutUsSwiper = () => {
    const section = document.querySelector('.about-us');
    if (!section) return;
    const el = section.querySelector('.about-us-swiper');
    if (!el) return;
    if (typeof window.Swiper === 'undefined') return;

    const slideCount = el.querySelectorAll('.swiper-slide').length;
    const canLoop = slideCount > 1;

    const swiper = new window.Swiper(el, {
      loop: canLoop,
      speed: 500,
      slidesPerView: 1,
      spaceBetween: 0,
      watchOverflow: false,
      autoHeight: true,
      autoplay: canLoop
        ? {
            delay: 4500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
          }
        : false,
      navigation: {
        prevEl: section.querySelector('.about-us-prev'),
        nextEl: section.querySelector('.about-us-next'),
      },
      pagination: canLoop
        ? {
            el: section.querySelector('.about-us-pagination'),
            clickable: true,
          }
        : undefined,
    });
    if (J()) J().startAutoplay(swiper);
  };

  const initCollectBtns = () => {
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.collect-btn');
      if (!btn) return;
      if (btn.classList.contains('js-prefer-toggle')) return;
      e.preventDefault();
      e.stopPropagation();
      const uncollect = btn.querySelector('.uncollect-icon');
      const collect = btn.querySelector('.collect-icon');
      uncollect.classList.toggle('hidden');
      collect.classList.toggle('hidden');
    });
  };

  const initInquirySelect = () => {
    const roots = document.querySelectorAll('[data-inquiry-select]');
    if (!roots.length) return;

    const closeAll = (except) => {
      roots.forEach((root) => {
        if (except && root === except) return;
        root.classList.remove('is-open');
        const trigger = root.querySelector('[data-inquiry-select-trigger]');
        const menu = root.querySelector('[data-inquiry-select-menu]');
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
        if (menu) menu.hidden = true;
      });
    };

    roots.forEach((root) => {
      const trigger = root.querySelector('[data-inquiry-select-trigger]');
      const menu = root.querySelector('[data-inquiry-select-menu]');
      const input = root.querySelector('[data-inquiry-select-input]');
      const labelEl = root.querySelector('[data-inquiry-select-label]');
      if (!trigger || !menu || !input || !labelEl) return;

      const setValue = (value, label) => {
        input.value = value;
        labelEl.textContent = label;
        trigger.classList.toggle('has-value', value !== '');
        menu.querySelectorAll('[role="option"]').forEach((opt) => {
          opt.classList.toggle('is-active', opt.getAttribute('data-value') === value);
        });
      };

      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const willOpen = menu.hidden;
        closeAll();
        if (willOpen) {
          root.classList.add('is-open');
          menu.hidden = false;
          trigger.setAttribute('aria-expanded', 'true');
        }
      });

      menu.addEventListener('click', (e) => {
        const opt = e.target.closest('[role="option"]');
        if (!opt || !menu.contains(opt)) return;
        e.preventDefault();
        e.stopPropagation();
        setValue(opt.getAttribute('data-value') || '', opt.getAttribute('data-label') || opt.textContent.trim());
        closeAll();
      });
    });

    document.addEventListener('click', () => closeAll());
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeAll();
    });
  };

  const initPartnersSwiper = () => {
    const section = document.querySelector('section.partners');
    if (!section) return;
    if (typeof window.Swiper === 'undefined') return;

    const ensureSwiperEl = () => {
      let el = section.querySelector('.partners-swiper');
      if (el) {
        const grid = section.querySelector('.partners-grid, .partners-static');
        if (grid) grid.classList.add('partners-static');
        return el;
      }

      const imgs = Array.from(section.querySelectorAll('img'));
      if (imgs.length < 2) return null;

      const staticRoot =
        imgs[0].closest('.flex.flex-wrap') ||
        imgs[0].closest('[class*="flex-wrap"]') ||
        imgs[0].parentElement;
      if (staticRoot) staticRoot.classList.add('partners-static');

      el = document.createElement('div');
      el.className = 'swiper partners-swiper';
      el.setAttribute('aria-label', 'Partner logos');
      const wrapper = document.createElement('div');
      wrapper.className = 'swiper-wrapper';
      imgs.forEach((img) => {
        const slide = document.createElement('div');
        slide.className = 'swiper-slide';
        const inner = document.createElement('div');
        inner.className = 'partners-slide-inner';
        inner.appendChild(img.cloneNode(true));
        slide.appendChild(inner);
        wrapper.appendChild(slide);
      });
      el.appendChild(wrapper);
      const host = (staticRoot && staticRoot.parentElement) || section.querySelector('.sec-pad') || section;
      host.appendChild(el);
      return el;
    };

    const el = ensureSwiperEl();
    if (!el) return;

    const slideCount = el.querySelectorAll('.swiper-slide').length;
    if (slideCount < 2) return;

    let swiper = null;
    const mqMobile = window.matchMedia('(max-width: 991px)');

    const mount = () => {
      if (mqMobile.matches) {
        if (swiper) return;
        const host = el.parentElement || section;
        let paginationEl = section.querySelector('.partners-pagination');
        if (!paginationEl) {
          paginationEl = document.createElement('div');
          paginationEl.className = 'swiper-pagination partners-pagination';
          paginationEl.setAttribute('aria-hidden', 'true');
          if (el.parentElement) {
            el.parentElement.insertBefore(paginationEl, el.nextSibling);
          } else {
            host.appendChild(paginationEl);
          }
        }
        const base = {
          loop: true,
          speed: 500,
          slidesPerView: 2.2,
          spaceBetween: 16,
          breakpoints: {
            480: { slidesPerView: 3, spaceBetween: 18 },
            768: { slidesPerView: 4, spaceBetween: 22 },
          },
          pagination: {
            el: paginationEl,
            clickable: true,
          },
        };
        const opts = J() ? J().withAutoNav(base, el, host, 'partners') : {
          ...base,
          autoplay: { delay: 2800, disableOnInteraction: false },
        };
        swiper = new window.Swiper(el, opts);
        if (J()) J().startAutoplay(swiper);
      } else if (swiper) {
        swiper.destroy(true, true);
        swiper = null;
      }
    };

    mount();
    if (mqMobile.addEventListener) mqMobile.addEventListener('change', mount);
    else if (mqMobile.addListener) mqMobile.addListener(mount);
  };

  const initAll = () => {
    const run = () => {
      initBannersSwiper();
      initAboutUsSwiper();
      initPartnersSwiper();
      initOdmSwiper();
      initOemSwiper();
      initHotStylesSwiper();
      initExcitingUpdatesSwiper();
      initVideoRecommendsSwiper();
      initCollectBtns();
      initInquirySelect();
    };
    if (typeof window.Swiper === 'undefined' || typeof window.JunexSwiper === 'undefined') {
      setTimeout(initAll, 40);
      return;
    }
    run();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
  } else {
    initAll();
  }
})();
