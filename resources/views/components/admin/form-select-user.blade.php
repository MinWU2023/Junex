<select name="user_id" @if(!is_null($verify)) lay-verify="{{ $verify }}" @endif>
    <option value="">{{ __('请选择') }}</option>
    @foreach($users as $key => $user)
        <option @if($user['id'] === $user_id) selected
                @endif value="{{ $user['id'] }}">{{ $user['name'] }}</option>
    @endforeach
</select>
