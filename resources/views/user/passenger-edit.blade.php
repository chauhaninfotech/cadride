<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-user"></i> Update Passenger 
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

                <form method="POST" action="{{ route('passenger.update', $passenger->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="cst_sec">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control form-select" id="status" name="status">
                                        <option value="1" {{ $passenger->status == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $passenger->status == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $passenger->fullname }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $passenger->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" value="{{ $passenger->contact }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $passenger->address }}" />
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" readonly class="form-control" id="postal_code" name="postal_code" value="{{ $passenger->postal_code }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" readonly class="form-control" id="city" name="city" value="{{ $passenger->city }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" readonly class="form-control" id="latitude" name="latitude" value="{{ $passenger->latitude }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" readonly class="form-control" id="longitude" name="longitude" value="{{ $passenger->longitude }}" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_image">Profile Photo</label>
                                    <input type="file" class="form-control" id="user_image" name="user_image" />
                                    @if($passenger->user_image)
                                        <img src="{{ asset('storage/' . $passenger->user_image) }}" alt="Profile Image" style="width: 100px; height: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <input type="hidden" name="id" value="{{ $passenger->id }}">
                                <button type="submit" class=" btn btn-primary">Update Passenger</button>
                            </div>
                </div>
              </div>
    </div>
</x-app-layout>
@yield('script')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqDeI1dXB5eZnzzGcqepqwzqn9HYk2LzY&libraries=places&callback=initGoogle" async defer></script>
<script>
    function initGoogle() {
        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            var postalCode = '';
            var city = '';
            for (var i = 0; i < place.address_components.length; i++) {
                var component = place.address_components[i];
                if (component.types.includes('postal_code')) {
                    postalCode = component.long_name;
                }
                if (component.types.includes('locality')) {
                    city = component.long_name;
                }
            }
            document.getElementById('postal_code').value = postalCode;
            document.getElementById('city').value = city;
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
        });
    }
</script>