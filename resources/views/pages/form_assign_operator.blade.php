{{--this page add to layout   --}}
@extends('layouts.app')

{{--identify the content form the layout--}}
@section('content')

<script>
    {{--Load Purchase User Role into the Modal hidden field--}}
    var sourceTextField = document.getElementById("selectedRole");
    var destinationTextField = document.getElementById("role_id");
    var copyButton = document.getElementById("btnRgUser");
    function copyText() {
        console.log(sourceTextField);
        destinationTextField.value = sourceTextField.value;
        console.log(destinationTextField.value);
    }
    copyButton.addEventListener("click", copyText);
</script>


<body>
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <header class="card-header">
                    <h4 class="card-title mt-2">Registered Users Assigned as Operator</h4>
                </header>
                <article class="card-body">
                    <form>
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
                                <th>User Role</th>
                                <th>Confirm Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($operators as $key => $regUser)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$regUser->full_name}}</td>
                                <td>{{$regUser->emp_no}}</td>
                                <td>{{$regUser->designation_id}}</td>
                                <td>{{$regUser->orgUnit->name}}</td>
                                <td>
                                    <select>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}"  id="selectedRole">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><a href="{{route('RegUserCertify.edit', $regUser->id)}}" id="btnRgUser" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalCertifyUserForm"><i class="bi bi-pencil-square"></i></a></td>
                            </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </form>

                </article>

            </div>
        </div>

    </div>

    @endsection

    <!-- Modal HTML Markup -->
    <div id="ModalCertifyUserForm" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registered User Details</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('RegUserCertify.addRole', $regUser->id)}}" method="post">

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
                                        <input type="text" class="form-control" id="org_unit" name="org_unit" value="{{ $regUser->orgUnit->name }}" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">User Role</label>
                            <div>
                                <input type="text" class="form-control" id="role_id" name="role_id" readonly>
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