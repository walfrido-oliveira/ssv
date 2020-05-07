<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();

        $roles = Role::pluck('name', 'name')->all();

        $userRole = $user->roles->pluck('name', 'name')->all();

        if (!is_null($user))
        {
            return view('admin.show-profile', compact('user', 'roles', 'userRole'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request)
    {
        $data = $request->all();

        $user = auth()->user();

        if (!is_null($user))
        {
            $oldImageProfile = $user->profile_image;

            $user->update($data);

            $user->syncRoles($data['roles']);

            if (!is_null($request->profile_image))
            {
                Storage::delete('public/' . $oldImageProfile);
                $profileImage = $request->profile_image->store('img', ['disk' => 'public']);

                $data['profile_image'] = $profileImage;
                $user->update($data);
            }

            flash('success', __('Profile updated successfully'));
        }

        return redirect(route('admin.profile.show'));

    }

}
