@extends('admin.layouts.app')
@section('content')




<div class="container mt-4">
<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-md-6">
            <h5>Sellers Payout Requests</h5>
        </div>
        
    </div>
</div>
<div class="card-body">
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr class="text-nowrap">
                    <th>ID</th>
                    <th>Sellers Name</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Requested Amount</th>
                    <th>Message</th>
                    <th>Status</th>
                    
                    
  
                
                </tr>
            </thead>
            <tbody>
            
                <tr>
                    <td>1</td>
             


                   
                  
                    <td>test business11</td>

                      <td>21-09-2024</td>
                      <td>20000</td>
                      <td>5000</td>
                      <td>But I must explain to you how</td>
                       <td>
                      
                       <a href="#">
                            <span class="badge bg-success" data-id=""  data-status="" data-commsionsrate="" id="addcommisonbutton">Paid</span></a>
                     
                    
                    </td>
                 
               
                
                  
                
                </tr>
             
              
            </tbody>
        </table>
    </div>
</div>

</div>
</div>



@endsection