@php
    $nbsp = '';
    for ($i = 0; $i < $level; $i++) {
        $nbsp .= '&nbsp;&nbsp;&nbsp;';
    }
    $isDisabled = !empty($model) && ($category->id === $model->id || in_array($category->id, $disabledIds ?? []));
    $isSelected = !empty($model) && $category->id === $model->parent_id;
@endphp
<option {{ $isDisabled ? 'disabled' : '' }} {{ $isSelected ? 'selected' : '' }} value="{{ $category->id }}">
    {!! $nbsp !!}{{ $category->name }}</option>
@if ($category->children)
    @foreach ($category->children as $cate)
        @include('layouts.admin.children-category', [
            'category' => $cate,
            'model' => $model,
            'level' => $level + 1,
            'disabledIds' => $disabledIds ?? [],
        ])
    @endforeach
@endif
