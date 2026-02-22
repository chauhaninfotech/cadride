<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-map-marker"></i> Add Subpoint
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
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary"><a href="{{ route('subpoints') }}" style="color: white; text-decoration: none;">Back to Subpoints</a></button>
                    </div>
                    <form method="POST" action="{{ route('subpoints.post') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_id">City Name</label>
                                    <select class="form-control form-select" id="city_id" name="city_id" required>
                                        <option value="" disabled selected>Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subpoint_name">Subpoint Name</label>
                                <input type="text" class="form-control" id="subpoint_name" name="subpoint_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control form-select" id="status" name="status" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add Subpoint</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
    </div>
</x-app-layout>