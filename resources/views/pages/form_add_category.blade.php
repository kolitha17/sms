
{{--this page add to layout   --}}
@extends('layouts.app')

{{--identity the content form the layout--}}
@section('content')

    <!-- Generate Code -->
    <script>
        {{--// Function to fetch the next letter using AJAX and update the text field--}}
        {{--function generateCatCode() {--}}
            {{--fetch("{{ route('Category.generateCatCode') }}")--}}
                {{--.then(response => response.json())--}}
                {{--.then(data => {--}}
                    {{--document.getElementById('code').value = data.nextLetter;--}}
                {{--})--}}
                {{--.catch(error => {--}}
                    {{--console.error('Error:', error);--}}
                {{--});--}}
        {{--}--}}

        {{--// Trigger the AJAX request when the page loads--}}
        {{--document.addEventListener('DOMContentLoaded', function() {--}}
            {{--generateCatCode();--}}
        {{--});--}}


        {{--Design for Data Table--}}
        $(document).ready( function () {
            // $('#regUserTable').DataTable();
            new DataTable('#categoryTable');
        } );


        function getCategoryCode(category_id){

            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass category_id as a parameter
            var url = "{{route('Category.generateCatCode', ['category_id' => ':category_id'])}}"
                .replace(':category_id', category_id);

            alert(category_id);
            ajaxObject.open("GET",url,true);

            ajaxObject.onreadystatechange = function(readyState, status){

                if(ajaxObject.readyState==4 && ajaxObject.status==200){
                    // alert(ajaxObject.responseText);
                    const data = JSON.parse(ajaxObject.responseText);
                    console.log(data[0].code.toString());
                    // alert(data[0].code.toString());

                    // $('#code').innerHTML = data[0].code.toString();
                    $('input[name=code]').val(data[0].code.toString());
                }
            }
            ajaxObject.send();
        }




        // open modal for edit
        $(document).ready(function() {
            $('#categoryTable').on('click','.editCategory',function(event) {
                event.preventDefault();
                var categoryId = $(this).data('id');

                // AJAX call to fetch category details
                $.ajax({
                    url: '/category/' + categoryId + '/edit',
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var json_return = $.parseJSON(response);
                        // Populate modal fields with the fetched data
                        console.log(json_return);
                        $('#ModalUpdateCat_name').val(json_return.name);
                        $('#ModalUpdateCat_code').val(json_return.code);

                        $('#cat_id').val(json_return.id);
                        $('#ModalUpdateCat').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });


            // modal for update function
            $('#catEditForm').submit(function(event) {
                event.preventDefault();
                var fd = new FormData (this);

                $('#btnUpdate').text('Updating...');

                // AJAX call to fetch category details
                $.ajax({
                    url: '{{route('Category.update')}}',
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
                                text: 'Category Updated Successfully!',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // reload Page
                                    location.reload(true);
                                }
                            });
                        }
                        // Populate modal fields with the fetched data

                        $('#btnUpdate').text('Update Category');
                        $('#catEditForm')[0].reset();
                        $('#ModalUpdateCat').modal('hide');
                    },

                });
            });


        });


    </script>


    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>

            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header">Add Category Details</h5>
                    <div class="card-body">
                        <form action="{{ route('CategoryData.categoryStore') }}" method="post">
                            @if (Session::has('success'))
                                <div class="alert alert-success">{{ Session::get('success') }}</div>
                            @endif
                            @if (Session::has('fail'))
                                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                            @endif
                            @csrf
                            <div class="input-field p-3">
                                <label for="txtCategoryName">Category Name :</label>
                                <div class="col p-2">
                                    <input type="text" class="form-control" placeholder="Item Name" name="name" id="name">
                                </div>
                            </div>

                            <div class="input-field p-3">
                                <label for="code">Category Code :</label>
                                <div class="col p-2">
                                    <input type="text" class="form-control" name="code" id="code">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary mb-2" id="btnAdd" value="ADD">
                        </form>
                    </div>
                </div>
                {{--Manufacture details views--}}
                <div class="row p-5">
                    <table id="categoryTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Category Code</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $key => $category)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->code}}</td>
                                <td>{{$category->status}}</td>
                                <td>
                                    <a href="#" class="editCategory" data-id="{{$category->id}}" data-toggle="modal"><i style="color: green" class="bi bi-pencil-square"></i></a>
                                    {{--<a data-toggle="modal" data-target="#DeleteCategory"><i style="color: red" class="bi bi-trash3-fill"></i></a>--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>

@endsection




<!-- Modal HTML Markup -->
<div id="ModalUpdateCat" class="modal fade" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update Category Details</h3>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="catEditForm">
                    @csrf
                    <div class="card mb-8">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="cat_id" id="cat_id">
                                <div class="col-sm-3">
                                    <p class="mb-0">Category Name</p>
                                </div>
                                <div class="col-sm-9">
                                        <input type="text" class="form-control col-sm-9" name="name" id="ModalUpdateCat_name" value="{{$category->name}}">
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Category Code</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="code" id="ModalUpdateCat_code" value="{{$category->code}}" class="form-control col-sm-9" data-bs-placement="right">
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
<div id="DeleteCategory" class="modal fade">
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
                <a href="{{route('Category.delete', $category->id)}}"><button type="button" class="btn btn-danger">Delete</button></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



