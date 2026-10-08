<div class="layui-form-item">
    <label class="layui-form-label">{{ __('所属职称') }}：</label>
    <div class="layui-input-block">
        @foreach($roles as $key => $role)
        <input type="radio" name="role" value="{{ $role['id'] }}" title="{{ $role['name'] }}" @if($role['id'] === $roldId) checked @endif>
        @endforeach
    </div>
</div>
