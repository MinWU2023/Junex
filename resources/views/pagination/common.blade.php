@if ($paginator->hasPages())
    <div class="flex justify-center mt-10 gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex h-10 w-10 items-center justify-center border border-slate-200 text-slate-300 cursor-not-allowed">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center border border-slate-200 text-slate-600 transition hover:bg-themeBg-d hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator->render()->elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="inline-flex h-10 w-10 items-center justify-center border border-slate-200 text-slate-400">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center bg-themeBg-d text-white font-medium">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="inline-flex h-10 w-10 items-center justify-center border border-slate-200 text-slate-600 transition hover:bg-themeBg-d hover:text-white">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center border border-slate-200 text-slate-600 transition hover:bg-themeBg-d hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="inline-flex h-10 w-10 items-center justify-center border border-slate-200 text-slate-300 cursor-not-allowed">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </div>
@endif
