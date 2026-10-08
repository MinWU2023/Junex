<select name="{{$name}}">
        <option value="0">{{ __('请选择') }}</option>
    @foreach($categories as $key => $category1)
        <option @if($category1->id === $parent_id) selected
                @endif value="{{ $category1->id }}">{{ $category1->name }}</option>
        @if(isset($category1->children[0]))
            @foreach($category1->children as  $category2)
                <option @if($category2->id === $parent_id) selected @endif @if($showLevel0)
                @endif value="{{ $category2->id }}">&nbsp;&nbsp;&nbsp;{{ $category2->name }}</option>
                @if(isset($category2->children[0]))
                    @foreach($category2->children as  $category3)
                        <option @if($category3->id === $parent_id) selected @endif @if($showLevel0)
                                @endif value="{{ $category3->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $category3->name }}</option>
                        @if(isset($category3->children[0]))
                            @foreach($category3->children as  $category4)
                                <option @if($category4->id === $parent_id) selected @endif @if($showLevel0) disabled
                                        @endif value="{{ $category4->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $category4->name }}</option>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endif
    @endforeach
</select>
