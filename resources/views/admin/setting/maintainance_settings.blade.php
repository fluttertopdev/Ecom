@if($row->key == 'enable_maintainance_mode')
<div class="col-md-4 mt-4">
    <label class="switch switch-square" style="display: table-footer-group;">
        <input value="1" type="checkbox" class="switch-input" id="enable_maintainance_mode" name="enable_maintainance_mode" @if($row->value == 1) checked @endif>
        <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
        </span>
        <span class="switch-label">{{__('lang.admin_enable_maintainance_mode_placeholder')}}</span>
    </label>
</div>
@endif
@if($row->key == 'maintainance_title')
<div class="col-md-8">
    <label class="form-label" for="maintainance_title">{{__('lang.admin_maintainance_title')}}</label>
    <input type="text" class="form-control" name="maintainance_title" value="{{$row->value}}" placeholder="{{__('lang.admin_maintainance_title_placeholder')}}">
</div>
@endif
@if($row->key == 'maintainance_short_text')
<div class="col-md-12 mt-3 mb-3">
    <label class="form-label" for="maintainance_short_text">{{__('lang.admin_maintainance_short_text')}}</label>
    <textarea type="text" class="form-control" name="maintainance_short_text" placeholder="{{__('lang.admin_maintainance_short_text_placeholder')}}">{{$row->value}}</textarea>
</div>
@endif