<x-layout>
@section('tdk')
@include('front.partials.seo-head')
@endsection

@section('page-css-header')
<link type="text/css" rel="stylesheet" href="/front/css/pages/home.css" />
@endsection

@if(isset($pageBanner) && $pageBanner->count())
@section('pagebanner')
@include('front.partials.page-banner-bg')
@endsection
@endif

@section('content')
<section class="w-full breadcrumb bg-[#f7f8fa]">
    <div>
        <div class="mx-auto w-full max-w-[1200px] px-4 py-4 sm2:px-5 md1:px-6 lg1:px-0">
            <nav aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-x-3 gap-y-1">
                <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center gap-2 transition hover:text-themeText-h">
                    <img src="{{ front_webp_url('/front/imgs/breadcrumbs-home.png') }}" alt="Home" class="w-[14px] h-[14px]" />
                    <span class="font-poppins-regular text-f14 text-themeText-p">Home</span>
                </a>
                </li>
                <li class="inline-flex items-center text-themeText-h" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
                </li>
                <li class="inline-flex items-center">
                <span class="font-poppins-regular text-f14 text-themeText-g" aria-current="page">Inquiry List</span>
                </li>
            </ol>
            </nav>
        </div>
    </div>
</section>

<section class="w-full bg-themeBg-a inquirylist">
    <div class="mx-auto w-full max-w-[1200px] px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="py-16">
        <div class="flex flex-col items-center">
            <h2 class="text-f24 font-poppins-semibold text-themeText-f uppercase tracking-wide md1:text-f32">PLEASE SEND YOUR MESSAGE TO US</h2>
            <div class="mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d" aria-hidden="true"></div>
        </div>

        <div id="inquiryCartEmpty" class="mt-10 hidden rounded border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
            <p class="text-f16 text-themeText-p">Your inquiry list is empty.</p>
            <a href="/products" class="mt-4 inline-flex h-11 items-center justify-center bg-themeBg-d px-6 text-f14 font-poppins-medium uppercase tracking-wide text-white transition hover:bg-red-700">Browse Products</a>
        </div>

        <div id="inquiryCartList" class="mt-8 flex flex-col gap-3 md1:mt-12"></div>
    </div>
    </div>
</section>

<section class="send_inquiry w-full">
    <div class="mx-auto flex w-full max-w-[1200px] flex-col px-[15px] sm2:px-5 md1:px-6 lg1:px-0">
    <div class="mt-2 mb-6 md1:mb-8 md4:mb-14">
        <form id="inquiryListForm" class="mt-8 flex flex-col gap-5 md1:mt-10" method="POST" action="{{ route('myinquirys.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="source_url" value="" class="js-inquiry-source-url" />
        <div id="inquiryProductsInputs"></div>

        <div class="flex flex-col gap-5 sm6:flex-row sm6:gap-5">
            <div class="flex flex-1 flex-col gap-2">
            <label class="form-field-label text-f14 font-poppins-regular text-themeText-g">Name <x-front.form-required /></label>
            <input type="text" name="name" required placeholder="Please enter your name" class="h-[42px] sm6:h-[46px] md1:h-[51px] w-full rounded border border-themeBg-h bg-white px-3 text-f14 font-poppins-regular text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d" />
            </div>
            <div class="flex flex-1 flex-col gap-2">
            <label class="form-field-label text-f14 font-poppins-regular text-themeText-g">E-Mail <x-front.form-required /></label>
            <input type="email" name="email" required placeholder="Please enter your email" class="h-[42px] sm6:h-[46px] md1:h-[51px] w-full rounded border border-themeBg-h bg-white px-3 text-f14 font-poppins-regular text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d" />
            </div>
        </div>

        <div class="flex flex-col gap-5 sm6:flex-row sm6:gap-5">
            <div class="flex flex-1 flex-col gap-2">
            <label class="text-f14 font-poppins-regular text-themeText-g">Quantity</label>
            <select name="quantity" class="h-[42px] sm6:h-[46px] md1:h-[51px] w-full appearance-none rounded border border-themeBg-h bg-white px-3 text-f14 font-poppins-regular text-themeText-a outline-none transition focus:border-themeBg-d">
                <option value="">Please select</option>
                <option value="0~100">0~100</option>
                <option value="101~500">101~500</option>
                <option value="501~1000">501~1000</option>
                <option value="1001~5000">1001~5000</option>
                <option value="5000+">5000+</option>
            </select>
            </div>
            <div class="flex flex-1 flex-col gap-2">
            <label class="form-field-label text-f14 font-poppins-regular text-themeText-g">Tel/WhatsAPP</label>
            <input type="tel" name="tel" placeholder="Please enter your phone number" class="h-[42px] sm6:h-[46px] md1:h-[51px] w-full rounded border border-themeBg-h bg-white px-3 text-f14 font-poppins-regular text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d" />
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <label class="form-field-label text-f14 font-poppins-regular text-themeText-g">Content <x-front.form-required /></label>
            <textarea name="content" rows="6" required placeholder="Please enter the content" class="h-[120px] sm6:h-[140px] md1:h-[163px] w-full resize-none rounded border border-themeBg-h bg-white px-3 py-3 text-f14 font-poppins-regular text-themeText-a placeholder-themeText-i outline-none transition focus:border-themeBg-d"></textarea>
        </div>

        @include('front.partials.inquiry-attachment-field', [
            'inputId' => 'inquiry-list-attachments',
            'labelClass' => 'form-field-label text-f14 font-poppins-regular text-themeText-g',
        ])

        <div class="flex justify-center">
            <button type="submit" id="inquiryListSubmit" class="h-[48px] sm6:h-[54px] md1:h-[60px] w-[200px] bg-themeText-f font-poppins-medium text-f18 uppercase tracking-wide text-white transition hover:opacity-90">SEND</button>
        </div>
        </form>
    </div>
    </div>
</section>
@endsection

@section('page-js-footer')
<script type="text/javascript" src="/front/js/inquiry-cart.js"></script>
<script>
(function () {
  function esc(s) {
    return String(s || '').replace(/[&<>"']/g, function (c) {
      return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c];
    });
  }

  function render() {
    if (!window.InquiryCart) return;
    var items = InquiryCart.getAll();
    var $list = document.getElementById('inquiryCartList');
    var $empty = document.getElementById('inquiryCartEmpty');
    var $inputs = document.getElementById('inquiryProductsInputs');
    if (!$list || !$empty || !$inputs) return;

    if (!items.length) {
      $list.innerHTML = '';
      $inputs.innerHTML = '';
      $empty.classList.remove('hidden');
      return;
    }
    $empty.classList.add('hidden');

    $list.innerHTML = items.map(function (item, index) {
      var img = item.image || '{{ front_webp_url('/front/imgs/inquiry-demo.png') }}';
      return (
        '<div class="flex items-center gap-3 border border-black/5 bg-themeBg-g px-3 py-3 sm6:gap-4 sm6:px-4 sm6:py-4 md4:gap-5 md4:px-5" data-product-id="' + item.id + '">' +
          '<div class="h-[70px] w-[70px] flex-shrink-0 overflow-hidden border border-black/5 sm6:h-[90px] sm6:w-[90px] md4:h-[100px] md4:w-[100px]">' +
            '<a href="' + esc(item.url || '#') + '"><img class="h-full w-full object-cover" src="' + esc(img) + '" alt="' + esc(item.name) + '" loading="lazy" /></a>' +
          '</div>' +
          '<div class="flex min-w-0 flex-1 flex-col gap-[6px] sm6:gap-[10px]">' +
            '<a href="' + esc(item.url || '#') + '" class="line-clamp-1 text-f16 font-poppins-semibold leading-[1.4] text-themeText-f transition hover:text-themeBg-d sm6:text-f18">' + esc(item.name) + '</a>' +
            '<div class="flex items-center gap-2">' +
              '<span class="text-f14 font-poppins-medium text-themeText-g">Qty:</span>' +
              '<input type="number" min="1" class="js-inquiry-qty h-9 w-20 rounded border border-themeBg-h bg-white px-2 text-f14" data-product-id="' + item.id + '" value="' + (parseInt(item.quantity, 10) || 1) + '" />' +
            '</div>' +
          '</div>' +
          '<button type="button" class="js-inquiry-remove flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full text-themeText-i transition hover:bg-black/5 hover:text-themeBg-d" data-product-id="' + item.id + '" aria-label="Remove">' +
            '<svg viewBox="0 0 24 24" class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg>' +
          '</button>' +
        '</div>'
      );
    }).join('');

    $inputs.innerHTML = items.map(function (item, index) {
      return (
        '<input type="hidden" name="products[' + index + '][id]" value="' + item.id + '" />' +
        '<input type="hidden" name="products[' + index + '][quantity]" value="' + (parseInt(item.quantity, 10) || 1) + '" class="js-inquiry-qty-hidden" data-product-id="' + item.id + '" />'
      );
    }).join('');
  }

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.js-inquiry-remove');
    if (!btn || !window.InquiryCart) return;
    e.preventDefault();
    InquiryCart.remove(btn.getAttribute('data-product-id'));
    render();
  });

  document.addEventListener('change', function (e) {
    var input = e.target.closest('.js-inquiry-qty');
    if (!input || !window.InquiryCart) return;
    var id = input.getAttribute('data-product-id');
    var qty = Math.max(1, parseInt(input.value, 10) || 1);
    input.value = qty;
    InquiryCart.setQuantity(id, qty);
    var hidden = document.querySelector('.js-inquiry-qty-hidden[data-product-id="' + id + '"]');
    if (hidden) hidden.value = qty;
  });

  var form = document.getElementById('inquiryListForm');
  if (form) {
    var srcField = form.querySelector('.js-inquiry-source-url');
    if (srcField) srcField.value = window.location.href;

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (srcField) srcField.value = window.location.href;
      if (!window.InquiryCart || !InquiryCart.getCount()) {
        if (typeof showMessage === 'function') {
          showMessage({ type: 'warning', message: 'Please add products to your inquiry list first.' });
        } else {
          alert('Please add products to your inquiry list first.');
        }
        return;
      }
      render();
      var submitBtn = document.getElementById('inquiryListSubmit');
      if (submitBtn) submitBtn.disabled = true;

      var fd = new FormData(form);
      fetch(form.action, {
        method: 'POST',
        body: fd,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
        },
      }).then(function (res) {
        return res.json().then(function (data) {
          return { ok: res.ok, data: data };
        });
      }).then(function (result) {
        if (result.ok && result.data && result.data.success) {
          InquiryCart.clear();
          window.location.href = result.data.redirect || '/inquirysuccess';
          return;
        }
        var msg = (result.data && result.data.message) ? result.data.message : 'Submit failed';
        if (typeof showMessage === 'function') showMessage({ type: 'error', message: msg });
        else alert(msg);
      }).catch(function () {
        if (typeof showMessage === 'function') showMessage({ type: 'error', message: 'Network error' });
        else alert('Network error');
      }).finally(function () {
        if (submitBtn) submitBtn.disabled = false;
      });
    });
  }

  if (window.InquiryCart) {
    InquiryCart.onChange(render);
    render();
  } else {
    document.addEventListener('DOMContentLoaded', render);
  }
})();
</script>
@endsection
</x-layout>
