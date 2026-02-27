<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-user"></i> Add Passenger 
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
        <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                <form method="POST" action="{{ route('passenger.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="cst_sec">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" oninput="capitalizeWords(this)" class="form-control" id="fullname" name="fullname" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" oninput="smalleWords(this)" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <select style="width: 15%;display: inline-block;float:left; margin-top: 25px;padding: 16px;" class="form-control" name="country_code" id="country_code" required>

                                            <option value="+1">+1</option>
                                            <option value="+91">+91</option>
                                    </select>
                                    <input type="number" style="width: 85%; display: inline-block; float:left;" class="form-control" id="contact" name="contact" required>
                                </div>
                            </div>
                         
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" onKeyup="initGoogle();" />
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" readonly class="form-control" id="postal_code" name="postal_code" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" readonly class="form-control" id="city" name="city" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" readonly class="form-control" id="latitude" name="latitude" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" readonly class="form-control" id="longitude" name="longitude" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_image">Profile Photo</label>
                                    <input type="file" class="form-control" id="user_image" name="user_image" />
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="submit" class=" btn btn-primary">Add Passenger</button>
                            </div>
                </div>
              </div>
    </div>
</x-app-layout>
