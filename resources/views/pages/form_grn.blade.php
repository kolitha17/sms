
{{--this page add to layout   --}}
@extends('layouts.app')

{{--identity the content form the layout--}}
@section('content')

    {{--Load Purchase Order Items into the Data Table--}}
    {{--<script>--}}
        {{--$(document).ready(function () {--}}
            {{--var purchaseOrderItemsTable = $('#purOrderItemsTable').DataTable({--}}
                {{--columns: [--}}
                    {{--{ data: 'id', title: 'ID' },--}}
                    {{--{ data: 'category', title: 'Category' },--}}
                    {{--{ data: 'itemName', title: 'Item Name' },--}}
                    {{--{ data: 'unitPrice', title: 'Unit Price' },--}}
                    {{--{ data: 'vat', title: 'Vat' },--}}
                    {{--{ data: 'quantity',--}}
                        {{--title: 'Received Quantity',--}}
                        {{--render: function (data, type, row) {--}}

                            {{--return type === 'display' ? '<input type="text" class="class-input" value="' + data + '">' : data;--}}
                        {{--} },--}}
                    {{--{ data: 'model',--}}
                        {{--title: 'Model',--}}
                        {{--render: function (data, type, row) {--}}

                            {{--return type === 'display' ? '<input type="text" class="class-input" value="' + data + '">' : data;--}}
                        {{--} },--}}
                    {{--{ data: 'manufacture',--}}
                        {{--title: 'Manufacture',--}}
                        {{--render: function (data, type, row) {--}}

                            {{--return type === 'display' ? '<input type="text" class="class-input" value="' + data + '">' : data;--}}
                        {{--} },--}}
                    {{--{ data: 'warrantyExpDate',--}}
                        {{--title: 'Warranty Expire Date',--}}
                        {{--render: function (data, type, row) {--}}

                            {{--return type === 'display' ? '<input type="text" class="class-input" value="' + data + '">' : data;--}}
                        {{--}},--}}
                    {{--{ data: 'completeStatus',--}}
                        {{--title: 'Complete Status',--}}
                        {{--render: function (data, type, row) {--}}

                            {{--return type === 'display' ? '<input type="text" class="class-input" value="' + data + '">' : data;--}}
                        {{--}},--}}
                {{--]--}}
            {{--});--}}

            {{--$('#po_id').change(function () {--}}
                {{--var purchaseOrderId = $(this).val();--}}

                {{--if (purchaseOrderId) {--}}
                    {{--// Use AJAX to fetch Purchase Order Items based on the selected Purchase Order--}}
                    {{--$.ajax({--}}
                        {{--url: '/get-purchase-order-items/' + purchaseOrderId,--}}
                        {{--type: 'GET',--}}
                        {{--success: function (data) {--}}
                            {{--// Clear existing data--}}
                            {{--purchaseOrderItemsTable.clear();--}}

                            {{--// Add new data--}}
                            {{--purchaseOrderItemsTable.rows.add(data).draw();--}}

                            {{--// Add event listeners for text fields if needed--}}
                            {{--addEventListeners();--}}
                        {{--}--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}

            {{--function addEventListeners() {--}}
                {{--// Add event listeners for text fields if needed--}}
                {{--$('.class-input').on('change', function () {--}}
                    {{--// Handle the change event for quantity input--}}
                    {{--var row = purchaseOrderItemsTable.row($(this).closest('tr'));--}}
                    {{--var newData = row.data();--}}
                    {{--newData.quantity = $(this).val();--}}
                    {{--newData.model = $(this).val();--}}
                    {{--newData.manufacture = $(this).val();--}}
                    {{--newData.warrantyExpDate = $(this).val();--}}
                    {{--newData.completeStatus = $(this).val();--}}
                    {{--row.data(newData).draw();--}}
                {{--});--}}
            {{--}--}}
        {{--});--}}
    {{--</script>--}}



    <div class="container">
        <form action="{{route('GRN.addItems')}}" method="post">
        <div class="row">
            <div class="col-md-3"></div>

            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Good Receive Note</h5>
                    <div class="card-body">
                            @csrf
                            <div class="input-field p-2">
                                <label for="po_id">Purchase Order Number :</label>
                                <div class="col p-2">
                                    <select name="po_id" id="po_id" class="form-control" required>
                                        @foreach( $purchaseOrders as $purchaseOrder )
                                            <option value="{{$purchaseOrder->id}}">{{$purchaseOrder->pur_order_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="invoice_no">Invoice Number : </label>
                                <div class="col p-2">
                                    <input type="text" name="invoice_no" id="invoice_no" class="form-control" required>
                                </div>
                                <label for="grn_date">GRN Date : </label>
                                <div class="col p-2">
                                    <input type="date" name="grn_date" id="grn_date" class="form-control" required>
                                </div>
                            </div>


                            <input type="submit" class="btn btn-primary mb-2" id="btnAdd" value="ADD">

                    </div>
                </div>

            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            {{--Manufacture details views--}}
            <div class="card mt-3 shadow">
                <div class="card-body">
                    <table class="table table-striped table-info" id="purOrderItemsTable">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Vat</th>
                            <th scope="col">Received Quantity</th>
                            <th scope="col">Model</th>
                            <th scope="col">Manufacture</th>
                            <th scope="col">Warranty Exp Date</th>
                            <th scope="col">Complete Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@foreach($poItems as $key => $poItem)--}}
                        {{--<tr>--}}
                        {{--<td>{{++$key}}</td>--}}
                        {{--<td>{{$poItem->name}}</td>--}}
                        {{--<td>{{$poItem->code}}</td>--}}
                        {{--<td>{{$poItem->status}}</td>--}}
                        {{--<td>--}}
                        {{--<a href="{{route('Category.edit', $poItem->id)}}"><i style="color: green" class="bi bi-pencil-square"></i></a> |--}}
                        {{--<a data-toggle="modal" data-target="#DeleteCategory"><i style="color: red" class="bi bi-trash3-fill"></i></a>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--@endforeach--}}
                        </tbody>
                    </table>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
                   <a href="ledger">
                    <input type="button" value="Next" id="btnNext" name="next" class="btn btn-success" >
                   </a>
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



