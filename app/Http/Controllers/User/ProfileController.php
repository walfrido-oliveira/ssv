<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Client\Client;
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
        $clients = Client::pluck('nome_fantasia', 'id')->all();

        $userRole = $user->roles->pluck('name', 'name')->all();
        $userClient = $user->clients->pluck('nome_fantasia')->all();

        if (!is_null($user))
        {
            return view('user.show-profile', compact('user', 'roles', 'clients', 'userRole', 'userClient'));
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
        $data = $request->only(['profile_image']);

        $user = auth()->user();

        if (!is_null($user))
        {
            $oldImageProfile = $user->profile_image;

            if (!is_null($request->profile_image))
            {
                Storage::delete('public/' . $oldImageProfile);
                $profileImage = $request->profile_image->store('img', ['disk' => 'public']);

                $data['profile_image'] = $profileImage;

            } else {
                $data['profile_image'] = $oldImageProfile;
            }

            $user->update(
                [
                    'profile_image' => $data['profile_image'],
                ]
            );

            flash('success', __('Profile updated successfully'));

        }

        return redirect(route('user.profile.show'));

    }

}
