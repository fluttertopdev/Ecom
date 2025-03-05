@if($row->key == 'map_api_key')
<div class="col-md-6">
    <label class="form-label" for="map_api_key">{{__('lang.admin_map_api_key')}}</label>
    <input type="text" class="form-control" placeholder="{{__('lang.admin_map_api_key_placeholder')}}" value="{{$row->value}}" name="map_api_key"/>
</div>
@endif
@if($row->key == 'map_api_key_server')
<div class="col-md-6">
    <label class="form-label" for="map_api_key_server">{{__('lang.admin_map_api_key_server')}}</label>
    <input type="text" class="form-control" placeholder="{{__('lang.map_api_key_server_placeholder')}}" value="{{$row->value}}" name="map_api_key_server"/>
</div>
@endif