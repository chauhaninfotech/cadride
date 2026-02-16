<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-users"></i> Passenger List
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
        
    </div>
</x-app-layout>