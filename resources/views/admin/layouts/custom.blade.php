    <script>
    $(window).on('load', function() {




    @if(Session::has('success'))

    toastr['success']("{{ session('success') }}", {
    closeButton: true,
    tapToDismiss: false,
    rtl: isRtl
    });

    @endif

    @if(Session::has('error'))
    toastr['error']("{{ session('error') }}", {
    closeButton: true,
    tapToDismiss: false,
    rtl: isRtl
    });
    @endif

    @if(Session::has('info'))
    toastr.options = {
    "closeButton": true,
    "progressBar": true
    };
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options = {
    "closeButton": true,
    "progressBar": true
    };
    toastr.warning("{{ session('warning') }}");
    @endif

    });

    function showImagePreview(input_id,preview_id,width,height) {
    $('#'+input_id).on('change', function() {
    var file = this.files[0];
    var reader = new FileReader();
    reader.onload = function(event) {
    var img = new Image();
    img.onload = function() {
    $("#"+preview_id).removeClass('hide');
    $('#'+preview_id).attr('src', event.target.result);             
    };
    img.src = event.target.result;
    };
    reader.readAsDataURL(file);
    });
    }


    function showDeleteConfirmation(pagename , itemId) {
    Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
    customClass: {
    confirmButton: 'swal-confirm-button-class'
    }
    }).then((result) => {
    if (result.isConfirmed) {



    if(pagename == 'category'){
    window.location.href = "/admin/delete-category/" + itemId;
    }else if(pagename == 'subcategory'){
    window.location.href = "/admin/delete-subcategory/" + itemId;
    }else if(pagename == 'coupon'){
    window.location.href = "/admin/delete-coupon/" + itemId;
    }else if(pagename == 'customer'){
    window.location.href = "/admin/delete-customer/" + itemId;
    }else if(pagename == 'deliveryman'){
    window.location.href = "/admin/delete-deliveryman/" + itemId;
    }else if(pagename == 'banner'){
    window.location.href = "/admin/delete-banner/" + itemId;
    }else if(pagename == 'push-notification'){
    window.location.href = "/admin/delete-push-notification/" + itemId;
    }else if(pagename == 'role'){
    window.location.href = "/admin/delete-role/" + itemId;
    }
    else if(pagename == 'attribute'){
    window.location.href = "/admin/delete-attributes/" + itemId;
    }
    else if(pagename == 'attributevalue'){
    window.location.href = "/admin/delete-attributes-value/" + itemId;
    }
    else if(pagename == 'brand'){
    window.location.href = "/admin/delete-brand/" + itemId;
    }

    else if(pagename == 'product'){
    window.location.href = "/admin/delete-product/" + itemId;
    }
    else if(pagename == 'sellers'){
    window.location.href = "/admin/delete-sellers/" + itemId;
    }

    else if(pagename == 'tax'){
    window.location.href = "/admin/delete-tax/" + itemId;
    }

    else if(pagename == 'shipping'){
    window.location.href = "/admin/delete-shipping/" + itemId;
    }

    else if(pagename == 'carriers'){
    window.location.href = "/admin/delete-carriers/" + itemId;
    }

    else if(pagename == 'coupon'){
    window.location.href = "/admin/delete-coupon/" + itemId;
    }
    else if(pagename == 'coustonnotifications'){
    window.location.href = "/admin/delete-noti/" + itemId;
    }
    else if(pagename == 'coustomsection'){
    window.location.href = "/admin/delete-coustom-section/" + itemId;
    }
    else if(pagename == 'deleteadminorder'){
    window.location.href = "/admin/admin-delete-order/" + itemId;
    }

    else if(pagename == 'cms'){
    window.location.href = "/admin/admin-cms-destroy/" + itemId;
    }
    else if(pagename == 'visibilities'){
    window.location.href = "/admin/visibilities-destroy/" + itemId;
    }
      else if(pagename == 'currency'){
    window.location.href = "/admin/delete-currency/" + itemId;
    }



    }

    });
    }

    </script>

    <script type="text/javascript">
    function selectAllSameData(source_class, des_class) {
    var sourceChecked = $("." + source_class + ":checked").length > 0;

    if (sourceChecked) {
    $("." + des_class).prop("checked", true);
    } else {
    $("." + des_class).prop("checked", false);
    }
    }
    </script>

    <!-- Category Bulk Export -->
    <script type="text/javascript">
    $(document).on('change','.export_select_tag',function(){
    var val = $(this).val();
    if(val == 'date_wise'){
    $('.id_wise_input').css('display','none');
    $('.date_wise_input').css('display','block');
    }else if(val == 'id_wise'){
    $('.date_wise_input').css('display','none');
    $('.id_wise_input').css('display','block');
    }else{
    $('.date_wise_input').css('display','none');
    $('.id_wise_input').css('display','none');
    }
    });
    </script>

    <!-- ckeditor -->
    <script type="text/javascript">
    ClassicEditor
    .create(document.querySelector('#editor'), {
    minHeight: '300px'
    })
    .then(editor => {
    editorInstance = editor;
    const prefilledValue = document.getElementById('seo_description').value;
    editor.setData(prefilledValue);
    // Set the prefilled value on keyup event
    editor.model.document.on('change', () => {
    const updatedValue = editor.getData();
    var stripedHtml = updatedValue.replace(/<[^>]+>/g, '');
    document.getElementById('seo_description').value = stripedHtml;
    });
    }).catch(error => {
    console.log(error);
    });
    </script>

    <!-- ckeditor -->
    <script type="text/javascript">
    ClassicEditor
    .create(document.querySelector('#shorteditor'), {
    minHeight: '300px'
    })
    .then(editor => {
    editorInstance = editor;
    const prefilledValue = document.getElementById('seo_description').value;
    editor.setData(prefilledValue);
    // Set the prefilled value on keyup event
    editor.model.document.on('change', () => {
    const updatedValue = editor.getData();
    var stripedHtml = updatedValue.replace(/<[^>]+>/g, '');
    document.getElementById('seo_description').value = stripedHtml;
    });
    }).catch(error => {
    console.log(error);
    });
    </script>

    <!-- image preview -->
    <script type="text/javascript">
    function readURL(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
    $('#imagePreview').hide();
    $('#imagePreview').fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
    }
    }
    $("#imageUpload").change(function() {
    readURL(this);
    });


    function readURLTwo(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
    $('#imagePreviewTwo').css('background-image', 'url('+e.target.result +')');
    $('#imagePreviewTwo').hide();
    $('#imagePreviewTwo').fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
    }
    }
    $("#imageUploadTwo").change(function() {
    readURLTwo(this);
    });


    function readURLThree(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
    $('#imagePreviewThree').css('background-image', 'url('+e.target.result +')');
    $('#imagePreviewThree').hide();
    $('#imagePreviewThree').fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
    }
    }
    $("#imageUploadThree").change(function() {
    readURLThree(this);
    });
    </script>

    <!-- subcategory by category -->
    <script type="text/javascript">
    var base_url = "{{ url('/admin/get-subcategory') }}";

    function showSubCategory(category_id, subcategory_html_body) {
    var category_id = $('.' + category_id).val();

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $.ajax({
    url: base_url,
    type: 'POST',
    data: { category_id: category_id },
    dataType: 'json',
    success: function (response) {
    if (response.status) {
    $('.' + subcategory_html_body).html(response.data);
    } else {
    myToastr(response.message, 'error');
    }
    },
    error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the error for debugging
    }
    });
    }
    </script>

    <!-- lat long by area -->
    <script type="text/javascript">
    var base_url = "{{ url('/admin/get-latlongByArea') }}";

    function showLatLong(area_id,latitude_id,longitude_id) {
    var area_id = $('.' + area_id).val();

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $.ajax({
    url: base_url,
    type: 'POST',
    data: { area_id: area_id },
    dataType: 'json',
    success: function (response) {
    if (response.status) {
    $('#' + latitude_id).val(response.data.latitude);
    $('#' + longitude_id).val(response.data.longitude);
    } else {
    myToastr(response.message, 'error');
    }
    },
    error: function (xhr, status, error) {
    console.error(xhr.responseText); // Log the error for debugging
    }
    });
    }
    </script>

    <!-- enable  disbale input of coupon by discount type -->
    <script type="text/javascript">
    $(document).on('change', '.check_discount_type', function() {
    var discount_type = $(this).val();
    if (discount_type == 'amount') {
    $('.max_discount_cls').prop('readonly', true);
    } else {
    $('.max_discount_cls').prop('readonly', false);
    }
    });
    $(window).on('load', function() {
    $('.check_discount_type').trigger('change');
    });
    </script>

    <script type="text/javascript">
    $(document).on('click','.click_cls_pos_user',function(){
    var type = $(this).val();

    if(type == 'existing'){
    $('.customer_form_pos').addClass('pos_section_hide');
    $('.custome_dropdown_select').removeClass('pos_section_hide');
    }else{
    $('.custome_dropdown_select').addClass('pos_section_hide');
    $('.customer_form_pos').removeClass('pos_section_hide');
    }
    })
    </script>

    <!-- for pos taps -->
    <script type="text/javascript">
    $(document).on('click','.target_section_form_wizard',function(){

    var active_section = $(this).attr('data-show');

    if(active_section == 'page-details-1'){

    var paymentMethod = $('input[name="payment_method"]:checked').val();

    if(paymentMethod == 'wallet'){

    var check_user_wallet_amount = parseFloat($('.user_wallet_amount').text());
    var check_total_cart_amount = parseFloat($('.hidden_total_cart_amount').val());


    if (check_total_cart_amount > check_user_wallet_amount) {
    alert('Insufficient amount in your wallet');
    return false;
    } else {
    alert('Please wait.....');

    // for place order
    var selectedType = $('input[name="type"]:checked').val();

    if(selectedType == 'existing'){

    var checkval = $('.existing_customer_dropdown').val();
    var userId = 0;
    userId = checkval;
    var address_input_field = $('.address_input_field').val();
    var house_flat_floorno_inp_cls = $('.house_flat_floorno_inp_cls').val();
    var apartment_road_area_inp_cls = $('.apartment_road_area_inp_cls').val();
    var delivery_label = $("input[name='btnradio']:checked").val();
    var item_id_array = $('.hidden_session_id').val();
    var check_total_cart_amount = parseFloat($('.hidden_total_cart_amount').val());
    var check_user_wallet_amount = parseFloat($('.user_wallet_amount').text());
    var apply_coupon_value = $('.apply_coupon_correct_value_cls').val();
    var itemQuantities = JSON.parse($('#item_quantities').val());
    var restaurant_id =  $('.select_restaurant_tag').val();

    $.ajax({
    url: "{{ url('admin/place-pos-order') }}",
    type: 'POST',
    data: {
    restaurant_id : restaurant_id,
    selectedType : selectedType,
    apply_coupon_value : apply_coupon_value,
    paymentMethod : paymentMethod,
    userId: userId,
    address_input_field: address_input_field,
    house_flat_floorno_inp_cls: house_flat_floorno_inp_cls,
    apartment_road_area_inp_cls: apartment_road_area_inp_cls,
    delivery_label: delivery_label,
    item_id_array: item_id_array,
    check_total_cart_amount: check_total_cart_amount,
    check_user_wallet_amount: check_user_wallet_amount,
    item_quantities: itemQuantities, // Include item quantities
    addon_ids: addonIds, // Include addon IDs collected previously
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    alert('Order placed successfully.');
    location.reload();
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    }else{

    var non_existing_user_name = $('.non_existing_user_name').val();
    var non_existing_email = $('.non_existing_email').val();
    var non_existing_user_phone = $('.non_existing_user_phone').val();
    var non_existing_password = $('.non_existing_password').val();
    var address_input_field = $('.address_input_field').val();
    var house_flat_floorno_inp_cls = $('.house_flat_floorno_inp_cls').val();
    var apartment_road_area_inp_cls = $('.apartment_road_area_inp_cls').val();
    var delivery_label = $("input[name='btnradio']:checked").val();
    var item_id_array = $('.hidden_session_id').val();
    var check_total_cart_amount = parseFloat($('.hidden_total_cart_amount').val());
    var check_user_wallet_amount = parseFloat($('.user_wallet_amount').text());
    var apply_coupon_value = $('.apply_coupon_correct_value_cls').val();
    var itemQuantities = JSON.parse($('#item_quantities').val());
    var restaurant_id =  $('.select_restaurant_tag').val();

    $.ajax({
    url: "{{ url('admin/place-pos-order') }}",
    type: 'POST',
    data: {
    restaurant_id : restaurant_id,
    non_existing_user_name : non_existing_user_name,
    non_existing_email : non_existing_email,
    non_existing_user_phone : non_existing_user_phone,
    non_existing_password : non_existing_password,
    selectedType : selectedType,
    apply_coupon_value : apply_coupon_value,
    paymentMethod : paymentMethod,
    userId: userId,
    address_input_field: address_input_field,
    house_flat_floorno_inp_cls: house_flat_floorno_inp_cls,
    apartment_road_area_inp_cls: apartment_road_area_inp_cls,
    delivery_label: delivery_label,
    item_id_array: item_id_array,
    check_total_cart_amount: check_total_cart_amount,
    check_user_wallet_amount: check_user_wallet_amount,
    item_quantities: itemQuantities, // Include item quantities
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    alert('Order placed successfully.');
    location.reload();
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    }

    }


    }else if(paymentMethod == 'cod'){

    alert('Please wait.....');

    // for place order
    var selectedType = $('input[name="type"]:checked').val();

    if(selectedType == 'existing'){

    var checkval = $('.existing_customer_dropdown').val();
    var userId = 0;
    userId = checkval;
    var address_input_field = $('.address_input_field').val();
    var house_flat_floorno_inp_cls = $('.house_flat_floorno_inp_cls').val();
    var apartment_road_area_inp_cls = $('.apartment_road_area_inp_cls').val();
    var delivery_label = $("input[name='btnradio']:checked").val();
    var item_id_array = $('.hidden_session_id').val();
    var check_total_cart_amount = parseFloat($('.hidden_total_cart_amount').val());
    var check_user_wallet_amount = parseFloat($('.user_wallet_amount').text());
    var apply_coupon_value = $('.apply_coupon_correct_value_cls').val();
    var itemQuantities = JSON.parse($('#item_quantities').val());
    var restaurant_id =  $('.select_restaurant_tag').val();
    $.ajax({
    url: "{{ url('admin/place-pos-order') }}",
    type: 'POST',
    data: {
    restaurant_id : restaurant_id,
    selectedType : selectedType,
    apply_coupon_value : apply_coupon_value,
    paymentMethod : paymentMethod,
    userId: userId,
    address_input_field: address_input_field,
    house_flat_floorno_inp_cls: house_flat_floorno_inp_cls,
    apartment_road_area_inp_cls: apartment_road_area_inp_cls,
    delivery_label: delivery_label,
    item_id_array: item_id_array,
    check_total_cart_amount: check_total_cart_amount,
    check_user_wallet_amount: check_user_wallet_amount,
    item_quantities: itemQuantities, // Include item quantities
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    alert('Order placed successfully.');
    location.reload();
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    }else{

    var non_existing_user_name = $('.non_existing_user_name').val();
    var non_existing_email = $('.non_existing_email').val();
    var non_existing_user_phone = $('.non_existing_user_phone').val();
    var non_existing_password = $('.non_existing_password').val();
    var address_input_field = $('.address_input_field').val();
    var house_flat_floorno_inp_cls = $('.house_flat_floorno_inp_cls').val();
    var apartment_road_area_inp_cls = $('.apartment_road_area_inp_cls').val();
    var delivery_label = $("input[name='btnradio']:checked").val();
    var item_id_array = $('.hidden_session_id').val();
    var check_total_cart_amount = parseFloat($('.hidden_total_cart_amount').val());
    var check_user_wallet_amount = parseFloat($('.user_wallet_amount').text());
    var apply_coupon_value = $('.apply_coupon_correct_value_cls').val();
    var itemQuantities = JSON.parse($('#item_quantities').val());
    var restaurant_id =  $('.select_restaurant_tag').val();

    $.ajax({
    url: "{{ url('admin/place-pos-order') }}",
    type: 'POST',
    data: {
    restaurant_id : restaurant_id,
    non_existing_user_name : non_existing_user_name,
    non_existing_email : non_existing_email,
    non_existing_user_phone : non_existing_user_phone,
    non_existing_password : non_existing_password,
    selectedType : selectedType,
    apply_coupon_value : apply_coupon_value,
    paymentMethod : paymentMethod,
    userId: userId,
    address_input_field: address_input_field,
    house_flat_floorno_inp_cls: house_flat_floorno_inp_cls,
    apartment_road_area_inp_cls: apartment_road_area_inp_cls,
    delivery_label: delivery_label,
    item_id_array: item_id_array,
    check_total_cart_amount: check_total_cart_amount,
    check_user_wallet_amount: check_user_wallet_amount,
    item_quantities: itemQuantities, // Include item quantities
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    alert('Order placed successfully.');
    location.reload();
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    }
    }


    $('.page-details-2').removeClass('active');
    $('.page-details-3').removeClass('active');
    $('.page-details-4').removeClass('active');

    $('.page-details-2 .step-trigger').attr('disabled','disabled');
    $('.page-details-3 .step-trigger').attr('disabled','disabled');
    $('.page-details-4 .step-trigger').attr('disabled','disabled');

    $('#page-details-2').removeClass('active');
    $('#page-details-3').removeClass('active');
    $('#page-details-4').removeClass('active');

    $('.page-details-1 .step-trigger').removeAttr('disabled','disabled');
    $('.page-details-1').addClass('active');
    $('#page-details-1').addClass('active');

    }else if(active_section == 'page-details-2'){

    var selectedType = $('input[name="type"]:checked').val();

    if(selectedType == 'existing'){
    var checkval = $('.existing_customer_dropdown').val();

    if(checkval == '' || checkval == null){
    alert('Please Select Customer First');
    return false;
    }


    }else{ 

    var check_condition_cls = $('.check_condition_cls').val();

    if($('.non_existing_user_name').val() == ''){
    alert('Please Enter Name');
    return false;
    }else if($('.non_existing_email').val() == ''){
    alert('Please Enter Email');
    return false;
    }else if($('.non_existing_user_phone').val() == ''){
    alert('Please Enter Phone');
    return false;
    }else if($('.non_existing_password').val() == ''){
    alert('Please Enter Password');
    return false;
    }else if(check_condition_cls == ''){

    var non_existing_email = $('.non_existing_email').val();
    var non_existing_user_phone = $('.non_existing_user_phone').val();

    $.ajax({
    url: "{{ url('admin/check-user-data-exists') }}",
    type: 'POST',
    data: {
    non_existing_email : non_existing_email,
    non_existing_user_phone : non_existing_user_phone,
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    if(response.success == 'email_already_exists' || response.success == 'phone_already_exists'){
    alert(response.message);
    return false;
    }else if(response.success == true){
    $('.check_condition_cls').val('yes_value');
    }
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    return false;
    }

    }

    $('.page-details-1').removeClass('active');
    $('.page-details-3').removeClass('active');
    $('.page-details-4').removeClass('active');

    $('.page-details-1 .step-trigger').attr('disabled','disabled');
    $('.page-details-3 .step-trigger').attr('disabled','disabled');
    $('.page-details-4 .step-trigger').attr('disabled','disabled');

    $('#page-details-1').removeClass('active');
    $('#page-details-3').removeClass('active');
    $('#page-details-4').removeClass('active');

    $('.page-details-2 .step-trigger').removeAttr('disabled','disabled');
    $('.page-details-2').addClass('active');
    $('#page-details-2').addClass('active');

    }else if(active_section == 'page-details-3'){

    if($('.address_input_field').val() == ''){
    alert('Please Select Address From Map First');
    return false;
    }

    $('.page-details-1').removeClass('active');
    $('.page-details-2').removeClass('active');
    $('.page-details-4').removeClass('active');

    $('.page-details-1 .step-trigger').attr('disabled','disabled');
    $('.page-details-2 .step-trigger').attr('disabled','disabled');
    $('.page-details-4 .step-trigger').attr('disabled','disabled');

    $('#page-details-1').removeClass('active');
    $('#page-details-2').removeClass('active');
    $('#page-details-4').removeClass('active');

    $('.page-details-3 .step-trigger').removeAttr('disabled','disabled');
    $('.page-details-3').addClass('active');
    $('#page-details-3').addClass('active');

    }else if(active_section == 'page-details-4'){

    var cartData = $('.hidden_session_id').val();

    if (cartData == '') {
    alert('Please Add Item To Cart First');
    return false;
    }

    fetchCartData();

    $('.page-details-1').removeClass('active');
    $('.page-details-2').removeClass('active');
    $('.page-details-3').removeClass('active');

    $('.page-details-1 .step-trigger').attr('disabled','disabled');
    $('.page-details-2 .step-trigger').attr('disabled','disabled');
    $('.page-details-3 .step-trigger').attr('disabled','disabled');

    $('#page-details-1').removeClass('active');
    $('#page-details-2').removeClass('active');
    $('#page-details-3').removeClass('active');

    $('.page-details-4 .step-trigger').removeAttr('disabled','disabled');
    $('.page-details-4').addClass('active');
    $('#page-details-4').addClass('active');

    }

    });
    </script>


    <!-- this is for pos product screen -->
    <script type="text/javascript">
    $(document).on('change','.item_select_screen_tag',function(){

    var restaurant_id =  $('.select_restaurant_tag').val();
    var category_id =  $('.select_category_tag').val();

    if(restaurant_id !='' && category_id !=''){
    $('.search_item_input_cls').prop('readonly', false);
    }else{
    $('.search_item_input_cls').prop('readonly', true);    
    }


    });


    $(document).on('click','.search_item_btn',function(){

    var restaurant_id =  $('.select_restaurant_tag').val();
    var category_id =  $('.select_category_tag').val();
    var search_input =$('.search_item_input_cls').val();

    if(restaurant_id == ''){
    alert('Please Select Restaurant');
    }else if(category_id == ''){
    alert('Please Select Category');
    }else{

    $.ajax({
    url: "{{ url('admin/search-items') }}",
    type: 'POST',
    data: {
    restaurant_id: restaurant_id,
    category_id: category_id,
    name: search_input,
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    $('.search_item_html_body').html(response.html);
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });


    }

    });
    </script>

    <script type="text/javascript">
    // Function to set the selected restaurant ID in local storage
    function checkSelectedRestaurantId(select_restaurant_id) {
    localStorage.setItem('select_restaurant_id', select_restaurant_id);  
    }

    // Event handler for the change event of elements with class 'select_restaurant_tag'
    $(document).on('change', '.select_restaurant_tag', function() {
    // Get the selected restaurant ID from the changed element
    var restaurant_id = $(this).val();

    // Get the previously selected restaurant ID from local storage
    var get_select_restaurant_id = localStorage.getItem('select_restaurant_id');

    // Check if a restaurant ID was previously selected
    if (get_select_restaurant_id !== null || get_select_restaurant_id != null) {
    // Compare the previously selected restaurant ID with the newly selected one
    if (restaurant_id != get_select_restaurant_id) {
    // Show SweetAlert confirmation message
    Swal.fire({
    title: 'Are you sure?',
    text: "If you want to change restaurant, your cart will be cleared.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, change it!',
    cancelButtonText: 'No, keep it'
    }).then((result) => {
    if (result.isConfirmed) {
    // Perform action if user clicks on Yes button
    $.ajax({
    url: "{{ url('admin/clear-session') }}",
    type: 'POST',
    data: {
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    $('.hidden_session_id').val(response.data);
    if (response.success) {
    button.text('Added to Cart');
    } else {
    button.text('Add to Cart');
    }
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });
    localStorage.clear();
    } else {
    // Show alert if user clicks on No button
    $('.select2').val(get_select_restaurant_id).trigger('change.select2');
    }
    });
    }
    }
    });

    </script>

    <!-- this is for add to cart item -->
    <script>
    var addonIds = [];
    // function to collect addonIds
    var count = 10; // Move the count variable outside of the click event handler

    $(document).on('click', '.add-to-cart', function() {
    // Reset addonIds before collecting them for the current item
    var addonIds = [];

    var button = $(this);
    var itemId = button.data('item-id');
    var select_restaurant_id = $('.select_restaurant_tag').val();

    checkSelectedRestaurantId(select_restaurant_id);

    // Iterate over selected addons and collect their IDs
    $('.addon-checkbox:checked').each(function() {
    var addonId = $(this).data('addon-id');
    // Assign addon IDs with item ID
    var addonIdWithItemId = count + '_' + itemId + '_' + addonId;
    addonIds.push(addonIdWithItemId);
    });

    // Update button text to show loading spinner or text
    button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');

    $.ajax({
    url: "{{ url('admin/add-items-to-cart') }}",
    type: 'POST',
    data: {
    item_id: itemId,
    count: count,
    addonIds: addonIds, // Include selected addon IDs with item ID
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    $('.hidden_session_id').val(response.data);
    if (response.success) {
    button.text('Added to Cart');
    } else {
    button.text('Add to Cart');
    }
    var html = `<button type="button" class="btn btn-primary">Added</button>`;
    $('.btn_html_change_cls_'+itemId).html(html);
    $('#addonsModal').modal('hide');
    count++; // Increment count here
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });
    });

    </script>


    <!-- this is for fetch data for pos cart -->
    <script type="text/javascript">
    function fetchCartData() {

    var userId = 0;

    var selectedType = $('input[name="type"]:checked').val();

    if(selectedType == 'existing'){
    var checkval = $('.existing_customer_dropdown').val();

    if(checkval != '' || checkval != 0){
    userId = checkval;
    }
    }


    $.ajax({
    url: "{{ url('admin/fetch-cart-data') }}",
    type: 'GET',
    data: {
    userId : userId
    },
    success: function(response) {
    $('.fetch_cart_item_html_body').html(response.html);
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    }
    </script>

    <!-- this is remove item -->
    <script type="text/javascript">
    $(document).on('click','.remove_item_btn',function(){

    var button = $(this);
    var itemId = button.data('item-id');

    $.ajax({
    url: "{{ url('admin/remove-items-to-cart') }}",
    type: 'POST',
    data: {
    item_id: itemId,
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    fetchCartData();
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    });
    </script>

    <!-- qty change for pos -->
    <script type="text/javascript">
    $(document).on('change', '.qty_change_function', function() {
    // Initialize total to 0
    var total = 0;

    // Initialize an object to store item IDs and quantities
    var itemQuantities = {};

    // Iterate over each product
    $('.qty_change_function').each(function() {
    var itemPrice = $(this).data('item-price');
    var qty = $(this).val();
    var itemId = $(this).data('item-id'); // Retrieve item ID

    // Calculate subtotal for the current product
    var subtotal = itemPrice * qty;

    // Add subtotal to the total
    total += subtotal;

    // Store item ID and quantity in the object
    itemQuantities[itemId] = qty;
    });

    // Update the grand total in the UI
    $('.grand_total_show_html').text(formatPrice(total));
    $('.hidden_total_cart_amount').val(total);

    // Update hidden input field with item IDs and quantities
    $('#item_quantities').val(JSON.stringify(itemQuantities));
    });

    function formatPrice(price) {
    // You can format the price here as needed
    return '$' + price.toFixed(2);
    }
    </script>


    <!-- this is for check apply coupon -->
    <script type="text/javascript">
    $(document).on('click','.check_apply_coupon',function(){

    checkApplyCoupon();       

    });


    function checkApplyCoupon(){

    var userId = 0;

    var selectedType = $('input[name="type"]:checked').val();

    if(selectedType == 'existing'){
    var checkval = $('.existing_customer_dropdown').val();

    if(checkval != '' || checkval != 0){
    userId = checkval;
    }
    }

    var coupon_value = $('.apply_coupon_inp_value').val();

    var total_cart_amount = $('.hidden_total_cart_amount').val();



    $.ajax({
    url: "{{ url('admin/check-pos-apply-coupon') }}",
    type: 'POST',
    data: {
    coupon_value: coupon_value,
    userId: userId,
    total_cart_amount: total_cart_amount,
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {

    if(response.success == 'invalid_coupon'){
    alert(response.message);
    }else if(response.success == 'not_for_you'){
    alert(response.message);
    }else if(response.success == 'expired'){
    alert(response.message);
    }else if(response.success == 'limit_cross'){
    alert(response.message);
    }else if(response.success == true){
    var total_cart_amount = parseFloat(response.amount);
    $('.grand_total_show_html').text('$ ' + total_cart_amount);
    $('.hidden_total_cart_amount').val(total_cart_amount);
    $('.check_apply_coupon').text(response.btn_msg);
    $('.check_apply_coupon').prop('disabled', true);
    $('.apply_coupon_correct_value_cls').val(response.coupon_value);
    alert(response.message);
    }

    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });
    }
    </script>

    <!-- this is for item add/edit forms -->
    <script type="text/javascript">
    $(document).on('change','.discount_type_change',function(){
    var discount_type = $(this).val();

    if(discount_type == 'amount'){
    $('.defaut_lavel').addClass('d-none');
    $('.discount_percent_label').addClass('d-none');
    $('.discount_amount_label').removeClass('d-none');
    }else if(discount_type == 'percent'){
    $('.defaut_lavel').addClass('d-none');
    $('.discount_amount_label').addClass('d-none');
    $('.discount_percent_label').removeClass('d-none');
    }else{
    $('.discount_amount_label').addClass('d-none');
    $('.discount_percent_label').addClass('d-none');
    $('.defaut_lavel').removeClass('d-none');
    }

    });

    $(document).ready(function() {

    var discount_type = $('.edit_discount_type_change').val();

    if(discount_type == 'amount'){
    $('.defaut_lavel').addClass('d-none');
    $('.discount_percent_label').addClass('d-none');
    $('.discount_amount_label').removeClass('d-none');
    }else if(discount_type == 'percent'){
    $('.defaut_lavel').addClass('d-none');
    $('.discount_amount_label').addClass('d-none');
    $('.discount_percent_label').removeClass('d-none');
    }else{
    $('.discount_amount_label').addClass('d-none');
    $('.discount_percent_label').addClass('d-none');
    $('.defaut_lavel').removeClass('d-none');
    }

    });

    </script>

    <!-- this is for handle item discount pricwe -->
    <script>
    function updateFinalAmount() {
    var price = parseFloat(document.getElementById('item_price_id').value);
    var discount = parseFloat(document.getElementById('item_discount_price_id').value);
    var discountType = document.getElementById('item_discount_type_id').value;
    var finalAmount = 0;

    if (discountType == "amount") {
    finalAmount = price - discount;
    } else if (discountType == "percent") {
    finalAmount = price - (price * (discount / 100));
    }

    document.getElementById('final_amount_input_id').value = finalAmount.toFixed(2);
    }

    $(document).ready(function() {
    updateFinalAmount();
    });

    $(document).on('change','#item_discount_type_id',function(){
    updateFinalAmount();
    });

    $(document).on('keyup','#item_discount_price_id',function(){
    updateFinalAmount();
    });

    $(document).on('keyup','#item_price_id',function(){
    updateFinalAmount();
    });


    function updateEditFinalAmount() {
    var price = parseFloat(document.getElementById('edit_item_price_id').value);
    var discount = parseFloat(document.getElementById('edit_item_discount_price_id').value);
    var discountType = document.getElementById('edit_item_discount_type_id').value;
    var finalAmount = 0;

    if (discountType == "amount") {
    finalAmount = price - discount;
    } else if (discountType == "percent") {
    finalAmount = price - (price * (discount / 100));
    }

    document.getElementById('edit_final_amount_input_id').value = finalAmount.toFixed(2);
    }

    $(document).ready(function() {
    updateEditFinalAmount();
    });

    $(document).on('change','#edit_item_discount_type_id',function(){
    updateEditFinalAmount();
    });

    $(document).on('keyup','#edit_item_discount_price_id',function(){
    updateEditFinalAmount();
    });

    $(document).on('keyup','#edit_item_price_id',function(){
    updateEditFinalAmount();
    });

    </script>

    <!-- This is for change order status in order details page -->
    <script type="text/javascript">
    $(document).on('change','.change_order_status_cls',function(){
    var status = $(this).val();
    var order_id = $('.hidden_order_id').val();

    $.ajax({
    url: "{{ url('admin/change-order-status') }}",
    type: 'POST',
    data: {
    status: status,
    order_id : order_id,
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    alert('Status updated successfully');
    location.reload(); 
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    }); 
    </script>

    <script type="text/javascript">
    $(document).on('click', '.assign_deliveryman_btn', function(){
    $('#assignDeliverymanModel').modal('show');
    });

    $(document).on('click', '.close_modal_btn', function(){
    $('#assignDeliverymanModel').modal('hide');
    $('#changeDeliveryInfoModel').modal('hide');
    $('#addonsModal').modal('hide');
    $('#addonsModalWithQty').modal('hide');
    });

    $(document).on('click', '.assign_order_modal_btn', function(){

    var order_id = $('.hidden_order_id').val();
    var deliveryman_id = $(this).attr('data-deliveryman-id');

    $.ajax({
    url: "{{ url('admin/assign-order-to-deliveryman') }}",
    type: 'POST',
    data: {
    deliveryman_id: deliveryman_id,
    order_id : order_id,
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    alert('Deliveryman assigned successfully');
    location.reload(); 
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });
    });


    $(document).on('click', '.change_delivery_info', function(){
    $('#changeDeliveryInfoModel').modal('show');
    });
    </script>


    <!-- This is for addons item for pos -->
    <script type="text/javascript">
    $(document).on('click', '.open_addon_model_btn', function(){
    var item_id = $(this).attr('data-item-id');

    $.ajax({
    url: "{{ url('admin/fetch-addons-data') }}",
    type: 'GET',
    data: {
    item_id : item_id,
    },
    success: function(response) {
    $('.inner_html_of_addon_modal').html(response.html);
    $('#addonsModal').modal('show'); 
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });
    });    
    </script>

    <script type="text/javascript">
    // $(document).ready(function() {
    //     // Function to calculate total item price including addons
    //     function calculateTotalPrice() {
    //         var totalPrice = parseFloat($('.item_price_cls_in_modal').text()); // Get base item price
    //         // Loop through selected addons
    //         $('.addon-checkbox:checked').each(function() {
    //             var addonPrice = parseFloat($('.addon_price_' + $(this).data('addon-id')).text()); // Get addon price
    //             totalPrice += addonPrice; // Add addon price to total price
    //         });
    //         // Update total amount in HTML
    //         $('.item_price_with_addon_price').text(totalPrice.toFixed(2));
    //     }

    //     // Event handler for addon checkbox change
    //     $(document).on('change', '.addon-checkbox', function() {
    //         calculateTotalPrice(); // Recalculate total price when addon selection changes
    //     });

    //     // Initial calculation when document is ready
    //     calculateTotalPrice();
    // });

    </script>

    <script type="text/javascript">
    $(document).on('change', '.qty_change_function_search_item', function() {
    var itemId = $(this).data('item-id');

    $.ajax({
    url: "{{ url('admin/fetch-added-item-in-qty-modal') }}",
    type: 'POST',
    data: {
    item_id: itemId, // Setting itemId in the data object
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    $('.inner_html_of_added_item_modal').html(response.html);
    $('.add_new_customisation_btn').attr('data-item-id', itemId);
    $('#addonsModalWithQty').modal('show');
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });
    });
    </script>

    <script type="text/javascript">
    $(document).on('click','.add_new_customisation_btn',function(){

    var itemId = $(this).data('item-id');
    $('#addonsModalWithQty').modal('hide');

    $.ajax({
    url: "{{ url('admin/fetch-addons-data') }}",
    type: 'GET',
    data: {
    item_id : itemId,
    },
    success: function(response) {
    $('.inner_html_of_addon_modal').html(response.html);
    $('#addonsModal').modal('show'); 
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });
    });
    </script>

    <script type="text/javascript">
    $(document).on('change','.addon_modal_qty',function(){

    var itemId = $(this).data('item-id');

    var itemId_with_count = $(this).data('itemId-with-count');

    var selfqty = parseInt($(this).val());

    var totalQty = 0; // Initialize total quantity

    $('.addon_modal_qty_'+itemId).each(function() {
    // Get the value of each input field and convert it to an integer
    var qty = parseInt($(this).val());

    // Add the quantity to the totalQty
    totalQty += qty;
    });


    $.ajax({
    url: "{{ url('admin/increase-decrease-qty-in-addons-modal') }}",
    type: 'POST',
    data: {
    item_id: itemId,
    itemId_with_count: itemId_with_count,
    selfqty: selfqty,
    _token: '{{ csrf_token() }}'
    },
    success: function(response) {
    $('.search_item_qty_'+itemId).val(totalQty);
    },
    error: function(xhr, status, error) {
    console.error(xhr.responseText);
    }
    });

    });
    </script>



    <!-- ===============For Order Address Change in Order Detail Page====================== -->
    <!-- <style>
    /* Adjusted style for the search input within the modal */
    #changeDeliveryInfoModel #pac-input-modal {
    background-color: #fff;
    padding: 10px;
    width: calc(100% - 20px); /* Adjusted width */
    font-family: 'Roboto', sans-serif; /* Added fallback font */
    font-size: 16px; /* Slightly increased font size */
    font-weight: 400; /* Adjusted font weight */
    border: none; /* Removed border */
    border-radius: 4px; /* Adjusted border-radius */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Adjusted box-shadow */
    z-index: 1001; /* Ensure input field appears above other elements */
    }

    /* Style for the autocomplete dropdown within the modal */
    #changeDeliveryInfoModel .pac-container {
    font-family: 'Roboto', sans-serif; /* Added fallback font */
    background-color: #fff; /* Adjusted background color */
    border-radius: 4px; /* Adjusted border-radius */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Adjusted box-shadow */
    z-index: 1001; /* Ensure dropdown appears above other elements */
    }

    /* Ensure autocomplete suggestions appear above other elements */
    .pac-container {
    z-index: 1002 !important;
    }
    </style> -->

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUNZZgE72aRG8H_aW_f9K1y1SedPg3LJI&libraries=places"></script>

    <script>
    function initializeMapModal() {
    var mapOptions = {
    center: { lat: 0, lng: 0 },
    zoom: 5, // Adjust the initial zoom level here
    };
    var map = new google.maps.Map(document.getElementById('AddressMapModal'), mapOptions);
    var marker = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png' // Custom red marker icon
    });

    // Add search box
    var input = document.getElementById('pac-input-modal');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport
    map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
    });

    // Listen for the event fired when the user selects a prediction and retrieve more details for that place.
    searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
    return;
    }

    // Clear out the old markers
    marker.setMap(null);

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
    if (!place.geometry) {
    console.log("Returned place contains no geometry");
    return;
    }

    marker.setPosition(place.geometry.location);
    getAddressModal(place.geometry.location);

    if (place.geometry.viewport) {
    // Only geocodes have viewport.
    bounds.union(place.geometry.viewport);
    } else {
    bounds.extend(place.geometry.location);
    }
    });
    map.fitBounds(bounds);
    });

    // Listen for click event on the map
    google.maps.event.addListener(map, 'click', function(event) {
    var clickedLocation = event.latLng;
    marker.setPosition(clickedLocation);
    getAddressModal(clickedLocation);
    });

    function getAddressModal(latLng) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'location': latLng }, function(results, status) {
    if (status === 'OK') {
    if (results[0]) {
    var formattedAddress = results[0].formatted_address;
    var latitude = latLng.lat();
    var longitude = latLng.lng();
    var addressComponents = results[0].address_components;

    // Populate hidden fields with address details
    document.getElementById('latitudeModal').value = latitude;
    document.getElementById('longitudeModal').value = longitude;
    document.getElementById('placeNameModal').value = formattedAddress;

    // Autofill address input field
    document.getElementById('addressModal').value = formattedAddress;

    // Autofill state, city, country, and pincode
    for (var i = 0; i < addressComponents.length; i++) {
    var component = addressComponents[i];
    if (component.types.includes('country')) {
    document.getElementById('countryModal').value = component.long_name;
    } else if (component.types.includes('administrative_area_level_1')) {
    document.getElementById('stateModal').value = component.long_name;
    } else if (component.types.includes('locality')) {
    document.getElementById('cityModal').value = component.long_name;
    } else if (component.types.includes('postal_code')) {
    document.getElementById('pincodeModal').value = component.long_name;
    }
    }
    } else {
    console.error('No results found');
    }
    } else {
    console.error('Geocoder failed due to: ' + status);
    }
    });
    }
    }

    // Initialize the map when the modal is shown
    $('#changeDeliveryInfoModel').on('shown.bs.modal', function () {
    initializeMapModal();
    });
    </script> -->







<!-- product add script start here -->

   
<!-- product add script end here -->



  <!-- edit product script start here -->










