<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-car"></i> Update Rider 
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

                <form method="POST" action="{{ route('rider.update', $rider->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="cst_sec">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control form-select" id="status" name="status">
                                        <option value="1" {{ $rider->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $rider->status == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $rider->fullname }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $rider->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <select style="width: 15%;display: inline-block;float:left; margin-top: 25px;padding: 16px;" class="form-control" name="country_code" id="country_code" required>

                                            <option value="+1" {{ $rider->country_code == '+1' ? 'selected' : '' }}>+1</option>
                                            <option value="+91" {{ $rider->country_code == '+91' ? 'selected' : '' }}>+91</option>
                                    </select>
                                    <input type="number" style="width: 85%; display: inline-block; float:left;" class="form-control" id="contact" name="contact" value="{{ $rider->contact }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $rider->address }}" onKeyup="initGoogle();" />
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" readonly class="form-control" id="postal_code" name="postal_code" value="{{ $rider->postal_code }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" readonly class="form-control" id="city" name="city" value="{{ $rider->city }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" readonly class="form-control" id="latitude" name="latitude" value="{{ $rider->latitude }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" readonly class="form-control" id="longitude" name="longitude" value="{{ $rider   ->longitude }}" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_image">Profile Photo</label>
                                    <input type="file" class="form-control" id="user_image" name="user_image" />
                                    @if($rider->user_image)
                                        <img src="{{ asset('storage/' . $rider->user_image) }}" alt="Profile Image" style="width: 100px; height: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <input type="hidden" name="id" value="{{ $rider->id }}">
                                <button type="submit" class=" btn btn-primary">Update Rider</button>
                            </div>
                </div>
              </div>
    </div>
</x-app-layout>
    