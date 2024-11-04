@extends('layouts.app')


@section('content')

    <script>
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




        //onchange function for SubCategory dropdown
        function getSubCategory(sub_category_id) {
            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass sub_category_id as a parameter
            var url = "{{ route('Item.getSubCatCode', ['sub_category_id' => ':sub_category_id']) }}".replace(':sub_category_id', sub_category_id);

            ajaxObject.open("GET", url, true);

            ajaxObject.onreadystatechange = function () {
                if (ajaxObject.readyState === 4 && ajaxObject.status === 200) {
                    const data = JSON.parse(ajaxObject.responseText);

                    var itemDropdown = document.getElementById('inv_item_id');

                    // Clear existing options
                    itemDropdown.innerHTML = '';

                    // Iterate through the received data to populate the "SubCategory" dropdown
                    data.forEach(function (item) {
                        var option = document.createElement('option');
                        option.value = item.id; // Assuming each subCategory object has an 'id' property
                        option.text = item.name; // Assuming each subCategory object has a 'name' property
                        itemDropdown.appendChild(option);
                    });
                }
            };

            ajaxObject.send();
        }



        {{--Show Ordered Items when Add Item Button Click--}}
        function addItem() {
            // Add input fields dynamically using JavaScript
            const dynamicItems = document.getElementById('dynamic_items');
            const newItem = document.createElement('tr');
            var category = document.getElementById('category_id').options[document.getElementById('category_id').selectedIndex].text;
            var subCat = document.getElementById('sub_category_id').options[document.getElementById('sub_category_id').selectedIndex].text;
            var item = document.getElementById('inv_item_id').options[document.getElementById('inv_item_id').selectedIndex].text;



            newItem.innerHTML = `

                    <td><input type="text" class="form-control category_input" name="category_input"></td>
                    <td><input type="text" class="form-control subCat_input" name="subCat_input"></td>
                    <td><input type="text" class="form-control item_input" name="item_input"></td>
                    <td><input type="text" class="form-control quantity_input" name="quantity[]"></td>
                    <td><input type="text" class="form-control unit_price_input" name="unit_price[]"></td>
                    <td><input type="text" class="form-control vat_input" name="vat[]"></td>
                    <td><input type="text" class="form-control amount_input" name="amount[]"></td>
                    <td><button class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button></td>

            `;

            // Set the value of category variable into the category_input td
            newItem.querySelector('.category_input').value = category;
            newItem.querySelector('.subCat_input').value = subCat;
            newItem.querySelector('.item_input').value = item;

            // Calculate total amount based on quantity, unit price, and VAT
            newItem.querySelector('.quantity_input').addEventListener('input', updateTotalAmount);
            newItem.querySelector('.unit_price_input').addEventListener('input', updateTotalAmount);
            newItem.querySelector('.vat_input').addEventListener('input', updateTotalAmount);

            dynamicItems.appendChild(newItem);

            // Add event listener to the delete button
            const deleteButton = newItem.querySelector('.btn-danger');
            deleteButton.addEventListener('click', function() {
                dynamicItems.removeChild(newItem); // Remove the row when delete button is clicked
            });

        }

        //update Total Amount in the table view
        function updateTotalAmount() {
            const quantity = parseFloat(this.parentElement.parentElement.querySelector('.quantity_input').value);
            const unitPrice = parseFloat(this.parentElement.parentElement.querySelector('.unit_price_input').value);
            const vat = parseFloat(this.parentElement.parentElement.querySelector('.vat_input').value);

            // Calculate the total amount
            const totalAmount = (quantity * unitPrice) * (1 + (vat / 100));

            // Set the total amount in the corresponding input field
            this.parentElement.parentElement.querySelector('.amount_input').value = totalAmount.toFixed(2);
        }


    </script>


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{route('PurchaseOrder.store')}}" method="post" id="purchaseOrderForm_id">
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if (Session::has('fail'))
                            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                        @endif
                        @csrf
                        <div class="card-header">
                            <h4>Purchase Order</h4>
                        </div>
                        <div class="card-body">
                            <div>
                                <label>Bid Number : </label>
                                <input type="text" name="bid_no" id="bid_no" class="form-control col-md-4" required>
                            </div>

                            <div class="mt-2">
                                <label>Purchase Order Number : </label>
                                <input type="text" name="pur_order_no" id="pur_order_no" class="form-control col-md-4" required>
                            </div>

                            <div class="mt-2">
                                <label>Purchase Order Date : </label>
                                <input type="date" name="po_date" id="po_date" class="form-control col-md-4" required>
                            </div>

                            <div class="mt-2">
                                <label>Supplier : </label>
                                <select name="supplier_id" id="supplier_id" class="form-control col-md-4">
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="card mt-4 shadow">
                                <div class="card-header d-flex justify-content-between">

                                    {{--add Item Inputs--}}
                                    <div class="col-sm-3">
                                        <select name="category_id" id="category_id" class="form-control" onchange="getCategory(this.value)" required>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <select name="sub_category_id" id="sub_category_id" class="form-control" onchange="getSubCategory(this.value)" required>
                                            <option value="">Select Subcategory</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <select name="inv_item_id" id="inv_item_id" class="form-control" required>
                                            <option value="">Select Item</option>
                                        </select>
                                    </div>

                                    {{--end add Item Inputs--}}

                                    <button type="button" class="btn btn-light" id="addItemModal_id" onclick="addItem()">

                                        <i class="bi bi-plus-circle-dotted">Add Item</i>
                                    </button>


                                </div>
                                <div class="card-body">

                                    <table id="purchaseOrderTable" class="table table-striped">

                                        <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Vat</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="dynamic_items">

                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="mt-3">
                                <input type="submit" value="Add Purchase Order" name="addPOrder" id="addPOrder" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>





        <script>
            {{--Load Purchase Order Number into the Modal hidden field--}}
            var sourceTextField = document.getElementById("pur_order_no");
            var destinationTextField = document.getElementById("pur_order_id");
            var copyButton = document.getElementById("addItemModal_id");
            function copyText() {
                console.log(sourceTextField);
                destinationTextField.value = sourceTextField.value;
                console.log(destinationTextField.value);
            }
            copyButton.addEventListener("click", copyText);
        </script>

    </div>


@endsection



