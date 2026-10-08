<select name="{{ $name }}" @if (!is_null($verify)) lay-verify="{{ $verify }}" @endif>
    <option value="0">{{ __('顶级分类') }}</option>
    @foreach ($categories as $key => $category)
        @include('layouts.admin.children-category', [
            'category' => $category,
            'model' => $model,
            'level' => 1,
            'disabledIds' => $disabledIds ?? [],
        ])
    @endforeach
</select>
