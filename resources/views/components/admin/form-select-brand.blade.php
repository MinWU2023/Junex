<select name="brand_id" @if(!is_null($verify)) lay-verify="{{ $verify }}" @endif>
    <option value="">{{ __('请选择') }}</option>
    @foreach($brands as $key => $brand)
        <option @if($brand['id'] === $brand_id) selected
                @endif value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
    @endforeach
</select>
