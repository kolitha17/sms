@extends('layouts.app')

@section('content')

    <script>
        {{--Design for Data Table--}}
        $(document).ready( function () {
            // $('#regUserTable').DataTable();
            new DataTable('#regUserTable');
        } );



        <!-- JavaScript to update badge class -->

        // Replace this with your actual logic to get the status
        const status = document.getElementById('status').innerText;

        // Get the badge element
        const badge = document.getElementsByClassName('badge');

        // Remove existing classes
        badge.classList.remove('badge-awaiting', 'badge-active', 'badge-deactive');

        // Add the appropriate class based on the status
        if (status === 'Awaiting') {
            badge.classList.add('badge-awaiting');
        } else if (status === 'Active') {
            badge.classList.add('badge-active');
        } else if (status === 'Deactive') {
            badge.classList.add('badge-deactive');
        }
    </script>

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title mt-2">Registered Users</h4>
                    </header>
                    <article class="card-body">
                        
                            

                            <table id="regUserTable" class="table table-striped" style="width:100%">
                                <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Emp No</th>
                                    <th>Designation</th>
                                    <th>Office/Branch</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                        <td>{{$user->full_name}}</td>
                                        <td>{{$user->emp_no}}</td>
                                        <td>{{$user->designation_id}}</td>
                                        <td>{{$user->orgUnit->name}}</td>
                                        <td id="status"><span class="badge @if($user->available_status == 'Awaiting') badge-awaiting bg-warning
                                                            @elseif($user->available_status == 'Active') badge-active badge-color: #19f2cf;
                                                            @elseif($user->available_status == 'Deactive') badge-deactive  badge-color: #ff9cc9;
                                                            @endif rounded-pill text-dark">
                                            {{$user->available_status}}</span></td>
                                    </tr>
                                    
                                @endforeach
                                
                                </tbody>
                                
                            </table>
                            <!-- Pagination Links -->
                        {{ $users->links() }}
                        
                        
                    </article>

                </div>
            </div>

        </div>


    </div>

@endsection

@push('css')
    <!-- Add this to your HTML/Blade file -->
    <style>
        .badge-awaiting {
            /* Define styles for Awaiting status */
            background-color: #e4ff0e;
        }

        .badge-active {
            /* Define styles for Active status */
            background-color: #19f2cf;
        }

        .badge-deactive {
            /* Define styles for Deactive status */
            background-color: #ff9cc9;
        }
    </style>
    @endpush


