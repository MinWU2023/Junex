@foreach(($nodes ?? []) as $node)
    @php
        $depth = (int)($depth ?? 0);
        $isActive = !empty($node['active']);
        $children = $node['children'] ?? [];
        $isOpen = !empty($node['open']);
        $hasChildren = !empty($children);
        $liClass = trim(
            ($hasChildren ? 'has-children ' : '')
            . ($isOpen ? 'is-open ' : '')
            . ($isActive ? 'is-active' : '')
        );
    @endphp
    <li class="{{ $liClass }}">
        @if($hasChildren)
            <button
                type="button"
                class="js-pls-toggle pls-toggle"
                aria-label="{{ __('Toggle subcategories') }}"
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
            >
                <svg class="pls-chevron" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        @endif
        <div class="pls-row">
            <a href="{{ $node['url'] ?? '#' }}" class="pls-link {{ $depth > 0 ? 'pls-link-child' : 'pls-link-root' }}">
                {{ $node['name'] ?? '' }}
            </a>
        </div>
        @if($hasChildren)
            <ul class="js-pls-children pls-children {{ $isOpen ? '' : 'hidden' }}">
                @include('front.partials.product-list-sidebar-category-nodes', [
                    'nodes' => $children,
                    'depth' => $depth + 1,
                ])
            </ul>
        @endif
    </li>
@endforeach
