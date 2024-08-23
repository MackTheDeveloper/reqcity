<input type="hidden" name="companyUserId" id="user_id" value="{{$userId}}">
@foreach($arrPermissions as $group => $permissionGroup)
<div class="userpermision-item">
    <div class="row">
        <div class="col-md-12 col-xl-6">
            <span>{{$group}}</span>
        </div>
        <div class="col-md-12 col-xl-6">
            <div class="user-permision-switches">
                @foreach($permissionGroup as $permission) 
                    <div class="custom-switch">
                        <input type="checkbox" class="custom-control-input permission" id="customSwitch{{$permission->id}}" data-permId="{{ $permission->id }}" {{ in_array($permission->id,$userPermissions ) ? ' checked' : '' }}>
                        <label class="custom-control-label" for="customSwitch{{$permission->id}}">{{ $permission->permission_title}}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endforeach