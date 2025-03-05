        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="ti ti-menu-2 ti-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <?php
                    $langList = \Helpers::getAllLangList();

                    if (Session()->has('seller_locale')) {
                        $langCode = Session()->get('seller_locale');
                    }
                    else {
                        $langCode = config('app.fallback_locale');
                    }
                ?>
             
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Language -->
                <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="ti ti-language rounded-circle ti-md"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      
                      
                       @if(count($langList)>0)
                        @foreach($langList as $langRow)
                    <li>
                      <a class="dropdown-item" href="{!! url('seller-setlang') !!}?lang={{$langRow->code}}" data-languages="{{$langRow->code}}">
                        <span class="align-middle">{{$langRow->name}}</span>
                      </a>
                    </li>
                  
                       @endforeach
                    @endif
                  
                  </ul>
                </li>
                <!--/ Language -->

            

              

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="">
                      <img src="{{ url('uploads/sellers/' . Auth::user()->image . '?type=sellers') }}" width="30px" height="30px;" style="object-fit: contain;" alt class="h-auto rounded-circle" onerror="this.onerror=null;this.src=`{{asset('uploads/no-avatar.png')}}`"/>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="">
                 <img src="{{ url('uploads/sellers/' . Auth::user()->image . '?type=sellers') }}" width="30px" height="30px;" style="object-fit: contain;" alt class="h-auto rounded-circle" onerror="this.onerror=null;this.src=`{{asset('uploads/no-avatar.png')}}`"/>
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-medium d-block">{{Auth::user()->name}}</span>
                            <small class="text-muted">{{Auth::user()->email}}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{url('/seller-profile')}}">
                        <i class="ti ti-user-check me-2 ti-sm"></i>
                        <span class="align-middle">{{__('lang.admin_my_profile')}}</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('seller.sellerslogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout me-2 ti-sm"></i>
                            <span class="align-middle">{{__('lang.admin_logout')}}</span>
                      </a>
                      <form id="logout-form" action="{{ route('seller.sellerslogout') }}" method="POST" class="d-none">
                            @csrf
                      </form>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>

            <!-- Search Small Screens -->
            <div class="navbar-search-wrapper search-input-wrapper d-none">
              <input
                type="text"
                class="form-control search-input container-xxl border-0"
                placeholder="Search..."
                aria-label="Search..." />
              <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
            </div>
          </nav>

          <!-- / Navbar -->