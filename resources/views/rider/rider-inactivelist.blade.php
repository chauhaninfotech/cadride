<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-user"></i> Inactive Rider List
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
                    <form method="GET" action="{{ url('rider-inactivelist') }}" class="mb-3">
                      <div class="row">
                        <div class="col-md-3" >
                          <div class="input-group">
                            <input type="number" name="id" class="form-control" placeholder="ID..." value="{{ request('id') }}">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="input-group">
                            <input type="text" name="name" class="form-control" placeholder="Rider Name..." value="{{ request('name') }}">
                          </div>
                       </div>
                       <div class="col-md-3" >
                          <div class="input-group">
                            <input type="number" name="contact" class="form-control" placeholder="Mobile Number..." value="{{ request('contact') }}">
                          </div>
                        </div>
                        
                        <div class="col-md-3" style="padding: 0px;">
                          <div class="input-group" style="float:left; width: 70px;">
                            <input type="number" style="padding:14px 8px;" name="perpage" class="form-control" placeholder="Per Page..." value="{{ request('perpage', Config::get('pagination.per_page')) }}">
                          </div>
                          <button type="submit" class="btn btn-primary">Search</button>
                          <a href="{{ url('rider-inactivelist') }}" style="padding: 14px 20px;" class="btn btn-secondary">Reset</a>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 200px;">Name</th>
                                <th style="width: 150px;">Contact Number</th>
                                <th style="width: 250px;">Email</th>
                                <th style="width: 300px;">Address</th>
                                <th style="width: 100px;">Postal Code</th>
                                <th style="width: 150px;">City</th>
                                <th style="width: 150px;">Subpoint</th>
                                <th style="width: 120px;">Status</th>
                                </tr>
                        </thead>
                        <tbody>
                          @forelse($riders as $key => $rider)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $rider->fullname }} - {{ $rider->id }} <b>{{ $rider->subpoint }}</b> 
                                
                              </td>
                                <td>{{ $rider->contact }}</td>
                                <td>{{ $rider->email }}</td>
                                <td>{{ $rider->address }}</td>
                                <td>{{ $rider->postal_code }}</td>
                                <td>{{ $rider->city }}</td>
                                <td>{{ $rider->subpoint }}</td>
                                <td>
                                    @if($rider->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @elseif($rider->status == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @elseif($rider->status == 2)
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <a href="{{ route('rider.edit', ['id' => $rider->id]) }}"><i class="fa fa-edit"></i> </a>
                                    <a href="{{ route('rider.show', ['id' => $rider->id]) }}" ><i class="fa fa-eye"></i> </a>
                                    
                                </td>
                               
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">No riders found.</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                    {{ $riders->links() }}
                  </div>
                </div>
              </div>  
    </div>
</x-app-layout>
@yield('script')
<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>

      .form-check.form-switch {
    min-height: auto;
    margin: 0px;
    margin-left: 20px;
}
.table td {
    word-wrap: break-word;
    overflow: hidden;
  }

  /* For longer text, truncate with ellipsis */
  .table td {
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .card .card-body {
    padding: 40px 10px;
}
</style>