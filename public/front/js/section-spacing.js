/**
 * All pages (except header/footer/banner/breadcrumb/popups):
 * Adjacent white OR image-bg sections → shared-edge padding = 2rem (32px)
 * so visual gap = 64px (32+32), NOT 4rem+4rem.
 * Solid colored sections keep original padding.
 */
(function () {
  var PAD_HALF = '2rem'; // 32px

  var SKIP = [
    'footer',
    '.footer',
    '.mobile-nav',
    '.mobile-tabbar',
    '#mobileMenu',
    '.pagebanner',
    '.banners',
    '.breadcrumb',
    '.search_popup',
    '.inquiry_popup',
    '.wishlist_popup',
    '.contact_popup',
    '#videoModal',
    '.video-modal'
  ].join(',');

  function parseRgb(color) {
    if (!color) return null;
    if (color === 'transparent') return { r: 255, g: 255, b: 255, a: 0 };
    var m = color.match(/rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)(?:\s*,\s*([0-9.]+))?\s*\)/i);
    if (!m) return null;
    return {
      r: parseInt(m[1], 10),
      g: parseInt(m[2], 10),
      b: parseInt(m[3], 10),
      a: m[4] !== undefined ? parseFloat(m[4]) : 1
    };
  }

  function isSkipped(el) {
    try {
      return el.matches(SKIP) || !!el.closest(SKIP);
    } catch (e) {
      return false;
    }
  }

  function isNonWhiteRgb(rgb) {
    if (!rgb) return false;
    if (rgb.a === 0) return false;
    return !(rgb.r >= 250 && rgb.g >= 250 && rgb.b >= 250);
  }

  function hasImageBg(st) {
    return (st.backgroundImage || '') !== 'none';
  }

  function childHasCoverImage(section) {
    var kids = section.children;
    for (var i = 0; i < kids.length; i++) {
      var child = kids[i];
      var st = window.getComputedStyle(child);
      if (st.position !== 'absolute' && st.position !== 'fixed') continue;
      if (hasImageBg(st)) return true;
      if (child.getElementsByTagName('img').length > 0) return true;
      var nested = child.querySelectorAll('*');
      for (var j = 0; j < nested.length; j++) {
        if (hasImageBg(window.getComputedStyle(nested[j]))) return true;
      }
    }
    return false;
  }

  function childHasSolidColorOnly(section) {
    var kids = section.children;
    for (var i = 0; i < kids.length; i++) {
      var child = kids[i];
      var st = window.getComputedStyle(child);
      if (st.position !== 'absolute' && st.position !== 'fixed') continue;
      if (hasImageBg(st)) continue;
      if (child.getElementsByTagName('img').length > 0) continue;
      var nestedImg = false;
      var nested = child.querySelectorAll('*');
      for (var j = 0; j < nested.length; j++) {
        if (hasImageBg(window.getComputedStyle(nested[j]))) {
          nestedImg = true;
          break;
        }
      }
      if (nestedImg) continue;
      if (isNonWhiteRgb(parseRgb(st.backgroundColor))) return true;
    }
    return false;
  }

  /** white OR image-bg → eligible; solid color → not */
  function isWhiteOrImageSection(el) {
    if (!el || el.nodeType !== 1 || isSkipped(el)) return false;
    if (el.classList.contains('sec-bg-color')) return false;
    if (el.classList.contains('sec-bg-white')) return true;

    var st = window.getComputedStyle(el);
    if (st.display === 'none' || st.visibility === 'hidden') return false;
    if (st.position === 'fixed' || st.position === 'sticky') return false;

    if (hasImageBg(st) || childHasCoverImage(el)) return true;
    if (childHasSolidColorOnly(el)) return false;

    var rgb = parseRgb(st.backgroundColor);
    if (!rgb) return false;
    if (rgb.a === 0) return true;
    return rgb.r >= 250 && rgb.g >= 250 && rgb.b >= 250;
  }

  function depthIn(section, el) {
    var d = 0;
    var n = el;
    while (n && n !== section) {
      d++;
      n = n.parentElement;
    }
    return n === section ? d : 999;
  }

  function classLooksLikeSectionPad(el) {
    var cls = el.className;
    if (typeof cls !== 'string') return false;
    return /(^|\s)(sec-pad|py-16|py-14|py-12|py-10|pt-16|pt-14|pt-12|pt-10|pb-16|pb-14|pb-12|md4:py-16|md1:py-14|md4:pt-16|pdp-shell|product-details-inner|product-faqs-inner|product-tags-inner|cs-cert-inner|cs-stages-inner|about-us-layout)(\s|$)/.test(cls)
      || /(^|\s)md\d:py-1[0-6](\s|$)/.test(cls)
      || /(^|\s)md\d:pt-1[0-6](\s|$)/.test(cls);
  }

  function findPadEl(section) {
    var markedList = section.querySelectorAll('.sec-pad');
    for (var mi = 0; mi < markedList.length; mi++) {
      var marked = markedList[mi];
      var mst = window.getComputedStyle(marked);
      if (mst.position === 'absolute' || mst.position === 'fixed') continue;
      return marked;
    }
    if (section.classList.contains('sec-pad')) return section;

    var st = window.getComputedStyle(section);
    var selfPt = parseFloat(st.paddingTop) || 0;
    var selfPb = parseFloat(st.paddingBottom) || 0;
    if (selfPt >= 32 || selfPb >= 32) return section;

    var best = null;
    var bestScore = 9999;
    var nodes = section.querySelectorAll('div, section');
    for (var i = 0; i < nodes.length; i++) {
      var el = nodes[i];
      if (isSkipped(el)) continue;
      var d = depthIn(section, el);
      if (d > 5) continue;

      var byClass = classLooksLikeSectionPad(el);
      var cst = window.getComputedStyle(el);
      var pt = parseFloat(cst.paddingTop) || 0;
      var pb = parseFloat(cst.paddingBottom) || 0;
      var maxPad = Math.max(pt, pb);

      if (!byClass && maxPad < 32) continue;

      var both = pt >= 32 && pb >= 32;
      // prefer shallow + class match + both sides
      var score = d * 10 - (byClass ? 5 : 0) - (both ? 3 : 0) - (maxPad >= 56 ? 2 : 0);
      if (score < bestScore) {
        bestScore = score;
        best = el;
      }
    }
    return best;
  }

  function collectSections() {
    var list = [];
    var children = document.body.children;
    for (var i = 0; i < children.length; i++) {
      var el = children[i];
      if (el.tagName !== 'SECTION') continue;
      if (isSkipped(el)) continue;
      var st = window.getComputedStyle(el);
      if (st.position === 'fixed' || st.position === 'sticky') continue;
      if (st.display === 'none') continue;
      list.push(el);
    }
    return list;
  }

  function applySpacing() {
    var sections = collectSections();
    var meta = sections.map(function (sec) {
      var white = isWhiteOrImageSection(sec);
      if (white) {
        sec.classList.add('sec-bg-white');
        sec.classList.remove('sec-bg-color');
      } else {
        sec.classList.add('sec-bg-color');
        sec.classList.remove('sec-bg-white');
      }
      var pad = findPadEl(sec);
      if (pad) pad.classList.add('sec-pad');
      return { el: sec, white: white, pad: pad };
    });

    // Clear only previous half-edge overrides
    meta.forEach(function (item) {
      if (!item.pad) return;
      if (item.pad.dataset.secEdgeTop === '1') {
        item.pad.style.removeProperty('padding-top');
        delete item.pad.dataset.secEdgeTop;
      }
      if (item.pad.dataset.secEdgeBottom === '1') {
        item.pad.style.removeProperty('padding-bottom');
        delete item.pad.dataset.secEdgeBottom;
      }
    });

    for (var i = 0; i < meta.length - 1; i++) {
      var a = meta[i];
      var b = meta[i + 1];
      if (!a.white || !b.white) continue;

      // /blogs 列表 → PRODUCT VIDEO：手机端更紧凑
      var tightBlogsVideo =
        a.el.classList.contains('blogs-list-section') &&
        b.el.classList.contains('blogs-videos-section');
      var edgePad = tightBlogsVideo
        ? (window.innerWidth <= 991 ? '0.5rem' : '1.5rem')
        : PAD_HALF;

      // 仅压缩上一区块底边距；不再给下一区块 .sec-pad 写 padding-top（保留页面自身间距）
      if (a.pad) {
        a.pad.style.setProperty('padding-bottom', edgePad, 'important');
        a.pad.dataset.secEdgeBottom = '1';
      }
    }
  }

  function run() {
    applySpacing();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', run);
  } else {
    run();
  }

  window.addEventListener('load', run);
  setTimeout(run, 0);
  setTimeout(run, 100);
  setTimeout(run, 400);
  setTimeout(run, 1000);
  window.addEventListener('resize', function () {
    window.clearTimeout(window.__secSpaceTimer);
    window.__secSpaceTimer = window.setTimeout(run, 150);
  });
})();
