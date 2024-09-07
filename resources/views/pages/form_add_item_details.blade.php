{{--this page add to layout   --}}
@extends('layouts.app')

{{--identify the content form the layout--}}
@section('content')



    <script>

        var addedCombinations = []; // Array to store added combinations of model and serial number
        {{--Show Items Details when Add Button Click--}}
        function addItem() {

            //preventDefault for default submission and page refresh of the form
            event.preventDefault();


            // Add input fields dynamically using JavaScript
            const dynamicItems = document.getElementById('dynamic_items');
            const newItem = document.createElement('tr');
            var model = document.getElementById('model').value;
            var serialNo = document.getElementById('serial_no').value;
            var quantity = document.getElementById('itemQuantityDetails').value;
            var rowCount = dynamicItems.getElementsByTagName('tr').length; // Get the current number of rows


            function checkMaxRows() {
                var addButton = document.getElementById('btnAdd');
                addButton.disabled = rowCount >= quantity;
            }

            //Check duplicates
            function combinationExists(model, serialNo) {
                return addedCombinations.some(function(item) {
                    return item.model === model && item.serialNo === serialNo;

                });
            }

            if (model !=='' && serialNo !==''){
                if(combinationExists(model,serialNo)){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "Info",
                        title: "Can't add Duplicate values"
                    });
                }else{
                    newItem.innerHTML = `

                    <td><input type="text" class="form-control model_input" name="model_input" readonly></td>
                    <td><input type="text" class="form-control serialNo_input" name="serialNo_input" readonly></td>
                    <td><button class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button></td>

            `;

                }

                // Set the value of category variable into the category_input td
                newItem.querySelector('.model_input').value = model;
                newItem.querySelector('.serialNo_input').value = serialNo;

                dynamicItems.appendChild(newItem);
                rowCount++;
                addedCombinations.push({ model: model, serialNo: serialNo }); // Add the combination to the list
                checkMaxRows();


            }



            // Add event listener to the delete button
            const deleteButton = newItem.querySelector('.btn-danger');
            deleteButton.addEventListener('click', function() {
                dynamicItems.removeChild(newItem); // Remove the row when delete button is clicked
                rowCount--;

                // Remove the combination from the list
                addedCombinations = addedCombinations.filter(function(item) {
                    return !(item.model === model && item.serialNo === serialNo);
                });
                checkMaxRows();
            });


            {{--For Delete Button in the Table Data--}}
            // function deleteRow(btn) {
            //     var row = btn.parentNode.parentNode; // Get the row
            //     row.parentNode.removeChild(row); // Remove the row
            // }

        }



        {{--Save Item Details--}}
        // function saveItems() {
        //     // var btnSave = document.getElementById('btnSave').submit();
        //     console.log('Saved Succcefully');
        //
        // }


    </script>



    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header">Item Details Form</h5>
                    <div class="card-body">
                        <form method="post" action="{{ route('PurchasingItem.saveItemDetails') }}">
                            @csrf
                            <div class="input-field" >
                                <label for="itemNameDetails">Item Name:</label>
                                {{--load combo list--}}
                                <div class="col-md-12">
                                    <input type="text" id="itemNameDetails" name="itemNameDtails" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="input-field">
                                <label for="itemQuantityDetails">Quantity:</label>
                                <div class="col-md-12">
                                    <input type="text" id="itemQuantityDetails" name="itemQuantityDetails" class="form-control" readonly>
                                </div>
                            </div>




                            <div class="card mt-4 shadow">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                <label for="sub_category_id">Model:</label>
                                <div class="col-md-12">
                                    <input type="text" id="model" name="model" class="form-control">
                                </div>
                                </div>

                                <div>
                                <label for="sub_category_id">Serial Number:</label>
                                <div class="col-md-12">
                                    <input type="text" id="serial_no" name="serial_no" class="form-control">
                                </div>
                                </div>

                            </div>


                                <div class="p-2 d-flex justify-content-between">
                                    <button type="button" class="btn btn-primary mb-2" id="btnBack" onclick=" ">Back</button>
                                <input type="submit" class="btn btn-primary mb-2" id="btnAdd" value="ADD" onclick="addItem()" >

                            </div>
                            </div>


                            <div class="card-body">

                                <table id="itemDetailsTable" class="table table-striped">

                                    <thead>
                                    <tr>
                                        <th>Model</th>
                                        <th>Serial Number</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="dynamic_items">

                                    </tbody>

                                </table>

                            </div>
                            {{--Save Models and Serial Numbers of the Items--}}
                            <input type="submit" class="btn btn-primary mb-2" id="btnSave" value="Save" >

                        </form>

                    </div>
                </div>

            </div>
            <div class="col-md-2"></div>
        </div>



        <script>
            {{--Set values to the Item Details form Item name and quantity--}}
            document.addEventListener("DOMContentLoaded", function() {
                // Retrieve the values from sessionStorage
                var itemName = sessionStorage.getItem('itemName');
                var quantity = sessionStorage.getItem('quantity');

                // Populate the input fields with the retrieved data
                document.getElementById('itemNameDetails').value = itemName;
                document.getElementById('itemQuantityDetails').value = quantity;


                // Add event listener to the "Back" button
                document.getElementById('btnBack').addEventListener('click', function() {
                    window.history.back(); // Go back to the previous page
                });
            });
        </script>


    </div>





@endsection

