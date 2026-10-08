<?php
$showLevel0 ? $name = 'parent_id' : $name = 'category_id';
?>
<select name="{{ $name }}" @if(!is_null($verify)) lay-verify="{{ $verify }}" @endif>
    @if($showLevel0)
        <option value="0" @if(0 === $parent_id) selected @endif>{{ __('顶级分类') }}</option>
    @endif
    @foreach($menus as $key => $menu)
        <option @if((int)$menu['id'] === (int)$parent_id) selected
                @endif value="{{ $menu['id'] }}">{{ $menu['name'] }}</option>
        @if(isset($menu['children']) && is_array($menu['children']))
            @foreach($menu['children'] as $k => $children)
                <option @if((int)$children['id'] === (int)$parent_id) selected @endif
                        value="{{ $children['id'] }}">-&nbsp;{{ $children['name'] }}</option>
            @endforeach
        @endif
    @endforeach
</select>
