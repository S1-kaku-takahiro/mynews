<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

use App\Profilehistory;

use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
      return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        $this->validate($request, Profile::$rules);
        
        $profiles = new Profile;
        $form = $request->all();
        
        unset($form['_token']);
        
        $profiles->fill($form);
        $profiles->save();
        
        return redirect('admin/profile/create');
        }
    
    public function edit(Request $request)
    {
        $profile = Profile::find($request->id);
        If (empty($profile)) {
        abort(404);
        }
        return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        
        $profile = Profile::find($request->id);
                
        $profile_form = $request->all();
        
        unset($profile_form['_token']);

        $profile->fill($profile_form)->save();
        
        $profilehistory = new Profilehistory;
        $profilehistory->profile_id = $profile->id;
        $profilehistory->edited_at = Carbon::now();
        $profilehistory->save();
        
        return redirect('admin/profile/edit?id=' . $request->id);
    }
}
