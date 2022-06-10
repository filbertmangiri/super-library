<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function createModerator()
    {
        return view('dashboard.moderator.create', [
            'users' => User::where('level', 0)->get()
        ]);
    }

    public function storeModerator(Request $request)
    {
        $validated = $request->validate([
            'level' => 'numeric',
            'user_id' => 'numeric'
        ]);

        $user = User::find($request->input('user_id'));

        $user->update($validated);

        return Redirect::back()->with('alert', [
            'text' => 'Berhasil menambahkan moderator'
        ]);
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
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if ($request->file('photo')) {
            if ($request->input('old_photo') && $request->input('old_photo') != User::IMAGE_PATH) {
                Storage::delete($request->input('old_photo'));
            }

            $validated['photo'] = $request->file('photo')->store('user-photos');
        }

        $user->update($validated);

        return Redirect::back()->with('alert', [
            'text' => 'Berhasil memperbarui user'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        return Redirect::route('dashboard.user')->with('alert', [
            'text' => 'Berhasil memblokir user'
        ]);
    }

    /**
     *  Restore the specified resource
     * 
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        User::withTrashed()->firstWhere('username', $request->input('username'))->restore();

        return Redirect::route('dashboard.user')->with('alert', [
            'text' => 'Berhasil membuka blokir user'
        ]);
    }

    /**
     * Force delete the specified resource
     * 
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Request $request)
    {
        $user = User::withTrashed()->firstWhere('username', $request->input('username'));

        if ($user->photo && $user->photo != User::IMAGE_PATH) {
            Storage::delete($user->photo);
        }

        $user->forceDelete();

        return Redirect::route('dashboard.user')->with('alert', [
            'text' => 'Berhasil memblokir user secara permanen'
        ]);
    }

    /**
     * Restore all soft deleted resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function restoreAll()
    {
        User::onlyTrashed()->restore();

        return Redirect::route('dashboard.user')->with('alert', [
            'text' => 'Berhasil membuka blokir semua user'
        ]);
    }
}
