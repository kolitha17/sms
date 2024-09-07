{{--this page add to layout   --}}
@extends('layouts.app')

{{--identity the content form the layout--}}
@section('content')

    <script>

        {{--Design for Data Table--}}
        $(document).ready( function () {
            // $('#regUserTable').DataTable();
            new DataTable('#supplierTable');
        } );

        // open modal for edit
        $(document).ready(function() {
            $('.editSupplier').click(function(event) {
                event.preventDefault();
                var supplierId = $(this).data('id');

                // AJAX call to fetch category details
                $.ajax({
                    url: '/form_add_supplier/' + supplierId + '/edit',
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var json_return = $.parseJSON(response);
                        // Populate modal fields with the fetched data
                        console.log(json_return);
                        $('#ModalUpdateSupplier_name').val(json_return.name);
                        $('#ModalUpdateSupplier_address').val(json_return.address);
                        $('#ModalUpdateSupplier_contactName').val(json_return.contact_person);
                        $('#ModalUpdateSupplier_TelNo').val(json_return.telephone_no);
                        $('#ModalUpdateSupplier_MobNo').val(json_return.mobile_no);
                        $('#ModalUpdateSupplier_Email').val(json_return.email);
                        $('#supplier_id').val(json_return.id);
                        $('#ModalEdiSupplier').modal('show');
                    },

                });
            });


            // modal for update function
            $('#SupplierUpdateForm').submit(function(event) {
                event.preventDefault();
                var fd = new FormData (this);

                $('#btnUpdate').text('Updating...');

                // AJAX call to fetch category details
                $.ajax({
                    url: '{{route('Supplier.update')}}',
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
                                text: 'Supplier Details Updated Successfully!',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // reload Page
                                    location.reload(true);
                                }
                            });
                        }
                        // Populate modal fields with the fetched data

                        $('#btnUpdate').text('Update Supplier');
                        $('#SupplierUpdateForm')[0].reset();
                        $('#ModalEdiSupplier').modal('hide');
                    },

                });
            });

        });

    </script>


    <div class="container">
        <div class="row">
            {{--<div class="col-md-3"></div>--}}
            <div class="col-md-5">
                <div class="card">

                    <h5 class="card-header">Add Supplier Details</h5>
                    <div class="card-body">
                        <form action="{{route('Supplier.store')}}" method="post" id="supplierAddForm" enctype="multipart/form-data">
                            @if (Session::has('success'))
                                <div class="alert alert-success">{{ Session::get('success') }}</div>
                            @endif
                            @if (Session::has('fail'))
                                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                            @endif
                            @csrf
                            <div class="input-field p-3">
                                <label for="txtCategoryName">Supplier Name :</label>
                                <div class="col p-2">
                                    <input type="text" class="form-control" placeholder="Supplier Name" name="name">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="txtCategoryName">Address :</label>
                                <div class="col p-2">
                                    <input type="text" class="form-control" placeholder="Postal Address" name="address">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="txtCategoryName">Contact Person Name :</label>
                                <div class="col p-2">
                                    <input type="text" class="form-control" placeholder="Contact Person Name" name="contact_person">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="txtCategoryName">Telephone Number :</label>
                                <div class="col p-2">
                                    <input type="tel" class="form-control" placeholder="Telephone Number" name="telephone_no">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="txtCategoryName">Mobile Number :</label>
                                <div class="col p-2">
                                    <input type="tel" class="form-control" placeholder="Mobile Number" name="mobile_no">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="txtCategoryName">Email :</label>
                                <div class="col p-2">
                                    <input type="email" class="form-control" placeholder="Email" name="email">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary mb-2" id="btnAdd" value="ADD">

                        </form>

                    </div>
                </div>

            </div>
            <div class="col-md-7">
                {{--data view table--}}
                <div class="card shadow">
                    <div class="card-body">

                        <table id="supplierTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Contact No</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($suppliers as $key=> $supplier)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$supplier->name}}</td>
                                <td>{{$supplier->address}}</td>
                                <td>{{$supplier->telephone_no}}</td>
                                <td>
                                    <a href="#" data-toggle="modal" class="editSupplier" data-id="{{$supplier->id}}"><i style="color: green" class="bi bi-pencil-square"></i></a> |
                                    <a href="{{route("Supplier.delete", $supplier->id)}} " data-toggle="modal" data-target="#DeleteSupplier"><i style="color: red" class="bi bi-trash3-fill"></i></a>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>


    </div>


@endsection

{{--table create as data table--}}
<script>
    $(document).ready( function () {
        $('#supplierTable').DataTable();
    } );
</script>



<!-- Modal HTML Markup -->
<div id="ModalEdiSupplier" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Item Details</h3>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="SupplierUpdateForm">
                    @csrf
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="supplier_id" id="supplier_id">
                            <div class="col-sm-3">
                                <p class="mb-0">Supplier Name</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="supName" id="ModalUpdateSupplier_name" value="{{$supplier->name}}" class="form-control col-sm-9">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Address</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="supAddress" id="ModalUpdateSupplier_address" value="{{$supplier->address}}" class="form-control col-sm-9">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Contact Person Name </p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="supContactName" id="ModalUpdateSupplier_contactName" value="{{$supplier->contact_person}}" class="form-control col-sm-9">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Telephone Number</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="supTelNo" id="ModalUpdateSupplier_TelNo" value="{{$supplier->telephone_no}}" class="form-control col-sm-9">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Mobile Number</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="supMobNo" id="ModalUpdateSupplier_MobNo" value="{{$supplier->mobile_no}}" class="form-control col-sm-9">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="supEmail" id="ModalUpdateSupplier_Email" value="{{$supplier->email}}" class="form-control col-sm-9">
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



<!-- Model Delete -->
<!-- Modal HTML -->
<div id="DeleteSupplier" class="modal fade">
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
                <a href="{{route('Supplier.delete', $supplier->id)}}"><button type="button" class="btn btn-danger">Delete</button></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>