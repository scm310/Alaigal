@extends('admin_layouts.app')

@section('content')

<div class="col-xl">
    <div class="card mb-4">


        <div class="card-header">
 
        <div class="d-flex justify-content-between align-items-center position-relative mb-4">
            <h5>Manage Permissions</h5>
            <a href="/permissions" class="btn btn-primary" style="text-transform: capitalize;font-size: small;">
                <i class="ti-plus"></i> Set Permissions
            </a>
        </div>
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Role') }}</th>
                        <th scope="col">{{ __('Assigned Permissions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->role }}</td>
                            <td>
                                <ul>
                                    @foreach ($role->permissions as $permission)
                                        <li>{{ $permission->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection