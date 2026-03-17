<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-image"></i> Carousel Add
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
                        <button type="button" class="btn btn-secondary"><a href="{{ route('carousel.list') }}" style="color: white; text-decoration: none;">Back to Carousel</a></button>
                    </div>
                    <form method="POST" action="{{ route('carousel.add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control form-select" id="type" name="type" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="passenger">Passenger</option>
                                    <option value="rider">Rider</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort">Sort Order</label>
                                <input type="number" class="form-control" id="sort" name="sort" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="link">Page Url</label>
                                <input type="url" class="form-control" id="link" name="link" />
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="image_path">Image Upload*</label>
                                <input type="file" class="form-control" id="image_path" name="image_path" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control form-select" id="status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Add Carousel</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
    </div>
</x-app-layout>
