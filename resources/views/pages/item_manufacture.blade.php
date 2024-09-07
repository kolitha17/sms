{{--this page add to layout   --}}
@extends('layouts.app')

{{--identity the content form the layout--}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>

            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header">Add Item Manufacture Details</h5>

                    @if(session('status'))
                        <div class="alert alert-success">{{session('status')}}</div>
                        @endif
                    <div class="card-body">

                        <form action="{{ route('Manufacture.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="manuf_id" id="manuf_id">
                            <div class="input-field p-3">
                                <label for="name">Name :</label>
                                <div class="col p-2">
                                    <input type="text" class="form-control" placeholder="Manufacture Name" name="name">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="address">Address :</label>
                                <div class="col p-2">
                                    <input type="text" class="form-control" placeholder="Manufacture Address" name="address">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="email">Email :</label>
                                <div class="col p-2">
                                    <input type="email" class="form-control" placeholder="Email" name="email">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="contact_no">Contact Number :</label>
                                <div class="col p-2">
                                    <input type="tel" class="form-control" placeholder="Contact Number" name="contact_no" maxlength="10">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary mb-2" id="btnAdd" value="ADD">
                            {{--<a href="/save_manufacture" class="btn btn-primary mb-2" id="btnAdd">ADD</a>--}}
                        </form>
                    </div>
                </div>

            </div>

            <div class="col-md-2"></div>
        </div>

        {{--Manufacture details views--}}

        <div class="row p-5">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Manufacture Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact Number</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($manufactures as $key=> $manufacture)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$manufacture->name}}</td>
                        <td>{{$manufacture->address}}</td>
                        <td>{{$manufacture->email}}</td>
                        <td>{{$manufacture->contact_no}}</td>
                        <td>{{$manufacture->status}}</td>
                        <td><a href="#" data-id="{{$manufacture->id}}" class="editManufacture" data-toggle="modal"><i style="color: green" class="editbtn bi bi-pencil-square"></i></a> |
                            <a data-toggle="modal" data-target="#DeleteManufacture"><i style="color: red" class="bi bi-trash3-fill"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    // open modal for edit
    $(document).ready(function() {
        $('.editManufacture').click(function(event) {
            event.preventDefault();
            var manufactureId = $(this).data('id');

            // AJAX call to fetch edit details
            $.ajax({
                url: '/item_manufacture/' + manufactureId + '/edit',
                method: 'GET',
                processData: false,
                contentType: false,
                success: function(response) {
                    var json_return = $.parseJSON(response);
                    // Populate modal fields with the fetched data
                    console.log(json_return);
                    $('#name').val(json_return.name);
                    $('#address').val(json_return.address);
                    $('#email').val(json_return.email);
                    $('#contact_no').val(json_return.contact_no);
                    $('#manufacture_id').val(json_return.id);
                    $('#EditManufacture').modal('show');
                },

            });
        });



        // modal for update function
        $('#ManufactureUpdateForm').submit(function(event) {
            event.preventDefault();
            var fd = new FormData (this);

            $('#btnUpdate').text('Updating...');

            // AJAX call to fetch category details
            $.ajax({
                url: '{{route('Manufacture.update')}}',
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
                            text: 'Item Manufacture Updated Successfully!',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // reload Page
                                location.reload(true);
                            }
                        });
                    }
                    // Populate modal fields with the fetched data

                    $('#btnUpdate').text('Update Item Manufacture');
                    $('#ManufactureUpdateForm')[0].reset();
                    $('#EditManufacture').modal('hide');
                },

            });
        });

    });


</script>
@endpush


<!-- Modal HTML Markup -->
<div id="EditManufacture" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Manufacture Details</h3>
            </div>

            <form action="#" method="post" id="ManufactureUpdateForm">
            @csrf
                <div class="modal-body">

                <div class="card mb-6">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="manufacture_id" id="manufacture_id">
                            <div class="col-sm-4">
                                <p class="mb-0">Name</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Address</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="address" id="address" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Contact Number</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="contact_no" id="contact_no" class="form-control">

                            </div>
                        </div>
                        <hr>

                    </div>
                </div>

                <div class="form-group">
                    <div class="text-center ">
                        <button type="submit" id="btnUpdate" class="btn btn-success btn-block">
                            Update
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Model Delete -->
<!-- Modal HTML -->
<div id="DeleteManufacture" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title w-100">Are you sure?</h4>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be re-do.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="{{route('Manufacture.delete', $manufacture->id)}}"><button type="button" class="btn btn-danger">Delete</button></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
