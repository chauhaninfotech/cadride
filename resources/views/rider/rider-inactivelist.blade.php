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
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                                <th class="sno">#</th>
                                <th class="name">Name</th>
                                <th class="contact">Contact Number</th>
                                <th class="email">Email</th>
                                <th class="address">Address</th>
                                <th class="postal-code">Postal Code</th>
                                <th class="city">City</th>
                                <th class="subpoint">Subpoint</th>
                                <th class="status">Status</th>
                                </tr>
                        </thead>
                        <tbody>
                          @forelse($riders as $key => $rider)
                            <tr>
                                <td class="sno">{{ $key + 1 }}</td>
                                <td class="name">{{ $rider->fullname }} - {{ $rider->id }} <b><sub>( {{ $rider->subpoint }} )</sub></b></td>
                                
                              </td>
                                <td class="contact">{{ $rider->contact }}</td>
                                <td class="email">{{ $rider->email }}</td>
                                <td class="address">{{ $rider->address }}</td>
                                <td class="postal-code">{{ $rider->postal_code }}</td>
                                <td class="city">{{ $rider->city }}</td>
                                <td class="subpoint">{{ $rider->subpoint }}</td>
                                <td class="status">
                                    @if($rider->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @elseif($rider->status == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @elseif($rider->status == 2)
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                
                                <td class="actions">
                                    <a href="{{ route('rider.edit', ['id' => $rider->id]) }}"><i class="fa fa-edit"></i> </a>
                                    <br><a href="{{ route('rider.show', ['id' => $rider->id]) }}" ><i class="fa fa-eye"></i> </a>
                                    
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


  .card .card-body {
    padding: 40px 10px;
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
.table td{
    white-space: normal !important;
    line-height: 22px;
}
td.name {
    max-width: 200px;
}
td.contact {
    max-width: 150px;
}
td.email {
    max-width: 250px;
}
td.address {
    max-width: 300px;
}
td.postal-code {
    max-width: 100px;
}
td.city {
    max-width: 150px;
}
td.subpoint {
    max-width: 150px;
}
td.status{
    max-width: 100px;
}
td.actions {
    max-width: 100px;
} 
</style>