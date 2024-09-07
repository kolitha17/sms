@extends('layouts.app')

@section('content')

    <dody id="page-top">
        <div id="wrapper">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Stores Branch</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>

                {{--Content Row--}}

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Instrument & Drawing Items Ledger
                                </div>
                                <div class="card-body">

                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">View Instrument Ledger</a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Furniture Item Ledger Details
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-info">View Furniture Ledger</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-xl-6">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Office Equipments & Welfare Ledger Details
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-success">View Welfare Ledger</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Building Materials Ledger Details
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-warning">View Building Ledger</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-xl-6">
                        <div class="card border-left-secondary shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Perishable Stores Ledger Details
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-secondary">View Perishable Ledger</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="mr-2 row no-gutters align-items-center">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    User Request Confirmation
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-danger">View User Request</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </dody>

@endsection