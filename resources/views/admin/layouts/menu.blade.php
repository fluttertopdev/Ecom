<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{url('admin/dashboard')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">




          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
            fill="#7367F0" />
          <path
            opacity="0.06"
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
            fill="#161616" />
          <path
            opacity="0.06"
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
            fill="#161616" />
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
            fill="#7367F0" />
        </svg>
      </span>
      <span class="app-brand-text demo menu-text fw-bold">{{Auth::user()->name}}</span>
    </a>


    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item {{ Request::url() == url('admin/dashboard') ? 'active' : '' }}">
        <a href="{{url('admin/dashboard')}}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="{{__('lang.admin_menu_dashboard')}}">{{__('lang.admin_menu_dashboard')}}</div>
        </a>
      </li>

     


       

    

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Products">Products</span>
      </li>

      <li class="menu-item {{(Request::is('admin/sellers-products*') || Request::is('admin/products*')|| Request::is('admin/category*') || Request::is('admin/product-create*')|| Request::is('admin/*coupon')|| Request::is('admin/subcategory*')|| Request::is('admin/attributes*')|| Request::is('admin/brand*') || Request::is('admin/update-products*')) ? 'active open' : ''}}" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="tf-icons ti ti-box"></i>
          <div data-i18n="Products"> Products</div>
          <div class="badge bg-primary rounded-pill ms-auto"></div>
        </a>
        <ul class="menu-sub">
             <!--order -->
         
            <li class="menu-item  {{Request::is('admin/products*') ? 'active' : ''}}">
              <a href="{{url('admin/products')}}" class="menu-link">
                <div data-i18n="All Product">All Product</div>
              </a>
            </li>
    
              
            <li class="menu-item {{Request::is('admin/sellers-products*') ? 'active' : ''}}">
              <a href="{{url('admin/sellers-products')}}" class="menu-link">
                <div data-i18n="Sellers Product">Sellers Product</div>
              </a>
            </li>

               <li class="menu-item {{Request::is('admin/category*') ? 'active' : ''}}">
              <a href="{{url('admin/category')}}" class="menu-link">
                <div data-i18n="Main Category">Main Category</div>
              </a>
            </li>
            
            <li class="menu-item {{Request::is('admin/subcategory*') ? 'active' : ''}}">
              <a href="{{url('admin/subcategory')}}" class="menu-link">
                <div data-i18n="{{__('lang.admin_subcategory_list')}}">{{__('lang.admin_subcategory_list')}}</div>
              </a>
            </li>
              
         
               <li class="menu-item {{Request::is('admin/brand*') ? 'active' : ''}}">
              <a href="{{url('admin/brand')}}" class="menu-link">
                <div data-i18n="Brands">Brands</div>
              </a>
            </li>
            

               <li class="menu-item {{Request::is('admin/attributes*') ? 'active' : ''}}">
              <a href="{{url('admin/attributes')}}" class="menu-link">
                <div data-i18n="Attributes">Attributes</div>
              </a>
            </li>
               
            
              <li class="menu-item {{Request::is('admin/coupon*') ? 'active' : ''}}">
              <a href="{{url('admin/coupon')}}" class="menu-link">
                <div data-i18n="Coupns">Coupns</div>
              </a>
            </li>

              
            
           
             

           
       
        </ul>
      </li>



  
        <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Orders">Orders</span>
      </li>
     
       <!--Order -->
      <li class="menu-item {{(Request::is('admin/all-orders*') || Request::is('admin/inhouse-orders*') || Request::is('admin/sellers-orders*') || Request::is('admin/delivered-orders*'))  ? 'active open' : ''}} " style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
          <div data-i18n="Orders"> Orders</div>
          <div class="badge bg-primary rounded-pill ms-auto"></div>
        </a>
        <ul class="menu-sub">
             <!--order -->
          
           

             <li class="menu-item {{Request::is('admin/all-orders*') ? 'active' : ''}}">
              <a href="{{url('admin/all-orders')}}" class="menu-link">
                <div data-i18n="All Orders">All Orders</div>
              </a>
            </li>
    
               <li class="menu-item {{Request::is('admin/inhouse-orders*') ? 'active' : ''}}">
              <a href="{{url('admin/inhouse-orders')}}" class="menu-link">
                <div data-i18n="Inhouse Orders">Inhouse Orders</div>
              </a>
            </li>
      
                 <li class="menu-item {{Request::is('admin/sellers-orders*') ? 'active' : ''}}">
              <a href="{{url('admin/sellers-orders')}}" class="menu-link">
                <div data-i18n="Sellers Orders">Sellers Orders</div>
              </a>
            </li>

                <li class="menu-item {{Request::is('admin/delivered-orders*') ? 'active' : ''}}">
              <a href="{{url('admin/delivered-orders')}}" class="menu-link">
                <div data-i18n="Delivered Orders">Delivered Orders</div>
              </a>
            </li>
    
          </ul>
      </li>
 
       
        <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Sellers">Sellers</span>
      </li>

      
      <li class="menu-item {{(Request::is('admin/all-sellers*')) ? 'active open' : ''}}" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="tf-icons ti ti-user"></i>
          <div data-i18n="Sellers">Sellers</div>
          <div class="badge bg-primary rounded-pill ms-auto"></div>
        </a>
        <ul class="menu-sub">
           

              <li class="menu-item {{Request::is('admin/all-sellers*') ? 'active' : ''}}">
              <a href="{{url('admin/all-sellers')}}" class="menu-link">
                <div data-i18n="All Sellers">All Sellers</div>
              </a>
            </li>
     </ul>
      </li>
   


        <!-- Disbursement management-->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Disbursement management">Disbursement management</span>
      </li>

      <li class="menu-item {{ Request::url() == url('admin/seller-disbursement') ? 'active' : '' }}">
        <a href="{{url('admin/seller-disbursement')}}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-wallet"></i>
          <div data-i18n="Disbursement">Disbursement</div>
        </a>
      </li>




 <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Refunds">Refunds</span>
      </li>

       
      <li class="menu-item {{ Request::url() == url('admin/refund-request') ? 'active' : '' }}" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="tf-icons ti ti-refresh"></i>
          <div data-i18n="Refunds"> Refunds</div>
          <div class="badge bg-primary rounded-pill ms-auto"></div>
        </a>
        <ul class="menu-sub">
             <!--order -->
          
            <li class="menu-item {{ Request::url() == url('admin/refund-request') ? 'active' : '' }}">
              <a href="{{url('admin/refund-request')}}" class="menu-link">
                <div data-i18n="Refund Request">Refund Request</div>
              </a>
            </li>
    
           
      

      <li class="menu-item {{ Request::url() == url('admin/approved-refund') ? 'active' : '' }}">
              <a href="{{url('admin/approved-refund')}}" class="menu-link">
                <div data-i18n="Approved Refund">Approved Refund</div>
              </a>
            </li>
            <li class="menu-item {{ Request::url() == url('admin/rejected-refund') ? 'active' : '' }}">
              <a href="{{url('admin/rejected-refund')}}" class="menu-link">
                <div data-i18n="Rejected Refund">Rejected Refund</div>
              </a>
            </li>
       </ul>
      </li>






 <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="CMS">CMS</span>
      </li>

       
      <li class="menu-item {{(Request::is('admin/cms*')) ? 'active open' : ''}}" style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-file"></i>
          <div data-i18n="CMS">CMS</div>
          <div class="badge bg-primary rounded-pill ms-auto"></div>
        </a>
        <ul class="menu-sub">
           
          

             <li class="menu-item {{Request::is('admin/cms*') ? 'active' : ''}}">
              <a href="{{url('admin/cms')}}" class="menu-link">
                <div data-i18n="CMS">CMS</div>
              </a>
            </li>


    
           
    

     </ul>
      </li>


    <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Marketing">Marketing</span>
      </li>

       
      <li class="menu-item {{(Request::is('admin/custom-notification*')) ? 'active open' : ''}} " style="">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="tf-icons ti ti-target"></i>
          <div data-i18n="Marketing">Marketing</div>
          <div class="badge bg-primary rounded-pill ms-auto"></div>
        </a>
        <ul class="menu-sub">
            
          
            
             <li class="menu-item {{Request::is('admin/custom-notification*') ? 'active' : ''}}">
              <a href="{{url('admin/custom-notification')}}" class="menu-link">
                <div data-i18n="Custom Notifications">Custom Notifications</div>
              </a>
            </li>
    </ul>
      </li>










 
<li class="menu-header small text-uppercase">
    <span class="menu-header-text" data-i18n="Home Page Management">Home Page Management</span>
</li>

<!-- Banner -->
<li class="menu-item {{(Request::is('admin/banner*') || Request::is('admin/home-icon*') || Request::is('admin/product-coustom-section*') || Request::is('admin/visibilities*'))  ? 'active open' : ''}}" style="">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
       <i class="tf-icons ti ti-home"></i>
        <div data-i18n="Home Page">Home Page</div>
        <div class="badge bg-primary rounded-pill ms-auto"></div>
    </a>
    <ul class="menu-sub">
        <!-- banner -->
      

        <li class="menu-item {{Request::is('admin/banner*') ? 'active' : ''}}">
              <a href="{{url('admin/banner')}}" class="menu-link">
                <div data-i18n="{{__('lang.admin_banner_list')}}">{{__('lang.admin_banner_list')}}</div>
              </a>
            </li>
      

          <li class="menu-item {{Request::is('admin/home-icon*') ? 'active' : ''}} ">
            <a href="{{ url('admin/home-icon') }}" class="menu-link">
                <div data-i18n="Icons">Icons</div>
            </a>
        </li>

         <li class="menu-item {{Request::is('admin/product-coustom-section*') ? 'active' : ''}} ">
            <a href="{{ url('admin/product-coustom-section') }}" class="menu-link">
                <div data-i18n="Custom Section">Custom Section</div>
            </a>
        </li>

         <li class="menu-item {{Request::is('admin/visibilities*') ? 'active' : ''}} ">
            <a href="{{ url('admin/visibilities') }}" class="menu-link">
                <div data-i18n="Visibilities">Visibilities</div>
            </a>
        </li>

       


       
    </ul>
</li>



   
       
    
     

           <!-- Banner Management-->

<li class="menu-header small text-uppercase">
    <span class="menu-header-text" data-i18n="{{__('lang.admin_roles_and_permissions')}}">{{__('lang.admin_roles_and_permissions')}}</span>
</li>

<!-- Banner -->
 <li class="menu-item {{ Request::url() == url('admin/role') ? 'active' : '' }}">
      <a href="{{url('admin/role')}}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-users"></i>
      <div data-i18n="{{__('lang.admin_roles_and_permissions')}}">{{__('lang.admin_roles_and_permissions')}}</div>
      </a>
      </li>

      

    


      <!--Deliveryman Management-->
  
      <li class="menu-header small text-uppercase">
       <span class="menu-header-text" data-i18n="{{__('lang.admin_deliveryman_management')}}">{{__('lang.admin_deliveryman_management')}}</span>
      </li>

    

     
      <li class="menu-item {{ Request::url() == url('admin/add-deliveryman') ? 'active' : '' }}">
       <a href="{{url('admin/add-deliveryman')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-plus"></i>
       <div data-i18n="{{__('lang.admin_add_deliveryman')}}">{{__('lang.admin_add_deliveryman')}}</div>
       </a>
      </li>
     

   
      <li class="menu-item {{ Request::url() == url('admin/deliveryman')? 'active' : '' }}">
      <a href="{{url('admin/deliveryman')}}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="{{__('lang.admin_deliveryman_list')}}">{{__('lang.admin_deliveryman_list')}}</div>
        </a>
      </li>
     

    

      

          
    
      

             <li class="menu-item {{(Request::is('admin/languages*') || Request::is('admin/translation*') || Request::is('admin/update-translation*')) ? 'active open' : ''}} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-language"></i>
                <div data-i18n="Localization">Localization</div>
                <div class="badge bg-label-primary rounded-pill ms-auto"></div>
            </a>
            <ul class="menu-sub">
              
                <li class="menu-item {{Request::is('admin/languages*') ? 'active' : ''}}">
                    <a href="{{url('admin/languages')}}" class="menu-link">
                    <div data-i18n="Languages">Languages</div>
                    </a>
                </li>
              
               
             
            </ul>
        </li>
      <!-- Setup & Configuations -->
      
      <li class="menu-item {{(Request::is('admin/settings/all-setting*') || Request::is('admin/tax-list*') || Request::is('admin/location*') || Request::is('admin/shipping-rate-type*') || Request::is('admin/carriers*')) ? 'active open' : ''}}" style="">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons ti ti-settings"></i>
       <div data-i18n="{{__('lang.admin_setting')}}">{{__('lang.admin_setting')}}</div>
      <div class="badge bg-primary rounded-pill ms-auto"></div>
     </a>
      <ul class="menu-sub">
      

   


                 <li class="menu-item {{Request::is('admin/settings/all-setting*') ? 'active' : ''}} ">
            <a href="{{ url('admin/settings/all-setting') }}" class="menu-link">
                <div data-i18n="{{__('lang.admin_all_settings')}}">{{__('lang.admin_all_settings')}}</div>
            </a>
        </li>

             <li class="menu-item {{Request::is('admin/tax-list*') ? 'active' : ''}} ">
            <a href="{{ url('admin/tax-list') }}" class="menu-link">
                <div data-i18n="Taxes">Taxes</div>
            </a>
        </li>

      
        <li class="menu-item {{Request::is('admin/location*') ? 'active' : ''}} ">
            <a href="{{ url('admin/location') }}" class="menu-link">
                <div data-i18n="Location">Location</div>
            </a>
        </li>

      <li class="menu-item {{Request::is('admin/shipping-rate-type*') ? 'active' : ''}} ">
            <a href="{{ url('admin/shipping-rate-type') }}" class="menu-link">
                <div data-i18n="Shipping Setting">Shipping Setting</div>
            </a>
        </li>
        
          <li class="menu-item {{Request::is('admin/currency*') ? 'active' : ''}} ">
            <a href="{{ url('admin/currency') }}" class="menu-link">
                <div data-i18n="Currency">Currency</div>
            </a>
        </li>
    
        <li class="menu-item {{Request::is('admin/carriers*') ? 'active' : ''}} ">
            <a href="{{ url('admin/carriers') }}" class="menu-link">
                <div data-i18n="Shipping carriers">Shipping carriers</div>
            </a>
        </li>
      
      
      </ul>
      </li>
      
    
      

   
  </ul>
</aside>
<!-- / Menu -->