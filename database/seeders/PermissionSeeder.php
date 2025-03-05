<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tempArr = array(
            array('module' => 'Dashboard','route_name' => 'dashboard','permission_name' => 'Dashboard','group' => 'dashboard','is_default' => 1),
           
            array('module' => 'Order','route_name' => 'order','permission_name' => 'List','group' => 'order','is_default' => 0),
            array('module' => 'Order','route_name' => 'view-order','permission_name' => 'View','group' => 'order','is_default' => 0),
         
            array('module' => 'Banner','route_name' => 'banner','permission_name' => 'List','group' => 'banner','is_default' => 0),
            array('module' => 'Banner','route_name' => 'add-banner','permission_name' => 'Add','group' => 'banner','is_default' => 0),

            array('module' => 'Banner','route_name' => 'update-banner','permission_name' => 'Update','group' => 'banner','is_default' => 0),
            array('module' => 'Banner','route_name' => 'update-banner-column','permission_name' => 'Status Change','group' => 'banner','is_default' => 0),

            array('module' => 'Banner','route_name' => 'delete-banner','permission_name' => 'Delete','group' => 'banner','is_default' => 0),
            
            
            
             array('module' => 'Product','route_name' => 'product','permission_name' => 'List','group' => 'product','is_default' => 0),
            array('module' => 'Product','route_name' => 'add-product','permission_name' => 'Add','group' => 'product','is_default' => 0),

            array('module' => 'Product','route_name' => 'update-product','permission_name' => 'Update','group' => 'product','is_default' => 0),
            array('module' => 'Product','route_name' => 'update-product-column','permission_name' => 'Status Change','group' => 'product','is_default' => 0),

            array('module' => 'Product','route_name' => 'delete-product','permission_name' => 'Delete','group' => 'product','is_default' => 0),

             array('module' => 'Category','route_name' => 'category','permission_name' => 'List','group' => 'category','is_default' => 0),
            array('module' => 'Category','route_name' => 'add-category','permission_name' => 'Add','group' => 'category','is_default' => 0),
            array('module' => 'Category','route_name' => 'update-category','permission_name' => 'Update','group' => 'category','is_default' => 0),
            array('module' => 'Category','route_name' => 'update-category-column','permission_name' => 'Status Change','group' => 'category','is_default' => 0),
            array('module' => 'Category','route_name' => 'delete-category','permission_name' => 'Delete','group' => 'category','is_default' => 0),
            array('module' => 'Category','route_name' => 'import-export-category','permission_name' => 'Bulk','group' => 'category','is_default' => 0),
            array('module' => 'SubCategory','route_name' => 'subcategory','permission_name' => 'List','group' => 'subcategory','is_default' => 0),
            array('module' => 'SubCategory','route_name' => 'add-subcategory','permission_name' => 'Add','group' => 'subcategory','is_default' => 0),
            array('module' => 'SubCategory','route_name' => 'update-subcategory','permission_name' => 'Update','group' => 'subcategory','is_default' => 0),
            array('module' => 'SubCategory','route_name' => 'update-subcategory-column','permission_name' => 'Status Change','group' => 'subcategory','is_default' => 0),
            array('module' => 'SubCategory','route_name' => 'delete-subcategory','permission_name' => 'Delete','group' => 'subcategory','is_default' => 0),
         
          
           
       
           
       
       
     
           
      
          
        
        
      
            
         
            array('module' => 'Coupon','route_name' => 'coupon','permission_name' => 'List','group' => 'coupon','is_default' => 0),
            array('module' => 'Coupon','route_name' => 'add-coupon','permission_name' => 'Add','group' => 'coupon','is_default' => 0),
            array('module' => 'Coupon','route_name' => 'update-coupon','permission_name' => 'Update','group' => 'coupon','is_default' => 0),
            array('module' => 'Coupon','route_name' => 'update-coupon-column','permission_name' => 'Status Change','group' => 'coupon','is_default' => 0),
            array('module' => 'Coupon','route_name' => 'delete-coupon','permission_name' => 'Delete','group' => 'coupon','is_default' => 0),

            array('module' => 'Push Notification','route_name' => 'push-notification','permission_name' => 'List','group' => 'push-notification','is_default' => 0),
            array('module' => 'Push Notification','route_name' => 'add-push-notification','permission_name' => 'Add','group' => 'push-notification','is_default' => 0),
            array('module' => 'Push Notification','route_name' => 'delete-push-notification','permission_name' => 'Delete','group' => 'push-notification','is_default' => 0),

         
            array('module' => 'Role','route_name' => 'role','permission_name' => 'List','group' => 'role','is_default' => 0),
            array('module' => 'Role','route_name' => 'add-role','permission_name' => 'Add','group' => 'role','is_default' => 0),
            array('module' => 'Role','route_name' => 'update-role','permission_name' => 'Update','group' => 'role','is_default' => 0),
            array('module' => 'Role','route_name' => 'update-role-status','permission_name' => 'Status Change','group' => 'role','is_default' => 0),
            array('module' => 'Role','route_name' => 'delete-role','permission_name' => 'Delete','group' => 'role','is_default' => 0),

      
      
            array('module' => 'Deliveryman ','route_name' => 'deliveryman','permission_name' => 'List','group' => 'deliveryman','is_default' => 0),
            array('module' => 'Deliveryman ','route_name' => 'add-deliveryman','permission_name' => 'Add','group' => 'deliveryman','is_default' => 0),
            array('module' => 'Deliveryman ','route_name' => 'update-deliveryman','permission_name' => 'Update','group' => 'deliveryman','is_default' => 0),
            array('module' => 'Deliveryman ','route_name' => 'update-deliveryman-column','permission_name' => 'Status Change','group' => 'deliveryman','is_default' => 0),
            array('module' => 'Deliveryman ','route_name' => 'delete-deliveryman','permission_name' => 'Delete','group' => 'deliveryman','is_default' => 0),

            array('module' => 'Setting','route_name' => 'settings','permission_name' => 'List','group' => 'settings','is_default' => 0),
            array('module' => 'Setting','route_name' => 'update-setting','permission_name' => 'Update','group' => 'settings','is_default' => 0),
          
            array('module' => 'Withdraw request','route_name' => 'withdraw-request','permission_name' => 'List','group' => 'withdraw request','is_default' => 0),
            array('module' => 'Withdraw request','route_name' => 'delete-withdraw request','permission_name' => 'Delete','group' => 'Withdraw request','is_default' => 0),

    
            array('module' => 'Income Management  ','route_name' => 'income-management ','permission_name' => 'Add','group' => 'Income Management ','is_default' => 0),
     
    array('module' => 'Brand ','route_name' => 'brand','permission_name' => 'List','group' => 'brand','is_default' => 0),
    array('module' => 'Brand','route_name' => 'add-brand','permission_name' => 'Add','group' => 'brand','is_default' => 0),
    array('module' => 'Brand','route_name' => 'update-brand','permission_name' => 'Update','group' => 'brand','is_default' => 0),
     array('module' => 'Brand','route_name' => 'delete-brand','permission_name' => 'Delete','group' => 'brand','is_default' => 0),
        array('module' => 'Brand','route_name' => 'update-brand-column','permission_name' => 'Status','group' => 'brand','is_default' => 0),
         array('module' => 'Attributes','route_name' => 'attributes','permission_name' => 'List','group' => 'attributes','is_default' => 0),
         array('module' => 'Attributes','route_name' => 'add-attributes','permission_name' => 'Add','group' => 'attributes','is_default' => 0),
        array('module' => 'Attributes','route_name' => 'update-attributes','permission_name' => 'Update','group' => 'attributes','is_default' => 0),
        array('module' => 'Attributes','route_name' => 'delete-attributes','permission_name' => 'Delete','group' => 'attributes','is_default' => 0),
         array('module' => 'Shipping-Setting','route_name' => 'shipping-setting','permission_name' => 'List','group' => 'shipping-setting','is_default' => 0),
        array('module' => 'Shipping-Setting','route_name' => 'update-shipping-setting','permission_name' => 'Update','group' => 'shipping-setting','is_default' => 0),
        );
         
        foreach ($tempArr as $key => $value) {
            $check = Permission::where('name',$value['route_name'])->where('module',$value['module'])->first();
            if(!$check){
                Permission::insert([
                    'module' => $value['module'],
                    'name' => $value['route_name'],
                    'permission_name' => $value['permission_name'],
                    'group' => $value['group'],
                    'is_default' => $value['is_default'],
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            }
        }
    }
}
