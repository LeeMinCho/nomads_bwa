<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\UserAdmin;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.user.index');
    }

    public function userDatatable()
    {
        $user = UserAdmin::query()->with(['role']);
        return DataTables::of($user)
            ->addColumn('action', function ($user) {
                return '<button id="edit-role" data-id="' . $user->id . '" class="btn btn-info"><i class="fas fa-edit"></i></button>';
            })
            ->editColumn('email_verified_at', function ($user) {
                if ($user->email_verified_at == NULL) {
                    return '<span class="badge badge-secondary"><i></i>Not Verified</span>';
                } else {
                    return '<div class="badge badge-success">Verified</div>';
                }
            })
            ->escapeColumns(['name', 'email', 'created_at'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['name'] = $request->name;
        $data['roles_id'] = 1;
        $data['username'] = '';
        $data['email_verified_at'] = date("Y-m-d H:i:s");
        UserAdmin::create($data);
        return response(['message' => 'Success create new data!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
