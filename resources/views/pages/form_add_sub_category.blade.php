
{{--this page add to layout   --}}
@extends('layouts.app')

{{--identify the content form the layout--}}
@section('content')


    <script type="text/javascript">

        {{--Design for Data Table--}}
        $(document).ready( function () {
            // $('#regUserTable').DataTable();
            new DataTable('#tableSubCat');
        } );


        {{--onchange function for Category dropdown--}}
        function getCategory(category_id){

            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass category_id as a parameter
            var url = "{{route('get-category-code', ['category_id' => ':category_id'])}}"
                .replace(':category_id', category_id);

            // alert(category_id);
            ajaxObject.open("GET",url,true);

            ajaxObject.onreadystatechange = function(readyState, status){

                if(ajaxObject.readyState==4 && ajaxObject.status==200){
                    // alert(ajaxObject.responseText);
                    const data = JSON.parse(ajaxObject.responseText);
                    console.log(data[0].code.toString());
                    // alert(data[0].code.toString());

                    // $('#code').innerHTML = data[0].code.toString();
                    $('input[name=catCode]').val(data[0].code.toString());
                }
            }
            ajaxObject.send();
        }


        // open modal for edit
        $(document).ready(function() {
            $('#tableSubCat').on('click','.editSubCategory',function(event) {
                event.preventDefault();
                var subCategoryId = $(this).data('id');

                // AJAX call to fetch category details
                $.ajax({
                    url: '/sub_category/' + subCategoryId + '/edit',
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var json_return = $.parseJSON(response);
                        // Populate modal fields with the fetched data
                        console.log(json_return);
                        $('#ModalUpdateSubCat_category_id').val(json_return.category_id);
                        $('#ModalUpdateSubCat_name').val(json_return.name);
                        $('#ModalUpdateSubCat_code').val(json_return.code);

                        $('#subCat_id').val(json_return.id);
                        $('#ModalUpdateSubCat').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });


            // modal for update function
            $('#subCatEditForm').submit(function(event) {
                event.preventDefault();
                var fd = new FormData (this);

                $('#btnUpdate').text('Updating...');

                // AJAX call to fetch category details
                $.ajax({
                    url: '{{route('SubCategory.updateSubCat')}}',
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
                               title: 'Updated!',
                               text: 'Sub Category Updated Successfully!',
                               icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // reload Page
                                    location.reload(true);
                                }
                            });
                        }
                        // Populate modal fields with the fetched data

                        $('#btnUpdate').text('Update Sub Category');
                        $('#subCatEditForm')[0].reset();
                        $('#ModalUpdateSubCat').modal('hide');
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
                    <h5 class="card-header">Add Sub Category Details</h5>
                       <div class="card-body">
                        <form method="post" action="{{route('SubCategory.subCategoryStore')}}">
                            @if (Session::has('success'))
                                <div class="alert alert-success">{{ Session::get('success') }}</div>
                            @endif
                            @if (Session::has('fail'))
                                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                            @endif
                            @csrf
                            <div class="input-field">
                                <label>Item Category Name :</label>
                                {{--load category list--}}
                                <div class="col-md-12">
                                    <select name="category_id" id="category_id" class="form-control" onchange='getCategory(this.value)' required >
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-field">
                                <label>Item Category Code :</label>
                                {{--load category code--}}
                                <div class="col-md-12">
                                    <input type="text" name="catCode" id="catCode" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Item Sub Category Name :</label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="Enter Sub Category Name" class="form-control" required>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Item Sub Category Code :</label>
                                <div class="col-md-12">
                                    <input type="text" id="code" name="code" placeholder="100" class="form-control" data-bs-placement="right" title="require 3 numbers" maxlength="3" required>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary mb-2" id="btnAdd" value="ADD">
                        </form>
                    </div>
                </div>
                {{--Sub Category details views--}}
                <div class="row p-3">
                    <table class="table table-striped" id="tableSubCat">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Sub Category Name</th>
                            <th scope="col">Sub Category Code</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subCategories as $key => $subCategory)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$subCategory->category->name}}</td>
                                <td>{{$subCategory->name}}</td>
                                <td>{{$subCategory->code}}</td>
                                <td>{{$subCategory->status}}</td>
                                <td>
                                    <a href="#" class="editSubCategory" data-id="{{$subCategory->id}}" data-toggle="modal"><i style="color: green" class="bi bi-pencil-square"></i></a>
                                    {{--|--}}
                                    {{--<a href="{{route('SubCategory.delete', $subCategory->id)}}" data-toggle="modal" data-target="#CancelRequest"><i style="color: red" class="bi bi-trash3-fill"></i></a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-3"></div>
        </div>
    </div>
@endsection




@push('css')
    <style>
        label{
            padding-bottom: 5px;
        }

        .input-field{
            padding: 10px;
        }

        input[type='text']{
            width: 400px;
        }
    </style>
@endpush


<!-- Modal HTML Markup -->
<div id="ModalUpdateSubCat" class="modal fade" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update Sub Category Details</h3>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="subCatEditForm">
                    @csrf
                    <div class="card mb-8">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="subCat_id" id="subCat_id">
                                <div class="col-sm-3">
                                    <p class="mb-0">Category Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <select name="category_id" id="ModalUpdateSubCat_category_id" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $subCategory->category_id ? 'selected' : '' }}>
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
                                    <input type="text" name="name" id="ModalUpdateSubCat_name" value="{{$subCategory->name}}" class="form-control col-sm-9">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Sub Category Code</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="code" id="ModalUpdateSubCat_code" value="{{$subCategory->code}}" class="form-control col-sm-9" data-bs-placement="right" title="require 3 numbers">
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



<!-- Modal Cancel -->
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







