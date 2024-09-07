{{--this page add to layout   --}}
@extends('layouts.app')

{{--identify the content form the layout--}}
@section('content')

    <script type="text/javascript" >
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


        {{--onchange function for Item dropdown--}}
        function getSubCategory(sub_category_id) {
            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass item_id as a parameter
            var url = "{{ route('Item.getItem', ['subcat_id' => ':sub_category_id']) }}".replace(':sub_category_id', sub_category_id);

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
                        option.value = item.id; // Assuming each item object has an 'id' property
                        option.text = item.name; // Assuming each item object has a 'name' property
                        itemDropdown.appendChild(option);
                    });
                }
            };

            ajaxObject.send();
        }


        {{--Onchange function for the Organization Unit--}}
        function getOrgUnit(pur_unit_type) {
            var ajaxObject = new XMLHttpRequest();

            // Generate the URL using Laravel's route() GET function and pass org_unit_type_id as a parameter
            var url = "{{ route('PurchasingItem.getUnit', ['pur_unit_type' => ':pur_unit_type']) }}".replace(':pur_unit_type', pur_unit_type);

            ajaxObject.open("GET", url, true);

            ajaxObject.onreadystatechange = function () {
                if (ajaxObject.readyState === 4 && ajaxObject.status === 200) {
                    const data = JSON.parse(ajaxObject.responseText);

                    var unitNameDropdown = document.getElementById('pur_units');

                    // Clear existing options
                    unitNameDropdown.innerHTML = '';

                    // Iterate through the received data to populate the "District" dropdown
                    data.forEach(function (unitName) {
                        var option = document.createElement('option');
                        option.value = unitName.id; // Assuming each unit object has an 'id' property
                        option.text = unitName.name; // Assuming each unit object has a 'name' property
                        unitNameDropdown.appendChild(option);
                    });
                }
            };

            ajaxObject.send();
        }


        {{--Change Save or Next Button according to the Category--}}

        // document.addEventListener('DOMContentLoaded',function () {
        //
        //     document.getElementById('category_id').addEventListener('change',function () {
        //
        //         var selectCategory = this.value;
        //         var buttonSave = document.getElementById('btnAdd');
        //         var buttonNext  = document.getElementById('btnNext');
        //
        //         var categoriesForNext = [
        //             '1',
        //             '14',
        //             '16',
        //
        //             // Add more mappings for other categories as needed
        //         ];
        //         if (categoriesForNext.includes(selectCategory)) {
        //             // buttonNext.removeAttribute('hidden')
        //
        //             // add sweet alert for go to next page
        //             document.getElementById('btnAdd').addEventListener('click', function() {
        //                 // Use SweetAlert for the notification
        //                 Swal.fire({
        //                     title: 'Saved Successfully!',
        //                     text: 'Go to Add Item Details Form for add Model Number and Serial Number.',
        //                     icon: 'success', // you can use 'success', 'error', 'warning', 'info', or 'question'
        //                     confirmButtonText: 'OK'
        //                 });
        //             });
        //
        //
        //         }else {
        //             button.textContent = 'Save';
        //         }
        //
        //     })
        // });

        // Save Or Next Button
        function getSaveOrNext() {
            // Submit the form
            document.getElementById('FormPurchasingItemId').submit();
            event.preventDefault();

        var selectCategory = document.getElementById('category_id').value;
            // console.log(selectCategory);
            var categoriesForNext = [
                '1',
                '14',
                '16',

                // Add more mappings for other categories as needed
            ];

            if(!(categoriesForNext.includes(selectCategory))){
                // Use SweetAlert for the notification
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Saved Successfully"
                });
            }

            {{--if (categoriesForNext.includes(selectCategory)){--}}

                {{--event.preventDefault();--}}

                {{--console.log ("Preventing defult submitting");--}}


                {{--Swal.fire({--}}
                    {{--title: 'Saved Successfully and Go to Next Page!',--}}
                    {{--icon: 'info', // you can use 'success', 'error', 'warning', 'info', or 'question'--}}
                            {{--confirmButtonText: 'Next'--}}
                {{--}).then((result) => {--}}
                    {{--if (result.isConfirmed) {--}}

                        {{--window.location.href = "{{ route('PurchasingItem.viewItemDetailsForm') }}";--}}

                    {{--}--}}
                {{--});--}}




            {{--}else {--}}

                {{--document.getElementById('FormPurchasingItemId').submit();--}}
                {{--// Use SweetAlert for the notification--}}
                {{--Swal.fire({--}}
                    {{--title: 'Saved Successfully!',--}}
                    {{--icon: 'success', // you can use 'success', 'error', 'warning', 'info', or 'question'--}}
                    {{--confirmButtonText: 'OK'--}}
                {{--}).then((result) => {--}}
                    {{--if (result.isConfirmed) {--}}
                        {{--// reload Page--}}
                        {{--window.location.href = "form_add_item_details";--}}

                    {{--}--}}
                {{--});--}}

            {{--}--}}





            {{--if (button.textContent === 'Next') {--}}
                var itemName = document.getElementById('inv_item_id').options[document.getElementById('inv_item_id').selectedIndex].text;
                var quantity = document.getElementById('quantity').value;
            //
            //     // Other rows but not view, just go for next page to save the data
            //     var itemCategory = document.getElementById('category_id').options[document.getElementById('category_id').selectedIndex].text;
            //     var itemSubCategory = document.getElementById('sub_category_id').options[document.getElementById('sub_category_id').selectedIndex].text;
            //     var itemMainStoreType = document.getElementById('ledger_type').options[document.getElementById('ledger_type').selectedIndex].text;
            //     var purchaseDate = document.getElementById('purchaseDate').value;
            //     var officeType = document.getElementById('pur_unit_type').options[document.getElementById('pur_unit_type').selectedIndex].text;
            //     var office = document.getElementById('pur_units').options[document.getElementById('pur_units').selectedIndex].text;
            //     var ledgerNo = document.getElementById('ledger_no').value;
            //     var purchaseCompany = document.getElementById('supplier_id').options[document.getElementById('supplier_id').selectedIndex].text;
            //     var invoiceNo = document.getElementById('invoiceNo').value;
            //     var unitPrice = document.getElementById('uPrice').value;

            // Store the values in sessionStorage
            sessionStorage.setItem('itemName', itemName);
            sessionStorage.setItem('quantity', quantity);
            {{--// Other session values--}}
            {{--sessionStorage.setItem('itemCategory', itemCategory);--}}
            {{--sessionStorage.setItem('itemSubCategory', itemSubCategory);--}}
            {{--sessionStorage.setItem('itemMainStoreType', itemMainStoreType);--}}
            {{--sessionStorage.setItem('purchaseDate', purchaseDate);--}}
            {{--sessionStorage.setItem('officeType', officeType);--}}
            {{--sessionStorage.setItem('office', office);--}}
            {{--sessionStorage.setItem('ledgerNo', ledgerNo);--}}
            {{--sessionStorage.setItem('purchaseCompany', purchaseCompany);--}}
            {{--sessionStorage.setItem('invoiceNo', invoiceNo);--}}
            {{--sessionStorage.setItem('unitPrice', unitPrice);--}}

            {{--console.log(sessionStorage);--}}

            // Send POST request using AJAX to store the data
            $.ajax({
            url: "{{ route('PurchasingItem.store') }}", // Change this to your route for saving data
            type: 'POST',
            data: {
            _token: '{{ csrf_token() }}', // Include CSRF token
            itemName: itemName,
            quantity: quantity,
            {{--itemCategory: itemCategory,--}}
            {{--itemSubCategory: itemSubCategory,--}}
            {{--itemMainStoreType: itemMainStoreType,--}}
            {{--purchaseDate: purchaseDate,--}}
            {{--officeType: officeType,--}}
            {{--office: office,--}}
            {{--ledgerNo: ledgerNo,--}}
            {{--purchaseCompany: purchaseCompany,--}}
            {{--invoiceNo: invoiceNo,--}}
            {{--unitPrice: unitPrice,--}}
            },

            {{--success: function(response) {--}}
            {{--console.log('Data saved successfully:', response);--}}

            {{--// Check if the response indicates success--}}
            {{--if (response && response.success) {--}}
            {{--console.log('Data saved successfully');--}}

            {{--// Redirect to the next page or perform other actions as needed--}}
            {{--window.location.href = "form_add_item_details";--}}
            {{--} else {--}}
            {{--// Handle the case where the save operation was not successful--}}
            {{--console.log('Save operation failed:', response.message);--}}
            {{--// Display an error message or take appropriate action--}}
            {{--}--}}
            {{--},--}}
            {{--error: function(xhr, status, error) {--}}
            {{--console.log('Error saving data:', error);--}}
            {{--}--}}
            {{--});--}}
            {{--} else {--}}
            {{--document.getElementById('FormPurchasingItemId').submit();--}}
            });
        }


    </script>





    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Purchasing Item</h5>
                    <div class="card-body container-fluid">
                        <form id="FormPurchasingItemId" method="post" action="{{route('PurchasingItem.store')}}">
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
                                    <select name="inv_item_id" id="inv_item_id" class="form-control" required>

                                        <option value="">Select Item</option>
                                    </select>
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

                            <div class="input-field">
                                <label>Purchase Date :</label>
                                <div class="col-md-12">
                                    <input type="date" name="purchaseDate" id="purchaseDate" class="form-control" data-bs-placement="right" required>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Purchase Office Type :</label>
                                <div class="col-md-12">
                                    <select name="pur_unit_type" id="pur_unit_type" class="form-control" onchange="getOrgUnit(this.value)" required>

                                        @foreach( $unitTypes as $unitType)
                                            <option value="{{$unitType->id}}">{{$unitType->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Purchase Office:</label>
                                <div class="col-md-12">
                                    <select name="pur_units" id="pur_units" class="form-control" required>
                                        <option value="">Select Purchase Office</option>
                                    </select>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Office Ledger Number:</label>
                                <div class="col-md-12">
                                    <input type="text" id="ledger_no" name="ledger_no" class="form-control">
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Purchased Company:</label>
                                <div class="col-md-12">
                                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                                        @foreach( $suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Invoice No:</label>
                                <div class="col-md-12">
                                    <input type="text" id="invoiceNo" name="invoiceNo" class="form-control" required>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Quantity:</label>
                                <div class="col-md-12">
                                    <input type="number" id="quantity" name="quantity" class="form-control" required>
                                </div>
                            </div>

                            <div class="input-field">
                                <label>Unit Price:</label>
                                <div class="col-md-12">
                                    <input type="text" id="uPrice" name="uPrice" class="form-control" required>
                                </div>
                            </div>

                            <div class="p-2">
                                <button type="submit" class="btn btn-primary mb-2" id="btnAdd" onclick="getSaveOrNext()">Save</button>

                            </div>


                        </form>

                    </div>
                </div>

            </div>
            <div class="col-md-3"></div>
        </div>


    </div>

@endsection