@extends('admin_layouts.app')

@section('content')

<div class="col-xl">
    <div class="card mb-4">

        <div class="card-header">
            
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: relative; pManageing-right: 2.5rem;">
                {{ session('success') }}
                <!-- Close button -->
                <button type="button" class=" btn-close" data-dismiss="alert" aria-label="Close">
                   
                </button>
                
            </div>
            @endif
            <div class="d-flex justify-content-between align-items-center position-relative ">
                <h5>1.Manage Designations <i class="fas fa-plus" title="click here to view table" onclick="toggleTable()"></i></h5>
                <!-- Button to trigger modal for creating a new designation -->
                <button class="btn btn-primary btn-sm waves-effect waves-light" style="text-transform:capitalize;" data-bs-toggle="modal" data-bs-target="#exLargeModal">
                    <i class="fas fa-plus"></i> Create Designation
                </button>
                
            </div>
        </div>
        <div class="card-body designationTable" style="display:none;">
           
            
            <div class="table-responsive col-md-8">
                
                <table id="designationTable" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">S.No</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Designation Name</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Shift</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Working Hours</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Total Work Hours/Day</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
    use Carbon\Carbon;
@endphp
                        @foreach($settings as $key=>$designation)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $designation->designation_name }}</td>
                            <td>{{ $designation->shift }}</td>
                            <td>{{ Carbon::parse($designation->working_from)->format('H:i') }} - {{ Carbon::parse($designation->working_to)->format('H:i') }}</td>

                            <td>{{ $designation->total_work_hours_per_day }}</td>
                            <td>
                                <button class="btn rounded-pill btn-outline-primary waves-effect editBtn" 
        data-id="{{ $designation->id }}" 
        data-name="{{ $designation->designation_name }}" 
        data-shift="{{ $designation->shift }}" 
        data-from="{{ date('H:i', strtotime($designation->working_from)) }}" 
        data-to="{{ date('H:i', strtotime($designation->working_to)) }}" 
        data-hours="{{ $designation->total_work_hours_per_day }}" 
        data-bs-toggle="modal" 
        data-bs-target="#editModal">
    <i class="mdi mdi-pencil-outline me-1"></i>
</button>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



<!------------ Manage type of vehicle TYPE ---------->

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center position-relative ">
                <h5>2.Manage Project Type   <i class="fas fa-plus" title="click here to view table" onclick="typeTable()"></i></h5>
                <!-- Button to trigger modal for creating a new designation -->
                <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#createvehicletype" style="text-transform:capitalize;" >
                    <i class="fas fa-plus"></i> Create Project Type
                </button>
                
            </div>
        </div>
        <div class="card-body typeTable" style="display:none;">
            <!-- Display success message if it exists -->
           
           <div class="table-responsive col-md-8">
             <table id="typeTable" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
    <thead class="bg-primary text-white">
        <tr>
            <th scope="col" style="color:white; font-size:small; text-align:center; text-transform:capitalize; width:5%;">S.No</th>
            <th scope="col" style="color:white; font-size:small; text-align:center; text-transform:capitalize; width:90%!important;">Project Type</th>
            <th scope="col" style="color:white; font-size:small; text-align:center; text-transform:capitalize; width:5%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($VehicleType as $key => $designation)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $designation->vehicle_type }}</td>
            <td>
                <button class="btn rounded-pill btn-outline-primary waves-effect editBtn" 
                        data-id="{{ $designation->id }}" 
                        data-name="{{ $designation->vehicle_type }}"
                        data-bs-toggle="modal"
                        data-bs-target="#editVehicleTypeModal">
                    <i class="mdi mdi-pencil-outline me-1"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

            </div>
        </div>



<!-- Modal for Create type of vehicle -->
<div class="modal fade" id="createvehicletype" tabindex="-1" aria-labelledby="exLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createvehicletypeLabel">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createvehicletypeForm" action="{{ route('settings.storevehicletype') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Form fields for creating/editing designation -->
                    <div class="col-md-6 mb-3">
                        <label for="designation_name" class="form-label">Project Type</label>
                        <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" required>

                    </div>
                   

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal fade" id="editVehicleTypeModal" tabindex="-1" aria-labelledby="editVehicleTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVehicleTypeModalLabel">Edit Project Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editVehicleTypeForm" action="{{ route('settings.updatevehicletype') }}" method="POST">
                @csrf
                @method('POST')
                <!-- Hidden input for storing the ID -->
                <input type="hidden" id="editVehicleTypeId" name="id">
                <div class="modal-body">
                    <!-- Form fields for editing vehicle type -->
                    <div class="col-md-6 mb-3">
                        <label  class="form-label">Project Type</label>
                        <input type="text" class="form-control" id="edit_vehicle_type" name="edit_vehicle_type" required>
                        <input type="hidden" name="edit_vehicle_type_id" id="edit_vehicle_type_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Create type of vehicle ends -->




<!------------ Manage type of vehicle TYPE ends---------->



<!------------ Manage type of vehicle TYPE ---------->

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center position-relative ">
                <h5>3.Manage Project Variant   <i class="fas fa-plus" title="click here to view table" onclick="typeTablevariant()"></i></h5>
                <!-- Button to trigger modal for creating a new designation -->
                <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#createtypeTablevariant" style="text-transform:capitalize;" >
                    <i class="fas fa-plus"></i> Create Project Variant
                </button>
                
            </div>
        </div>
        <div class="card-body typeTablevariant" style="display:none;">
            <!-- Display success message if it exists -->
           
           <div class="table-responsive col-md-8">
                
                <table id="typeTable" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">S.No</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Project Type</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Project Variant</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Actions</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach($VehicleVariants as $key=>$designation)

                       
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $designation->type->vehicle_type }}</td>
                            <td>{{ $designation->vehicle_variant }}</td>
                            <td>
    <button class="btn rounded-pill btn-outline-primary waves-effect editBtn" 
        data-id="{{ $designation->id }}" 
        data-vehicle-type="{{ $designation->type->id }}"
        data-vehicle-variant="{{ $designation->vehicle_variant }}"
        data-bs-toggle="modal"
        data-bs-target="#editVehicleVariantModal">
        <i class="mdi mdi-pencil-outline me-1"></i>
    </button>
</td>
                    
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



<!-- Modal for Create type of vehicle -->
<div class="modal fade" id="createtypeTablevariant" tabindex="-1" aria-labelledby="exLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createvehicletypeLabel">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createvehicletypeForm" action="{{ route('settings.storevehiclevariant') }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <!-- Form fields for creating/editing designation -->
                    <div class="col-md-6 mb-3">
                        <label for="designation_name" class="form-label">Project Type</label>
                        <select class="form-select" id="vehicle_type_id" name="vehicle_type_id" required>
                            <option value="">Select Project Type</option>
                            @foreach($VehicleType as $type)
                            <option value="{{$type->id}}">{{$type->vehicle_type}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                   <div class="col-md-6 mb-3">
                        <label for="designation_name" class="form-label">Project Variant</label>
                        <input type="text" class="form-control" id="vehicle_variant" name="vehicle_variant" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editVehicleVariantModal" tabindex="-1" aria-labelledby="editVehicleVariantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVehicleVariantModalLabel">Edit Project Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editVehicleVariantForm" action="{{ route('settings.updatevehiclevariant') }}" method="POST">
                @csrf
                @method('POST')
                <!-- Hidden input for storing the ID -->
                <input type="hidden" id="edit_vehicle_variant_id" name="edit_vehicle_variant_id" value="">
                <div class="modal-body row">
                    <!-- Form fields for editing vehicle variant -->
                    <div class="col-md-6 mb-3">
                        <label for="edit_vehicle_type_id" class="form-label">Project Type</label>
                        <select class="form-select" id="edit_vehicle_type_ids" name="vehicle_type_id" required>
                            <option value="">Select Project Type</option>
                            @foreach($VehicleType as $type)
                            <option value="{{$type->id}}">{{$type->vehicle_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_vehicle_variant" class="form-label">Project Variant</label>
                        <input type="text" class="form-control" id="edit_vehicle_variant" name="vehicle_variant" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Create type of vehicle ends -->




<!------------ Manage type of vehicle TYPE ends---------->

<!------------ Manage type of body ---------->

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center position-relative ">
                <h5>4.Manage Body Type  <i class="fas fa-plus" title="click here to view table" onclick="worktypeTable()"></i></h5>
                <!-- Button to trigger modal for creating a new designation -->
                <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#createbodytype" style="text-transform:capitalize;" >
                    <i class="fas fa-plus"></i> Create Body Type
                </button>
                
            </div>
        </div>
        <div class="card-body worktypeTable" style="display:none;">
            <!-- Display success message if it exists -->
           
           <div class="table-responsive col-md-8">
                
                <table id="typeTable" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">S.No</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Body Type</th>
                             <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Actions</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach($BodyType as $key=>$designation)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $designation->body_type }}</td>
                            <td>
    <button class="btn rounded-pill btn-outline-primary waves-effect editBtn" 
        data-id="{{ $designation->id }}" 
        data-name="{{ $designation->body_type }}"
        data-bs-toggle="modal"
        data-bs-target="#editBodyTypeModal">
        <i class="mdi mdi-pencil-outline me-1"></i>
    </button>
</td>
                    
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



<!-- Modal for Create type of vehicle -->
<div class="modal fade" id="createbodytype" tabindex="-1" aria-labelledby="exLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createvehicletypeLabel">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createbodytypeForm" action="{{ route('settings.storebodytype') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Form fields for creating/editing designation -->
                    <div class="col-md-6 mb-3">
                        <label for="designation_name" class="form-label">Body Type</label>
                        <input type="text" class="form-control" id="body_type" name="body_type" required>
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBodyTypeModal" tabindex="-1" aria-labelledby="editBodyTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBodyTypeModalLabel">Edit Body Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBodyTypeForm" action="{{ route('settings.updatebodytype') }}" method="POST">
                @csrf
                @method('POST')
                <!-- Hidden input for storing the ID -->
                <input type="hidden" id="edit_body_type_id" name="edit_body_type_id">
                <div class="modal-body">
                    <!-- Form fields for editing body type -->
                    <div class="col-md-6 mb-3">
                        <label for="edit_body_type" class="form-label">Body Type</label>
                        <input type="text" class="form-control" id="edit_body_type" name="edit_body_type" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Create type of body ends -->




<!------------ Manage type of body TYPE ends---------->


<!------------ Manage type of vehicle TYPE ---------->

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center position-relative ">
                <h5>5.Manage Body Variant   <i class="fas fa-plus" title="click here to view table" onclick="typeTablebodyvariant()"></i></h5>
                <!-- Button to trigger modal for creating a new designation -->
                <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#createtypeTablebodyvariant" style="text-transform:capitalize;" >
                    <i class="fas fa-plus"></i> Create Body Variant
                </button>
                
            </div>
        </div>
        <div class="card-body typeTablebodyvariant" style="display:none;">
            <!-- Display success message if it exists -->
           
           <div class="table-responsive col-md-8">
                
                <table id="typeTable" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">S.No</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Body Type</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Body Variant</th>
                           <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach($BodyVariants as $key=>$designation)

                       
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $designation->type->body_type }}</td>
                            <td>{{ $designation->body_variant }}</td>
                            <td>
    <button class="btn rounded-pill btn-outline-primary waves-effect editBtn" 
        data-id="{{ $designation->id }}" 
        data-body-type="{{ $designation->type->id }}"
        data-body-variant="{{ $designation->body_variant }}"
        data-bs-toggle="modal"
        data-bs-target="#editBodyVariantModal">
        <i class="mdi mdi-pencil-outline me-1"></i>
    </button>
</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



<!-- Modal for Create type of vehicle -->
<div class="modal fade" id="createtypeTablebodyvariant" tabindex="-1" aria-labelledby="exLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createvehicletypeLabel">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createvehicletypeForm" action="{{ route('settings.storevehiclebodyvariant') }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <!-- Form fields for creating/editing designation -->
                    <div class="col-md-6 mb-3">
                        <label for="designation_name" class="form-label">Body Type</label>
                        <select class="form-select" id="body_type_id" name="body_type_id" required>
                            <option value="">Select Body Type</option>
                            @foreach($BodyType as $type)
                            <option value="{{$type->id}}">{{$type->body_type}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                   <div class="col-md-6 mb-3">
                        <label for="designation_name" class="form-label">Body Variant</label>
                        <input type="text" class="form-control" id="body_variant" name="body_variant" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="editBodyVariantModal" tabindex="-1" aria-labelledby="editBodyVariantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBodyVariantModalLabel">Edit Body Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBodyVariantForm" action="{{ route('settings.updatebodyvariant') }}" method="POST">
                @csrf
                @method('POST')
                <!-- Hidden input for storing the ID -->
                <input type="hidden" id="edit_body_variant_ids" name="edit_body_variant_ids">
                <div class="modal-body row">
                    <!-- Form fields for editing body variant -->
                    <div class="mb-3 col-md-6">
                        <label for="edit_body_type_id" class="form-label">Body Type</label>
                        <select class="form-select" id="edit_body_type_idnew" name="edit_body_type_id" required>
                            <option value="">Select Body Type</option>
                            @foreach($BodyType as $type)
                            <option value="{{$type->id}}">{{$type->body_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="edit_body_variant" class="form-label">Body Variant</label>
                        <input type="text" class="form-control" id="edit_body_variant" name="body_variant" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Create type of vehicle ends -->




<!------------ Manage type of vehicle TYPE ends---------->




<!------------ Manage type of work---------->


        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center position-relative ">
                <h5>6.Manage Type Of Work  <i class="fas fa-plus" title="click here to view table" onclick="bodytypeTable()"></i></h5>
                <!-- Button to trigger modal for creating a new designation -->
                <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#createworktype" style="text-transform:capitalize;" >
                    <i class="fas fa-plus"></i> Create Type of Work
                </button>
                
            </div>
        </div>
        <div class="card-body bodytypeTable" style="display:none;">
            <!-- Display success message if it exists -->
           
           <div class="table-responsive col-md-8">
                
                <table id="typeTable" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">S.No</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Type of work</th>
                            <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize;">Actions</th>
                            
                          
                        </tr>
                    </thead>
                    <tbody>
                      
                        @foreach($workType as $key=>$designation)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $designation->work_type }}</td>
                            <td>
    <button class="btn rounded-pill btn-outline-primary waves-effect editBtn" 
        data-id="{{ $designation->id }}" 
        data-name="{{ $designation->work_type }}"
        data-bs-toggle="modal"
        data-bs-target="#editTypeOfWorkModal">
        <i class="mdi mdi-pencil-outline me-1"></i>
    </button>
</td>
               
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



<!-- Modal for Create type of work-->
<div class="modal fade" id="createworktype" tabindex="-1" aria-labelledby="exLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createvehicletypeLabel">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createbodytypeForm" action="{{ route('settings.storeworktype') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Form fields for creating/editing designation -->
                    <div class="mb-3 col-md-6">
                        <label for="designation_name" class="form-label">Type of Work</label>
                        <input type="text" class="form-control" id="work_type" name="work_type" required>
                    </div>
                   

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="editTypeOfWorkModal" tabindex="-1" aria-labelledby="editTypeOfWorkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTypeOfWorkModalLabel">Edit Type of Work</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTypeOfWorkForm" action="{{ route('settings.updatetypeofwork') }}" method="POST">
                @csrf
                @method('POST')
                <!-- Hidden input for storing the ID -->
                <input type="hidden" id="edit_work_type_id" name="edit_work_type_id" value="">

                <div class="modal-body">
                    <!-- Form fields for editing type of work -->
                    <div class="mb-3 col-md-6">
                        <label for="edit_work_type" class="form-label">Type of Work</label>
                        <input type="text" class="form-control" id="edit_work_type" name="edit_work_type" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Create type of body ends -->

<!-- Modal -->
<div class="modal fade" id="exLargeModalss" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Create Unit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form fields for editing -->
       <form id="addForm" class="row">
  <div class="col-md-6">
    <label for="unitName" class="form-label">Unit Name</label>
    <input type="text" class="form-control" id="unitNames">
  </div>
  <div class="col-md-6">
    <label for="unitAbbreviation" class="form-label">Unit Abbreviation</label>
    <input type="text" class="form-control" id="unitAbbreviations">
  </div>
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary pt-1 mt-1 btn-sm">Save</button>
  </div>
</form>

      </div>
    </div>
  </div>
</div>






<!-- Modal -->
<div class="modal fade" id="editModalss" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Unit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Form fields for editing -->
        <form id="editForm" class="row">
          <div class="col-md-6">
            <label for="unitName" class="form-label">Unit Name</label>
            <input type="text" class="form-control" id="unitName">
          </div>
          <div class="col-md-6">
            <label for="unitAbbreviation" class="form-label">Unit Abbreviation</label>
            <input type="text" class="form-control" id="unitAbbreviation">
          </div>
          <input type="hidden" id="unitId">
          <div class="col-12">
          <button type="submit" class="btn btn-primary pt-1 mt-1 btn-sm">Update</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center position-relative ">
                <h5>7.Manage UOM  <i class="fas fa-plus" title="click here to view table" onclick="unit()"></i></h5>
                <!-- Button to trigger modal for creating a new designation -->
                <button class="btn btn-primary waves-effect waves-light btn-sm" data-bs-toggle="modal" data-bs-target="#exLargeModalss">
                    <i class="fas fa-plus"></i> Create Unit
                </button>
                
            </div>
        </div>
        <div class="card-body unit" style="display:none;">
            <!-- Display success message if it exists -->
           
           <div class="table-responsive col-md-8">
                
                <table id="unit" style="width:100%" class="table table-striped table-bordered mt-4 pt-4">
                        <thead class="bg-primary">
                            <tr>
                                <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize">S.No</th>
                                <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize">Unit Name</th>
                                <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize">Unit abbreviation</th>
                                <th scope="col" style="color:white;font-size:small;text-align:center;text-transform:capitalize">Actions</th>
                            </tr>
                        </thead>

                          <tbody>
                            @foreach($units as $key => $unit)
                            <tr>
                              <td style="color:black">{{ $key + 1 }}</td>
                              <td style="color:black">{{ $unit->unit }}</td>
                              <td style="color:black">{{ $unit->abbreviation }}</td>
                             
                              <td style="color:black">
                                
                                    
                                        
                                        <button class="btn rounded-pill btn-outline-primary waves-effect editBtnsss" data-id="{{ $unit->id }}" data-unit="{{ $unit->unit }}" data-abbreviation="{{ $unit->abbreviation }}">
                                          <i class="mdi mdi-pencil-outline me-1"></i> Edit
                                        </button>
                                    
                              
                            </td>
                            </tr>
                            @endforeach
                          </tbody>
                </table>
            </div>
        </div>



<!------------ Manage  type of work ends---------->
    </div>
</div>

<!-- Modal for creating/editing designations -->
<div class="modal fade" id="exLargeModal" tabindex="-1" aria-labelledby="exLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exLargeModalLabel">Create Designation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="designationForm" action="{{ route('settings.store') }}" method="POST">
                @csrf
                <div class="modal-body">
    <!-- Form fields for creating/editing designation -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6 mb-3">
            <label for="designation_name" class="form-label">Designation Name</label>
            <input type="text" class="form-control" id="designation_name" name="designation_name" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="shift" class="form-label">Shift</label>
            <select class="form-select" id="shift" name="shift" required>
                <option value="general">General</option>
                <option value="morning">Morning</option>
                <option value="night">Night</option>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Right Column -->
        <div class="col-md-6 mb-3">
            <label for="working_from" class="form-label">Working From</label>
            <input type="time" class="form-control" id="working_from" name="working_from" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="working_to" class="form-label">Working To</label>
            <input type="time" class="form-control" id="working_to" name="working_to" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="total_work_hours_per_day" class="form-label">Total Work Hours/Day</label>
            <input type="number" class="form-control" id="total_work_hours_per_day" name="total_work_hours_per_day" min="1" required>
        </div>
        <!-- You can add another input here if needed -->
        <div class="col-md-6 mb-3">
            <!-- Placeholder for additional field or empty space -->
        </div>
    </div>
</div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for editing designations -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Designation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
<form id="editForm" method="POST" action="{{ route('settings.update') }}">
    @csrf
    <!-- Hidden input for storing the ID -->
    <input type="hidden" id="edit_designation_id" name="editId" value="">

    <div class="modal-body row">
        <!-- Form fields for editing designation -->
        <div class="col-md-6 mb-3">
            <label for="edit_designation_name" class="form-label">Designation Name</label>
            <input type="text" class="form-control" id="edit_designation_name" name="designation_name" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="edit_shift" class="form-label">Shift</label>
            <select class="form-select" id="edit_shift" name="shift" required>
                <option value="general">General</option>
                <option value="morning">Morning</option>
                <option value="night">Night</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="edit_working_from" class="form-label">Working From</label>
            <input type="time" class="form-control" id="edit_working_from" name="working_from" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="edit_working_to" class="form-label">Working To</label>
            <input type="time" class="form-control" id="edit_working_to" name="working_to" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="edit_total_work_hours_per_day" class="form-label">Total Work Hours/Day</label>
            <input type="number" class="form-control" id="edit_total_work_hours_per_day" name="total_work_hours_per_day" required min="1">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>


        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    // Edit button click handling
    $(document).on('click', '.editBtn', function () {
        // Populate modal fields with data from the button's data attributes
        var id = $(this).data('id');
        var name = $(this).data('name');
        // Populate the modal for each type of table
        $('#editModal').find('#edit_designation_id').val(id);
        $('#editModal').find('#edit_designation_name').val(name);

        var shift = $(this).data('shift');
        $('#editModal').find('#edit_shift').val(shift);

        var from = $(this).data('from');
        $('#editModal').find('#edit_working_from').val(from);

        var to = $(this).data('to');
        $('#editModal').find('#edit_working_to').val(to);

        var hours = $(this).data('hours');
        $('#editModal').find('#edit_total_work_hours_per_day').val(hours);

        // Vehicle Type
        var vehicleTypeId = $(this).data('id');
        var vehicleType = $(this).data('name');
        $('#editVehicleTypeModal').find('#edit_vehicle_type_id').val(vehicleTypeId);
        $('#editVehicleTypeModal').find('#edit_vehicle_type').val(vehicleType);

        // Vehicle Variant
        var vehicleVariantId = $(this).data('id');
        var vehicleType = $(this).data('vehicle-type');
        var vehicleVariant = $(this).data('vehicle-variant');
        $('#editVehicleVariantModal').find('#edit_vehicle_variant_id').val(vehicleVariantId);
      $('#editVehicleVariantModal').find('#edit_vehicle_type_ids').val(vehicleType);

        $('#editVehicleVariantModal').find('#edit_vehicle_variant').val(vehicleVariant);

        // Body Type
        var bodyTypeId = $(this).data('id');
        var bodyType = $(this).data('name');
        $('#editBodyTypeModal').find('#edit_body_type_id').val(bodyTypeId);
        $('#editBodyTypeModal').find('#edit_body_type').val(bodyType);

        // Body Variant
        var bodyVariantId = $(this).data('id');
        var bodyTypeId = $(this).data('body-type');
        var bodyVariant = $(this).data('body-variant');
        $('#editBodyVariantModal').find('#edit_body_variant_ids').val(bodyVariantId);
        $('#editBodyVariantModal').find('#edit_body_type_idnew').val(bodyTypeId);
        $('#editBodyVariantModal').find('#edit_body_variant').val(bodyVariant);

        // Type of Work
        var workTypeId = $(this).data('id');
        var workType = $(this).data('name');
    
        $('#editTypeOfWorkModal').find('#edit_work_type_id').val(workTypeId);
        $('#editTypeOfWorkModal').find('#edit_work_type').val(workType);
    });




</script>

<script>
       $(document).ready(function() {
            $('#designationTable,#typeTable,#unit').DataTable({
                 paging: true, // Enable pagination
                ordering: false,
                pageLength: 2
            });

        });
    </script>
    <script>
        function toggleTable() {
            var tables = document.getElementsByClassName('designationTable');
            for (var i = 0; i < tables.length; i++) {
                var table = tables[i];
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                } else {
                    table.style.display = 'none';
                }
            }
        }
        function typeTable() {
            var tables = document.getElementsByClassName('typeTable');
            for (var i = 0; i < tables.length; i++) {
                var table = tables[i];
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                } else {
                    table.style.display = 'none';
                }
            }
        }
        function bodytypeTable() {
            var tables = document.getElementsByClassName('bodytypeTable');
            for (var i = 0; i < tables.length; i++) {
                var table = tables[i];
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                } else {
                    table.style.display = 'none';
                }
            }
        }
        function unit() {
            var tables = document.getElementsByClassName('unit');
            for (var i = 0; i < tables.length; i++) {
                var table = tables[i];
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                } else {
                    table.style.display = 'none';
                }
            }
        }
        function worktypeTable() {
            var tables = document.getElementsByClassName('worktypeTable');
            for (var i = 0; i < tables.length; i++) {
                var table = tables[i];
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                } else {
                    table.style.display = 'none';
                }
            }
        }
        function typeTablevariant() {
            var tables = document.getElementsByClassName('typeTablevariant');
            for (var i = 0; i < tables.length; i++) {
                var table = tables[i];
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                } else {
                    table.style.display = 'none';
                }
            }
        }
        function typeTablebodyvariant() {
            var tables = document.getElementsByClassName('typeTablebodyvariant');
            for (var i = 0; i < tables.length; i++) {
                var table = tables[i];
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                } else {
                    table.style.display = 'none';
                }
            }
        }
    </script>


  <script>
$(document).ready(function() {
        $('.delete-vehicle').click(function() {
            var vehicleId = $(this).data('id');
            if (confirm('Are you sure you want to delete this unit?')) {
                $.ajax({
                    url: '/delete-unit/' + vehicleId,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
swal({
    title: "Success!",
    text: response.message,
    icon: "success",
    button: "Close",
}).then(() => {
    location.reload();
});

                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
  // JavaScript to handle edit button click
  
    $('.editBtnsss').on('click', function() {
      // Get data attributes
      var id = $(this).data('id');
      var unit = $(this).data('unit');
      var abbreviation = $(this).data('abbreviation');
      
      // Set modal fields with data
      $('#unitId').val(id);
      $('#unitName').val(unit);
      $('#unitAbbreviation').val(abbreviation);
      
      // Show modal
      $('#editModalss').modal('show');
    });

</script>
  <script>
  $(document).ready(function() {
    $('#editForm').submit(function(event) {
      // Prevent default form submission
      event.preventDefault();
      
      // Get form data
      var id = $('#unitId').val();
      var unit = $('#unitName').val();
      var abbreviation = $('#unitAbbreviation').val();
      
      // Ajax call to update unit
      $.ajax({
        url: '/units/' + id,
        type: 'POST', // Change method to POST
        data: {
          unit: unit,
          abbreviation: abbreviation,
          _token: '{{ csrf_token() }}', // Ensure to include CSRF token
          _method: 'POST' // Include _method as POST
        },
        success: function(response) {
          // Handle success response
          $('#editModalss').modal('hide');
          swal({
    title: "Success!",
    text: response.message,
    icon: "success",
    button: "Close",
}).then(() => {
    location.reload();
});

        },
        error: function(xhr) {
          // Handle error response
          alert('Error: ' + xhr.responseText); // You can customize error handling
        }
      });
    });
  });
</script> 



  <script>
  $(document).ready(function() {
    $('#addForm').submit(function(event) {
      // Prevent default form submission
      event.preventDefault();
      
 
      var unit = $('#unitNames').val();
      var abbreviation = $('#unitAbbreviations').val();
      
      // Ajax call to update unit
      $.ajax({
        url: '/units_add',
        type: 'POST', // Change method to POST
        data: {
          unit: unit,
          abbreviation: abbreviation,
          _token: '{{ csrf_token() }}', // Ensure to include CSRF token
          _method: 'POST' // Include _method as POST
        },
        success: function(response) {
          // Handle success response
           
          $('#exLargeModalss').modal('hide');
swal({
    title: "Success!",
    text: response.message,
    icon: "success",
    button: "Close",
}).then(() => {
    location.reload();
});
        },
        error: function(xhr) {
          // Handle error response
          alert('Error: ' + xhr.responseText); // You can customize error handling
        }
      });
    });
  });
</script> 

@endsection
