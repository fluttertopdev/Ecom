       </div>
       <!-- / Layout page -->
       </div>

       <!-- Overlay -->
       <div class="layout-overlay layout-menu-toggle"></div>

       <!-- Drag Target Area To SlideIn Menu On Small Screens -->
       <div class="drag-target"></div>
       </div>
       <!-- / Layout wrapper -->

       <!-- Core JS -->
       <!-- build:js assets/vendor/js/core.js -->

       <script src="{{asset('/assets/vendor/libs/jquery/jquery.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/popper/popper.js')}}"></script>
       <script src="{{asset('/assets/vendor/js/bootstrap.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/node-waves/node-waves.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/hammer/hammer.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/i18n/i18n.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
       <script src="{{asset('/assets/vendor/js/menu.js')}}"></script>

       <!-- endbuild -->

       <!-- Dashboard Vendors JS -->
       <script src="{{asset('/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
       <!-- Account Vendors JS -->
       <script src="{{asset('/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/select2/select2.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/@form-validation/popular.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/@form-validation/auto-focus.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/cleavejs/cleave.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
       <!-- list table -->
       <script src="{{asset('/assets/vendor/libs/quill/katex.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/quill/quill.js')}}"></script>

       <!-- by pawan -->
       <script src="{{asset('/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

       <!-- date -->
       <script src="{{asset('/assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js')}}"></script>
       <script src="{{asset('/assets/vendor/libs/pickr/pickr.js')}}"></script>


       <!-- toastr -->
       <script src="{{asset('/assets/vendor/libs/toastr/toastr.js')}}"></script>

       <!-- account page -->
       <script src="{{asset('/assets/js/pages-account-settings-account.js')}}"></script>

       <!-- sweet alert 2 -->
       <script src="{{asset('/assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

       <!-- popover -->
       <script src="{{asset('/assets/js/ui-popover.js')}}"></script>

       <!-- Main JS -->
       <script src="{{asset('/assets/js/main.js')}}"></script>

       <!-- Page JS -->
       <script src="{{asset('/assets/js/app-ecommerce-dashboard.js')}}"></script>

       <script src="{{asset('/assets/js/ckeditor.js')}}"></script>

       <script src="{{asset('/assets/js/extended-ui-sweetalert2.js')}}"></script>
       
       <!-- form wizard js -->
        @if (Request::is('admin/view-deliveryman/*'))
        <script src="{{asset('/assets/js/form-wizard-numbered.js')}}"></script>
        @endif
       <!-- form wizard js -->
       <script src="{{asset('/assets/js/form-wizard-validation.js')}}"></script>

       <script src="{{asset('/assets/js/forms-pickers.js')}}"></script>

  </body>
</html>
