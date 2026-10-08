<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no" />
    <meta name="color-scheme" content="light" />
    <meta name="theme-color" content="#0b1220" />
    @php
      // 后台 ico 常为相对路径（无前导 /），详情页等 URL 下会解析错；统一成站点根路径，SVG 补 type
      $siteIco = front_image_url($data['setting']->ico ?? null);
      $faviconHref = $siteIco !== '' ? $siteIco : asset('favicon.ico');
      $faviconPath = strtolower((string) (parse_url($faviconHref, PHP_URL_PATH) ?: $faviconHref));
      $faviconType = str_ends_with($faviconPath, '.svg') ? 'image/svg+xml' : null;
    @endphp
    <link rel="icon" href="@yield('favicon', $faviconHref)"@if($faviconType) type="{{ $faviconType }}"@endif>
    @yield('tdk')

    <style type="text/css">
      @font-face { font-family: 'Poppins-Regular'; src: url('/front/fonts/Poppins-Regular.ttf') format('truetype'); font-weight: 400; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-Italic'; src: url('/front/fonts/Poppins-Italic.ttf') format('truetype'); font-weight: 400; font-style: italic; font-display: swap; }

      @font-face { font-family: 'Poppins-Thin'; src: url('/front/fonts/Poppins-Thin.ttf') format('truetype'); font-weight: 100; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-ThinItalic'; src: url('/front/fonts/Poppins-ThinItalic.ttf') format('truetype'); font-weight: 100; font-style: italic; font-display: swap; }

      @font-face { font-family: 'Poppins-ExtraLight'; src: url('/front/fonts/Poppins-ExtraLight.ttf') format('truetype'); font-weight: 200; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-ExtraLightItalic'; src: url('/front/fonts/Poppins-ExtraLightItalic.ttf') format('truetype'); font-weight: 200; font-style: italic; font-display: swap; }

      @font-face { font-family: 'Poppins-Light'; src: url('/front/fonts/Poppins-Light.ttf') format('truetype'); font-weight: 300; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-LightItalic'; src: url('/front/fonts/Poppins-LightItalic.ttf') format('truetype'); font-weight: 300; font-style: italic; font-display: swap; }

      @font-face { font-family: 'Poppins-Medium'; src: url('/front/fonts/Poppins-Medium.ttf') format('truetype'); font-weight: 500; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-MediumItalic'; src: url('/front/fonts/Poppins-MediumItalic.ttf') format('truetype'); font-weight: 500; font-style: italic; font-display: swap; }

      @font-face { font-family: 'Poppins-SemiBold'; src: url('/front/fonts/Poppins-SemiBold.ttf') format('truetype'); font-weight: 600; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-SemiBoldItalic'; src: url('/front/fonts/Poppins-SemiBoldItalic.ttf') format('truetype'); font-weight: 600; font-style: italic; font-display: swap; }

      @font-face { font-family: 'Poppins-Bold'; src: url('/front/fonts/Poppins-Bold.ttf') format('truetype'); font-weight: 700; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-BoldItalic'; src: url('/front/fonts/Poppins-BoldItalic.ttf') format('truetype'); font-weight: 700; font-style: italic; font-display: swap; }

      @font-face { font-family: 'Poppins-ExtraBold'; src: url('/front/fonts/Poppins-ExtraBold.ttf') format('truetype'); font-weight: 800; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-ExtraBoldItalic'; src: url('/front/fonts/Poppins-ExtraBoldItalic.ttf') format('truetype'); font-weight: 800; font-style: italic; font-display: swap; }

      @font-face { font-family: 'Poppins-Black'; src: url('/front/fonts/Poppins-Black.ttf') format('truetype'); font-weight: 900; font-style: normal; font-display: swap; }
      @font-face { font-family: 'Poppins-BlackItalic'; src: url('/front/fonts/Poppins-BlackItalic.ttf') format('truetype'); font-weight: 900; font-style: italic; font-display: swap; }

      @media screen and (max-width: 600px) {
        .home_cates_big { position: relative; }
        .home_cates_big::before { content: ''; position: absolute; inset: 0; background: rgba(0, 0, 0, 0.35); z-index: 1; }
        .home_cates_big_grid { display: grid !important; grid-template-columns: 1fr !important; grid-template-rows: 1fr !important; height: 100%; }
        .home_cates_big_img { grid-column: 1 / 1; grid-row: 1 / 1; z-index: 0; position: relative; }
        .home_cates_big_text { grid-column: 1 / 1; grid-row: 1 / 1; z-index: 2; position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        .home_cates_big_text h3 { color: #fff; }
        .home_cates_big_text p { color: rgba(255, 255, 255, 0.9); }
      }

      /* FULL CUSTOMIZATION: intro subtitles left; feature card copy stays centered */
      section.full_cus .py-12 > p.full-cus-subtitle,
      section.full_cus p.full-cus-subtitle {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        align-self: stretch !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        text-align: left !important;
      }
      section.full_cus .grid > div.text-center,
      section.full_cus .grid > div > p {
        text-align: center !important;
      }
    </style>

    <!-- Tailwind Css -->
    <script  type="text/javascript" src="/front/js/tailwindcss.js"></script>
    <script type="text/javascript">
      window.tailwind = window.tailwind || {};
      window.tailwind.config = {
        theme: {
          fontFamily: {
            sans: ['Poppins-Regular', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            poppins: ['Poppins-Regular', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-regular': ['Poppins-Regular', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-italic': ['Poppins-Italic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-thin': ['Poppins-Thin', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-thin-italic': ['Poppins-ThinItalic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-extralight': ['Poppins-ExtraLight', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-extralight-italic': ['Poppins-ExtraLightItalic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-light': ['Poppins-Light', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-light-italic': ['Poppins-LightItalic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-medium': ['Poppins-Medium', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-medium-italic': ['Poppins-MediumItalic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-semibold': ['Poppins-SemiBold', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-semibold-italic': ['Poppins-SemiBoldItalic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-bold': ['Poppins-Bold', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-bold-italic': ['Poppins-BoldItalic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-extrabold': ['Poppins-ExtraBold', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-extrabold-italic': ['Poppins-ExtraBoldItalic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-black': ['Poppins-Black', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            'poppins-black-italic': ['Poppins-BlackItalic', 'ui-sans-serif', 'system-ui', 'sans-serif']
          },
          extend: {
            screens: {
                    lg7: '1920px',lg6: '1680px', lg5: '1600px', lg4: '1560px', lg3: '1440px',lg2: '1280px',lg1: '1200px',md7: '1192px',md6: '1080px',md5: '1024px', md4: '992px',md3: '800px',md2: '768px', md1: '600px', sm7: '560px', sm6: '480px',sm5: '420px',sm4: '390px',sm3: '375px',sm2: '360px',sm1:'340px'
            },
            fontSize: {
              f48: ['clamp(2rem, 1.6vw + 1.6rem, 3rem)', { lineHeight: '1.1' }],
              f46: ['clamp(2rem, 1.55vw + 1.55rem, 2.875rem)', { lineHeight: '1.12' }],
              f44: ['clamp(1.875rem, 1.5vw + 1.5rem, 2.75rem)', { lineHeight: '1.12' }],
              f42: ['clamp(1.75rem, 1.45vw + 1.45rem, 2.625rem)', { lineHeight: '1.15' }],
              f40: ['clamp(1.75rem, 1.35vw + 1.35rem, 2.5rem)', { lineHeight: '1.15' }],
              f38: ['clamp(1.625rem, 1.25vw + 1.25rem, 2.375rem)', { lineHeight: '1.2' }],
              f36: ['clamp(1.5rem, 1.15vw + 1.15rem, 2.25rem)', { lineHeight: '1.2' }],
              f34: ['clamp(1.375rem, 1.05vw + 1.05rem, 2.125rem)', { lineHeight: '1.25' }],
              f32: ['clamp(1.25rem, 1vw + 1rem, 2rem)', { lineHeight: '1.25' }],
              f30: ['clamp(1.125rem, 0.9vw + 0.95rem, 1.875rem)', { lineHeight: '1.3' }],
              f28: ['clamp(1rem, 0.8vw + 0.9rem, 1.75rem)', { lineHeight: '1.35' }],
              f26: ['clamp(1rem, 0.7vw + 0.85rem, 1.625rem)', { lineHeight: '1.4' }],
              f24: ['clamp(0.875rem, 0.6vw + 0.8rem, 1.5rem)', { lineHeight: '1.45' }],
              f22: ['clamp(0.875rem, 0.5vw + 0.78rem, 1.375rem)', { lineHeight: '1.5' }],
              f20: ['clamp(0.8125rem, 0.45vw + 0.75rem, 1.25rem)', { lineHeight: '1.55' }],
              f18: ['clamp(0.75rem, 0.4vw + 0.72rem, 1.125rem)', { lineHeight: '1.6' }],
              f16: ['clamp(0.875rem, 0.26vw + 0.75rem, 1rem)', { lineHeight: '1.6' }],
              f15: ['clamp(0.8125rem, 0.28vw + 0.7rem, 0.9375rem)', { lineHeight: '1.6' }],
              f14: ['clamp(0.75rem, 0.25vw + 0.68rem, 0.875rem)', { lineHeight: '1.6' }],
              f12: ['clamp(0.75rem, 0.15vw + 0.66rem, 0.75rem)', { lineHeight: '1.6' }]
            },
              colors: {
              themeText: {a: '#0f172a',b: '#111827',c: '#334155',d: '#475569',f:'#000000',g:'#333333',h:"#D92B28",o: '#CFCFCF',p:'#666666'},
              themeBg: {m: '#CFCFCF',n: '#33373B',o:'#f5f3ff',a: '#ffffff',b: '#f8fafc',c: '#f1f5f9',d: '#D92B28',e: '#0b1220',f:'#F8F8F8',g:'#F4F4F4',h:"#DFDFDF"},
              'brand-red': '#D92B28',
              'brand-navy': '#1A202C',
              'brand-dark': '#0b1220',
              'brand-gray-light': '#F3F4F6',
              'brand-black': '#000000',
              'sample-red': '#D92B28',
              'sample-red-light': '#FFF5F5',
              'sample-lead': '#585858'
            }
          }
        }
      };
    </script>
    <style type="text/css">
      /* Hover: link / button label uses theme red (#D92B28). Red-filled controls keep white text. */
      a:hover,
      button:hover,
      input[type="button"]:hover,
      input[type="submit"]:hover,
      input[type="reset"]:hover,
      a:hover *,
      button:hover * {
        color: #D92B28 !important;
      }

      a.bg-themeBg-d:hover,
      button.bg-themeBg-d:hover,
      input.bg-themeBg-d:hover,
      a.bg-themeBg-d:hover *,
      button.bg-themeBg-d:hover *,
      a[class~="hover:bg-themeBg-d"]:hover,
      button[class~="hover:bg-themeBg-d"]:hover,
      a[class~="hover:bg-themeBg-d"]:hover *,
      button[class~="hover:bg-themeBg-d"]:hover *,
      a[class~="hover:bg-red-700"]:hover,
      button[class~="hover:bg-red-700"]:hover,
      a[class~="hover:bg-red-700"]:hover *,
      button[class~="hover:bg-red-700"]:hover *,
      a[class~="hover:bg-[#c22522]"]:hover,
      button[class~="hover:bg-[#c22522]"]:hover,
      a[class~="hover:bg-[#c22522]"]:hover *,
      button[class~="hover:bg-[#c22522]"]:hover *,
      a[class~="hover:text-white"]:hover,
      button[class~="hover:text-white"]:hover,
      a[class~="hover:text-white"]:hover *,
      button[class~="hover:text-white"]:hover *,
      /* 视频播放按钮：悬停保持白色三角，避免与红底叠成实心圆点 */
      a.js-video-modal:hover .video-card__play,
      a.js-video-modal:hover .video-card__play *,
      a.js-video-modal:hover .video-play-btn,
      a.js-video-modal:hover .video-play-btn * {
        color: #ffffff !important;
        fill: #ffffff !important;
      }
    </style>
    <style type="text/tailwindcss">
      @layer components {
        .pdp-shell { @apply pt-[18px] pb-16 md4:py-16; }
        .pdp-layout { @apply flex flex-col gap-6 md4:flex-row md4:gap-10; }
        .pdp-gallery { @apply w-full flex-none md4:w-[44.8%]; }
        .pdp-main-frame { @apply aspect-[1/1] w-full overflow-hidden bg-themeBg-g; }
        .pdp-main-img { @apply h-full w-full object-cover; }
        .pdp-thumbs { @apply mt-3; }
        .pdp-thumb { @apply flex h-[68px] w-[68px] items-center justify-center overflow-hidden border-[2px] border-transparent bg-themeBg-g; }
        .productThumbSwiper .swiper-slide-thumb-active .pdp-thumb { @apply border-[#da2b28]; }
        .pdp-thumb-img { @apply h-full w-full object-cover; }
        .pdp-info { @apply flex flex-1 flex-col; }
        .pdp-title { @apply font-poppins-medium text-themeText-f text-f22; }
        .pdp-share { @apply mt-5; }
        .product-share-bar { @apply flex items-center gap-3; }
        .product-share-label { @apply text-f15 font-poppins-medium text-themeText-g; }
        .product-share-list { @apply flex items-center gap-2; }
        .product-share-link { @apply inline-flex items-center justify-center transition duration-200 hover:-translate-y-0.5 hover:opacity-95; }
        .pdp-specs { @apply mt-5 space-y-3; }
        .pdp-spec-row { @apply grid grid-cols-[110px_1fr] items-start gap-x-3 sm6:grid-cols-[140px_1fr] sm6:gap-x-4 md4:grid-cols-[200px_1fr] md4:gap-x-6; }
        .attr-label { @apply min-w-0 text-f15 font-semibold text-gray-700 font-poppins-medium; }
        .attr-value { @apply min-w-0 break-words text-[15px] text-themeText-p font-poppins-regular; }
        .pdp-actions { @apply mt-6 flex flex-wrap items-center gap-6; }
        .pdp-btn-quote { @apply inline-flex h-[50px] items-center justify-center gap-2 bg-themeBg-d px-6 text-f14 font-poppins-medium text-white transition hover:bg-red-700; }
        .pdp-btn-fav { @apply inline-flex h-[50px] items-center justify-center gap-2 bg-black px-6 text-f14 font-poppins-medium text-white transition hover:bg-gray-800; }
        .pdp-section-head { @apply relative flex items-center gap-3 bg-themeBg-g py-2 pl-[62px]; }
        .pdp-section-icon { @apply absolute left-0 top-[-8px] flex h-[50px] w-[50px] items-center justify-center bg-themeBg-d; }
        .pdp-section-title { @apply text-f22 font-poppins-medium text-themeText-f; }
        .product-details { @apply relative w-full bg-white; }
        .product-details-inner { @apply py-16; }
        /* Typography/table styles come from scoped Bootstrap (product-highlights.css) */
        .product-details-content { @apply mt-2; }
        .product-tags { @apply relative w-full bg-white; }
        .product-tags-inner { @apply py-16; }
        .product-tags-list { @apply mt-6 flex flex-wrap gap-2.5 sm2:mt-7 sm2:gap-3 md1:mt-8 md1:gap-3.5; }
        .product-tag-link {
          @apply inline-flex max-w-full items-center break-words bg-themeBg-g px-3.5 py-2 text-f14 font-poppins-regular text-themeText-p transition duration-200
            hover:bg-themeBg-d hover:text-white
            sm2:px-4 sm2:py-2.5
            md1:px-5 md1:text-[15px];
        }
        .product-faqs { @apply relative w-full bg-white; }
        .product-faqs-inner { @apply py-16; }
        .product-faqs-panel { @apply mt-6 flex w-full flex-col bg-themeBg-g p-5 sm2:mt-7 sm2:p-7 md1:mt-8 md1:p-10; }
        .product-faq-accordion { @apply border-t border-gray-300; }
        .product-faq-accordion:first-child { @apply border-t-0; }
        .product-faq-accordion:last-child { @apply border-b; }
        .product-faq-trigger { @apply flex w-full items-center justify-between py-4 text-left md1:py-5; }
        .product-faq-subject { @apply pr-4 text-f16 font-poppins-regular text-themeText-f sm2:text-f18; }
        .product-faq-icon { @apply h-5 w-5 flex-shrink-0 text-themeText-d transition-transform duration-300; }
        .product-faq-content { @apply pb-4; }
        .product-faq-answer { @apply text-f14 font-poppins-regular leading-relaxed text-themeText-g sm2:text-f16; }
        /* Customer Services — Multiple Certificate Verification */
        .cs-cert { @apply w-full bg-white; }
        .cs-cert-inner { @apply mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0; }
        .cs-cert-header { @apply text-center; }
        .cs-cert-title { @apply text-f24 font-poppins-semibold uppercase tracking-wide text-themeText-f sm2:text-f28 md1:text-f32; }
        .cs-cert-bar { @apply mx-auto mt-3 h-[7px] w-[46px] rounded bg-themeBg-d; }

        /* Inquiry attachment dropzone */
        .inquiry-attach__zone.is-dragover {
          border-color: #D92B28 !important;
          background: linear-gradient(180deg, rgba(217,43,40,0.08) 0%, #fff 100%) !important;
          box-shadow: inset 0 0 0 1px rgba(217,43,40,0.25);
        }
        .inquiry-attach__zone.is-dragover .js-inquiry-attach-overlay {
          display: flex !important;
        }
        .inquiry-attach__file {
          display: flex;
          align-items: center;
          gap: 10px;
          padding: 10px 12px;
          border: 1px solid #e8e8e8;
          background: #fff;
          transition: border-color .2s, box-shadow .2s;
        }
        .inquiry-attach__file:hover {
          border-color: rgba(217,43,40,0.35);
          box-shadow: 0 4px 14px rgba(15,23,42,0.06);
        }
        .inquiry-attach__file-icon {
          flex: 0 0 auto;
          width: 36px;
          height: 36px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          border-radius: 999px;
          background: rgba(217,43,40,0.08);
          color: #D92B28;
        }
        .inquiry-attach__file-meta {
          flex: 1;
          min-width: 0;
        }
        .inquiry-attach__file-name {
          display: block;
          font-size: 13px;
          line-height: 1.35;
          color: #1f2937;
          font-weight: 500;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }
        .inquiry-attach__file-size {
          display: block;
          margin-top: 2px;
          font-size: 11px;
          color: #94a3b8;
        }
        .inquiry-attach__file-remove {
          flex: 0 0 auto;
          width: 28px;
          height: 28px;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          border-radius: 999px;
          color: #94a3b8;
          transition: background .15s, color .15s;
        }
        .inquiry-attach__file-remove:hover {
          background: rgba(217,43,40,0.1);
          color: #D92B28;
        }
        .inquiry-attach--compact .inquiry-attach__file {
          padding: 8px 10px;
        }
        .inquiry-attach--compact .inquiry-attach__file-icon {
          width: 30px;
          height: 30px;
        }
        .inquiry-attach--compact .inquiry-attach__file-name {
          font-size: 12px;
        }
        .cs-cert-desc { @apply mx-auto mt-4 max-w-[825px] text-f14 leading-6 text-themeText-g font-poppins-regular sm2:text-f16; }
        .cs-cert-grid { @apply mt-8 grid grid-cols-1 gap-5 sm2:mt-10 sm2:gap-6 sm6:grid-cols-2 md4:grid-cols-4; }
        .cs-cert-carousel { @apply relative mx-auto mt-8 mb-10 w-full max-w-[1344px] px-4 sm2:mt-10 sm2:px-5 md1:mb-12 md1:px-16 md4:mb-14; }
        .cs-cert-viewport { @apply mx-auto w-full max-w-[1200px]; }
        .cs-cert-swiper { @apply w-full; }
        .cs-cert-swiper .swiper-slide { @apply h-auto; }
        .cs-cert-nav {
          @apply absolute top-1/2 z-10 hidden h-[56px] w-[56px] -translate-y-1/2 cursor-pointer items-center justify-center border-0 bg-black/50 text-white transition hover:bg-black/80 md1:flex;
        }
        .cs-cert-nav::after { content: none !important; }
        .cs-cert-prev { @apply left-0; }
        .cs-cert-next { @apply right-0; }
        .cs-cert-nav-icon { @apply h-7 w-4; }
        .cs-cert-pagination {
          @apply relative z-10 mt-5 flex items-center justify-center gap-2 md1:hidden;
        }
        .cs-cert-pagination .swiper-pagination-bullet {
          @apply m-0 h-2 w-2 cursor-pointer rounded-full bg-slate-300 opacity-100 transition;
        }
        .cs-cert-pagination .swiper-pagination-bullet-active {
          @apply w-5 rounded-full bg-themeBg-d;
        }
        .cs-cert-card { @apply h-full overflow-hidden border border-gray-100 bg-white shadow-sm transition-shadow duration-200 hover:shadow-md; }
        .cs-cert-img { @apply h-auto w-full object-contain; }
        /* Customer Services — Four Sample Stages */
        .cs-stages { @apply w-full bg-themeBg-f; }
        .cs-stages-inner { @apply mx-auto w-full max-w-[1200px] px-4 py-16 sm2:px-5 md1:px-6 lg1:px-0; }
        .cs-stages-header { @apply text-center; }
        .cs-stages-title { @apply mx-auto max-w-[980px] text-f24 font-poppins-semibold uppercase leading-snug tracking-wide text-themeText-f sm2:text-f28 md1:text-f32; }
        .cs-stages-bar { @apply mx-auto mt-3 h-[7px] w-[46px] rounded bg-sample-red; }
        .cs-stages-desc { @apply mx-auto mt-4 max-w-[825px] text-f14 leading-6 text-themeText-g font-poppins-regular sm2:text-f16; }
        .cs-stages-grid {
          @apply mt-10 grid grid-cols-1 justify-items-center gap-6 sm2:mt-12 sm6:grid-cols-2 md4:grid-cols-4 md4:justify-items-stretch md4:gap-4;
        }
        .sample-stage-card,
        .sample-card {
          @apply flex w-full max-w-[288px] flex-col rounded border border-gray-100 border-t-4 border-t-sample-red bg-white shadow-sm transition-shadow duration-200 hover:shadow-md md4:w-[288px] md4:max-w-[288px];
        }
        .sample-stage-tag,
        .sample-badge {
          @apply mb-0 inline-block max-w-full self-start text-f12 font-poppins-semibold uppercase tracking-wide text-sample-red;
          display: inline-block !important;
          width: fit-content !important;
          max-width: 100%;
          padding: 10px;
          border-radius: 4px;
          box-sizing: border-box;
          background-color: #FFF5F5;
          color: #D92B28;
          align-self: flex-start;
        }
        .sample-stage-title { @apply mb-0 flex-none font-poppins-semibold leading-snug text-themeText-f; font-size: 18px; }
        .sample-stage-list { @apply flex flex-none flex-col gap-0; }
        .sample-stage-item,
        .sample-feature-item {
          @apply flex items-start gap-2 text-f14 leading-[1.55] font-poppins-regular text-themeText-g;
          padding-bottom: 16px;
        }
        .sample-stage-item:last-child,
        .sample-feature-item:last-child {
          padding-bottom: 0;
        }
        .sample-stage-check {
          @apply mt-[3px] h-[14px] w-[14px] flex-none object-contain;
        }
        .sample-stage-item-body { @apply min-w-0 flex-1; }
        .sample-stage-label { @apply font-poppins-semibold text-themeText-f; }
        .sample-stage-text { @apply text-themeText-g; }
        .sample-stage-footer { @apply mt-auto flex-none; }
        .sample-stage-divider {
          @apply w-full flex-none border-0;
          height: 1px;
          background-color: #E5E7EB;
        }
        .sample-stage-lead { @apply pt-0; }
        .sample-stage-lead-label {
          @apply mb-1 font-poppins-regular;
          font-size: 14px;
          color: #585858;
        }
        .sample-stage-lead-value { @apply text-f14 font-poppins-semibold leading-snug text-themeText-f; }
      }
    </style>
    <style type="text/css">
      /* Sample stage cards: min height + no overflow overlap */
      .sample-stage-card,
      .sample-card {
        box-sizing: border-box;
        padding: 22px 22px 28px;
        gap: 16px;
        border-radius: 4px;
        overflow: visible;
      }
      @media (min-width: 992px) {
        .sample-stage-card,
        .sample-card {
          min-height: 521px;
          height: auto;
          padding: 22px 22px 28px;
          gap: 16px;
        }
      }
      .sample-stage-list {
        flex: none !important;
        min-height: 0;
        overflow: visible;
      }
      .sample-stage-footer {
        display: flex;
        flex-direction: column;
        gap: 16px;
        flex: none !important;
        margin-top: auto;
        position: relative;
        z-index: 1;
        background: #fff;
        padding-top: 0;
      }
      .sample-stage-lead {
        margin: 0;
        padding: 0;
      }
      .sample-stage-divider {
        margin: 0;
        width: 100%;
        height: 1px !important;
        min-height: 1px;
        border: 0 !important;
        background-color: #E5E7EB !important;
        display: block !important;
        flex: none;
        position: relative;
        z-index: 1;
      }
      .sample-stage-tag,
      .sample-badge {
        display: inline-block !important;
        width: fit-content !important;
        max-width: 100% !important;
        align-self: flex-start !important;
        padding: 10px !important;
        border-radius: 4px !important;
        box-sizing: border-box;
      }
      .sample-stage-title {
        font-size: 18px !important;
        line-height: 1.35;
      }
      .sample-stage-item,
      .sample-feature-item {
        padding-bottom: 16px !important;
      }
      .sample-stage-item:last-child,
      .sample-feature-item:last-child {
        padding-bottom: 0 !important;
      }
      .sample-stage-lead-label {
        font-size: 14px !important;
        color: #585858 !important;
      }
      /* Rich-text tables: never exceed parent column (CMS often sets fixed width) */
      .product-highlights-content,
      .product-details-content {
        overflow-x: auto !important;
        overflow-y: visible;
        max-width: 100%;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
      }
      .product-details-content {
        overflow-x: hidden !important;
      }
      .product-details-content,
      .product-details-content * {
        max-width: 100% !important;
        box-sizing: border-box !important;
      }
      .product-details-content img,
      .product-details-content video,
      .product-details-content svg,
      .product-details-content iframe {
        width: auto !important;
        max-width: 100% !important;
        height: auto !important;
      }
      /* 前台强制：列表3/4/5 一排一图；后台编辑器样式不改 */
      .product-details-content #list_three,
      .product-details-content #list_four,
      .product-details-content #list_five,
      .product-details-content .det_pic_content .list:not([id]),
      .product-highlights-content #list_three,
      .product-highlights-content #list_four,
      .product-highlights-content #list_five,
      .product-highlights-content .det_pic_content .list:not([id]) {
        display: flex !important;
        flex-direction: column !important;
        flex-wrap: nowrap !important;
        gap: 20px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
      .product-details-content #list_three > li,
      .product-details-content #list_four > li,
      .product-details-content #list_five > li,
      .product-details-content .det_pic_content .list:not([id]) > li,
      .product-highlights-content #list_three > li,
      .product-highlights-content #list_four > li,
      .product-highlights-content #list_five > li,
      .product-highlights-content .det_pic_content .list:not([id]) > li {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        display: block !important;
        box-sizing: border-box !important;
      }
      .product-details-content #list_three > li .column,
      .product-details-content #list_four > li .column,
      .product-details-content #list_five > li .column,
      .product-details-content .det_pic_content .list:not([id]) > li .column,
      .product-highlights-content #list_three > li .column,
      .product-highlights-content #list_four > li .column,
      .product-highlights-content #list_five > li .column,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column {
        width: 100% !important;
        height: auto !important;
        display: block !important;
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        transition: none !important;
        transform: none !important;
      }
      .product-details-content #list_three > li .column:hover,
      .product-details-content #list_four > li .column:hover,
      .product-details-content #list_five > li .column:hover,
      .product-details-content .det_pic_content .list:not([id]) > li .column:hover,
      .product-highlights-content #list_three > li .column:hover,
      .product-highlights-content #list_four > li .column:hover,
      .product-highlights-content #list_five > li .column:hover,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column:hover {
        transform: none !important;
        box-shadow: none !important;
      }
      .product-details-content #list_three > li .column .wrap,
      .product-details-content #list_four > li .column .wrap,
      .product-details-content #list_five > li .column .wrap,
      .product-details-content .det_pic_content .list:not([id]) > li .column .wrap,
      .product-highlights-content #list_three > li .column .wrap,
      .product-highlights-content #list_four > li .column .wrap,
      .product-highlights-content #list_five > li .column .wrap,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column .wrap {
        padding: 0 !important;
        margin: 0 !important;
      }
      .product-details-content #list_three > li .column .image,
      .product-details-content #list_four > li .column .image,
      .product-details-content #list_five > li .column .image,
      .product-details-content .det_pic_content .list:not([id]) > li .column .image,
      .product-highlights-content #list_three > li .column .image,
      .product-highlights-content #list_four > li .column .image,
      .product-highlights-content #list_five > li .column .image,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column .image {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
        overflow: hidden !important;
        aspect-ratio: auto !important;
        padding: 0 !important;
        margin: 0 !important;
      }
      .product-details-content #list_three > li .column .image img,
      .product-details-content #list_four > li .column .image img,
      .product-details-content #list_five > li .column .image img,
      .product-details-content .det_pic_content .list:not([id]) > li .column .image img,
      .product-highlights-content #list_three > li .column .image img,
      .product-highlights-content #list_four > li .column .image img,
      .product-highlights-content #list_five > li .column .image img,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column .image img {
        width: 100% !important;
        height: auto !important;
        max-width: 100% !important;
        max-height: none !important;
        min-width: 0 !important;
        object-fit: initial !important;
        display: block !important;
        transition: none !important;
        transform: none !important;
      }
      .product-details-content #list_three > li .column:hover .image img,
      .product-details-content #list_four > li .column:hover .image img,
      .product-details-content #list_five > li .column:hover .image img,
      .product-details-content .det_pic_content .list:not([id]) > li .column:hover .image img,
      .product-highlights-content #list_three > li .column:hover .image img,
      .product-highlights-content #list_four > li .column:hover .image img,
      .product-highlights-content #list_five > li .column:hover .image img,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column:hover .image img {
        transform: none !important;
      }
      /* 前台强制：列表6 一排一图；后台编辑器样式不改 */
      .product-details-content .cate_section_holder .cate_main_holder,
      .product-highlights-content .cate_section_holder .cate_main_holder {
        display: block !important;
      }
      .product-details-content .cate_section_holder .cate_l,
      .product-details-content .cate_section_holder .cate_r,
      .product-highlights-content .cate_section_holder .cate_l,
      .product-highlights-content .cate_section_holder .cate_r {
        float: none !important;
        width: 100% !important;
        max-width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .product-details-content .cate_section_holder .membership,
      .product-highlights-content .cate_section_holder .membership {
        display: flex !important;
        flex-direction: column !important;
        gap: 20px !important;
        width: 100% !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li,
      .product-highlights-content .cate_section_holder .membership .sp_li {
        float: none !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
        transition: none !important;
        transform: none !important;
        overflow: hidden !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li:hover,
      .product-highlights-content .cate_section_holder .membership .sp_li:hover {
        transform: none !important;
        border: none !important;
        box-shadow: none !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li .membership_img,
      .product-highlights-content .cate_section_holder .membership .sp_li .membership_img {
        padding: 0 !important;
        margin: 0 !important;
        overflow: hidden !important;
        width: 100% !important;
        text-align: left !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li .membership_img img,
      .product-highlights-content .cate_section_holder .membership .sp_li .membership_img img {
        width: 100% !important;
        height: auto !important;
        max-width: 100% !important;
        display: block !important;
        transition: none !important;
        transform: none !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li .membership_text,
      .product-highlights-content .cate_section_holder .membership .sp_li .membership_text {
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
      }
      .product-details-content .table-responsive,
      .product-details-content [class*="overflow"],
      .product-details-content pre {
        overflow-x: hidden !important;
      }
      .product-highlights-content::after,
      .product-details-content::after {
        content: "";
        display: block;
        clear: both;
      }
      .product-highlights-content .table-responsive,
      .product-details-content .table-responsive {
        overflow-x: auto !important;
        width: 100% !important;
        max-width: 100% !important;
      }
      .product-highlights-content table,
      .product-details-content table {
        float: none !important;
        display: table !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        height: auto !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        border-collapse: collapse;
        table-layout: fixed !important;
        box-sizing: border-box !important;
      }
      .product-highlights-content table col,
      .product-details-content table col,
      .product-highlights-content table colgroup,
      .product-details-content table colgroup {
        width: auto !important;
      }
      .product-highlights-content table thead,
      .product-highlights-content table tbody,
      .product-highlights-content table tfoot,
      .product-highlights-content table tr,
      .product-highlights-content table td,
      .product-highlights-content table th,
      .product-details-content table thead,
      .product-details-content table tbody,
      .product-details-content table tfoot,
      .product-details-content table tr,
      .product-details-content table td,
      .product-details-content table th {
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
        overflow: visible !important;
        width: auto !important;
        min-width: 0 !important;
        max-width: none !important;
      }
      .product-highlights-content table td,
      .product-highlights-content table th,
      .product-details-content table td,
      .product-details-content table th {
        white-space: normal !important;
        word-break: break-word !important;
        overflow-wrap: anywhere !important;
        vertical-align: top;
        padding: 8px 10px;
        font-size: 14px;
        line-height: 1.45;
      }
      .product-highlights-content table p,
      .product-details-content table p,
      .product-highlights-content table .text-nowrap,
      .product-details-content table .text-nowrap {
        margin: 0 !important;
        line-height: 1.45 !important;
        overflow: visible !important;
        white-space: normal !important;
        word-break: break-word !important;
      }
      .product-highlights-content table img,
      .product-details-content table img {
        max-width: 100% !important;
        height: auto !important;
      }
      /* Only allow horizontal scroll on small phones when content is extremely wide */
      @media (max-width: 767px) {
        .product-highlights-content,
        .product-highlights-content .table-responsive {
          overflow-x: auto !important;
          -webkit-overflow-scrolling: touch;
        }
        .product-details-content,
        .product-details-content .table-responsive {
          overflow-x: hidden !important;
        }
        .product-highlights-content table,
        .product-details-content table {
          table-layout: auto !important;
        }
        .product-highlights-content table td,
        .product-highlights-content table th,
        .product-details-content table td,
        .product-details-content table th {
          font-size: 13px;
          padding: 6px 8px;
        }
      }
      /* Required field asterisk: red, inline with label text */
      .form-field-label {
        display: inline-block;
        vertical-align: baseline;
        line-height: 1.4;
      }
      .form-required-mark,
      label .form-required-mark,
      .form-field-label .form-required-mark {
        display: inline;
        color: #D92B28;
        margin-left: 2px;
        font-weight: inherit;
        vertical-align: baseline;
      }
      label > span.text-themeBg-d,
      span.text-themeBg-d.form-required-mark {
        color: #D92B28 !important;
      }
    </style>
    <!-- Tailwind Css -->

    <link rel="stylesheet" href="/front/css/swiper-bundle.min.css" />
    <link type="text/css" rel="stylesheet" href="/front/css/style.css" />
    <style id="sec-space-css">
      /* White/image adjacent edges: 2rem + 2rem = 64px visual gap (not 4rem+4rem) */
      body.sec-space-on section.sec-bg-white:has(+ section.sec-bg-white) .sec-pad,
      body.sec-space-on section.sec-bg-white:has(+ section.sec-bg-white) .cs-cert-inner,
      body.sec-space-on section.sec-bg-white:has(+ section.sec-bg-white) .cs-stages-inner,
      body.sec-space-on section.sec-bg-white:has(+ section.sec-bg-white) .product-details-inner,
      body.sec-space-on section.sec-bg-white:has(+ section.sec-bg-white) .product-faqs-inner,
      body.sec-space-on section.sec-bg-white:has(+ section.sec-bg-white) .product-tags-inner,
      body.sec-space-on section.sec-bg-white:has(+ section.sec-bg-white) .pdp-shell,
      body.sec-space-on section.sec-bg-white:has(+ section.sec-bg-white) .about-us-layout,
      body.sec-space-on section.sec-bg-white.sec-pad:has(+ section.sec-bg-white) {
        padding-bottom: 2rem !important;
      }
      body.sec-space-on section.sec-bg-white + section.sec-bg-white .sec-pad,
      body.sec-space-on section.sec-bg-white + section.sec-bg-white .cs-cert-inner,
      body.sec-space-on section.sec-bg-white + section.sec-bg-white .cs-stages-inner,
      body.sec-space-on section.sec-bg-white + section.sec-bg-white .product-details-inner,
      body.sec-space-on section.sec-bg-white + section.sec-bg-white .product-faqs-inner,
      body.sec-space-on section.sec-bg-white + section.sec-bg-white .product-tags-inner,
      body.sec-space-on section.sec-bg-white + section.sec-bg-white .pdp-shell,
      body.sec-space-on section.sec-bg-white + section.sec-bg-white .about-us-layout,
      body.sec-space-on section.sec-bg-white + section.sec-bg-white.sec-pad {
        padding-top: 2rem !important;
      }
    </style>
    @yield('page-css-header')
    {{-- After product-highlights.css: force CMS tables to stay within column --}}
    <style type="text/css">
      .product-highlights-content table,
      .product-details-content table {
        width: 100% !important;
        max-width: 100% !important;
        table-layout: fixed !important;
        box-sizing: border-box !important;
      }
      .product-highlights-content table td,
      .product-highlights-content table th,
      .product-details-content table td,
      .product-details-content table th,
      .product-highlights-content table p,
      .product-details-content table p {
        white-space: normal !important;
        word-break: break-word !important;
        overflow-wrap: anywhere !important;
        max-width: 100% !important;
      }
      .product-details-content ul,
      .product-details-content ol {
        margin: 0 !important;
        padding: 0 !important;
      }
      .product-details-content {
        overflow-x: hidden !important;
      }
      .product-details-content,
      .product-details-content * {
        max-width: 100% !important;
        box-sizing: border-box !important;
      }
      .product-details-content img,
      .product-details-content video,
      .product-details-content svg,
      .product-details-content iframe {
        width: auto !important;
        max-width: 100% !important;
        height: auto !important;
      }
      /* 前台强制：列表3/4/5 一排一图；后台编辑器样式不改 */
      .product-details-content #list_three,
      .product-details-content #list_four,
      .product-details-content #list_five,
      .product-details-content .det_pic_content .list:not([id]),
      .product-highlights-content #list_three,
      .product-highlights-content #list_four,
      .product-highlights-content #list_five,
      .product-highlights-content .det_pic_content .list:not([id]) {
        display: flex !important;
        flex-direction: column !important;
        flex-wrap: nowrap !important;
        gap: 20px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
      .product-details-content #list_three > li,
      .product-details-content #list_four > li,
      .product-details-content #list_five > li,
      .product-details-content .det_pic_content .list:not([id]) > li,
      .product-highlights-content #list_three > li,
      .product-highlights-content #list_four > li,
      .product-highlights-content #list_five > li,
      .product-highlights-content .det_pic_content .list:not([id]) > li {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        display: block !important;
        box-sizing: border-box !important;
      }
      .product-details-content #list_three > li .column,
      .product-details-content #list_four > li .column,
      .product-details-content #list_five > li .column,
      .product-details-content .det_pic_content .list:not([id]) > li .column,
      .product-highlights-content #list_three > li .column,
      .product-highlights-content #list_four > li .column,
      .product-highlights-content #list_five > li .column,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column {
        width: 100% !important;
        height: auto !important;
        display: block !important;
        background: transparent !important;
        background-color: transparent !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        transition: none !important;
        transform: none !important;
      }
      .product-details-content #list_three > li .column:hover,
      .product-details-content #list_four > li .column:hover,
      .product-details-content #list_five > li .column:hover,
      .product-details-content .det_pic_content .list:not([id]) > li .column:hover,
      .product-highlights-content #list_three > li .column:hover,
      .product-highlights-content #list_four > li .column:hover,
      .product-highlights-content #list_five > li .column:hover,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column:hover {
        transform: none !important;
        box-shadow: none !important;
      }
      .product-details-content #list_three > li .column .wrap,
      .product-details-content #list_four > li .column .wrap,
      .product-details-content #list_five > li .column .wrap,
      .product-details-content .det_pic_content .list:not([id]) > li .column .wrap,
      .product-highlights-content #list_three > li .column .wrap,
      .product-highlights-content #list_four > li .column .wrap,
      .product-highlights-content #list_five > li .column .wrap,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column .wrap {
        padding: 0 !important;
        margin: 0 !important;
      }
      .product-details-content #list_three > li .column .image,
      .product-details-content #list_four > li .column .image,
      .product-details-content #list_five > li .column .image,
      .product-details-content .det_pic_content .list:not([id]) > li .column .image,
      .product-highlights-content #list_three > li .column .image,
      .product-highlights-content #list_four > li .column .image,
      .product-highlights-content #list_five > li .column .image,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column .image {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
        overflow: hidden !important;
        aspect-ratio: auto !important;
        padding: 0 !important;
        margin: 0 !important;
      }
      .product-details-content #list_three > li .column .image img,
      .product-details-content #list_four > li .column .image img,
      .product-details-content #list_five > li .column .image img,
      .product-details-content .det_pic_content .list:not([id]) > li .column .image img,
      .product-highlights-content #list_three > li .column .image img,
      .product-highlights-content #list_four > li .column .image img,
      .product-highlights-content #list_five > li .column .image img,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column .image img {
        width: 100% !important;
        height: auto !important;
        max-width: 100% !important;
        max-height: none !important;
        min-width: 0 !important;
        object-fit: initial !important;
        display: block !important;
        transition: none !important;
        transform: none !important;
      }
      .product-details-content #list_three > li .column:hover .image img,
      .product-details-content #list_four > li .column:hover .image img,
      .product-details-content #list_five > li .column:hover .image img,
      .product-details-content .det_pic_content .list:not([id]) > li .column:hover .image img,
      .product-highlights-content #list_three > li .column:hover .image img,
      .product-highlights-content #list_four > li .column:hover .image img,
      .product-highlights-content #list_five > li .column:hover .image img,
      .product-highlights-content .det_pic_content .list:not([id]) > li .column:hover .image img {
        transform: none !important;
      }
      /* 前台强制：列表6 一排一图；后台编辑器样式不改 */
      .product-details-content .cate_section_holder .cate_main_holder,
      .product-highlights-content .cate_section_holder .cate_main_holder {
        display: block !important;
      }
      .product-details-content .cate_section_holder .cate_l,
      .product-details-content .cate_section_holder .cate_r,
      .product-highlights-content .cate_section_holder .cate_l,
      .product-highlights-content .cate_section_holder .cate_r {
        float: none !important;
        width: 100% !important;
        max-width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .product-details-content .cate_section_holder .membership,
      .product-highlights-content .cate_section_holder .membership {
        display: flex !important;
        flex-direction: column !important;
        gap: 20px !important;
        width: 100% !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li,
      .product-highlights-content .cate_section_holder .membership .sp_li {
        float: none !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
        transition: none !important;
        transform: none !important;
        overflow: hidden !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li:hover,
      .product-highlights-content .cate_section_holder .membership .sp_li:hover {
        transform: none !important;
        border: none !important;
        box-shadow: none !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li .membership_img,
      .product-highlights-content .cate_section_holder .membership .sp_li .membership_img {
        padding: 0 !important;
        margin: 0 !important;
        overflow: hidden !important;
        width: 100% !important;
        text-align: left !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li .membership_img img,
      .product-highlights-content .cate_section_holder .membership .sp_li .membership_img img {
        width: 100% !important;
        height: auto !important;
        max-width: 100% !important;
        display: block !important;
        transition: none !important;
        transform: none !important;
      }
      .product-details-content .cate_section_holder .membership .sp_li .membership_text,
      .product-highlights-content .cate_section_holder .membership .sp_li .membership_text {
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
      }
      .product-details-content .table-responsive,
      .product-details-content pre,
      .product-details-content [style*="overflow"] {
        overflow-x: hidden !important;
      }
      /* Two-column Item/Details: pull divider left (narrower label column) */
      .product-highlights-content table td:first-child,
      .product-highlights-content table th:first-child,
      .product-details-content table td:first-child,
      .product-details-content table th:first-child {
        width: 160px !important;
        max-width: 160px !important;
        min-width: 0 !important;
      }
      .product-highlights-content table td:nth-child(2),
      .product-highlights-content table th:nth-child(2),
      .product-details-content table td:nth-child(2),
      .product-details-content table th:nth-child(2) {
        width: auto !important;
      }
      @media (max-width: 991px) {
        .product-highlights-content table td:first-child,
        .product-highlights-content table th:first-child,
        .product-details-content table td:first-child,
        .product-details-content table th:first-child {
          width: 28% !important;
          max-width: 120px !important;
        }
      }
      @media (max-width: 767px) {
        .product-highlights-content table td:first-child,
        .product-highlights-content table th:first-child,
        .product-details-content table td:first-child,
        .product-details-content table th:first-child {
          width: 32% !important;
          max-width: 96px !important;
          padding-left: 6px !important;
          padding-right: 6px !important;
          font-size: 12px !important;
        }
        .product-highlights-content table td:nth-child(2),
        .product-highlights-content table th:nth-child(2),
        .product-details-content table td:nth-child(2),
        .product-details-content table th:nth-child(2) {
          padding-left: 6px !important;
          padding-right: 6px !important;
          font-size: 12px !important;
        }
      }
    </style>
    @yield('page-js-header')
</head>
<body class="min-h-full bg-white font-sans text-slate-900 antialiased sec-space-on">
    <input type="hidden" id="customer_id" value="{{ $data['customer_id'] }}" /> 
    <svg xmlns="http://www.w3.org/2000/svg" class="hidden">
      <symbol id="icon-uncollect" viewBox="0 0 15 14" fill="none">
        <path d="M10.7637 0.650391C12.6871 0.650391 14.3496 2.40091 14.3496 4.63867C14.3495 5.95289 13.7592 6.84623 13.2158 7.74414C12.4711 8.91365 11.1369 10.2651 9.92871 11.3652C8.73087 12.4559 7.71082 13.2524 7.63965 13.3057L7.60547 13.3311L7.59766 13.3379H7.59863C7.58764 13.3411 7.57216 13.3443 7.55371 13.3467C7.53546 13.349 7.51696 13.3496 7.5 13.3496C7.46572 13.3496 7.44322 13.3458 7.42676 13.3408C7.41132 13.3361 7.38941 13.3274 7.36035 13.3057L7.3584 13.3037L7.35254 13.2998C7.34921 13.2973 7.34533 13.2933 7.33984 13.2891C7.32865 13.2805 7.31341 13.2693 7.29492 13.2549C7.25763 13.2258 7.20629 13.1857 7.14355 13.1357C7.01788 13.0357 6.84455 12.8964 6.63672 12.7246C6.22083 12.3809 5.66656 11.9091 5.06934 11.3652C3.86123 10.265 2.52812 8.91365 1.78418 7.74512L1.7793 7.7373L1.56738 7.41016C1.07958 6.63818 0.650511 5.79742 0.650391 4.63867C0.650391 2.40073 2.31287 0.650391 4.23438 0.650391C5.28664 0.65043 6.29433 1.19031 6.98145 2.09766L7.50098 2.7832L8.01855 2.09766C8.70359 1.1909 9.71285 0.650509 10.7637 0.650391Z" stroke="black" stroke-width="1.3"/>
      </symbol>
      <symbol id="icon-collect" viewBox="0 0 15 14" fill="none">
        <path d="M10.764 0C9.48529 0 8.29274 0.65625 7.5 1.70557C6.70554 0.65625 5.51471 0 4.23426 0C1.8974 0 0 2.10034 0 4.63818C0 6.16943 0.661765 7.21875 1.23564 8.09375C2.82284 10.5872 6.79343 13.6941 6.97093 13.8257C7.14671 13.9573 7.32422 14 7.5 14C7.67578 14 7.89637 13.9556 8.02907 13.8257C8.20485 13.6941 12.1754 10.5889 13.7644 8.09375C14.2934 7.21875 15 6.16943 15 4.63818C15 2.10034 13.1026 0 10.764 0Z" fill="#DA2B28"/>
      </symbol>
    </svg>

    <section class="fixed inset-x-0 top-0 z-30 bg-white shadow-[0_6px_18px_rgba(0,0,0,0.22)] md4:hidden mobile-nav">
      <div class="header-mobile-bar relative mx-auto flex h-16 w-full max-w-[1200px] items-center justify-between px-4 sm2:px-2 md1:px-2 lg1:px-0">
        <div class="header-mobile-left">
          <button id="mobileMenuBtn" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded bg-transparent text-slate-900 transition hover:bg-slate-100" aria-label="Menu">
            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
              <path d="M3 6h18M3 12h18M3 18h18" />
            </svg>
          </button>

          @php
            $logoForInner = $data['header_logo_url'] ?? front_webp_url('/front/imgs/logo2.svg');
          @endphp
          <a href="/" class="header-mobile-logo">
            <img class="h-[52px] w-auto max-w-[110px] object-contain" src="{{ $logoForInner }}" alt="Logo" loading="lazy" />
          </a>
        </div>

        @php
          $localeItems = $data['locales']['items'] ?? [];
          $firstLocale = $localeItems[0] ?? null;
        @endphp
        <div class="header-mobile-actions">
          <button type="button" class="header-search-btn search-trigger" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" aria-hidden="true">
              <path stroke-linejoin="round" stroke-width="4" stroke="currentColor" d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4 4 11.611 4 21s7.611 17 17 17Z" />
              <path stroke-linejoin="round" stroke-linecap="round" stroke-width="4" stroke="currentColor" d="M26.657 14.343A7.975 7.975 0 0 0 21 12c-2.209 0-4.209.895-5.657 2.343M33.222 33.222l8.485 8.485" />
            </svg>
          </button>

          <div class="relative">
            <button id="mobileLangBtn" type="button" class="inline-flex h-9 items-center gap-2 rounded bg-slate-900/5 px-3 text-[12px] font-semibold text-slate-900 ring-1 ring-slate-900/10 transition hover:bg-slate-900/10" aria-label="Language">
              <img class="h-5 w-5 rounded-full object-cover" src="{{ $firstLocale['path'] ?? front_webp_url('/front/imgs/us-flag.svg') }}" alt="{{ $firstLocale['code'] ?? 'EN' }}" loading="lazy" />
              <span>{{ $firstLocale['code'] ?? 'EN' }}</span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-slate-700" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
              </svg>
            </button>

            <div id="mobileLangDropdown" class="absolute right-0 top-full z-50 mt-2 hidden w-[180px] overflow-hidden rounded-lg border border-white/30 bg-white/30 shadow-lg backdrop-blur-md">
              @foreach($localeItems as $locale)
                <a href="{{ $locale['url'] }}" class="flex items-center gap-3 px-4 py-3 text-[13px] text-slate-700 transition-colors hover:bg-white/25">
                  <img class="h-5 w-5 rounded-full object-cover" src="{{ $locale['path'] }}" alt="{{ $locale['code'] }}" loading="lazy" />
                  <span>{{ $locale['label'] }}</span>
                </a>
                @if(!$loop->last)
                  <div class="h-px w-full bg-white/25"></div>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="mobileMenu" class="fixed inset-0 z-[70] pointer-events-none opacity-0 transition-opacity duration-200 md4:hidden" aria-hidden="true">
      <div id="mobileMenuBackdrop" class="absolute inset-0 bg-black/60"></div>
      <div id="mobileMenuPanel" class="absolute left-0 top-0 flex h-full w-[280px] max-w-[85vw] -translate-x-full flex-col bg-white shadow-xl transition-transform duration-200">
        <div class="flex items-center justify-between px-4 py-4 ring-1 ring-slate-200">
          <img class="h-10 w-auto max-w-[110px] object-contain" src="{{ $logoForInner }}" alt="Logo" loading="lazy" />
          <button id="mobileMenuClose" type="button" class="inline-flex h-9 w-9 items-center justify-center rounded bg-slate-900/5 text-slate-800 transition hover:bg-slate-900/10" aria-label="Close">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 6L6 18" />
              <path d="M6 6l12 12" />
            </svg>
          </button>
        </div>

        @php
          $navItems = $data['nav']['items'] ?? [];
        @endphp
        <nav class="flex-1 overflow-y-auto px-4 py-4">
          @foreach($navItems as $item)
            @if(!empty($item['has_dropdown']) || !empty($item['children']))
              @php $mobileSubId = 'mobileSubNav'.$loop->index; @endphp
              <div class="mt-1">
                <button type="button" class="mobile-menu-toggle flex w-full items-center justify-between rounded px-3 py-3 text-left text-[14px] font-semibold text-slate-900 transition hover:bg-slate-50 {{ !empty($item['active']) ? 'bg-slate-50' : '' }}" data-target="#{{ $mobileSubId }}" aria-expanded="false">
                  <span>{{ $item['label'] }}</span>
                  <svg viewBox="0 0 20 20" class="h-4 w-4 text-slate-500 transition-transform duration-200" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                  </svg>
                </button>

                <div id="{{ $mobileSubId }}" class="hidden">
                  @if(!empty($item['url']) && $item['url'] !== '#')
                    <a href="{{ $item['url'] }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif @if(!empty($item['rel'])) rel="{{ $item['rel'] }}" @endif class="mt-1 block rounded bg-slate-50 px-3 py-2 text-[13px] font-semibold text-slate-800 transition hover:bg-slate-100">{{ ($item['link_type'] ?? '') === 'category' ? __('All Products') : $item['label'] }}</a>
                  @endif

                  @foreach($item['children'] as $catIndex => $category)
                    @if(!empty($category['children']))
                      @php $subId = 'mobileSubCat'.$loop->parent->index.'_'.$catIndex; @endphp
                      <div class="mt-1">
                        <button type="button" class="mobile-menu-toggle flex w-full items-center justify-between rounded bg-slate-50 px-3 py-2 text-left text-[13px] font-semibold text-slate-800 transition hover:bg-slate-50 {{ !empty($category['active']) ? 'bg-slate-100' : '' }}" data-target="#{{ $subId }}" aria-expanded="false">
                          <span>{{ $category['label'] }}</span>
                          <svg viewBox="0 0 20 20" class="h-4 w-4 text-slate-500 transition-transform duration-200" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                          </svg>
                        </button>
                        <div id="{{ $subId }}" class="hidden">
                          @foreach($category['children'] as $child)
                            <a href="{{ $child['url'] }}" @if(!empty($child['target'])) target="{{ $child['target'] }}" @endif @if(!empty($child['rel'])) rel="{{ $child['rel'] }}" @endif class="mt-1 block rounded bg-white px-3 py-2 text-[12px] font-semibold text-slate-700 transition hover:bg-slate-50 {{ !empty($child['active']) ? 'bg-slate-50' : '' }}">{{ $child['label'] }}</a>
                          @endforeach
                        </div>
                      </div>
                    @else
                      <a href="{{ $category['url'] }}" @if(!empty($category['target'])) target="{{ $category['target'] }}" @endif @if(!empty($category['rel'])) rel="{{ $category['rel'] }}" @endif class="mt-1 block rounded bg-slate-50 px-3 py-2 text-[13px] font-semibold text-slate-800 transition hover:bg-slate-50 {{ !empty($category['active']) ? 'bg-slate-100' : '' }}">{{ $category['label'] }}</a>
                    @endif
                  @endforeach
                </div>
              </div>
            @else
              <a href="{{ $item['url'] }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif @if(!empty($item['rel'])) rel="{{ $item['rel'] }}" @endif class="mt-1 block rounded px-3 py-3 text-[14px] font-semibold text-slate-900 transition hover:bg-slate-50 {{ !empty($item['active']) ? 'bg-slate-50' : '' }}">{{ $item['label'] }}</a>
            @endif
          @endforeach
        </nav>
        
        <div class="px-4 pb-5">
          <a href="#" class="mobile-menu-get-in-touch inline-flex h-10 w-full items-center justify-center bg-themeBg-d text-[12px] font-semibold uppercase tracking-wide text-white transition hover:bg-themeBg-d">Get In Touch</a>
        </div>
      </div>
    </section>
     


    @if(View::hasSection('page-header'))
        @yield('page-header')
    @else
        <!-- Page Banner：加/去掉 pagebanner--off 可统一统一内页 Banner（首页走 page-header，不受影响） -->
        <section class="relative w-full h-[300px] sm6:h-[350px] md1:h-[400px] md4:h-[500px] overflow-hidden pagebanner pagebanner--off pt-16 md4:pt-0">
          @if(View::hasSection('pagebanner'))
            @yield('pagebanner')
          @else
            <div class="absolute inset-0 bg-[url('{{ front_webp_url('/front/imgs/pagebanner.png') }}')] bg-center bg-no-repeat bg-cover" aria-hidden="true"></div>
          @endif
          <!-- Desktop Header：固定在顶部，侧栏 sticky 预留其高度 -->
          <header class="pointer-events-none fixed inset-x-0 top-0 z-20 bg-[#FFF] py-[6px] hidden md4:block">
            <div class="pointer-events-auto mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
              <div class="flex h-16 items-center justify-between md1:h-20">
                <a href="/" class="flex items-center gap-2">
                  <img class="h-[70px] w-auto max-w-[140px] object-contain" src="{{ $logoForInner }}" alt="Logo" loading="lazy" />
                </a>

                <div class="flex items-center gap-[35px]">
                  @php
                    $navItems = $data['nav']['items'] ?? [];
                    $linkBase = 'relative transition duration-200 hover:text-black/70 after:absolute after:left-1/2 after:-translate-x-1/2 after:-bottom-[14px] after:h-[5px] after:w-[34px] after:rounded-[5px] after:bg-themeBg-d after:opacity-0 after:transition-all after:duration-200 hover:after:opacity-100';
                    $linkActive = 'text-black/70 after:opacity-100';
                  @endphp
                  <nav class="hidden items-center gap-[26px] text-[16px] font-poppins-medium uppercase tracking-wide text-black md4:flex">
                    @foreach($navItems as $item)
                      @if(!empty($item['has_dropdown']) || !empty($item['children']))
                        <div class="relative group">
                        <a class="{{ $linkBase }} {{ !empty($item['active']) ? $linkActive : '' }} inline-flex items-center gap-0" href="{{ $item['url'] }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif @if(!empty($item['rel'])) rel="{{ $item['rel'] }}" @endif>
                            {{ $item['label'] }}
                          </a>

                          <div class="pointer-events-none absolute left-1/2 -translate-x-1/2 top-full z-40 pt-[26px] mt-0 w-[240px] opacity-0 transition duration-150 group-hover:pointer-events-auto group-hover:opacity-100">
                            <div class="relative overflow-visible rounded bg-white shadow-lg ring-1 ring-black/10">
                              @if(!empty($item['url']) && $item['url'] !== '#' && ($item['link_type'] ?? '') === 'category')
                                <a href="{{ $item['url'] }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif @if(!empty($item['rel'])) rel="{{ $item['rel'] }}" @endif class="flex items-center justify-between px-4 py-3 text-[13px] font-poppins-regular text-slate-800 transition hover:bg-slate-50">{{ __('All Products') }}</a>
                              @endif

                              @foreach($item['children'] as $category)
                                <div class="h-px w-full bg-slate-200"></div>
                                @if(!empty($category['children']))
                                  <div class="relative submenu-parent">
                                    <a href="{{ $category['url'] }}" @if(!empty($category['target'])) target="{{ $category['target'] }}" @endif @if(!empty($category['rel'])) rel="{{ $category['rel'] }}" @endif class="flex items-center justify-between px-4 py-3 text-[13px] font-poppins-regular text-slate-800 transition hover:bg-slate-50 {{ !empty($category['active']) ? 'bg-slate-50' : '' }}">
                                      {{ $category['label'] }}
                                      <svg viewBox="0 0 20 20" class="h-4 w-4 text-slate-500" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 5.23a.75.75 0 011.06 0l4.25 4.24a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06-1.06L10.94 10 7.21 6.29a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                      </svg>
                                    </a>

                                    <div class="submenu-third pointer-events-none absolute left-full top-0 z-50 ml-0 w-[240px] opacity-0 transition duration-150">
                                      <div class="overflow-hidden rounded bg-white shadow-lg ring-1 ring-black/10">
                                        @foreach($category['children'] as $child)
                                          <a href="{{ $child['url'] }}" @if(!empty($child['target'])) target="{{ $child['target'] }}" @endif @if(!empty($child['rel'])) rel="{{ $child['rel'] }}" @endif class="block px-4 py-3 text-[13px] font-poppins-regular text-slate-800 transition hover:bg-slate-50 {{ !empty($child['active']) ? 'bg-slate-50' : '' }}">{{ $child['label'] }}</a>
                                          @if(!$loop->last)
                                            <div class="h-px w-full bg-slate-200"></div>
                                          @endif
                                        @endforeach
                                      </div>
                                    </div>
                                  </div>
                                @else
                                  <a href="{{ $category['url'] }}" @if(!empty($category['target'])) target="{{ $category['target'] }}" @endif @if(!empty($category['rel'])) rel="{{ $category['rel'] }}" @endif class="flex items-center justify-between px-4 py-3 text-[13px] font-poppins-regular text-slate-800 transition hover:bg-slate-50 {{ !empty($category['active']) ? 'bg-slate-50' : '' }}">{{ $category['label'] }}</a>
                                @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      @else
                        <a class="{{ $linkBase }} {{ !empty($item['active']) ? $linkActive : '' }}" href="{{ $item['url'] }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif @if(!empty($item['rel'])) rel="{{ $item['rel'] }}" @endif>{{ $item['label'] }}</a>
                      @endif
                    @endforeach
                  </nav>

                  <div class="flex items-center gap-[35px] text-white/90">
                    <button type="button" class="hidden h-8 w-8 items-center justify-center md4:inline-flex search-trigger" aria-label="Search">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" class="h-6 w-6 text-black" aria-hidden="true">
                        <path stroke-linejoin="round" stroke-width="4" stroke="currentColor" d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4 4 11.611 4 21s7.611 17 17 17 Z" data-follow-stroke="#000"></path>
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="4" stroke="currentColor" d="M26.657 14.343A7.975 7.975 0 0 0 21 12c-2.209 0-4.209.895-5.657 2.343M33.222 33.222l8.485 8.485" data-follow-stroke="#000"></path>
                      </svg>
                    </button>
                    <div class="language-switcher relative ml-auto hidden cursor-pointer select-none items-center gap-2 md4:flex">
                      <img class="h-[26px] w-[26px] rounded-full object-cover" src="{{ $firstLocale['path'] ?? front_webp_url('/front/imgs/us-flag.svg') }}" alt="{{ $firstLocale['code'] ?? 'EN' }}" loading="lazy" />
                      <span class="text-[15px] font-poppins-regular text-black  font-[500]">{{ $firstLocale['label'] ?? 'ENGLISH' }}</span>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-black" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                      </svg>
                      <div class="language-dropdown absolute left-1/2 top-full z-30 mt-3 w-[170px]">
                        <div class="language-dropdown-panel overflow-hidden rounded-lg border border-white/30 bg-white/30 shadow-lg backdrop-blur-md">
                          @foreach($localeItems as $locale)
                            <a href="{{ $locale['url'] }}" class="flex items-center gap-3 px-4 py-3 text-[15px] text-themeText-a transition-colors hover:bg-white/25">
                              <img class="h-[26px] w-[26px] rounded-full object-cover" src="{{ $locale['path'] }}" alt="{{ $locale['code'] }}" loading="lazy" />
                              <span>{{ $locale['label'] }}</span>
                            </a>
                            @if(!$loop->last)
                              <div class="h-px w-full bg-white/25"></div>
                            @endif
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </header>
        </section>
    @endif

    @yield('content')

    <!-- Footer -->
    <footer class="relative w-full overflow-hidden footer">
      <div class="absolute inset-0 bg-[url('{{ front_webp_url('/front/imgs/footer-bg.png') }}')] bg-center bg-no-repeat bg-cover" aria-hidden="true"></div>
      <div class="absolute inset-0 bg-black/80" aria-hidden="true"></div>
      <div class="relative mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
        <div class="py-6 md1:py-10 md4:py-14">
          <div class="footer-menu-grid grid grid-cols-1 gap-4 text-white lg1:grid-cols-3 lg1:justify-between">
            <!-- Left Group: Our Services + Product Categories -->
            <div class="order-2 lg1:order-1 flex flex-col gap-4 lg1:flex-row lg1:gap-5">
              <div class="flex-1">
                <details class="footer-accordion group" data-footer-accordion>
                  <summary class="flex cursor-pointer items-center justify-between gap-4 select-none rounded pr-2 py-1 transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d/50 focus-visible:ring-offset-2 focus-visible:ring-offset-black/60">
                    <div>
                      <div class="footer-nav-title text-f16 md1:text-f18 font-poppins-medium uppercase tracking-wide whitespace-nowrap">{{ $data['footerNavGroups'][0]['label'] ?? 'Our Services' }}</div>
                      <div class="mt-2 h-[6px] w-[34px] rounded-[6px] bg-themeBg-d  lg1:block hidden" aria-hidden="true"></div>
                    </div>

                    <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 transition-transform duration-200 group-open:rotate-180 lg1:hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M6 9l6 6 6-6" />
                    </svg>
                  </summary>

                  <div class="mt-5">
                    <ul class="space-y-2.5 text-[11px] text-white/75">
                      @if(!empty($data['footerNavGroups'][0]['children']))
                        @foreach($data['footerNavGroups'][0]['children'] as $child)
                          @if(!empty($child['label']) && !empty($child['url']))
                            <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="{{ $child['url'] }}" @if(!empty($child['target'])) target="{{ $child['target'] }}" @endif @if(!empty($child['rel'])) rel="{{ $child['rel'] }}" @endif>{{ $child['label'] }}</a></li>
                          @endif
                        @endforeach
                      @else
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/faqs.html">FAQs</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/customerservices.html">Support</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/productcategory.html">Catalog</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/aboutus.htmlq">Our Story</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/blogs.html">Blogs</a></li>
                      @endif
                    </ul>
                  </div>
                </details>
              </div>

              <div class="flex-1 min-w-0 lg1:min-w-[12rem]">
                <details class="footer-accordion group" data-footer-accordion>
                  <summary class="flex cursor-pointer items-center justify-between gap-4 select-none rounded pr-2 py-1 transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d/50 focus-visible:ring-offset-2 focus-visible:ring-offset-black/60">
                    <div class="min-w-0">
                      <div class="footer-nav-title text-f16 md1:text-f18 font-poppins-medium uppercase tracking-wide whitespace-nowrap">{{ $data['footerNavGroups'][1]['label'] ?? 'Product Categories' }}</div>
                      <div class="mt-2 h-[6px] w-[34px] rounded-[6px] bg-themeBg-d  lg1:block hidden" aria-hidden="true"></div>
                    </div>

                    <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 transition-transform duration-200 group-open:rotate-180 lg1:hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M6 9l6 6 6-6" />
                    </svg>
                  </summary>

                  <div class="mt-5">
                    <ul class="space-y-2.5 text-[11px] text-white/75">
                      @if(!empty($data['footerNavGroups'][1]['children']))
                        @foreach($data['footerNavGroups'][1]['children'] as $child)
                          @if(!empty($child['label']) && !empty($child['url']))
                            <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="{{ $child['url'] }}" @if(!empty($child['target'])) target="{{ $child['target'] }}" @endif @if(!empty($child['rel'])) rel="{{ $child['rel'] }}" @endif>{{ $child['label'] }}</a></li>
                          @endif
                        @endforeach
                      @else
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="#">Activewear Manufacture</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="#">Gym Clothing Wholesale</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="#">Fitness Wear Wholesale</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="#">Gym Clothing Supplier</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="#">Gym Clothes Manufacturer</a></li>
                      @endif
                    </ul>
                  </div>
                </details>
              </div>
            </div>

            <!-- Center: Logo Block -->
            <div class="footer-logo-block order-1 lg1:order-2 w-[calc(100%-30px)] md4:w-[360px]">
              <div class="flex flex-col items-center text-center">
                @php
                  $bottomLogo = $data['footer_logo_url'] ?? front_webp_url('/front/imgs/footer_logo.png');
                @endphp
                <img class="h-auto w-[110px] object-contain sm3:w-[130px] sm6:w-[150px] md1:w-[170px]" src="{{ $bottomLogo }}" alt="Logo" loading="lazy" />
                <p class="mt-3 max-w-[100%] text-[11px] leading-5 text-white/70">
                  {{ $data['footerContact']['brief'] ?? 'Infray Technologies Co., Ltd., A Subsidiary Corporation Of Rayton, Is An Innovative.' }}
                </p>

                <div class="mt-5 flex items-center justify-center gap-2">
                  @include('front.partials.sns-icons', [
                    'variant' => 'link',
                    'snsIcons' => $data['snsIcons'] ?? sns_icons('link'),
                  ])
                </div>
              </div>
            </div>

            <!-- Right Group: Follow Us + Hot Tags -->
            <div class="order-3 lg1:order-3 flex flex-col gap-4 lg1:flex-row lg1:gap-8">
              <div class="flex-1">
                <details class="footer-accordion group" data-footer-accordion>
                  <summary class="flex cursor-pointer items-center justify-between gap-4 select-none rounded pr-2 py-1 transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d/50 focus-visible:ring-offset-2 focus-visible:ring-offset-black/60">
                    <div>
                      <div class="footer-nav-title text-f16 md1:text-f18 font-poppins-medium uppercase tracking-wide whitespace-nowrap">{{ $data['footerNavGroups'][2]['label'] ?? 'Follow Us' }}</div>
                      <div class="mt-2 h-[6px] w-[34px] rounded-[6px] bg-themeBg-d  lg1:block hidden" aria-hidden="true"></div>
                    </div>

                    <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 transition-transform duration-200 group-open:rotate-180 lg1:hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M6 9l6 6 6-6" />
                    </svg>
                  </summary>

                  <div class="mt-5">
                    <ul class="space-y-2.5 text-[11px] text-white/75">
                      @if(!empty($data['footerNavGroups'][2]['children']))
                        @foreach($data['footerNavGroups'][2]['children'] as $child)
                          @if(!empty($child['label']) && !empty($child['url']))
                            <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="{{ $child['url'] }}" @if(!empty($child['target'])) target="{{ $child['target'] }}" @endif @if(!empty($child['rel'])) rel="{{ $child['rel'] }}" @endif>{{ $child['label'] }}</a></li>
                          @endif
                        @endforeach
                      @else
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/">Home</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/products.html">Products</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/contactus.html">Contact Us</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="/singlepage.html">Privacy Policy</a></li>
                      <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="#">New Style Display</a></li>
                      @endif
                    </ul>
                  </div>
                </details>
              </div>

              <div class="flex-1">
                <details class="footer-accordion group" data-footer-accordion>
                  <summary class="flex cursor-pointer items-center justify-between gap-4 select-none rounded pr-2 py-1 transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d/50 focus-visible:ring-offset-2 focus-visible:ring-offset-black/60">
                    <div>
                      <div class="footer-nav-title text-f16 md1:text-f18 font-poppins-medium uppercase tracking-wide whitespace-nowrap">{{ $data['footerNavGroups'][3]['label'] ?? 'Hot Tags' }}</div>
                      <div class="mt-2 h-[6px] w-[34px] rounded-[6px] bg-themeBg-d  lg1:block hidden" aria-hidden="true"></div>
                    </div>

                    <svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 transition-transform duration-200 group-open:rotate-180 lg1:hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                      <path d="M6 9l6 6 6-6" />
                    </svg>
                  </summary>

                  <div class="mt-5">
                    <ul class="space-y-2.5 text-[11px] text-white/75">
                      @foreach($data['hotTags'] ?? [] as $tag)
                        @php
                          $hotTagLabel = trim((string)($tag->name ?? ''));
                          $hotTagUrl = ($tag->url && !empty($tag->url->url))
                            ? ('/' . ltrim((string)$tag->url->url, '/'))
                            : '';
                        @endphp
                        @if($hotTagLabel !== '' && $hotTagUrl !== '')
                          <li><a class="inline-flex transition duration-200 hover:translate-x-0.5 text-themeText-o" href="{{ $hotTagUrl }}">{{ $hotTagLabel }}</a></li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                </details>
              </div>
            </div>
          </div>
          <div class="mt-[30px] grid grid-cols-1 gap-4  pt-8 text-white sm6:grid-cols-2 md2:grid-cols-3 md4:grid-cols-[30%_40%_30%] md4:pt-10">
            <div class="flex items-center gap-4 bg-themeBg-n px-5 py-8 ring-1 ring-white/10 transition duration-200 hover:-translate-y-0.5 sm6:col-span-2 md2:col-span-1">
              <span class="inline-flex h-[52px] w-[52px] min-h-[52px] min-w-[52px] shrink-0 items-center justify-center bg-themeBg-m ring-1 ring-white/10 bg-opacity-25" aria-hidden="true">
                <img src="{{ front_webp_url('/front/icons/ft-email.svg') }}" alt="icon" width="24" height="24" />
              </span>
              <div class="min-w-0">
                <div class="text-[16px] font-poppins-medium">Our Email</div>
                <div class="mt-0.5 truncate text-[14px] font-poppins-regular text-white/70">
                  @if(!empty($data['footerContact']['email']['href']) && !empty($data['footerContact']['email']['label']))
                    <a href="{{ $data['footerContact']['email']['href'] }}" class="text-white/70">{{ $data['footerContact']['email']['label'] }}</a>
                  @else
                    Info@Junzhusport.com
                  @endif
                </div>
              </div>
            </div>

            <div class="flex items-center gap-4 bg-themeBg-n px-5 py-8 ring-1 ring-white/10 transition duration-200 hover:-translate-y-0.5 sm6:col-span-2 md2:col-span-1">
              <span class="inline-flex h-[52px] w-[52px] min-h-[52px] min-w-[52px] shrink-0 items-center justify-center bg-themeBg-m ring-1 ring-white/10 bg-opacity-25" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" class="h-6 w-6"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="4" stroke="#DA2B28" d="M9.858 32.757C6.238 33.843 4 35.343 4 37c0 3.314 8.954 6 20 6s20-2.686 20-6c0-1.657-2.239-3.157-5.858-4.243"/><path stroke-linejoin="round" stroke-width="4" stroke="#FFFFFF" d="M24 35s13-8.496 13-18.318C37 9.678 31.18 4 24 4S11 9.678 11 16.682C11 26.504 24 35 24 35Z"/><path stroke-linejoin="round" stroke-width="4" stroke="#FFFFFF" d="M24 22a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/></svg>
              </span>
              <div class="min-w-0">
                <div class="text-[16px] font-poppins-medium">Address</div>
                <div class="mt-0.5 text-[14px] font-poppins-regular leading-5 text-white/70">{{ $data['footerContact']['address'] ?? 'Room 701,Block C, Zhonghuancity CBD, Shushan District,Hefei,Anhui Province,China. ZIP CODE:230031' }}</div>
              </div>
            </div>

            <div class="flex items-center gap-4 bg-themeBg-n px-5 py-8 ring-1 ring-white/10 transition duration-200 hover:-translate-y-0.5 sm6:col-span-2 md2:col-span-1 sm6:col-span-2 md2:col-span-1">
              <span class="inline-flex h-[52px] w-[52px] min-h-[52px] min-w-[52px] shrink-0 items-center justify-center bg-themeBg-m ring-1 ring-white/10 bg-opacity-25" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" class="h-6 w-6"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="4" stroke="#DA2B28" d="M41.78 20.607c.252-1.696.17-3.432-.25-5.102a12.939 12.939 0 0 0-3.415-6.018 12.94 12.94 0 0 0-6.018-3.416 13.068 13.068 0 0 0-5.102-.249M34.19 19.803a5.991 5.991 0 0 0-1.692-5.132 5.992 5.992 0 0 0-5.132-1.691"/><path stroke-linejoin="round" stroke-width="4" stroke="#FFFFFF" d="M14.376 8.794a2 2 0 0 1 1.748 1.03l2.447 4.406a2 2 0 0 1 .04 1.866l-2.357 4.713s.683 3.512 3.541 6.37c2.859 2.858 6.358 3.53 6.358 3.53l4.713-2.357a2 2 0 0 1 1.867.041l4.419 2.457a2 2 0 0 1 1.028 1.748v5.074c0 2.583-2.4 4.45-4.848 3.623-5.028-1.696-12.832-4.927-17.78-9.873-4.946-4.947-8.176-12.752-9.873-17.78-.826-2.448 1.04-4.848 3.624-4.848h5.072Z"/></svg>
              </span>
              <div class="min-w-0">
                <div class="text-[16px] font-poppins-medium">Call Us</div>
                <div class="mt-0.5 text-[14px] font-poppins-regular leading-5 text-white/70">
                  @if(!empty($data['footerContact']['phone']['href']) && !empty($data['footerContact']['phone']['label']))
                    <a href="{{ $data['footerContact']['phone']['href'] }}" class="text-white/70">{{ $data['footerContact']['phone']['label'] }}</a>
                  @else
                    +86 178 5654 3698
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="relative w-full overflow-hidden copyright">
        <div class="pointer-events-none absolute left-1/2 top-0 h-px w-full max-w-[calc(100%-30px)] -translate-x-1/2 bg-white/10" aria-hidden="true"></div>
        <div class="pointer-events-none absolute inset-0 hidden bg-themeBg-d [clip-path:polygon(0_0,calc(50%_-_60px)_0,50%_100%,0_100%)] md4:block" aria-hidden="true"></div>

        <div class="relative mx-auto w-full max-w-[1200px] px-4 sm2:px-5 md1:px-6 lg1:px-0">
          <div class="flex flex-col items-center justify-between gap-3 py-3 text-center text-[14px] font-poppins-regular text-white md4:flex-row md4:text-left">
            <div class="order-2 text-[15px] font-poppins-regular md4:order-1">JUNZHUO SPORTS CO., LTD. &copy; 2025 ICP NO. ALL RIGHTS RESERVED.</div>

            <div class="order-1 flex items-center justify-center gap-2 md4:order-2 md4:justify-end">
              <span class="inline-flex h-5 items-center justify-center bg-themeBg-n px-2 text-[14px] font-poppins-regular text-white ring-1 ring-white/15 transition duration-200 hover:bg-black/35">IPV6</span>
              <span class="inline-flex h-5 items-center justify-center  px-2 text-[14px] font-poppins-regular text-white  transition duration-200 hover:bg-black/35">IPV6 NETWORK SUPPORTED</span>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer -->

    <!-- Search Popup -->
    <section class="search_popup fixed inset-0 z-[60]">
      <div class="absolute inset-0 cursor-pointer bg-black/80 transition-colors duration-200 hover:bg-black/70" aria-hidden="true"></div>

      <div class="relative flex min-h-full w-full flex-col">
        <div class="w-full bg-white search_main">
          <div class="mx-auto w-full max-w-[1200px] px-4 py-10 sm2:px-5 md1:px-6 md1:py-12 lg1:px-0">
            <h2 class="text-center text-[18px] font-extrabold text-slate-900 md1:text-[22px]">What Are You Looking For?</h2>

            <form class="mx-auto mt-6 w-[1200px] max-w-[calc(100%-30px)] md1:mt-7" action="{{ $data['search']['action'] ?? '/search' }}" method="get">
              <div class="relative w-full">
                <input
                  type="text"
                  name="q"
                  placeholder="{{ $data['search']['placeholder'] ?? 'Search For...' }}"
                  value="{{ $data['search']['q'] ?? '' }}"
                  class="w-full rounded border border-slate-200 bg-white py-[26px] pl-4 pr-14 text-[14px] text-slate-800 outline-none placeholder:text-slate-400 focus:border-themeBg-d md1:h-11 md1:text-[16px]"
                />
                <button
                  type="submit"
                  class="absolute right-2 top-1/2 inline-flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded bg-themeBg-d text-white transition duration-200 hover:bg-themeBg-d active:bg-themeBg-d md1:h-11 md1:w-11"
                  aria-label="Search"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" class="h-6 w-6" aria-hidden="true">
                    <path stroke-linejoin="round" stroke-width="4" stroke="currentColor" d="M21 38c9.389 0 17-7.611 17-17S30.389 4 21 4 4 11.611 4 21s7.611 17 17 17Z" data-follow-stroke="#000" />
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="4" stroke="currentColor" d="M26.657 14.343A7.975 7.975 0 0 0 21 12c-2.209 0-4.209.895-5.657 2.343M33.222 33.222l8.485 8.485" data-follow-stroke="#000" />
                  </svg>
                </button>
              </div>

              <div class="mx-auto mt-6 flex w-[1200px] max-w-[calc(100%-30px)] flex-wrap items-center justify-center gap-3 md1:mt-[40px] md1:gap-4 mb-3">
                @if (!empty($data['search']['hot']))
                  @foreach ($data['search']['hot'] as $hotKeyword)
                    <a
                      href="{{ route('search', ['q' => $hotKeyword]) }}"
                      target="_blank"
                      rel="noopener"
                      class="inline-flex h-9 items-center justify-center rounded bg-themeBg-c px-3 py-4 text-f14 font-poppins-regular font-normal text-themeText-p transition duration-200 hover:-translate-y-0.5 hover:bg-themeBg-d hover:text-white active:translate-y-0 md1:h-10 md1:px-4"
                    >
                      {{ $hotKeyword }}
                    </a>
                  @endforeach
                @endif
              </div>
            </form>
          </div>
        </div>

        <div class="relative flex flex-1 items-start justify-center">
          <button type="button" class="group absolute -top-5 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-700 shadow-md ring-1 ring-slate-200 transition duration-200 hover:-translate-y-0.5 hover:bg-slate-50 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-themeBg-d focus-visible:ring-offset-2" aria-label="Close search">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" width="18" height="18" class="transition-transform duration-200 group-hover:rotate-90"><path stroke-linejoin="round" stroke-width="6" stroke="#000" d="m8 8 32 32M8 40 40 8" data-follow-stroke="#000"/></svg>
          </button>
        </div>
      </div>
    </section>
    <!-- Search Popup -->

    <!-- Contact List -->
    <div id="contactSideBackdrop" class="contact-side-backdrop" aria-hidden="true"></div>
    <div id="contactSidePanel" class="group/contact contact-side-panel fixed right-[-280px] top-1/2 z-50 -translate-y-1/2 shadow-xl transition-all duration-300 ease-out">
      <div class="flex w-[330px] flex-col">
          <!-- Phone -->
          @if(!empty($data['contactPopup']['phones']))
          <div class="contact-row flex items-center bg-themeBg-d px-[13px] text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 26 26" class="mr-3 h-[24px] w-[24px] flex-shrink-0">
              <path d="M24.5564 10.653C24.7228 9.51659 24.6683 8.35316 24.3926 7.2345C24.0284 5.75671 23.2784 4.35719 22.1427 3.20153C21.0069 2.04589 19.6315 1.28279 18.1792 0.912238C17.0798 0.631731 15.9364 0.576177 14.8195 0.745575M19.5576 10.1148C19.736 8.89742 19.3646 7.61276 18.4437 6.67564C17.5226 5.73852 16.2601 5.36063 15.0637 5.5421M6.50811 2.73708C6.98664 2.73708 7.42751 3.00113 7.65973 3.42683L9.27099 6.38001C9.48193 6.76668 9.49181 7.23437 9.29746 7.62995L7.74528 10.7887C7.74528 10.7887 8.1951 13.1419 10.0776 15.0574C11.9602 16.973 14.2651 17.4228 14.2651 17.4228L17.369 15.8436C17.758 15.6457 18.218 15.6559 18.5981 15.871L21.5086 17.5175C21.9266 17.7539 22.1858 18.2023 22.1858 18.6889V22.0889C22.1858 23.8203 20.6052 25.0709 18.9929 24.5173C15.6816 23.3804 10.5414 21.2157 7.28347 17.9006C4.02546 14.5855 1.89806 9.35529 0.780724 5.9859C0.23671 4.34533 1.46571 2.73708 3.16729 2.73708H6.50811Z" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class="flex flex-col">
              @foreach($data['contactPopup']['phones'] as $item)
                @if(!empty($item['href']) && !empty($item['label']))
                  <a href="{{ $item['href'] }}" class="text-f16 leading-relaxed text-white transition-colors hover:text-white hover:underline">{{ $item['label'] }}</a>
                @endif
              @endforeach
            </div>
          </div>
          @endif

          <!-- WhatsApp -->
          @if(!empty($data['contactPopup']['whatsapps']))
          <div class="contact-row flex items-center border-t border-white/20 bg-themeBg-d px-[13px] text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="mr-3 h-[24px] w-[24px] flex-shrink-0">
              <path d="M0 24L1.69505 17.837C0.649083 16.033 0.0994725 13.988 0.100477 11.891C0.103492 5.335 5.46395 0 12.0502 0C15.2464 0.001 18.2467 1.24 20.5034 3.488C22.7591 5.736 24.001 8.724 24 11.902C23.997 18.459 18.6365 23.794 12.0502 23.794C10.0507 23.793 8.08038 23.294 6.33509 22.346L0 24ZM6.62848 20.193C8.31248 21.188 9.92012 21.784 12.0462 21.785C17.5202 21.785 21.9794 17.351 21.9824 11.9C21.9844 6.438 17.5463 2.01 12.0543 2.008C6.57624 2.008 2.12007 6.442 2.11806 11.892C2.11706 14.117 2.77217 15.783 3.87239 17.526L2.86863 21.174L6.62848 20.193ZM18.0698 14.729C17.9955 14.605 17.7965 14.531 17.4971 14.382C17.1987 14.233 15.7307 13.514 15.4564 13.415C15.1831 13.316 14.9842 13.266 14.7842 13.564C14.5853 13.861 14.0126 14.531 13.8387 14.729C13.6649 14.927 13.4901 14.952 13.1917 14.803C12.8932 14.654 11.9307 14.341 10.7903 13.328C9.90304 12.54 9.30319 11.567 9.12936 11.269C8.95554 10.972 9.11128 10.811 9.25998 10.663C9.39462 10.53 9.5584 10.316 9.70811 10.142C9.85983 9.97 9.90907 9.846 10.0095 9.647C10.109 9.449 10.0598 9.275 9.98443 9.126C9.90907 8.978 9.31223 7.515 9.06405 6.92C8.8209 6.341 8.57473 6.419 8.39186 6.41L7.81914 6.4C7.6202 6.4 7.29666 6.474 7.02336 6.772C6.75006 7.07 5.9784 7.788 5.9784 9.251C5.9784 10.714 7.04848 12.127 7.19719 12.325C7.3469 12.523 9.30218 15.525 12.2974 16.812C13.0098 17.118 13.5664 17.301 13.9995 17.438C14.7149 17.664 15.366 17.632 15.8804 17.556C16.4542 17.471 17.6468 16.837 17.896 16.143C18.1452 15.448 18.1452 14.853 18.0698 14.729Z" fill="white"/>
            </svg>
            <div class="flex flex-col">
              @foreach($data['contactPopup']['whatsapps'] as $item)
                @if(!empty($item['href']) && !empty($item['label']))
                  <a href="{{ $item['href'] }}" target="_blank" class="text-f16 leading-relaxed text-white transition-colors hover:text-white hover:underline">{{ $item['label'] }}</a>
                @endif
              @endforeach
            </div>
          </div>
          @endif

          <!-- Instagram -->
          @if(!empty($data['contactPopup']['teams']['href']))
          <div class="contact-row flex items-center border-t border-white/20 bg-themeBg-d px-[13px] text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" viewBox="0 0 24 24" class="mr-3 h-[24px] w-[24px] flex-shrink-0">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
            <a href="{{ $data['contactPopup']['teams']['href'] }}" target="_blank" class="text-f16 text-white transition-colors hover:text-white">{{ $data['contactPopup']['teams']['label'] ?? 'Instagram' }}</a>
          </div>
          @endif

          <!-- Email -->
          @if(!empty($data['contactPopup']['emails']))
          <div class="contact-row flex items-center border-t border-white/20 bg-themeBg-d px-[13px] text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="mr-3 h-[24px] w-[24px] flex-shrink-0">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
            </svg>
            <div class="flex flex-col">
              @foreach($data['contactPopup']['emails'] as $item)
                @if(!empty($item['href']) && !empty($item['label']))
                  <a href="{{ $item['href'] }}" class="text-f16 leading-relaxed text-white transition-colors hover:text-white hover:underline">{{ $item['label'] }}</a>
                @endif
              @endforeach
            </div>
          </div>
          @endif

          <!-- QR Code -->
          @if(!empty($data['contactPopup']['qrs']))
          <a href="#" class="contact-row flex items-center justify-start border-t border-white/20 bg-themeBg-d px-[13px] text-white transition-colors hover:bg-[#c22522]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="mr-3 h-[24px] w-[24px] flex-shrink-0">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
            </svg>
            @foreach($data['contactPopup']['qrs'] as $qr)
              @if(!empty($qr['src']))
                <img src="{{ $qr['src'] }}" alt="QR Code" class="ml-3 w-[120px] h-auto bg-white object-contain p-1" />
              @endif
            @endforeach
          </a>
          @endif
      </div>
    </div>
    <!-- Contact List -->

    @php
      $currentPath = trim(request()->path(), '/');
      $tabHomeActive = $currentPath === '';
      $tabProductsActive = $currentPath === 'products' || str_starts_with($currentPath, 'products/');
      $tabAboutActive = $currentPath === 'about-us' || str_starts_with($currentPath, 'about-us/');
      $tabContactActive = $currentPath === 'contact-us' || str_starts_with($currentPath, 'contact-us/');
    @endphp
    <!-- Mobile Bottom Tabbar (<768px) -->
    <nav class="mobile-tabbar" aria-label="Mobile bottom navigation">
      <div class="mobile-tabbar__inner">
        <a href="{{ route('home') }}" class="mobile-tabbar__item {{ $tabHomeActive ? 'is-active' : '' }}" @if($tabHomeActive) aria-current="page" @endif>
          <span class="mobile-tabbar__icon" aria-hidden="true">
            <img class="mobile-tabbar__icon-default" src="{{ front_webp_url('/front/imgs/icons/tabbar/home.svg') }}" alt="" width="22" height="22" />
            <img class="mobile-tabbar__icon-active" src="{{ front_webp_url('/front/imgs/icons/tabbar/home-active.svg') }}" alt="" width="22" height="22" />
          </span>
          <span class="mobile-tabbar__label">Home</span>
        </a>
        <a href="{{ route('products') }}" class="mobile-tabbar__item {{ $tabProductsActive ? 'is-active' : '' }}" @if($tabProductsActive) aria-current="page" @endif>
          <span class="mobile-tabbar__icon" aria-hidden="true">
            <img class="mobile-tabbar__icon-default" src="{{ front_webp_url('/front/imgs/icons/tabbar/products.svg') }}" alt="" width="22" height="22" />
            <img class="mobile-tabbar__icon-active" src="{{ front_webp_url('/front/imgs/icons/tabbar/products-active.svg') }}" alt="" width="22" height="22" />
          </span>
          <span class="mobile-tabbar__label">Products</span>
        </a>
        <button type="button" class="mobile-tabbar__inquiry inquiry-entry-btn" aria-label="Inquiry">
          <span class="mobile-tabbar__inquiry-btn">
            <img src="{{ front_webp_url('/front/imgs/icons/tabbar/inquiry.svg') }}" alt="" width="26" height="26" />
            <span class="inquiry-cart-badge inquiry-cart-badge-float mobile-tabbar__badge hidden">0</span>
          </span>
        </button>
        <a href="{{ url('/about-us') }}" class="mobile-tabbar__item {{ $tabAboutActive ? 'is-active' : '' }}" @if($tabAboutActive) aria-current="page" @endif>
          <span class="mobile-tabbar__icon" aria-hidden="true">
            <img class="mobile-tabbar__icon-default" src="{{ front_webp_url('/front/imgs/icons/tabbar/about.svg') }}" alt="" width="22" height="22" />
            <img class="mobile-tabbar__icon-active" src="{{ front_webp_url('/front/imgs/icons/tabbar/about-active.svg') }}" alt="" width="22" height="22" />
          </span>
          <span class="mobile-tabbar__label">About</span>
        </a>
        <a href="{{ url('/contact-us') }}" class="mobile-tabbar__item {{ $tabContactActive ? 'is-active' : '' }}" @if($tabContactActive) aria-current="page" @endif>
          <span class="mobile-tabbar__icon" aria-hidden="true">
            <img class="mobile-tabbar__icon-default" src="{{ front_webp_url('/front/imgs/icons/tabbar/contact.svg') }}" alt="" width="22" height="22" />
            <img class="mobile-tabbar__icon-active" src="{{ front_webp_url('/front/imgs/icons/tabbar/contact-active.svg') }}" alt="" width="22" height="22" />
          </span>
          <span class="mobile-tabbar__label">Contact</span>
        </a>
      </div>
    </nav>
    <!-- Mobile Bottom Tabbar -->

    <!-- Fixed Right Side Buttons -->
    <div class="fixed bottom-[100px] right-3 z-40 flex flex-col items-center gap-3 md4:bottom-[170px] md4:right-[100px] md4:gap-4 float-side-actions">
      <!-- Message Button -->
      <a href="#" class="inquiry-entry-btn group relative flex h-[38px] w-[38px] items-center justify-center rounded-full bg-black shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl md4:h-[45px] md4:w-[45px] float-inquiry-btn" aria-label="Messages">
        <svg class="h-[20px] w-[20px] md4:h-[26px] md4:w-[26px]" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g clip-path="url(#clip_fbmsg)">
            <path d="M12.9998 0C5.85096 0 0.0546875 5.07213 0.0546875 11.3269C0.0546875 14.9024 1.95196 18.086 4.90907 20.1612V25.8903C6.79941 24.7431 8.6898 23.5963 10.5799 22.4493C11.3646 22.5786 12.1718 22.6541 12.9998 22.6541C20.1487 22.6541 25.9449 17.5828 25.9449 11.327C25.9448 5.07213 20.1487 0 12.9998 0ZM6.52727 12.9451C5.63409 12.9451 4.90907 12.2201 4.90907 11.327C4.90907 10.434 5.63409 9.70899 6.52727 9.70899C7.42042 9.70899 8.14548 10.434 8.14548 11.327C8.14543 12.2201 7.42042 12.9451 6.52727 12.9451ZM12.9998 12.9451C12.1066 12.9451 11.3816 12.2201 11.3816 11.327C11.3816 10.434 12.1066 9.70899 12.9998 9.70899C13.893 9.70899 14.618 10.434 14.618 11.327C14.618 12.2201 13.893 12.9451 12.9998 12.9451ZM19.4724 12.9451C18.5792 12.9451 17.8541 12.2201 17.8541 11.327C17.8541 10.434 18.5792 9.70899 19.4724 9.70899C20.3655 9.70899 21.0906 10.434 21.0906 11.327C21.0906 12.2201 20.3655 12.9451 19.4724 12.9451Z" fill="white"/>
          </g>
          <defs><clipPath id="clip_fbmsg"><rect width="26" height="26" fill="white"/></clipPath></defs>
        </svg>
      </a>
      <!-- Inquiry List Button -->
      <a href="#" class="wishlist-entry-btn group relative flex h-[38px] w-[38px] items-center justify-center rounded-full bg-themeBg-d shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl md4:h-[45px] md4:w-[45px]" aria-label="Inquiry List">
        <svg class="h-[20px] w-[20px] md4:h-[26px] md4:w-[26px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M7.5 19.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Zm9 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z" fill="white"/>
          <path d="M3.2 3.2h1.86c.64 0 1.2.43 1.36 1.05l.28 1.05h12.55c.86 0 1.5.8 1.3 1.63l-1.4 5.9a1.4 1.4 0 0 1-1.36 1.07H8.55l.22.82c.16.62.72 1.05 1.36 1.05h8.62a.9.9 0 1 1 0 1.8H9.91a3.2 3.2 0 0 1-3.1-2.4L4.86 4.7H3.2a.9.9 0 1 1 0-1.8Zm3.7 3.9.78 2.95h9.55l1.05-4.4H7.28l-.38 1.45Z" fill="white"/>
        </svg>
        <span class="inquiry-cart-badge inquiry-cart-badge-float absolute -right-1 -top-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-black px-1 text-[11px] font-bold text-white hidden">0</span>
      </a>
      <!-- Back to Top Button -->
      <a href="#" id="backToTopBtn" class="group relative flex h-[38px] w-[38px] items-center justify-center rounded-full bg-slate-200 shadow-lg transition-all duration-300 hover:scale-110 hover:bg-slate-300 hover:shadow-xl md4:h-[45px] md4:w-[45px]" aria-label="Back to top">
        <svg class="h-[20px] w-[20px] md4:h-[26px] md4:w-[26px]" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M16.8187 1.04346C16.8187 1.61973 16.359 2.08692 15.7919 2.08692H1.04321C0.476172 2.08692 0.0164712 1.61975 0.0164712 1.04346C0.0164712 0.467187 0.476147 0 1.04321 0H15.7919C16.359 0 16.8187 0.467162 16.8187 1.04346ZM8.49993 4.92416C7.9329 4.92416 7.4732 5.39133 7.4732 5.96762V20.9565C7.4732 21.5328 7.93287 22 8.49993 22C9.06697 22 9.52667 21.5328 9.52667 20.9565V5.9676C9.52664 5.39132 9.06697 4.92416 8.49993 4.92416ZM9.22859 4.15434C8.82763 3.74685 8.20054 3.72347 7.82794 4.10214L0.265064 11.7882C-0.107516 12.1668 -0.0845296 12.8041 0.316431 13.2116C0.717391 13.6191 1.34448 13.6425 1.71706 13.2638L9.27996 5.57778C9.65254 5.19913 9.62955 4.56183 9.22859 4.15434ZM7.77143 4.15434C7.37047 4.56183 7.34745 5.19913 7.72006 5.57778L15.2829 13.2638C15.6555 13.6425 16.2826 13.6191 16.6836 13.2116C17.0845 12.8041 17.1075 12.1668 16.7349 11.7882L9.17205 4.10212C8.79947 3.72347 8.17239 3.74685 7.77143 4.15434Z" fill="black"/>
        </svg>
      </a>
    </div>
    <!-- Fixed Right Side Buttons -->

    <!-- Inquiry Popup -->
    <section class="inquiry_popup fixed inset-0 z-[60]">
      <div class="inquiry_popup_backdrop absolute inset-0 cursor-pointer bg-black/70" aria-hidden="true"></div>
      <div class="inquiry_popup_panel relative mx-auto w-[calc(100%-20px)] bg-white shadow-2xl ring-1 ring-black/10 md4:w-[320px]">
        <div class="flex items-center justify-between bg-themeBg-d px-4 py-3 text-white">
          <div class="text-[16px] font-extrabold uppercase tracking-wide">LEAVE A MESSAGE</div>
          <button type="button" class="inquiry_popup_close inline-flex h-8 w-8 items-center justify-center text-white/90 hover:text-white" aria-label="Close inquiry">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48" width="16" height="16"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="6" stroke="currentColor" d="m8 8 32 32M8 40 40 8"/></svg>
          </button>
        </div>
        <div class="px-4 py-4">
          <p class="text-[12px] leading-5 text-slate-600">
            If you are interested in our products and want to know more details, please leave a message here, we will reply you as soon as we can.
          </p>
          <form class="mt-4 js-inquiry-popup-form" action="#" onsubmit="return false" method="post">
            <input type="hidden" name="source_url" value="" class="js-inquiry-popup-source-url" />
            <div class="space-y-3">
              <div>
                <label class="form-field-label mb-1 block text-[12px] font-poppins-regular text-slate-700">E-Mail<x-front.form-required /></label>
                <div class="relative">
                <input type="email" name="email" required placeholder="Please enter your email" class="h-10 w-full rounded border border-slate-200 bg-white px-3 pr-10 text-[12px] text-slate-900 outline-none placeholder:text-slate-400 focus:border-themeBg-d" />
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400" aria-hidden="true">
                  <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16v16H4z" opacity="0" />
                    <path d="M4 8l8 5 8-5" />
                    <path d="M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2" />
                    <path d="M20 8v10a2 2 0 01-2 2H6a2 2 0 01-2-2V8" />
                  </svg>
                </span>
                </div>
              </div>
              <div>
                <label class="form-field-label mb-1 block text-[12px] font-poppins-regular text-slate-700">Tel/WhatsApp</label>
                <div class="relative">
                <input type="tel" name="tel" placeholder="Please enter your phone number" class="h-10 w-full rounded border border-slate-200 bg-white px-3 pr-10 text-[12px] text-slate-900 outline-none placeholder:text-slate-400 focus:border-themeBg-d" />
                <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400" aria-hidden="true">
                  <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.8 19.8 0 013.11 4.18 2 2 0 015.09 2h3a2 2 0 012 1.72c.12.86.32 1.7.59 2.5a2 2 0 01-.45 2.11L9.09 9.91a16 16 0 006 6l1.58-1.13a2 2 0 012.11-.45c.8.27 1.64.47 2.5.59A2 2 0 0122 16.92z" />
                  </svg>
                </span>
                </div>
              </div>
              <div>
                <label class="form-field-label mb-1 block text-[12px] font-poppins-regular text-slate-700">Content<x-front.form-required /></label>
                <textarea name="content" rows="5" required placeholder="Enter product details (such as color, size, materials etc.) and other specific requirements to receive an accurate quote." class="w-full resize-y rounded border border-slate-200 bg-white px-3 py-2 text-[12px] text-slate-900 outline-none placeholder:text-slate-400 focus:border-themeBg-d"></textarea>
              </div>
            </div>
            <button type="submit" class="mt-4 inline-flex h-10 w-full items-center justify-center bg-themeBg-d text-[12px] font-extrabold uppercase tracking-wide text-white transition hover:bg-themeBg-d">
              SUBMIT
            </button>
            {{-- 暂时隐藏 Inquiry List 入口 --}}
            <a href="/myinquirys" class="mt-3 hidden h-10 w-full items-center justify-center border border-themeBg-d bg-white text-[12px] font-extrabold uppercase tracking-wide text-themeBg-d transition hover:bg-themeBg-d hover:text-white">
              Inquiry List (<span class="inquiry-cart-badge">0</span>)
            </a>
          </form>
        </div>
      </div>
    </section>
    <!-- Inquiry Popup -->

    <!-- Inquiry List Popup (reuse wishlist_popup styles/position) -->
    <section class="wishlist_popup fixed inset-0 z-[60]" aria-label="Inquiry List">
      <div class="wishlist_popup_backdrop absolute inset-0 cursor-pointer bg-black/70" aria-hidden="true"></div>
      <div class="wishlist_popup_panel w-[calc(100%-20px)] bg-white shadow-2xl ring-1 ring-black/10 md4:w-[280px]">
        <div class="wishlist_popup_header">
          <div class="wishlist_popup_title">INQUIRY LIST</div>
          <button type="button" class="wishlist_popup_close" aria-label="Close inquiry list">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 6L6 18" />
              <path d="M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="wishlist_popup_content js-inquiry-float-content h-[316px] overflow-y-auto">
          <div class="wishlist_empty js-inquiry-float-empty flex flex-col items-center justify-center px-4 py-12">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="mb-3 h-8 w-8 text-slate-400" aria-hidden="true">
              <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
            <p class="text-center text-[13px] text-slate-500">There is currently no<br>inquiry product</p>
          </div>
          <div class="wishlist_list js-inquiry-float-list hidden"></div>
        </div>
        <div class="wishlist_footer js-inquiry-float-footer hidden border-t border-slate-200 px-3 py-2">
          <div class="flex items-center gap-2">
            <button type="button" class="wishlist_delete_btn js-inquiry-float-clear flex-1 rounded border border-slate-300 px-3 py-1 text-[12px] text-slate-600 transition hover:bg-slate-100">Clear</button>
            <button type="button" class="wishlist_contact_btn js-inquiry-float-contact flex-1 rounded bg-themeBg-d px-3 py-1 text-[12px] text-white transition hover:bg-[#c22522]">Contact Now</button>
          </div>
        </div>
      </div>
    </section>
    <!-- Inquiry List Popup -->

    <div id="videoModal" class="fixed inset-0 z-[90] hidden" aria-hidden="true">
      <div class="video-modal-backdrop absolute inset-0 bg-black/70"></div>
      <div class="absolute inset-0 flex items-center justify-center px-4 py-6">
        <div class="relative w-full max-w-[920px]">
          <button type="button" class="video-modal-close absolute -top-4 -right-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-slate-900 shadow ring-1 ring-black/10 transition hover:bg-white" aria-label="Close">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M18 6L6 18" />
              <path d="M6 6l12 12" />
            </svg>
          </button>
          <div class="w-full overflow-hidden rounded bg-black">
            <div class="relative w-full aspect-video">
              <iframe id="videoModalIframe" class="absolute inset-0 h-full w-full" src="" title="Video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
              <video id="videoModalVideo" class="absolute inset-0 hidden h-full w-full" controls playsinline></video>
            </div>
          </div>
        </div>
      </div>
    </div>

    @yield('page-css-footer')
    <script type="text/javascript" src="/front/js/jquery.min.js"></script>
    <script type="text/javascript" src="/front/js/inquiry-cart.js?v=20260316c"></script>
    <script type="text/javascript" src="/front/js/main.js?v=20260929a"></script>
    <script type="text/javascript" src="/front/js/sns-share.js?v=20260923a"></script>
    <script type="text/javascript" src="/front/js/section-spacing.js?v=20260915b"></script>
    <script src="/front/js/swiper-bundle.min.js" defer></script>
    <script src="/front/js/swiper-common.js?v=20260915d" defer></script>
    @yield('page-js-footer')
</body>
</html>
