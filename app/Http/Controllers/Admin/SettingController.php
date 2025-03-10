<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as ContentSetting;
use App\Models\Setting;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;


class SettingController extends Controller
{
    public function index()
    {
        $data['result'] = Setting::get();
        $data['settings'] = Setting::get();
        $data['headline'] = Setting::where('key', 'headline')->get();
        $country_id = Setting::where('key', 'country')->value('value');
        $state_id = Setting::where('key', 'state')->value('value');
        $data['country_data'] = Country::get();
        $data['state_data'] = State::where('countryid', $country_id)->get();
        $data['city_data'] = City::where('stateid', $state_id)->get();
        $data['loactionsettings'] = Setting::with(['country', 'state', 'city'])->get();
        return view('admin.setting.index', $data);
    }


    public function update(Request $request)
    {
        try {
            $updated = Setting::updateContent($request->all());
            if ($updated['status']) {
                return redirect()->back()->with('success', $updated['message']);
            } else {
                return redirect()->back()->with('error', $updated['message']);
            }
            //Set into current setting
            $settingsc = Setting::all();
            foreach ($settingsc as $row) {
                ContentSetting::set($row->key, $row->value);
            }
            ContentSetting::save(); // Save the settings
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage() . ' ' . $ex->getLine() . ' ' . $ex->getFile());
        }
    }

    public function storeheading(Request $request)
    {
        // Delete all existing headlines
        $headlines = [];
        Setting::where('key', 'headline')->delete();
        // Ensure the request has the 'headline' key and it contains values
        if ($request->has('headline') && is_array($request->headline)) {
            foreach ($request->headline as $headline) {
                Setting::create([
                    'value' => $headline,
                    'key' => 'headline',
                ]);
                $headlines[] = $headline;
            }
        }
        // Store the array of headlines in ContentSetting
        ContentSetting::set('headline', $headlines);
        ContentSetting::save(); // Save the settings
        // Redirect back with a success message
        return redirect()->back();
    }

    public function deleteHeadline(Request $request)
    {
        // Find the setting with the given value (assuming the key is 'headline')
        $setting = Setting::where('key', 'headline')->where('value', $request->headline)->first();
        if ($setting) {
            $setting->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);  // Return failure if not found
    }

    public function setLanguage(Request $request)
    {
        $post = $request->all();
        if (array_key_exists($post['lang'], Config::get('languages'))) {
            if (isset($post['lang'])) {
                App::setLocale($post['lang']);
                Session::put('admin_locale', $post['lang']);
                setcookie('admin_lang_code', $post['lang'], time() + 60 * 60 * 24 * 365);
            }
        }
        return redirect()->back();
    }
}
