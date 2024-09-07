
{{--this page add to layout   --}}
@extends('layouts.app')

{{--identity the content form the layout--}}
@section('content')



    <div class="container">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-3"></div>

                <div class="col-md-6">
                    {{--<div class="card">--}}
                        {{--<h5 class="card-header">Add New Items to Ledger</h5>--}}
                        {{--<div class="card-body">--}}
                            {{--@csrf--}}
                            {{--<div class="input-field p-3">--}}
                                {{--<label for="txtPurchaseOrderNo">Purchase Order Number :</label>--}}
                                {{--<div class="col p-2">--}}
                                    {{--<select name="po_id" id="po_id" class="form-control" required>--}}
                                        {{--@foreach( $categories as $category )--}}
                                        {{--<option value="{{$category->id}}">{{$category->name}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}


                            {{--<input type="submit" class="btn btn-primary mb-2" id="btnAdd" value="ADD">--}}

                        {{--</div>--}}
                    {{--</div>--}}

                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                {{--Manufacture details views--}}
                <div class="card mt-3 shadow">
                    <div class="card-body">
                        <p align="center">Add the Technical Committee approved Items to the relevant Store</p>
                        <table class="table table-striped table-info">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Select Relevant Store Type</th>
                                <th scope="col">Serial No</th>
                                <th scope="col">Barcode No</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--@foreach($categories as $key => $category)--}}
                            {{--<tr>--}}
                            {{--<td>{{++$key}}</td>--}}
                            {{--<td>{{$category->name}}</td>--}}
                            {{--<td>{{$category->code}}</td>--}}
                            {{--<td>{{$category->status}}</td>--}}
                            {{--<td>--}}
                            {{--<a href="{{route('Category.edit', $category->id)}}"><i style="color: green" class="bi bi-pencil-square"></i></a> |--}}
                            {{--<a data-toggle="modal" data-target="#DeleteCategory"><i style="color: red" class="bi bi-trash3-fill"></i></a>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--@endforeach--}}
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
                        <input type="button" value="Update" id="btnUpdate" name="update" class="btn btn-success" >

                    </div>

                </div>
            </div>
        </form>
    </div>


@endsection


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
                <a href=""><button type="button" class="btn btn-danger">Delete</button></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



