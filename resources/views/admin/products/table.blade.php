

<?php
$Symbol = \Helpers::getActiveCurrencySymbol();
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<input type="hidden" id="name" value="{{ $_GET['name'] ?? '' }}" name="">
<input type="hidden" id="status" value="{{ $_GET['status'] ?? '' }}" name="">
<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Product List</h5>

        </div>
        <div class="col-md-6">
            <h6 class="float-right">
                <?php if ($result->firstItem() != null) {?>
                {{__('lang.admin_showing')}} {{ $result->firstItem() }}-{{ $result->lastItem() }}
                {{__('lang.admin_of')}} {{ $result->total() }} <?php }?>
            </h6>
        </div>


    </div>
    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button id="exportBtn" class="btn btn-success">
                            Excel 
                        </button>
                        <button id="pdfBtn" class="btn btn-success">
                            PDF 
                        </button>
                        <button type="button" class="btn btn-danger" id="delete-selected-btn">Bulk Delete</button>
                       
                    </div>
</div>
<div class="card-body">
    <div class="table-responsive text-nowrap">
        <form id="multi-delete-form">
           
            @csrf
            

            <table class="table">
                <thead class="table-light">
                    <tr class="text-nowrap">
                        <th>
                            <input type="checkbox" id="select-all" />
                        </th>
                        <th>{{__('lang.admin_id')}}</th>
                        <th>{{__('lang.admin_image')}}</th>
                        <th>{{__('lang.admin_name')}}</th>
                          <th>Price</th>
                         <!-- <th>Creaded By</th> -->
                        <th>{{__('lang.admin_created_at')}}</th>
                      
                        
                         <th>Category</th>
                        <th>Brand</th>
            
                        <th>{{__('lang.admin_status')}}</th>
                
                        
                        <th>{{__('lang.admin_action')}}</th>
                
                    </tr>
                </thead>
                <tbody>
                    
                    @if(count($result) > 0)
                    @foreach($result as $row)
                              @php
                    $activeVariant = $row->productVariants->where('status', '1')->first();
                    $productPrice = $activeVariant ? $activeVariant->price : $row->price;
                     $imageArray = $activeVariant && $activeVariant->images ? explode(',', $activeVariant->images) : [];
    $firstImage = count($imageArray) > 0 ? $imageArray[0] : null;

    $productImage = $firstImage ? url('uploads/' . $firstImage) : url('uploads/product/' . $row->product_image);
                   
                
                @endphp
                    <tr>
                        <td>
                            <input type="checkbox" class="category-checkbox" name="category_ids[]" value="{{ $row->id }}" />
                        </td>
                        <td>{{$row->id}}</td>
                        <td aria-colindex="2" role="cell" class="">
                            <span class="b-avatar mr-1 badge-secondary rounded-circle">
                                <span class="b-avatar-img">
                                    @if($productImage != '')
                                    <img src="{{ $productImage }}" width="100px" height="75px;" style="object-fit: contain;"  onerror="this.src='{{asset('uploads/no-image.png')}}';">
                                    @else
                                    <img src="{{asset('/admin-assets/images/no-image.png')}}">
                                    @endif
                                </span>
                            </span>
                        </td>
                        <td>{{$row->name}}</td>

                        <td>{{$Symbol}}{{$productPrice}}</td>

                           <!-- <td>{{$row->price}}</td> -->
                        <td>{{ \Helpers::commonDateFormate($row->created_at) }}</td>
                       
                      
                        <td>{{$row->category->name}}</td>
                        <td>{{$row->brand->name}}</td>
                        
                        <td>
                            @if($row->status == 1)
                            <a href="{{ url('admin/update-product-column/'.$row->id) }}">
                                <span class="badge bg-success">{{__('lang.admin_active')}}</span>
                            </a>
                            @else
                            <a href="{{ url('admin/update-product-column/'.$row->id) }}">
                                <span class="badge bg-warning">{{__('lang.admin_deactive')}}</span>
                            </a>
                            @endif
                        </td>
                
            
                        <td>
                            <div class="inline_action_btn">
                                
                                <a href="{{ url('admin/edit-product/'.$row->id.'?type=admin') }}" class="edit_icon" title="{{__('lang.admin_edit')}}"><i class="ti ti-pencil me-1"></i></a>
                                <a class="delete_icon" href="javascript:void(0);" onclick="showDeleteConfirmation('product', {{ $row->id }})"><i class="ti ti-trash me-1"></i></a>
                                   <a class="edit_icon" href="{{ url('admin/product/translation/'.$row->id) }}"
                          title="Translation">
                          <i class=" ti ti-language me-1 margin-top-negative-4"></i>
                            </a>
                            
                            </div>
                        </td>
                
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10" class="record-not-found">
                            <span>{{__('lang.admin_no_data_found')}}</span>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="card-footer">
    <div class="pagination" style="float: right;">
        {{$result->withQueryString()->links('pagination::bootstrap-4')}}
    </div>
</div>
</div>

<script>
    // Select/Deselect all checkboxes
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.category-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // AJAX for multi-delete
    document.getElementById('delete-selected-btn').addEventListener('click', function () {
        const selectedIds = Array.from(document.querySelectorAll('.category-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            
          
               Swal.fire({
          title: 'warning',
          text: 'You need to select a Product for deletion!',
          icon: 'warning',
          confirmButtonText: 'OK',
          buttonsStyling: false,
          customClass: {
          confirmButton: 'btn btn-warning' // Optional: Add a class for styling the button
         }
     });

            return;
        }

        if (confirm('Are you sure you want to delete selected product?')) {
            $.ajax({
                url: '{{ url("admin/multi-delete-product") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    products_ids: selectedIds
                },
                success: function (response) {
                    // Handle success response
                    location.reload(); // Refresh the page or handle response as needed
                },
                error: function (xhr) {
                    // Handle error response
                    alert('An error occurred while deleting categories.');
                }
            });
        }
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


<script type="text/javascript">
    document.getElementById('exportBtn').addEventListener('click', function () {
        var url = "{{ route('exportAllOrders') }}";

        // Gather filter values
        var name = document.getElementById('name').value;
        
        
        var status = document.getElementById('status').value;

        // Create query parameters string
        var params = new URLSearchParams({
            name: name,
            status: status
        });

        // Append parameters to the URL
        url += '?' + params.toString();

        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Prepare data for the sheet
                var sheetData = [
                    [
                        'ID',
                        'Name',
                        'Price',
                        'Created At',
                        'Category',
                        'Brand',
                        'Featured',
                        'Status'
                    ]
                ];

                data.forEach(function (product) {
                    sheetData.push([
                        `#${product.id}`,
                        product.name || '--',
                        product.price || '--',
                        product.created_at || '--',
                        product.category_name || '--',
                        product.brand_name || '--',
                        product.is_featured || '--',
                        product.status || '0'
                    ]);
                });

                // Create a worksheet
                var ws = XLSX.utils.aoa_to_sheet(sheetData);

                // Set column widths
                ws['!cols'] = [
                    { wch: 10 }, // ID
                    { wch: 25 }, // Name
                    { wch: 15 }, // Price
                    { wch: 20 }, // Created At
                    { wch: 20 }, // Category
                    { wch: 20 }, // Brand
                    { wch: 10 }, // Featured
                    { wch: 10 }  // Status
                ];

                // Create a workbook and append the worksheet
                var workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, ws, "Orders");

                // Export the workbook to a file
                XLSX.writeFile(workbook, 'ProductList.xlsx');
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>



<script type="text/javascript">
document.getElementById('pdfBtn').addEventListener('click', function() {
    var url = "{{ route('exportAllOrders') }}";
    
    var name = document.getElementById('name').value;
    var status = document.getElementById('status').value;
  

    url += `?name=${name}&status=${status}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text("Product List", 20, 10);

            let headers = [
                "ID", 
                "Name", 
                "Price", 
                "Created", 
                 "Category", 
                  "Brand", 
                "Featured", 
                "Status", 
            

            ];

            let rows = data.map(product => {
               
                
  
                return [
                    `#${product.id}`,
                    product.name ? product.name : '--',
                  product.price ? product.price : '--',
                 product.created_at ? product.created_at : '--',
                  product.created_at ? product.category_name : '--',
                   product.created_at ? product.brand_name : '--',
                 product.is_featured ? product.is_featured : '--',
                 product.status ? product.status : '0',
                   
                ];
            });

            doc.setFont("helvetica");

            doc.autoTable({
                head: [headers],
                body: rows,
                startY: 20,
            });

            doc.save('ProductList.pdf');
        })
        .catch(error => console.error('Error fetching data:', error));
});


</script>









