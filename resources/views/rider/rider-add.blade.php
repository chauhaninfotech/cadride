<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-car"></i> Add Rider 
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

                <form method="POST" action="{{ route('rider.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="cst_sec">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" oninput="capitalizeWords(this)" class="form-control" id="fullname" name="fullname" required value="{{ old('fullname') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" oninput="smalleWords(this)" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <select style="width: 15%;display: inline-block;float:left; margin-top: 25px;padding: 16px;" class="form-control" name="country_code" id="country_code" required>
                                            <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>+1</option>
                                            <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>+91</option>
                                    </select>
                                    <input type="number" style="width: 85%; display: inline-block; float:left;" class="form-control" id="contact" name="contact" required value="{{ old('contact') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" onKeyup="initGoogle();" />
                                    
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" readonly class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" readonly class="form-control" id="city" name="city" value="{{ old('city') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" readonly class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" readonly class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_image">Profile Photo</label>
                                    <input type="file" class="form-control" id="user_image" name="user_image" />
                                    @if (old('user_image'))
                                        <img src="{{ asset('storage/' . old('user_image')) }}" alt="Profile Image" style="width: 100px; height: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="submit" class=" btn btn-primary">Add Rider</button>
                            </div>
                </div>
              </div>
    </div>
</x-app-layout>

