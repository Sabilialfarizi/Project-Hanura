<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user ? $user->name : '' }}">

            @error('name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user ? $user->email : '' }}">

            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone_number">No Telp.</label>
            <input type="number" name="phone_number" id="phone_number" class="form-control" value="{{ $user ? $user->phone_number : '' }}">

            @error('phone_number')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role[]" id="role" class="form-control select2" multiple="multiple">
                @foreach($user->roles as $rol)
                <option selected value="{{ $rol->id }}">{{ $rol->key }}</option>
                @endforeach
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->key }}</option>
                @endforeach
            </select>

            @error('role')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="cabang">Cabang</label>
            <select name="cabang_id" id="cabang" class="form-control">
                <option disabled selected>-- Select Cabang --</option>
                @foreach($warehouses as $warehouse)
                <option {{ $user->cabang_id == $warehouse->id ? 'selected' : '' }} value="{{ $warehouse->id }}">{{ $warehouse->nama }}</option>
                @endforeach
            </select>

            @error('cabang_id')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea name="address" id="address" rows="3" class="form-control">{{ $user->address }}</textarea>

            @error('address')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Image Profile</label><br>
            <input type="file" name="image" id="image">
        </div>
    </div>
</div>

<div class="m-t-20 text-center">
    <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save"></i> Save</button>
</div>