/**
 * SNS share helpers for product/blog share bars.
 * Platforms with share intents open a popup; others fall back to configured profile link.
 */
(function () {
  function absUrl(u) {
    u = (u || '').trim();
    if (!u) return window.location.href;
    if (/^https?:\/\//i.test(u)) return u;
    try {
      return new URL(u, window.location.origin).href;
    } catch (e) {
      return window.location.href;
    }
  }

  function buildShareUrl(sign, pageUrl, title, image) {
    var enc = encodeURIComponent;
    sign = String(sign || '').toLowerCase();
    pageUrl = absUrl(pageUrl);
    title = title || document.title || '';
    image = image ? absUrl(image) : '';

    switch (sign) {
      case 'twitter':
      case 'x':
        return 'https://twitter.com/intent/tweet?url=' + enc(pageUrl) + '&text=' + enc(title);
      case 'linkedin':
        return 'https://www.linkedin.com/sharing/share-offsite/?url=' + enc(pageUrl);
      case 'facebook':
      case 'fb':
        return 'https://www.facebook.com/sharer/sharer.php?u=' + enc(pageUrl);
      case 'pinterest':
        return 'https://pinterest.com/pin/create/button/?url=' + enc(pageUrl)
          + (image ? '&media=' + enc(image) : '')
          + '&description=' + enc(title);
      case 'reddit':
        return 'https://www.reddit.com/submit?url=' + enc(pageUrl) + '&title=' + enc(title);
      case 'whatsapp':
        return 'https://api.whatsapp.com/send?text=' + enc(title + ' ' + pageUrl);
      case 'telegram':
        return 'https://t.me/share/url?url=' + enc(pageUrl) + '&text=' + enc(title);
      default:
        // youtube / instagram / others: no page-share intent
        return '';
    }
  }

  function openShare(url) {
    if (!url) return;
    window.open(url, '_blank', 'noopener,noreferrer,width=640,height=560');
  }

  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a.js-sns-share');
    if (!a) return;

    var sign = a.getAttribute('data-sns-sign') || '';
    var pageUrl = a.getAttribute('data-share-url') || window.location.href;
    var title = a.getAttribute('data-share-title') || document.title || '';
    var image = a.getAttribute('data-share-image') || '';
    var fallback = (a.getAttribute('href') || '').trim();

    var shareUrl = buildShareUrl(sign, pageUrl, title, image);
    if (shareUrl) {
      e.preventDefault();
      openShare(shareUrl);
      return;
    }

    if (!fallback || fallback === '#' || fallback === 'javascript:void(0);') {
      e.preventDefault();
      return;
    }
    // allow normal navigation to configured profile link
  }, false);
})();
