<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-home"></i> Dashboard
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span>HI! {{ Auth::user()->name }}</span>
                  </li>
                </ul>
              </nav>
            </div>
    </x-slot>

    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Passengers <i class="fa fa-users mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">500</h2>
                <h6 class="card-text">Total Passengers</h6>
                </div>
            </div>
        </div>
        
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Riders <i class="fa fa-car mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">1000</h2>
                    <h6 class="card-text">Total Riders</h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Booking <i class="fa fa-copy mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5">5000</h2>
                    <h6 class="card-text">Total Booking</h6>
                  </div>
                </div>
              </div>
    </div>
</x-app-layout>
