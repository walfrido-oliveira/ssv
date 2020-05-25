<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
	 * @var User
	 */
    private $user;

    /**
     * create a new instance of controll
     */
	public function __construct(User $user)
	{
        $this->user = $user;

        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(10);
        return view('admin.users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles($this->user));

        $this->user->create($request->all());

        flash('success', 'User added successfully!');

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = $this->user->where('slug', $slug)->first();

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user = $this->user->where('slug', $slug)->first();

        $roles = Role::pluck('name', 'name')->all();

        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
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
        $data = $request->only(['roles', 'profile_image']);

        $user = $this->user->find($id);

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

        return redirect(route('admin.profile.show'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);

        $user->delete();

        flash('success', 'User removed successfully!');

        return redirect(route('admin.users.index'));
    }

    /**
     * Get rules of validation
     *
     * @param Transport Method user
     * @return array
     */
    public function roles($user)
    {
        return
        [
            'name' => 'required|max:255|unique:users,name,' . $user->id
        ];
    }
}
