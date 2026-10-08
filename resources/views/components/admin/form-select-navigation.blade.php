<select name="parent_id"  lay-verify="required" >
    <option value="0" @if(0 === $parent_id) selected @endif>{{ __('顶级分类') }}</option>
    @foreach($categories as $category_2)
        <option @if($category_2->id === $parent_id) selected
                @endif value="{{ $category_2->id }}">{{ $category_2->name }}</option>
            @foreach($category_2->children as $category_3)
                <option @if($category_3->id === $parent_id) selected @endif
                         value="{{ $category_3->id }}">&nbsp;&nbsp;{{ $category_3->name }}</option>
            @endforeach
    @endforeach
</select>
