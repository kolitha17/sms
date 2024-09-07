@extends('layouts.app')

@section('content')

    <dody id="page-top">
        <div id="wrapper">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Surveyor</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>

                {{--Content Row--}}

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                View Ledger Details
                            </div>
                            <div class="card-body">

                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" class="btn btn-primary">Ledger</a>

                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Add Request for Stores Items
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" class="btn btn-info">Item Request</a>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stores Items Transfer
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" class="btn btn-warning">Item Transfer</a>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </dody>

@endsection