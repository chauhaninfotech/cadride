<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-question-circle"></i> Query
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
                    <form method="GET" action="">
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" name="pincode" class="form-control" placeholder="Search Registration code" value="">
        </div>
        <div class="col-md-4">
            <input type="number" name="status" class="form-control" placeholder="Status e.g 0,1" value="">
        </div>

        
        <div class="col-md-4">
            <button class="btn btn-gradient-success btn-fw">Search</button>
            <a href="https://partner.dyementor.com/registrationcode-list" class="btn btn-gradient-dark btn-fw">Reset</a>
        </div>
    </div>
</form>

                    <hr>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Name </th>
                          <th> Status </th>
                        </tr>
                      </thead>
                      <tbody>
                                                
                            <tr>
                                <td>1</td>
                                <td>4TUH1UXBA</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>2</td>
                                <td>NTAISQIXM</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>3</td>
                                <td>5VJ27QS6U</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>4</td>
                                <td>119MI87MR</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>5</td>
                                <td>WJL6HTGDZ</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>6</td>
                                <td>EZOOYULHP</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>7</td>
                                <td>HV4O4C9ID</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>8</td>
                                <td>YAP0IS804</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>9</td>
                                <td>US0YW8P0B</td>
                                
                                <td>
                                    <label class="badge badge-success">Approved</label>
                                
                                </td>
                                
                            </tr>
                       
                            <tr>
                                <td>10</td>
                                <td>7XX0T1P9D</td>
                                
                                <td>
                                    <label class="badge badge-danger">Inactive</label>
                                
                                </td>
                                
                            </tr>
                                               
                      </tbody>
                    </table>
                    <!-- Pagination links -->
                    <nav>
        <ul class="pagination">
            
                            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                    <span class="page-link" aria-hidden="true">‹</span>
                </li>
            
            
                            
                
                
                                                                                        <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=2">2</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=3">3</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=4">4</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=5">5</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=6">6</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=7">7</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=8">8</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=9">9</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=10">10</a></li>
                                                                                        
                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                
                
                                            
                
                
                                                                                        <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=500">500</a></li>
                                                                                                <li class="page-item"><a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=501">501</a></li>
                                                                        
            
                            <li class="page-item">
                    <a class="page-link" href="https://partner.dyementor.com/registrationcode-list?page=2" rel="next" aria-label="Next »">›</a>
                </li>
                    </ul>
    </nav>

                  </div>
                </div>
              </div>
    </div>
</x-app-layout>