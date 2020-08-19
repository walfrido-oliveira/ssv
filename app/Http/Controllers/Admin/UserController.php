<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Client\Client;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $term = trim($request->q);

        if (!empty($term)) {
            $users = $this->user
            ->whereHas('roles', function($query) use ($term) {
                $query->where('name', 'like', '%' . $term . '%');
            })
            ->orwhere('id', '=', $term )
            ->orwhere('name', 'like', '%' . $term . '%')
            ->paginate(10);
        } else {
            $users = $this->user->paginate(10);
        }

        return view('admin.users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->user->getRoles();
        $clients = Client::pluck('nome_fantasia', 'id')->all();

        return view('admin.users.create', compact('roles', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->roles());

        $data = $request->all();

        $data['password'] = Hash::make(Str::random(8));

        $user = $this->user->create($data);

        $user->syncRoles($data['roles']);
        $user->clients()->sync($data['clients']);

        if (!is_null($request->profile_image))
        {
            $profileImage = $request->profile_image->store('img', ['disk' => 'public']);

            $data['profile_image'] = $profileImage;
            $user->update($data);
        }

        $user->sendWelcomeEmail();

        flash('success', __('User added successfully!'));

        return redirect(route('admin.users.index'));
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

        $roles = $this->user->getRoles();
        $clients = Client::pluck('nome_fantasia', 'id')->all();

        $userRole = $user->roles->pluck('name', 'name')->all();
        $userClient = $user->clients->pluck('id')->all();

        return view('admin.users.edit', compact('user', 'roles', 'clients', 'userRole', 'userClient'));
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
        $data = $request->only(['roles', 'clients', 'profile_image']);

        $user = $this->user->find($id);

        $oldImageProfile = $user->profile_image;

        $user->update($data);

        $user->syncRoles($data['roles']);

        $user->clients()->sync([]);

        if (isset($data['clients']))
        {
            $user->clients()->sync($data['clients']);
        }

        if (!is_null($request->profile_image))
        {
            Storage::delete('public/' . $oldImageProfile);
            $profileImage = $request->profile_image->store('img', ['disk' => 'public']);

            $data['profile_image'] = $profileImage;
            $user->update($data);
        }

        flash('success', __('User updated successfully!'));

        return redirect(route('admin.users.index'));
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
     * @return array
     */
    public function roles()
    {
        return
        [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'roles' => 'required'
        ];
    }
}
