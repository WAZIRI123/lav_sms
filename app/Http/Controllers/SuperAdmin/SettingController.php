<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingUpdate;
use App\Repositories\MyClassRepo;
use App\Repositories\SettingRepo;

class SettingController extends Controller
{
    protected $setting, $my_class;

    public function __construct(SettingRepo $setting, MyClassRepo $my_class)
    {
        $this->setting = $setting;
        $this->my_class = $my_class;
    }

    public function index()
    {
         $s = $this->setting->all();
         $d['class_types'] = $this->my_class->getTypes();
         $d['s'] = $s->flatMap(function($s){
            return [$s->type => $s->description];
        });
        return view('pages.super_admin.settings', $d);
    }

    public function update(SettingUpdate $req)
    {
        $sets = $req->except('_token', '_method', 'logo');
        $sets['lock_exam'] = $sets['lock_exam'] == 1 ? 1 : 0;
        $keys = array_keys($sets);
        $values = array_values($sets);
        
        // Update all settings except logo
        for($i=0; $i<count($sets); $i++){
            $this->setting->update($keys[$i], $values[$i]);
        }

        // Handle logo upload if present
        if($req->hasFile('logo')) {
            $logo = $req->file('logo');
            
            // Validate file type
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($logo->getClientOriginalExtension());
            
            if (!in_array($extension, $validExtensions)) {
                return back()->with('flash_danger', 'Invalid file type. Please upload a valid image (jpg, jpeg, png, gif)');
            }
            
            try {
                // Ensure upload directory exists
                $uploadPath = storage_path('app/public/' . Qs::getPublicUploadPath());
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Generate unique filename
                $filename = 'logo_' . time() . '.' . $extension;
                $path = $logo->storeAs('public/' . Qs::getPublicUploadPath(), $filename);
                
                if ($path) {
                    // Update logo path in database
                    $logoPath = 'storage/' . Qs::getPublicUploadPath() . $filename;
                    $this->setting->update('logo', $logoPath);
                } else {
                    return back()->with('flash_danger', 'Failed to upload logo. Please try again.');
                }
                
            } catch (\Exception $e) {
                \Log::error('Logo upload error: ' . $e->getMessage());
                return back()->with('flash_danger', 'An error occurred while uploading the logo.');
            }
        }

        return back()->with('flash_success', __('msg.update_ok'));
    }
}
