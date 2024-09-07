@extends('layouts.app');

@section('content')


    <script type="text/javascript">
        {{--onchange function for Province dropdown--}}
        function getOrgUnit(org_unit_type_id) {
            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass org_unit_type_id as a parameter
            var url = "{{ route('Supervisor.getOrgUnit', ['org_unit_type_id' => ':org_unit_type_id']) }}"
                .replace(':org_unit_type_id', org_unit_type_id);

            ajaxObject.open("GET", url, true);

            ajaxObject.onreadystatechange = function () {
                if (ajaxObject.readyState === 4 && ajaxObject.status === 200) {
                    const data = JSON.parse(ajaxObject.responseText);

                    var unitNameDropdown = document.getElementById('org_unit_id');

                    // Clear existing options
                    unitNameDropdown.innerHTML = '';

                    // Iterate through the received data to populate the "District" dropdown
                    data.forEach(function (unitName) {
                        var option = document.createElement('option');
                        option.value = unitName.id; // Assuming each subCategory object has an 'id' property
                        option.text = unitName.name; // Assuming each subCategory object has a 'name' property
                        unitNameDropdown.appendChild(option);
                    });
                }
            };

            ajaxObject.send();
        }


    </script>



    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>

            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Registered User Assigned as Supervisor</h5>
                    <div class="card-body">
                        <form method="get" action="">
                            @csrf
                            <h6>(Stores Branch View)</h6>
                            <div class="input-field mt-1">
                                <label>Organization Unit Type :</label>
                                {{--load Office Type list--}}
                                <div class="col-md-12">
                                    <select name="org_unit_type_id" id="org_unit_type_id" class="form-control" onchange="getOrgUnit(this.value)">
                                        @foreach($orgUnitTypes as $orgUnitType)
                                            <option value="{{$orgUnitType->id}}">{{$orgUnitType->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="input-field mt-2">
                                <label>Unit Name :</label>
                                {{--load Unit Name list--}}
                                <div class="col-md-12">

                                    <select name="org_unit_id" id="org_unit_id" class="form-control">
                                        <option value="">Select a Unit Name</option>
                                    </select>

                                </div>
                            </div>

                            <div class="input-field mt-2">
                                <label>Registered User Name :</label>
                                <h6>(Assigned as Supervisor)</h6>
                                <div class="col-md-12">

                                    <select name="user_id" class="form-control">
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->full_name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="input-field mt-2">
                                <label>User Role :</label>
                                <div class="col-md-12">
                                    <select name="role_id" id="role_id" class="form-control" onchange='' required >
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary mb-2 mt-3" id="btnAdd" value="Assign">
                        </form>
                    </div>
                </div>

            </div>

            <div class="col-md-3"></div>
        </div>
    </div>


    @endsection