@push('css')
<style>
.divider:after,.divider:before {
content: "";
flex: 1;
height: 1px;
background: #eee;
}
.h-custom {
height: calc(100% - 73px);
}
@media (max-width: 450px) {
.h-custom {
height: 100%;
}
}
</style>

@endpush

@extends('layouts.registration')

@section('content')


<div class="container-fluid h-custom">
  <div class="row d-flex justify-content-center align-items-center h-100">
    <!-- Left column for the image -->
    <div class="col-md-6 col-lg-6 col-xl-5 d-none d-md-block">
      <img src="https://www.itarian.com/images/ticketing/ticket-management-system.png"
           class="img-fluid" alt="Sample image">
    </div>
    
    <!-- Right column for the form -->
    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
      <h1><i class="fa-solid fa-cubes-stacked fa-fade" style="color: #be1e13; font-size: 50px;"></i> Stock Management System</h1>
      <div class="form-container">
        <form action="/login-user" method="POST">
          @csrf
            <!-- Sign in text -->
            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
              <h4 class="lead fw-normal mb-0 me-3">Sign in</h4>
            </div>

            <div class="divider d-flex align-items-center my-4"></div>

            <!-- Email input -->
            <div class="form-outline mb-4">
              <label class="form-label" for="form3Example3">Email address</label>
              <input type="text" id="loginusername" name="loginusername" class="form-control form-control-lg" placeholder="Enter a valid email address"  />
              
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
              <label class="form-label" for="form3Example4">Password</label>
              <input type="password" id="loginpassword" name="loginpassword" class="form-control form-control-lg" placeholder="Enter password"  />
              
            </div>

            <!-- Remember me and Forgot password -->
            <div class="d-flex justify-content-between align-items-center">
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                  Remember me
                </label>
              </div>
              <a href="#!" class="text-body">Forgot password?</a>
            </div>

            <!-- Submit button -->
            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" class="btn btn-info btn-lg"
                      style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="user_registration"
                  class="link-success">Register</a></p>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
