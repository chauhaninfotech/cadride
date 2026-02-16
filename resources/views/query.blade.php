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
                      <textarea class="form-control" id="query" name="pickup_address" rows="2" required></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                       <label for="pickup_zipcode">Pickup Zipcode</label>
                        <input type="text" class="form-control" id="pickup_zipcode" name="pickup_zipcode" readonly value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                       <label for="pickup_city">Pickup City</label>
                        <input type="text" class="form-control" id="pickup_city" name="pickup_city" readonly value="">
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="query">Dropoff Address</label>
                      <textarea class="form-control" id="query" name="dropoff_address" rows="2" required></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                       <label for="dropoff_zipcode">Dropoff Zipcode</label>
                        <input type="text" class="form-control" id="dropoff_zipcode" name="dropoff_zipcode" readonly value="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                       <label for="dropoff_city">Dropoff City</label>
                        <input type="text" class="form-control" id="dropoff_city" name="dropoff_city" readonly value="">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                  </form>
                </div>
              </div>
    </div>
</x-app-layout>