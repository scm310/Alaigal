@extends('admin_layouts.app')

@section('content')

<div class="col-xl">
    <div class="card mb-4">


        <div class="card-header">

<div class="d-flex justify-content-between align-items-center position-relative ">
    <h5>Create Permissions</h5>
</div>
<div class="table-responsive">
    <form method="POST" action="/permissions/assign">
        @csrf
        <div class="mb-3 col-md-4">
            <label for="role" class="form-label">{{ __('Select Role') }}</label>
            <select name="role" id="role" class="form-select" required>
                <option value="" disabled selected>{{ __('Select Role') }}</option>
                @foreach ($roles as $roleId => $roleName)
                    <option value="{{ $roleId }}">{{ $roleName }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
    <table class="table table-striped table-bordered mt-2 pt-2 dataTable no-footer">
        <thead class="bg-primary">
            <tr>
                <th scope="col" style="color: white; text-align: center; text-transform: capitalize; font-size: 11px;">{{ __('Permission Name') }}</th>
                <th scope="col" style="color: white; text-align: center; text-transform: capitalize; font-size: 11px;">{{ __('Assign') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr class="font-style">
                    <td>{{ $permission->name }}</td>
                    <td class="text-center">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="custom-control-input" id="permission{{ $permission->id }}">
                            <label class="custom-control-label" for="permission{{ $permission->id }}"></label>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="text-end">
                    <input type="submit" value="{{ __('Save Permissions') }}" class="btn" style="background-color: #9055fd; color: white;">
                </td>
            </tr>
        </tbody>
    </table>
</div>

    </form>
</div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');

    roleSelect.addEventListener('change', function() {
        const roleId = this.value;

        if (roleId) {
            fetch(`/permissions/role/${roleId}`)
                .then(response => response.json())
                .then(permissions => {
                    // Deselect all checkboxes
                    document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
                        checkbox.checked = false;
                    });

                    // Select the checkboxes for the permissions of the selected role
                    permissions.forEach(permission => {
                        const checkbox = document.getElementById(`permission${permission.id}`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                })
                .catch(error => console.error('Error fetching permissions:', error));
        }
    });
});
</script>
@endsection