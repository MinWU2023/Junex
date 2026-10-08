@php(
    $nbsp =''
)
@for($i=0;$i<$level;$i++)
    @php($nbsp.="&nbsp;&nbsp;&nbsp;")
@endfor

<option @if($disable && !$is_single) disabled @endif @if(!empty($model)  &&  $category->id == $model->$name) selected
        @php($disable =true)
        @endif value="{{ $category->id }}">{!! $nbsp !!}{{ $category->name }}</option>
@if($category->children)
    @foreach($category->children as $cate)
        @include('layouts.admin.base-children-category',['category' => $cate,'model' => $model,'level' =>$level+1,'disable'=>$disable,'name'=>$name,'$is_single'=>$is_single])
    @endforeach
@endif
