@php
    $renderCat = function ($nodes, $selected) use (&$renderCat) {
        foreach ($nodes as $node) {
            $pad = (int)($node['depth'] ?? 0) * 18;
            $id = (int)$node['id'];
            $checked = in_array($id, array_map('intval', (array)$selected), true);
            echo '<div class="nav-cat-item" data-id="'.$id.'" style="padding-left:'.$pad.'px;margin:4px 0;">';
            echo '<input type="checkbox" name="category_ids[]" value="'.$id.'" title="'.e($node['name']).'" data-nav-cat="1" data-id="'.$id.'" lay-skin="primary"';
            if ($checked) echo ' checked';
            echo '>';
            echo '</div>';
            if (!empty($node['children'])) {
                $renderCat($node['children'], $selected);
            }
        }
    };
@endphp
<div class="nav-cat-tree" style="max-height:280px;overflow:auto;border:1px solid #eee;padding:10px;background:#fafafa;">
    @if(empty($categoryTree))
        <div style="color:#999;">{{ __('暂无产品分类') }}</div>
    @else
        @php($renderCat($categoryTree, $selectedCategoryIds ?? []))
    @endif
</div>
<div class="layui-word-aux">{{ __('勾选父级会联动勾选全部子级；取消父级会取消全部子级') }}</div>
