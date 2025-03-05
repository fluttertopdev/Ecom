@if($row->key=='is_enable_twilio')
    <div class="col-md-1" style="margin-top: 30px;">
        <input <?php if($row->value=='1'){?>checked<?php } ?> class="form-check-input" type="checkbox" name="is_enable_twilio" value="1"/>
        <label class="form-check-label" for="is_enable_twilio">{{__('lang.admin_is_enable_twilio')}}</label>
    </div>
@endif
@if($row->key=='twilio_account_sid')
    <div class="col-md-4">
        <div class="mb-1">
            <label class="form-label" for="twilio_account_sid">{{__('lang.admin_twilio_account_sid')}}</label>
            <input type="text" class="form-control" placeholder="{{__('lang.admin_twilio_account_sid')}}" name="twilio_account_sid" id="twilio_account_sid" value="{{$row->value}}" />
        </div>
    </div>
@endif
@if($row->key=='twilio_auth_token')
    <div class="col-md-4">
        <div class="mb-1">
            <label class="form-label" for="twilio_auth_token">{{__('lang.admin_twilio_auth_token')}}</label>
            <input type="text" class="form-control" placeholder="{{__('lang.admin_twilio_auth_token')}}" name="twilio_auth_token" id="twilio_auth_token" value="{{$row->value}}" />
        </div>
    </div>
@endif
@if($row->key=='twilio_phone_number')
    <div class="col-md-3">
        <div class="mb-1">
            <label class="form-label" for="twilio_phone_number">{{__('lang.admin_twilio_phone_number')}}</label>
            <input type="text" class="form-control" placeholder="{{__('lang.admin_twilio_phone_number')}}" name="twilio_phone_number" id="twilio_phone_number" value="{{$row->value}}" />
        </div>
    </div>
@endif

<!-- ====================================================== -->
@if($row->key=='is_enable_msg91')
    <div class="col-md-2 mt-7" style="max-width: 95px;margin-top: 75px;">
        <input <?php if($row->value=='1'){?>checked<?php } ?> class="form-check-input" type="checkbox" name="is_enable_msg91" value="1"/>
        <label class="form-check-label" for="is_enable_msg91">{{__('lang.admin_is_enable_msg91')}}</label>
    </div>
@endif
@if($row->key=='msg91_auth_key')
    <div class="col-md-5 mt-5">
        <div class="mb-1">
            <label class="form-label" for="msg91_auth_key">{{__('lang.admin_msg91_auth_key')}}</label>
            <input type="text" class="form-control" placeholder="{{__('lang.admin_msg91_auth_key')}}" name="msg91_auth_key" id="msg91_auth_key" value="{{$row->value}}" />
        </div>
    </div>
@endif
@if($row->key=='msg91_sender_id')
    <div class="col-md-5 mt-5">
        <div class="mb-1">
            <label class="form-label" for="msg91_sender_id">{{__('lang.admin_msg91_sender_id')}}</label>
            <input type="text" class="form-control" placeholder="{{__('lang.admin_msg91_sender_id')}}" name="msg91_sender_id" id="msg91_sender_id" value="{{$row->value}}" />
        </div>
    </div>
@endif