@extends('layouts.app')

@section('content')

	<script type="text/javascript">
		{{--onchange function for Province dropdown--}}
        function getProvince(province_id) {
            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass category_id as a parameter
            var url = "{{ route('OrgUnit.getProvince', ['province_id' => ':province_id']) }}"
				.replace(':province_id', province_id);

            ajaxObject.open("GET", url, true);

            ajaxObject.onreadystatechange = function () {
                if (ajaxObject.readyState === 4 && ajaxObject.status === 200) {
                    const data = JSON.parse(ajaxObject.responseText);

                    var districtsDropdown = document.getElementById('district_id');

                    // Clear existing options
                    districtsDropdown.innerHTML = '';

                    // Iterate through the received data to populate the "District" dropdown
                    data.forEach(function (district) {
                        var option = document.createElement('option');
                        option.value = district.id; // Assuming each subCategory object has an 'id' property
                        option.text = district.name; // Assuming each subCategory object has a 'name' property
                        districtsDropdown.appendChild(option);
                    });
                }
            };

            ajaxObject.send();
        }



        // open modal for edit
        $(document).ready(function() {
            $('.editOrgUnit').click(function(event) {
                event.preventDefault();
                var unitId = $(this).data('id');

                // AJAX call to fetch category details
                $.ajax({
                    url: '/org_unit/' + unitId + '/edit',
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var json_return = $.parseJSON(response);
                        // Populate modal fields with the fetched data
                        console.log(json_return);
                        $('#ModalUpdateOrgUnit_type').val(json_return.org_unit_type_id);
                        $('#ModalUpdateOrgUnit_province').val(json_return.province_id);
                        $('#ModalUpdateOrgUnit_district').val(json_return.district_id);
                        $('#ModalUpdateOrgUnit_SupUnit').val(json_return.parent_id);
                        $('#ModalUpdateOrgUnit_unitName').val(json_return.name);
                        $('#orgUnit_id').val(json_return.id);
                        $('#ModalUpdateOrgUnit').modal('show');
                    },

                });
            });


            // modal for update function
            $('#OrgUnitUpdateForm').submit(function(event) {
                event.preventDefault();
                var fd = new FormData (this);

                $('#btnUpdate').text('Updating...');

                // AJAX call to fetch category details
                $.ajax({
                    url: '{{route('OrgUnit.update')}}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        // var json_return = $.parseJSON(response);

                        console.log(response);
                        if (response.status==200) {
                            Swal.fire({
                                title:  'Updated!',
                                text: 'Organization Unit Updated Successfully!',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // reload Page
                                    location.reload(true);
                                }
                            });
                        }
                        // Populate modal fields with the fetched data

                        $('#btnUpdate').text('Update Organization Unit');
                        $('#OrgUnitUpdateForm')[0].reset();
                        $('#ModalUpdateOrgUnit').modal('hide');
                    },

                });
            });

        });


	</script>


	<div class="container">
		<div class="row">

			<div class="col-md-5">
				<div class="card">
					<header class="card-header">
						<h4 class="card-title mt-2">Organization units</h4>
					</header>
					<article class="card-body">
						<form method="post" action="{{route('OrgUnit.store')}}">
							@csrf
							<div class="form-row">
								<div class="col form-group">
									<label>Organization Unit Type</label>
									<select name="org_unit_type_id" class="form-control">
										@foreach($orgUnitTypes as $orgUnitType)
											<option value="{{$orgUnitType->id}}">{{$orgUnitType->type}}</option>
										@endforeach
									</select>
								</div>
							</div>

							{{--province--}}
							<div class="form-row">
								<div class="col form-group">
									<label>Province</label>
									<select name="province_id" class="form-control" id="province_id" onchange="getProvince(this.value)">
										@foreach( $provinces as $province )
											<option value="{{$province->id}}">{{$province->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							{{--district--}}
							<div class="form-row">
								<div class="col form-group">
									<label>District</label>
									<select name="district_id" class="form-control" id="district_id">
										<option value="">Select a District</option>
									</select>
								</div>
							</div>

							<div class="form-row">
								<div class="col form-group">
									<label>Supervisor Unit</label>
									<select name="parent_id" class="form-control">
										@foreach($orgUnits as $orgUnit)
											<option value="{{$orgUnit->id}}">{{$orgUnit->name}}</option>
										@endforeach
									</select>
								</div>
							</div>


							<div class="form-group">
								<label>Unit Name</label>
								<input type="text" name="name" class="form-control" placeholder="">

							</div>
							<!-- form-row end.// -->
							<div class="form-group">
								<label>Remarks</label>
								<input name="remarks" type="text" class="form-control" placeholder="">

							</div>

							<div class="form-group">
								<input type="submit" class="btn btn-primary mb-2 btn-block" id="btnAdd" value="ADD">
							</div>
						</form>
					</article>
				</div>
			</div>



			{{--Org Units details views--}}
			<div class="col md-7">
				<table class="table table-striped">
					<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Unit Type</th>
						<th scope="col">Unit Name</th>
						<th scope="col">Remarks</th>
						<th scope="col">Action</th>
					</tr>
					</thead>
					<tbody>
					@foreach($orgUnits as $key => $orgUnit)
						<tr>
							<td>{{++$key}}</td>
							<td>{{$orgUnit->orgUnitType->type}}</td>
							<td>{{$orgUnit->name}}</td>
							<td>{{$orgUnit->remarks}}</td>
							<td>
								<a href="#" data-toggle="modal" class="editOrgUnit" data-id="{{$orgUnit->id}}"><i style="color: green" class="bi bi-pencil-square"></i></a> |
								<a href="" data-toggle="modal" data-target="#CancelRequest"><i style="color: red" class="bi bi-trash3-fill"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection




<!-- Modal HTML Markup -->
<div id="ModalUpdateOrgUnit" class="modal fade">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Organization Unit Details Update</h3>
			</div>
			<div class="modal-body">
				<form action="#" method="post" id="OrgUnitUpdateForm">
					@csrf
					<div class="card mb-6">
						<div class="card-body">
							<div class="row">
								<input type="hidden" name="orgUnit_id" id="orgUnit_id">
								<div class="col-sm-4">
									<p class="mb-0">Organization Unit Type</p>
								</div>
								<div class="col-sm-8">
									<select name="unitType" id="ModalUpdateOrgUnit_type" class="form-control">
										@foreach($orgUnitTypes as $orgUnitType)
											<option value="{{ $orgUnitType->id }}" {{ $orgUnitType->id == $orgUnitType->org_unit_type_id ? 'selected' : '' }}>
												{{ $orgUnitType->type }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-4">
									<p class="mb-0">Province</p>
								</div>
								<div class="col-sm-8">
									<select name="province" id="ModalUpdateOrgUnit_province" class="form-control">
										@foreach($provinces as $province)
											<option value="{{ $province->id }}" {{ $province->id == $orgUnit->province_id ? 'selected' : '' }}>
												{{ $province->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-4">
									<p class="mb-0">District</p>
								</div>
								<div class="col-sm-8">
									<select name="district" id="ModalUpdateOrgUnit_district" class="form-control">
										@foreach($districts as $district)
											<option value="{{ $district->id }}" {{ $district->id == $orgUnit->district_id ? 'selected' : '' }}>
												{{ $district->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-4">
									<p class="mb-0">Supervisor Unit</p>
								</div>
								<div class="col-sm-8">
									<select name="supervisorUnit" id="ModalUpdateOrgUnit_SupUnit" class="form-control">
										@foreach($orgUnits as $orgUnit)
											<option value="{{$orgUnit->id}}"{{$orgUnit->id == $orgUnit->parent_id ? 'selected' : ''}}>
												{{$orgUnit->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-4">
									<p class="mb-0">Unit Name</p>
								</div>
								<div class="col-sm-8">
									<input type="text" name="unitName" id="ModalUpdateOrgUnit_unitName" value="{{$orgUnit->name}}" class="form-control col-sm-9">
								</div>
							</div>

						</div>
					</div>

					<div class="form-group">
						<div class="text-center ">
							<button type="submit" id="btnUpdate" class="btn btn-success btn-block">
								Update
							</button>
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

