<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required'
        ]);

        $data = $request->all();
        $user = User::find($id);
        $user->update($data);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($data['roles']);

        if (!is_null('profile_image'))
        {
            $profileImage = $request->profile_image->store('img', ['disk' => 'public']);
            $data['profile_image'] = $profileImage;
            $user->update($data);
        }

        flash(__('Profile updated successfully'))->success();

        return \redirect(\route('admin.profile.show'));

    }
}
