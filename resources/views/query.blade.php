<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-question-circle"></i> Address Check Query
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
<form method="POST" action="{{ route('query.check') }}">
                    @csrf
                    <div class="col-md-12">
                    <div class="form-group">
                      <label for="query">Pickup Address</label>
                      <input type="text" class="form-control" id="address" name="pickup_address" onKeyup="initGoogle();" value="{{ old('pickup_address') }}" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                       <label for="pickup_zipcode">Pickup Zipcode</label>
                        <input type="text" class="form-control" id="postal_code" name="pickup_postal_code" readonly value="{{ old('pickup_postal_code') }}">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                       <label for="pickup_city">Pickup City</label>
                        <input type="text" class="form-control" id="city" name="pickup_city" readonly value="{{ old('pickup_city') }}">
                      </div>
                    </div>
                    <input type="hidden" class="form-control" id="longitude" name="pickup_longitude" readonly value="{{ old('pickup_longitude') }}">
                        <input type="hidden" class="form-control" id="latitude" name="pickup_latitude" readonly value="{{ old('pickup_latitude') }}">
                      
                    
                    <div class="col-md-4 col-sm-12"> 
                      <div class="form-group">
                      <label for="pickup_longitude">Lat, Long</label>
                      <input class="form-control" type="text" id="latlong" name="pickup_latlong" value="{{ old('pickup_latlong') }}" />
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                                          @if(session('pickup_available_message'))
    <div class="alert alert-{{ session('pickup_available_status') ? 'success' : 'danger' }}">
        {{ session('pickup_available_message') }}
    </div>
@endif
                                          </div>
                  </div>
                  <hr>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="query">Dropoff Address</label>
                      <input type="text" class="form-control" id="address2" name="dropup_address" onKeyup="initGoogle2();" value="{{ old('dropup_address') }}" />
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                       <label for="dropoff_zipcode">Dropoff Zipcode</label>
                        <input type="text" class="form-control" id="postal_code2" name="dropup_postal_code" readonly value="{{ old('dropup_postal_code') }}">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                       <label for="dropoff_city">Dropoff City</label>
                        <input type="text" class="form-control" id="city2" name="dropup_city" readonly value="{{ old('dropup_city') }}">
                      </div>
                    </div>
                    <input type="hidden" class="form-control" id="longitude2" name="dropup_longitude" readonly value="{{ old('dropup_longitude') }}">
                        <input type="hidden" class="form-control" id="latitude2" name="dropup_latitude" readonly value="{{ old('dropup_latitude') }}">
                      

                    <div class="col-md-4 col-sm-4"> 
                      <div class="form-group">
                      <label for="dropoff_latlong">Lat, Long</label>
                      <input type="text" class="form-control" id="latlong2" name="dropup_latlong" readonly value="{{ old('dropup_latlong') }}">
                    </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 col-sm-12"> 
                           @if(session('dropup_available_message'))
    <div class="alert alert-{{ session('dropup_available_status') ? 'success' : 'danger' }}">
        {{ session('dropup_available_message') }}
    </div>
@endif        
										  </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                  </form>
                </div>
              </div>
    </div>
</x-app-layout>
@yield('script')
<script>
  function initGoogle2() {
        var input = document.getElementById('address2');
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
            document.getElementById('postal_code2').value = postalCode;
            document.getElementById('city2').value = city;
            document.getElementById('latitude2').value = place.geometry.location.lat();
            document.getElementById('longitude2').value = place.geometry.location.lng();
            document.getElementById('latlong2').value = place.geometry.location.lat() + ',' +  place.geometry.location.lng();
        });
    }
</script>