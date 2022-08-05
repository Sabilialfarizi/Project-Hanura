<div class="form-group">
    <label>Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ $role->key }}">
</div>
<div class="form-group">
    <label>Permissions</label>
    <select name="permission[]" id="permission" class="form-control select2" multiple>
        @if($rolePermissions != null)
        @foreach($rolePermissions as $roles)
        <option value="{{ $roles->permission_id }}" selected>{{ $roles->key }}</option>
        @endforeach
        @endif
        @foreach($permissions as $permission)
        <option value="{{ $permission->id }}">{{ $permission->key }}</option>
        @endforeach
    </select>

    @error('permission')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="m-t-20 text-center">
    <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
</div>