<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-shield"></i> Term of Services
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
        <div class="col-md-12 stretch-card grid-margin">
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

                    <form action="{{ route('term-services.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label style="font-size: 18px;" for="passenger_message">Passenger Term of Services Content</label>
                            <textarea class="form-control" id="passenger_message" name="passenger_message" rows="10">{{ $data->passenger_message ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;" for="driver_message">Rider Term of Services Content</label>
                            <textarea class="form-control" id="driver_message" name="driver_message" rows="10">{{ $data->driver_message ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control form-select" required id="action" name="action">
                                <option value="" disabled selected>Select Action</option>
                                <option value="add">Add</option>
                                <option value="update">Update</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
                        <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@yield('script')
<!-- Free TinyMCE CDN without an API key -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js"></script>

<script>
        tinymce.init({
            selector: '#driver_message', // This links to your textarea
            plugins: 'colorpicker', // Enable color picker for font color and background color
            toolbar: [
                'undo redo | bold italic underline | forecolor backcolor | alignleft aligncenter alignright | link'
            ],
            toolbar_mode: 'floating', // Optional, floating toolbar when scrolling
        });
        tinymce.init({
            selector: '#passenger_message', // This links to your textarea
            plugins: 'colorpicker', // Enable color picker for font color and background color
            toolbar: [
                'undo redo | bold italic underline | forecolor backcolor | alignleft aligncenter alignright | link'
            ],
            toolbar_mode: 'floating', // Optional, floating toolbar when scrolling
        });
</script>