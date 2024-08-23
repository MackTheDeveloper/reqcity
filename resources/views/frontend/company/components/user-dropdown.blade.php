@if(isset($companyUserList))
<div class="user-permission-section">
    <div class="selectuser-forpermision">
        <div class="input-groups">
            <span>Select User</span>
            <select name="user" id="user-list">
                <option>Select...</option>
                @foreach ($companyUserList as $user)
                <option value="{{ $user['id'] }}">
                    {{ $user['name']}}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="user-permisions-detailed">
        <!-- Permission Iteam -->
    </div>
</div>
@endif