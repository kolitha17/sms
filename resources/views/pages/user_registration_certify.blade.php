{{--this page add to layout   --}}
@extends('layouts.app')

{{--identify the content form the layout--}}
@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <header class="card-header">
                    <h4 class="card-title mt-2">Registered Users for Certifying</h4>
                </header>
                <article class="card-body">
                    {{-- <form> --}}
                        <div class="mt-2">
                            <label>Search : </label>

                        </div>

                        <table id="regUserTable" class="table table-striped" style="width:100%">
                            <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Emp No</th>
                                <th>Designation</th>
                                <th>Office/Branch</th>
                                <th>Status</th>
                                <th>Confirm Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($regUsers as $key => $regUser)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$regUser->full_name}}</td>
                                    <td>{{$regUser->emp_no}}</td>
                                    <td>{{$regUser->designation_id}}</td>
                                    <td>{{$regUser->orgUnit->name}}</td>
                                    <td id="status"><span class="badge @if($regUser->available_status == 'Awaiting') badge-awaiting bg-warning
                                                            @endif rounded-pill text-dark">
                                            {{$regUser->available_status}}</span></td>
                                    <td><a href="{{route('RegUserCertify.edit', $regUser->id)}}" id="btnRgUser" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalCertifyUserForm"><i class="fas fa-check" onclick="loadRoles()"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    {{-- </form> --}}

                </article>

            </div>
        </div>

    </div>

@endsection


@push('css')
    <!-- Add this to your HTML/Blade file -->
        <style>
            .badge-awaiting {
                /* Define styles for Awaiting status */
                background-color: #e4ff0e;
            }

        </style>
@endpush



<!-- Modal HTML Markup -->
<div id="ModalCertifyUserForm" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Registered User Details</h4>
            </div>
            <div class="modal-body">
                
                <form action="{{route('RegUserCertify.addRole')}}" method="post">
                @csrf
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="fName" name="fName" value="{{ $regUser->full_name }}" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Employee No</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="empNo" name="empNo" value="{{ $regUser->emp_no }}" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Designation</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="designation" name="designation" value="{{ $regUser->designation_id }}" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Mobile</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $regUser->mobile_no }}" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Organization Unit</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $regUser->orgUnit->name }}" readonly>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">User Role</label>
                    <div>
                        
                        <select id="role_id" name="role_id" class="form-control input-lg">
                        </select>
                        <input type="hidden" name="user_id" id="user_id" value="{{$regUser->id}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center ">
                        <button type="submit" class="btn btn-success">Accept</button>
                        <input type="button" value="Reject" class="btn btn-warning">
                    </div>
                </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Model Cancel -->
<!-- Modal HTML -->
<div id="CancelRequest" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title w-100">Are you sure?</h4>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // When Click Confirm Action Button and load Modal
    $(document).ready(function () {
        
        $('#btnRgUser').click(function() {

            //get ID from the clicked row
            var userId = $(this).closest('tr').data('user-id');
            console.log('User ID:', userId);
            $.get('/user_registration_certify/' + userId, function(data) {
                $('#ModalCertifyUserForm').modal('show');

            });
        });

$('#ModalCertifyUserForm').on('show.bs.modal', function (e) {
    loadRoles();
});
//certify user

$('#ModalCertifyUserForm').on('hidden.bs.modal', function (e) {
$('#role_id').empty();
$('#role_id').append('<option value="">Select an Item</option>');
});

});

function loadRoles(){

var $dropdown = $('#role_id');
$dropdown.html('<option>Loading...</option>');

$.ajax({
    url: '/roles',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        //console.log('AJAX request successful:', data);
        $dropdown.empty();
        $dropdown.append('<option value="">Select an Item</option>');
        $.each(data, function(index, item) {
            $dropdown.append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    },
    error: function(xhr, status, error) {
        $dropdown.html('<option>Error loading items</option>');
    }
});
}

    //JavaScript to update badge class

    // Replace this with your actual logic to get the status
    const status = $('status').val();

    // Get the badge element
    const badge = document.getElementsByClassName('badge');

    // Remove existing classes
    //badge.classList.remove('badge-awaiting', 'badge-active', 'badge-deactive');

    // Add the appropriate class based on the status
    if (status === 'Awaiting') {
        badge.classList.add('badge-awaiting');
    } else if (status === 'Active') {
        badge.classList.add('badge-active');
    } else if (status === 'Deactive') {
        badge.classList.add('badge-deactive');
    }

</script>
@endpush