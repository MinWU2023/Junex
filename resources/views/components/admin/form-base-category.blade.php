<select name="{{ $name }}" @if(!is_null($verify)) lay-verify="{{ $verify }}" @endif>
    <option value="">{{ __('请选择') }}</option>
    @foreach($categories as $key => $category)
        @include('layouts.admin.base-children-category',['category' => $category,'model' => $model,'level' =>1,'disable'=>false,'name'=>$name,'is_single'=>$is_single])
    @endforeach
</select>
