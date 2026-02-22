<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-building"></i> City Update
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
                        <button type="button" class="btn btn-secondary"><a href="{{ route('cities') }}" style="color: white; text-decoration: none;">Back to Cities</a></button>
                    </div>
                    <form action="{{ route('city.update', $city->id) }}" method="POST">
                        @csrf
                      
                        <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="city_name">City Name</label>
                                <input type="text" class="form-control" id="city_name" name="city_name" value="{{ $city->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control form-select" id="status" name="status" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option {{ $city->status == '1' ? 'selected' : '' }} value="1">Active</option>
                                    <option {{ $city->status == '0' ? 'selected' : '' }} value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <input type="hidden" name="id" value="{{ $city->id }}">
                                <button type="submit" class="btn btn-primary">Update City</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
    </div>
</x-app-layout>