@if($row->key == 'site_name')
<div class="col-md-6 mb-3 display-inline-block width-32-percent mr-10">
    <label class="form-label" for="site_name">{{__('lang.admin_website_name')}}</label>
    <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_website_name_placeholder')}}"  name="site_name"/>
</div>
@endif
@if($row->key == 'site_admin_name')
<div class="col-md-6 mb-3 display-inline-block width-32-percent mr-10">
    <label class="form-label" for="site_admin_name">{{__('lang.admin_website_admin_name')}}</label>
    <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_website_admin_name_placeholder')}}"  name="site_admin_name"/>
</div>
@endif
@if($row->key == 'powered_by')
<div class="col-md-6 mb-3 display-inline-block width-32-percent mr-10">
    <label class="form-label" for="powered_by">{{__('lang.admin_powered_by')}}</label>
    <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_powered_by_placeholder')}}"  name="powered_by"/>
</div>
@endif
@if($row->key == 'site_seo_title')
<div class="col-md-6 mb-3 display-inline-block width-32-percent mr-10">
    <label class="form-label" for="site_seo_title">{{__('lang.admin_seo_title')}}</label>
    <input type="text" class="form-control" value="{{$row->value}}" placeholder="{{__('lang.admin_seo_title_placeholder')}}"  name="site_seo_title"/>
</div>
@endif
@if($row->key == 'site_seo_description')
<div class="col-md-6 mb-3 display-inline-block width-32-percent mr-10">
    <label class="form-label" for="site_seo_description">{{__('lang.admin_seo_description')}}</label>
    <textarea type="text" class="form-control" value="{{$row->value}}" name="site_seo_description" placeholder="{{__('lang.admin_seo_description_placeholder')}}">{{$row->value}}</textarea>
</div>
@endif
@if($row->key == 'site_seo_keyword')
<div class="col-md-6 mb-3 display-inline-block width-32-percent mr-10">
    <label class="form-label" for="site_seo_keyword">{{__('lang.admin_seo_keyword')}}</label>
    <textarea type="text" class="form-control" value="{{$row->value}}" name="site_seo_keyword" placeholder="{{__('lang.admin_seo_keyword_placeholder')}}">{{$row->value}}</textarea>
</div>
@endif
@if($row->key == 'site_seo_tag')
<div class="col-md-12 mb-3 display-inline-block width-32-percent mr-10">
    <label class="form-label" for="site_seo_tag">{{__('lang.admin_seo_tags')}}</label>
    <textarea type="text" class="form-control" value="{{$row->value}}" name="site_seo_tag" placeholder="{{__('lang.admin_seo_tags_placeholder')}}">{{$row->value}}</textarea>
</div>
@endif
@if($row->key == 'site_logo')
<div class="col-md-4 mb-3 display-inline-block mr-10">
    <label class="form-label" for="basic-icon-default-uname">{{__('lang.admin_website_logo')}}</label>
    <div class="d-flex">
    <img src="{{url('uploads/setting/'.$row->value)}}" class="rounded me-50" id="site-logo-preview" alt="site_logo" height="80" width="80" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`"/>
    <div class="mt-75 ms-1">
        <label class="btn btn-primary me-75 mb-0" for="change-site-logo">
        <span class="d-none d-sm-block">{{__('lang.admin_upload_website_logo')}}</span>
        <input class="form-control" type="file" name="site_logo" id="change-site-logo" hidden accept="image/*" name="site_logo" onclick="showImagePreview('change-site-logo','site-logo-preview',512,512);"/>
        <span class="d-block d-sm-none">
            <i class="me-0" data-feather="edit"></i>
        </span>
        </label>
        <p>{{__('lang.admin_upload_website_logo_resolution')}}</p>
    </div>
    </div>
</div>
@endif
@if($row->key == 'website_admin_logo')
<div class="col-md-4 mb-3 display-inline-block mr-10">
    <label class="form-label" for="basic-icon-default-uname">{{__('lang.admin_website_admin_logo')}}</label>
    <div class="d-flex">
    <img src="{{url('uploads/setting/'.$row->value)}}" class="rounded me-50" id="website-admin-logo-preview" alt="website_admin_logo" height="80" width="80" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`"/>
    <div class="mt-75 ms-1">
        <label class="btn btn-primary me-75 mb-0" for="change-website-admin-logo">
        <span class="d-none d-sm-block">{{__('lang.admin_upload_website_admin_logo')}}</span>
        <input class="form-control" type="file" name="website_admin_logo" id="change-website-admin-logo" hidden accept="image/*" name="website_admin_logo" onclick="showImagePreview('change-website-admin-logo','website-admin-logo-preview',512,512);"/>
        <span class="d-block d-sm-none">
            <i class="me-0" data-feather="edit"></i>
        </span>
        </label>
        <p>{{__('lang.admin_website_admin_logo_resolution')}}</p>
    </div>
    </div>
</div>
@endif
@if($row->key == 'site_favicon')
<div class="col-md-4 mb-3 display-inline-block mr-10">
    <label class="form-label" for="basic-icon-default-uname">{{__('lang.admin_website_favicon')}}</label>
    <div class="d-flex">
        <img src="{{url('uploads/setting/'.$row->value)}}" class="rounded me-50" id="website-favicon-preview" alt="site_favicon" height="80" width="80" onerror="this.onerror=null;this.src=`{{ asset('uploads/no-image.png') }}`"/>
        <div class="mt-75 ms-1">
            <label class="btn btn-primary me-75 mb-0" for="change-website-favicon">
            <span class="d-none d-sm-block">{{__('lang.admin_upload_website_favicon')}}</span>
            <input class="form-control" type="file" name="site_favicon" id="change-website-favicon" hidden accept="image/*" name="site_favicon" onclick="showImagePreview('change-website-favicon','website-favicon-preview',512,512);"/>
            <span class="d-block d-sm-none">
                <i class="me-0" data-feather="edit"></i>
            </span>
            </label>
            <p>{{__('lang.admin_website_favicon_resolution')}}</p>
        </div>
    </div>
</div>
@endif