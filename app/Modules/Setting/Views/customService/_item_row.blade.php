@php
    $item = $item ?? null;
    $index = $index ?? 0;
    $sortDefault = 0;
    if ($item && $item->sort !== null && $item->sort !== '') {
        $sortDefault = (int)$item->sort;
    } elseif (is_numeric($index)) {
        $sortDefault = 100 - (int)$index;
    }
    $itemId = $item ? (string)($item->id ?? '') : '';
    $itemPath = $item ? (string)($item->path ?? '') : '';
    $itemUrl = $item ? (string)($item->url ?? '') : '';
    $itemActive = $item ? (string)($item->active ?? '1') : '1';
    $tabLocales = $locales ?? config('translatable.locales', ['en']);
    $tabFilter = 'cs-item-tabs-' . $index;
@endphp
<div class="cs-item-row" style="border:1px solid #e6e6e6;padding:12px;margin-bottom:12px;background:#fafafa;">
    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $itemId }}">

    <div class="layui-form-item" style="margin-bottom:8px;">
        <label class="layui-form-label">{{ __('卡片图片') }}</label>
        <div class="layui-input-block">
            <input type="text"
                   name="items[{{ $index }}][path]"
                   class="layui-input"
                   value="{{ old('items.'.$index.'.path', $itemPath) }}"
                   placeholder="front/imgs/xxx.png">
            @if($itemPath !== '')
                <div style="margin-top:8px;">
                    <img src="{{ front_image_url($itemPath) }}" alt="" style="max-height:60px;max-width:120px;">
                </div>
            @endif
            <div class="layui-word-aux">{{ __('填写图片相对路径，或先在「文件管理」上传后粘贴路径') }}</div>
        </div>
    </div>

    <div class="layui-form-item" style="margin-bottom:8px;">
        <label class="layui-form-label">{{ __('跳转链接') }}</label>
        <div class="layui-input-block">
            <input type="text" name="items[{{ $index }}][url]" class="layui-input"
                   value="{{ old('items.'.$index.'.url', $itemUrl) }}" placeholder="#">
        </div>
    </div>
    <div class="layui-form-item" style="margin-bottom:8px;">
        <label class="layui-form-label">{{ __('排序') }}</label>
        <div class="layui-input-inline" style="width:120px;">
            <input type="number" name="items[{{ $index }}][sort]" class="layui-input"
                   value="{{ old('items.'.$index.'.sort', $sortDefault) }}">
        </div>
        <div class="layui-input-inline" style="width:140px;">
            <select name="items[{{ $index }}][active]" lay-ignore class="layui-input">
                @php $activeVal = (string)old('items.'.$index.'.active', $itemActive); @endphp
                <option value="1" @if($activeVal==='1') selected @endif>{{ __('启用') }}</option>
                <option value="0" @if($activeVal==='0') selected @endif>{{ __('禁用') }}</option>
            </select>
        </div>
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm cs-item-remove">{{ __('删除此项') }}</button>
    </div>

    <div class="layui-form-item" style="margin-bottom:0;">
        <label class="layui-form-label">{{ __('卡片标题') }}</label>
        <div class="layui-input-block">
            <div class="layui-tab layui-tab-brief" lay-filter="{{ $tabFilter }}">
                <ul class="layui-tab-title">
                    @foreach($tabLocales as $locale)
                        <li @if($loop->first) class="layui-this" @endif>{{ $locale }}</li>
                    @endforeach
                </ul>
                <div class="layui-tab-content" style="padding:10px 0 0;">
                    @foreach($tabLocales as $locale)
                        @php
                            $titleVal = old('items.'.$index.'.translate.'.$locale.'.title');
                            if ($titleVal === null && $item) {
                                $titleVal = optional($item->translate($locale, false))->title ?? '';
                            }
                            $titleVal = $titleVal ?? '';
                        @endphp
                        <div class="layui-tab-item @if($loop->first) layui-show @endif">
                            <input type="text"
                                   name="items[{{ $index }}][translate][{{ $locale }}][title]"
                                   class="layui-input"
                                   value="{{ $titleVal }}"
                                   placeholder="{{ __('卡片标题') }} ({{ $locale }})">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
