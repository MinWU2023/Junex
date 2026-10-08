/**
 * Junex Inquiry Cart — localStorage-backed multi-product inquiry list
 * Storage key: junex_inquiry_cart
 * Item shape: { id, name, image, url, model, quantity }
 */
(function (window) {
  'use strict';

  var STORAGE_KEY = 'junex_inquiry_cart';
  var CHANGE_EVENT = 'junex:inquiry-cart-change';

  function safeParse(raw) {
    try {
      var data = JSON.parse(raw);
      return Array.isArray(data) ? data : [];
    } catch (e) {
      return [];
    }
  }

  function read() {
    if (!window.localStorage) return [];
    return safeParse(window.localStorage.getItem(STORAGE_KEY) || '[]');
  }

  function write(items) {
    if (!window.localStorage) return;
    window.localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
    window.dispatchEvent(new CustomEvent(CHANGE_EVENT, { detail: { items: items, count: items.length } }));
  }

  function normalizeId(id) {
    var n = parseInt(id, 10);
    return isNaN(n) || n <= 0 ? 0 : n;
  }

  function escapeHtml(str) {
    return String(str == null ? '' : str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function getAll() {
    return read();
  }

  function getCount() {
    return read().length;
  }

  function has(id) {
    id = normalizeId(id);
    if (!id) return false;
    return read().some(function (item) {
      return normalizeId(item.id) === id;
    });
  }

  function add(product) {
    if (!product) return false;
    var id = normalizeId(product.id);
    if (!id) return false;
    var items = read();
    var idx = items.findIndex(function (item) {
      return normalizeId(item.id) === id;
    });
    if (idx >= 0) {
      items[idx] = Object.assign({}, items[idx], {
        name: product.name || items[idx].name || '',
        image: product.image || items[idx].image || '',
        url: product.url || items[idx].url || '#',
        model: product.model || items[idx].model || '',
        quantity: Math.max(1, parseInt(product.quantity || items[idx].quantity || 1, 10) || 1),
      });
    } else {
      items.push({
        id: id,
        name: product.name || '',
        image: product.image || '',
        url: product.url || '#',
        model: product.model || '',
        quantity: Math.max(1, parseInt(product.quantity || 1, 10) || 1),
      });
    }
    write(items);
    return true;
  }

  function remove(id) {
    id = normalizeId(id);
    if (!id) return false;
    var items = read().filter(function (item) {
      return normalizeId(item.id) !== id;
    });
    write(items);
    return true;
  }

  function toggle(product) {
    var id = normalizeId(product && product.id);
    if (!id) return false;
    if (has(id)) {
      remove(id);
      return false;
    }
    add(product);
    return true;
  }

  function setQuantity(id, quantity) {
    id = normalizeId(id);
    quantity = Math.max(1, parseInt(quantity, 10) || 1);
    if (!id) return false;
    var items = read();
    var found = false;
    items.forEach(function (item) {
      if (normalizeId(item.id) === id) {
        item.quantity = quantity;
        found = true;
      }
    });
    if (found) write(items);
    return found;
  }

  function clear() {
    write([]);
  }

  function syncCheckboxes(root) {
    var scope = root || document;
    var boxes = scope.querySelectorAll('.js-inquiry-toggle');
    boxes.forEach(function (el) {
      var id = normalizeId(el.getAttribute('data-product-id'));
      el.checked = id ? has(id) : false;
    });
  }

  function syncBadge() {
    var count = getCount();
    document.querySelectorAll('.inquiry-cart-badge').forEach(function (badge) {
      badge.textContent = String(count > 99 ? '99+' : count);
      if (badge.classList.contains('inquiry-cart-badge-float')) {
        if (count > 0) badge.classList.remove('hidden');
        else badge.classList.add('hidden');
      }
    });
  }

  function syncFloatPopup() {
    var emptyEl = document.querySelector('.js-inquiry-float-empty');
    var listEl = document.querySelector('.js-inquiry-float-list');
    var footerEl = document.querySelector('.js-inquiry-float-footer');
    if (!emptyEl || !listEl) return;

    var items = getAll();
    if (!items.length) {
      emptyEl.classList.remove('hidden');
      listEl.classList.add('hidden');
      listEl.innerHTML = '';
      if (footerEl) footerEl.classList.add('hidden');
      return;
    }

    emptyEl.classList.add('hidden');
    listEl.classList.remove('hidden');
    if (footerEl) footerEl.classList.remove('hidden');

    listEl.innerHTML = items
      .map(function (item) {
        var id = normalizeId(item.id);
        var name = escapeHtml(item.name || '');
        var image = escapeHtml(item.image || '');
        var url = escapeHtml(item.url || '#');
        var imgHtml = image
          ? '<img src="' + image + '" alt="' + name + '" class="h-full w-full object-cover" />'
          : '';
        var titleHtml = url && url !== '#'
          ? '<a href="' + url + '" class="line-clamp-2 hover:text-themeBg-d">' + name + '</a>'
          : '<span class="line-clamp-2">' + name + '</span>';

        return (
          '<div class="wishlist_item js-inquiry-float-item flex items-center gap-2 border-b border-slate-100 px-3 py-2" data-product-id="' + id + '">' +
          '  <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded border border-slate-200 bg-slate-50">' +
          imgHtml +
          '  </div>' +
          '  <div class="min-w-0 flex-1 text-[12px] leading-4 text-slate-700">' +
          titleHtml +
          '  </div>' +
          '  <button type="button" class="js-inquiry-float-remove flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-themeBg-d" data-product-id="' + id + '" aria-label="Remove">' +
          '    <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>' +
          '  </button>' +
          '</div>'
        );
      })
      .join('');
  }

  function syncPdpButtons(root) {
    var scope = root || document;
    scope.querySelectorAll('.js-inquiry-pdp-toggle').forEach(function (btn) {
      var id = normalizeId(btn.getAttribute('data-product-id'));
      var inInquiry = id ? has(id) : false;
      btn.setAttribute('data-in-inquiry', inInquiry ? '1' : '0');
      btn.setAttribute('aria-label', inInquiry ? 'Remove from inquiry' : 'Add to inquiry');
      var text = btn.querySelector('.inquiry-pdp-text');
      if (text) {
        text.textContent = inInquiry ? 'REMOVE FROM INQUIRY' : 'ADD TO INQUIRY';
      }
    });
  }

  function productFromPdpButton(el) {
    return {
      id: el.getAttribute('data-product-id'),
      name: el.getAttribute('data-product-name') || '',
      image: el.getAttribute('data-product-image') || '',
      url: el.getAttribute('data-product-url') || '#',
      model: el.getAttribute('data-product-model') || '',
      quantity: 1,
    };
  }

  function productFromCheckbox(el) {
    return {
      id: el.getAttribute('data-product-id'),
      name: el.getAttribute('data-product-name') || '',
      image: el.getAttribute('data-product-image') || '',
      url: el.getAttribute('data-product-url') || '#',
      model: el.getAttribute('data-product-model') || '',
      quantity: 1,
    };
  }

  function bindCheckboxEvents() {
    document.addEventListener('change', function (e) {
      var el = e.target.closest('.js-inquiry-toggle');
      if (!el) return;
      e.stopPropagation();
      var product = productFromCheckbox(el);
      if (el.checked) {
        add(product);
      } else {
        remove(product.id);
      }
    });

    // Prevent card link navigation when clicking checkbox area
    document.addEventListener('click', function (e) {
      var wrap = e.target.closest('.js-inquiry-toggle-wrap');
      if (!wrap) return;

      var box = wrap.querySelector('.js-inquiry-toggle');
      if (!box) return;

      // Native checkbox click: do not preventDefault (that blocks toggle).
      // Still stopPropagation so parent card links do not navigate.
      if (e.target === box || box.contains(e.target)) {
        e.stopPropagation();
        return;
      }

      e.preventDefault();
      e.stopPropagation();
      box.checked = !box.checked;
      box.dispatchEvent(new Event('change', { bubbles: true }));
    });
  }

  function bindPdpButtonEvents() {
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.js-inquiry-pdp-toggle');
      if (!btn) return;
      e.preventDefault();
      e.stopPropagation();
      if (!window.InquiryCart) return;
      toggle(productFromPdpButton(btn));
      if (typeof showMessage === 'function') {
        var inInquiry = has(btn.getAttribute('data-product-id'));
        showMessage({
          type: 'success',
          message: inInquiry ? 'Added to inquiry list.' : 'Removed from inquiry list.',
        });
      }
    });
  }

  function bindFloatPopupEvents() {
    // Bind on the panel itself: main.js stops propagation on .wishlist_popup_panel,
    // so document-level bubble listeners never see Clear / Contact / Remove clicks.
    function handleFloatClick(e) {
      var removeBtn = e.target.closest('.js-inquiry-float-remove');
      if (removeBtn) {
        e.preventDefault();
        e.stopPropagation();
        remove(removeBtn.getAttribute('data-product-id'));
        return;
      }

      var clearBtn = e.target.closest('.js-inquiry-float-clear');
      if (clearBtn) {
        e.preventDefault();
        e.stopPropagation();
        clear();
        return;
      }

      var contactBtn = e.target.closest('.js-inquiry-float-contact');
      if (contactBtn) {
        e.preventDefault();
        e.stopPropagation();
        if (!getCount()) return;
        window.location.href = '/myinquirys';
      }
    }

    var panel = document.querySelector('.wishlist_popup .wishlist_popup_panel');
    if (panel) {
      panel.addEventListener('click', handleFloatClick);
    } else {
      document.addEventListener('click', handleFloatClick);
    }
  }

  function onChange(cb) {
    window.addEventListener(CHANGE_EVENT, function (e) {
      cb(e.detail || {});
    });
  }

  function init() {
    bindCheckboxEvents();
    bindPdpButtonEvents();
    bindFloatPopupEvents();
    syncCheckboxes();
    syncPdpButtons();
    syncBadge();
    syncFloatPopup();
    onChange(function () {
      syncCheckboxes();
      syncPdpButtons();
      syncBadge();
      syncFloatPopup();
    });
  }

  window.InquiryCart = {
    getAll: getAll,
    getCount: getCount,
    has: has,
    add: add,
    remove: remove,
    toggle: toggle,
    setQuantity: setQuantity,
    clear: clear,
    syncCheckboxes: syncCheckboxes,
    syncPdpButtons: syncPdpButtons,
    syncBadge: syncBadge,
    syncFloatPopup: syncFloatPopup,
    onChange: onChange,
    init: init,
    STORAGE_KEY: STORAGE_KEY,
    CHANGE_EVENT: CHANGE_EVENT,
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})(window);
