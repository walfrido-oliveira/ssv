<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CredentialRequest;

class CredentialController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();

        if (!is_null($user))
        {
            return view('admin.change-password', compact('user'));
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProfileCredentialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CredentialRequest $request)
    {
        $user = auth()->user();

        $data = $request->all();

        if (!is_null($user))
        {
            $current_password = $user->password;

            if (Hash::check($data['current-password'], $current_password))
            {
                $user->password = Hash::make($data['password']);
                $user->save();
                flash('success', __('Password updated successfully'));
            } else {
                flash('error', __('Please enter correct current password'));
            }
        }

        return redirect(route('admin.profile.credentials.show'));

    }
}
