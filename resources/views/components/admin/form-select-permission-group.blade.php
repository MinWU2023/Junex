<label class="layui-form-label">{{ __('所属权限组') }}</label>
<div class="layui-input-block">
<select name="pg_id">
    @foreach($permissionGroups as $key => $permissionGroup)
        <option @if($permissionGroup['id'] === $permissionGroupId) selected
                @endif value="{{ $permissionGroup['id'] }}">{{ $permissionGroup['name'] }}</option>
    @endforeach
</select>
</div>
