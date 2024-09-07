{{--this page add to layout   --}}
@extends('layouts.app')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

{{--identify the content form the layout--}}
@section('content')
    @include('pages.form_purchasing_item')
    @include('pages.form_add_item_details')

    <script>

        // load Item Name and Quantity into the Item Details Form

        $(document).ready(function() {
            $('#btnAdd').click(function() {
                var itemName = $('#inv_item_id').val();
                var quantity = $('#quantity').val();

                $.ajax({
                    url: '{{route('PurchasingForm.viewPurchaseForm')}}',
                    type: 'GET',
                    data: {
                        inv_item_id: itemName,
                        quantity: quantity
                    },
                    success: function(response) {
                        $('#itemNameDetails').val(response.inv_item_id);
                        $('#itemQuantityDetails').val(response.quantity);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });



    </script>

    @endsection