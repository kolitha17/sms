{{--this page add to layout   --}}
@extends('layouts.app')

{{--identify the content form the layout--}}
@section('content')

    <script type="text/javascript">
        {{--Design for Data Table--}}
        $(document).ready( function () {
            // $('#regUserTable').DataTable();
            new DataTable('#itemTable');
        } );


        {{--onchange function for Category dropdown--}}
        function getCategory(category_id) {
            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass category_id as a parameter
            var url = "{{ route('Item.getCategoryCode', ['category_id' => ':category_id']) }}".replace(':category_id', category_id);

            ajaxObject.open("GET", url, true);

            ajaxObject.onreadystatechange = function () {
                if (ajaxObject.readyState === 4 && ajaxObject.status === 200) {
                    const data = JSON.parse(ajaxObject.responseText);

                    var subCategoryDropdown = document.getElementById('sub_category_id');

                    // Clear existing options
                    subCategoryDropdown.innerHTML = '';

                    // Iterate through the received data to populate the "SubCategory" dropdown
                    data.forEach(function (subCategory) {
                        var option = document.createElement('option');
                        option.value = subCategory.id; // Assuming each subCategory object has an 'id' property
                        option.text = subCategory.name; // Assuming each subCategory object has a 'name' property
                        subCategoryDropdown.appendChild(option);
                    });
                }
            };

            ajaxObject.send();
        }




        {{--SubCategory Code Set to the hidden field--}}

        function getSubCategory(sub_category_id){

            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass category_id as a parameter
            var url = "{{route('Item.getSubCategoryCode', ['sub_category_id' => ':sub_category_id'])}}"
                .replace(':sub_category_id', sub_category_id);

            // alert(category_id);
            ajaxObject.open("GET",url,true);

            ajaxObject.onreadystatechange = function(readyState, status){

                if(ajaxObject.readyState==4 && ajaxObject.status==200){
                    // alert(ajaxObject.responseText);
                    const data = JSON.parse(ajaxObject.responseText);
                    console.log(data[0].code.toString());
                    // alert(data[0].code.toString());

                    // $('#code').innerHTML = data[0].code.toString();
                    $('input[name=subCode]').val(data[0].code.toString());
                }
            }
            ajaxObject.send();
        }



        // open modal for edit
        $(document).ready(function() {
            $('#itemTable').on('click','.editItem',function(event) {
                event.preventDefault();
                var itemId = $(this).data('id');

                // AJAX call to fetch category details
                $.ajax({
                    url: '/item/' + itemId + '/edit',
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var json_return = $.parseJSON(response);
                        // Populate modal fields with the fetched data
                        console.log(json_return);
                        $('#ModalUpdateItem_category_id').val(json_return.category_id);
                        $('#ModalUpdateItem_SubCatName').val(json_return.sub_category_id);
                        $('#ModalUpdateItem_name').val(json_return.name);
                        $('#ModalUpdateItem_code').val(json_return.code);
                        $('#ModalUpdateItem_ledgerType').val(json_return.ledger_type);
                        $('#item_id').val(json_return.id);
                        $('#ModalUpdateItem').modal('show');
                    },

                });
            });


            // modal for update function
            $('#ItemUpdateForm').submit(function(event) {
                event.preventDefault();
                var fd = new FormData (this);

                $('#btnUpdate').text('Updating...');

                // AJAX call to fetch category details
                $.ajax({
                    url: '{{route('Item.update')}}',
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
                               text: 'Item Updated Successfully!',
                               icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // reload Page
                                    location.reload(true);
                                }
                            });
                        }
                        // Populate modal fields with the fetched data

                        $('#btnUpdate').text('Update Item');
                        $('#ItemUpdateForm')[0].reset();
                        $('#ModalUpdateItem').modal('hide');
                    },

                });
            });

        });



    </script>

    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Add New Item</h5>
                    <div class="card-body">
                        <form method="post" action="{{route('Item.itemStore')}}">
                            @csrf
                            <div class="input-field">
                                <label for="category_id">Item Category:</label>
                                {{--load combo list--}}
                                <div class="col-md-12">
                                    <select name="category_id" id="category_id" class="form-control" onchange="getCategory(this.value)" required>
                                        @foreach( $categories as $category )
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-field">
                                <label for="sub_category_id">Item Sub Category:</label>
                                <div class="col-md-12">
                                    <select name="sub_category_id" id="sub_category_id" class="form-control" onchange="getSubCategory(this.value)" required>


                                        <option value="">Select Subcategory</option>
                                    </select>
                                    {{--set SubCategory Code in the hidden field to concatinate with Item Code--}}
                                    <input type="hidden" name="subCode" id="subCode">

                                </div>
                            </div>

                            <div class="input-field">
                                <label>Item Name :</label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="Enter Item Name" class="form-control" required>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Item Code :</label>
                                <div class="col-md-12">
                                    <input type="text" name="code" id="code" placeholder="001" class="form-control" data-bs-placement="right" required>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Main Store Type:</label>
                                <div class="col-md-12">
                                    <select name="ledger_type" id="ledger_type" class="form-control" required>
                                        <option selected>Select the Main Store type</option>
                                        <option value="Instrument & Drawing Items">Instrument & Drawing Items</option>
                                        <option value="Furniture">Furniture</option>
                                        <option value="Office Equipments & Welfare">Office Equipments & Welfare</option>
                                        <option value="Building Materials">Building Materials</option>
                                        <option value="Perishable">Perishable</option>

                                    </select>
                                </div>
                            </div>

                            <div class="p-2">
                                <input type="submit" class="btn btn-primary mb-2" id="btnAdd" value="ADD">
                            </div>


                        </form>

                    </div>
                </div>

            </div>
            <div class="col-md-3"></div>
        </div>


            {{--Item View Table--}}
            <div class="card mt-3 shadow">
                <div class="card-body">
                    <table id="itemTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Sub Category Name</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Ledger Type</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $key => $item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$item->category->name}}</td>
                                <td>{{$item->subCategory->name}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->code}}</td>
                                <td>{{$item->ledger_type}}</td>
                                <td>
                                    <a href="#" class="editItem" data-id="{{$item->id}}" data-toggle="modal" ><i style="color: green" class="bi bi-pencil-square"></i></a> |
                                    <a href="{{route('SubCategory.delete', $item->id)}}" data-toggle="modal" data-target="#DeleteItem"><i style="color: red" class="bi bi-trash3-fill"></i></a>
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
<div id="ModalUpdateItem" class="modal fade" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update Sub Category Details</h3>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="ItemUpdateForm">
                    @csrf
                    <div class="card mb-8">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="item_id" id="item_id">
                                <div class="col-sm-3">
                                    <p class="mb-0">Category Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <select name="category_id" id="ModalUpdateItem_category_id" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $item->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Sub Category Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <select name="sub_category_id" id="ModalUpdateItem_SubCatName" class="form-control">
                                        @foreach($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}" {{ $subCategory->id == $item->sub_category_id ? 'selected' : '' }}>
                                                {{ $subCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Item Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="name" id="ModalUpdateItem_name" value="{{$item->name}}" class="form-control col-sm-9">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Sub Category Code</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="code" id="ModalUpdateItem_code" value="{{$item->code}}" class="form-control col-sm-9" data-bs-placement="right" title="require 3 numbers">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Ledger Type</p>
                                </div>
                                <div class="col-sm-9">
                                    <select name="ledger_type" id="ModalUpdateItem_ledgerType" class="form-control">
                                        <option value="Instrument & Drawing Items" {{ $item->ledger_type == 'Instrument & Drawing Items' ? 'selected' : '' }}>Instrument & Drawing Items</option>
                                        <option value="Furniture" {{ $item->ledger_type == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                        <option value="Office Equipments & Welfare" {{ $item->ledger_type == 'Office Equipments & Welfare' ? 'selected' : '' }}>Office Equipments & Welfare</option>
                                        <option value="Building Materials" {{ $item->ledger_type == 'Building Materials' ? 'selected' : '' }}>Building Materials</option>
                                        <option value="Perishable" {{ $item->ledger_type == 'Perishable' ? 'selected' : '' }}>Perishable</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="text-center ">
                            <button type="Submit" id="btnUpdate" class="btn btn-success btn-block">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{--End Modal--}}



<!-- Model Delete -->
<!-- Modal HTML -->
<div id="DeleteItem" class="modal fade">
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
                <a href="{{route('Item.itemDelete', $item->id)}}"><button type="button" class="btn btn-danger">Delete</button></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>