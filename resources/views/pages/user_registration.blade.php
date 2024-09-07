@extends('layouts/registration')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6 mt-3">
            <div class="card">
                <header class="card-header">
                    <h4 class="card-title mt-2">Registration</h4>
                </header>
                <article class="card-body">
                    <form action="{{route('UserReg.store')}}" method="post">
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if (Session::has('fail'))
                            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3" >
                                    <label for="emp_no" class="form-label">Employee No</label>
                                    <input type="number" class="form-control" id="emp_no" name="emp_no" placeholder="Enter your Employee No ex: 9483" required>
                                    <small class="form-text text-danger"><b>@error('emp_no'){{ $message }}@enderror</b></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" class="form-control" id="designation_id" name="designation_id" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email_address" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email_address" name="email_address">
                                    <small class="form-text text-danger"><b>@error('email_address'){{ $message }}@enderror</b></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mobile_no" class="form-label">Mobile Number</label>
                                    <input type="number" class="form-control" id="mobile_no" name="mobile_no" readonly>
                                    <small class="form-text text-danger"><b>@error('mobile_no'){{ $message }}@enderror</b></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="office_type" class="form-label">Office Type</label>
                                    <select name="office_type" id="office_type" class="form-control" onchange="getOfficeName(this.value)" required>
                                        @foreach($orgUnitTypes as $orgUnitType)
                                            <option value="{{$orgUnitType->id}}">{{$orgUnitType->type}}</option>
                                        @endforeach
                                    </select>
                                    <small  class="form-text text-danger"><b>@error('office_type'){{ $message }}@enderror</b></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="org_unit_id" class="form-label">Office Name</label>
                                    <select id="org_unit_id" name="org_unit_id" class="form-control" required>
                                        
                                    </select>
                                    <small class="form-text text-danger"><b>@error('office_name'){{ $message }}@enderror</b></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="user_name" class="form-label">User Name</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" value="{{ old('user_name') }}" required>
                                    <small class="form-text text-danger"><b>@error('user_name'){{ $message }}@enderror</b></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <small class="form-text text-danger"><b>@error('password'){{ $message }}@enderror</b></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label"> Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    <small class="form-text text-danger"><b>@error('password_confirmation'){{ $message }}@enderror</b></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">Register Now</button>
                            </div>
                        </div>
                    </form>

                    <p class="small fw-bold mt-2 pt-1 mb-0" align="center">Back to <a href="/" class="link-success"> Login </a></p>

                </article>
            </div>
        </div>

    </div>

</div>
@push('scripts')
<script>
    //load Employee data when type Employee No
    $(document).ready(function () {
        $("#emp_no").on("blur", function () {
            var empno = $(this).val();
            $.ajax({
                //get API url from proxy file in public folder
                url: 'proxy.php?empno='+empno,
                type: 'GET',
                dataType: 'json',
                success: function (response) {

                    if(response.success == true) {
                        console.log(response.employee.empno);

                        $('#full_name').val(response.employee.name + ' ' + response.employee.initial);
                        $('#designation_id').val(response.employee.designation);
                        $('#email_address').val(response.employee.emailid);
                        $('#mobile_no').val(response.employee.mobile);

                    }else{
                        $('#full_name').val("not valid user");
                        $('#designation_id').val("not valid user");
                        $('#email_address').val("not valid user");
                        $('#mobile_no').val("not valid user");

                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });


    // onchange function for Office Name dropdown
    function getOfficeName(office_type) {
        var ajaxObject = new XMLHttpRequest();

        // Generate the URL using Laravel's route() GET function and pass category_id as a parameter
        var url = "{{ route('UserReg.getOfficeName', ['office_type' => ':office_type']) }}"
            .replace(':office_type', office_type);

        ajaxObject.open("GET", url, true);

        ajaxObject.onreadystatechange = function () {
            if (ajaxObject.readyState === 4 && ajaxObject.status === 200) {
                const data = JSON.parse(ajaxObject.responseText);

                var officeNameDropdown = document.getElementById('org_unit_id');

                // Clear existing options
                officeNameDropdown.innerHTML = '';

                // Iterate through the received data to populate the "District" dropdown
                data.forEach(function (officeName) {
                    var option = document.createElement('option');
                    option.value = officeName.id; // Assuming each subCategory object has an 'id' property
                    option.text = officeName.name; // Assuming each subCategory object has a 'name' property
                    officeNameDropdown.appendChild(option);
                });
            }
        };

        ajaxObject.send();
    }
</script>
@endpush
@endsection


