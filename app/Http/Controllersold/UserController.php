<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function getUsers()
    {
        if ((Auth::user()->usertype == "chefgare" || Auth::user()->usertype == "caissiere") && Auth::user()->gare_id != null) {
            $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->where('gare_id', Auth::user()->gare_id)->get();
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->where('id', Auth::user()->gare_id)->get();
        }
        else
        {
            $users = DB::table('users')->where('compagnie_id', Auth::user()->compagnie_id)->get();
            $gares = DB::table('gare')->where('compagnie_id', Auth::user()->compagnie_id)->get();
        }

        return view('user-lists', compact('users', 'gares'));
    }

    public function store(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:255',
            'usertype' => 'required|string|max:255',
            'gare_id' => 'sometimes',
            'id_module' => 'sometimes',
            'email' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;
        $validated['password'] = Hash::make($validated['password']);

        if(User::insert($validated))
        {
            return back()->withSuccess("Insertion réussi !");
        }

    }


    public function update(REQUEST $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'password' => 'sometimes',
            'phone' => 'required|string|max:255',
            'usertype' => 'required|string|max:255',
            'gare_id' => 'sometimes',
            'id_module' => 'sometimes',
            'email' => 'sometimes',
        ]);
 
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
        $validated['compagnie_id'] = Auth::user()->compagnie_id;

        if ($validated['password'] != null) {
            $validated['password'] = Hash::make($validated['password']);
        }
        else
        {
            // We don't want to change password to null So we remove it using collection helpers and convert to array like it was.
            $validated = collect($validated)->except(['password'])->toArray();
        }
        // dd($validated);

        if(User::where('id', $validated['id'])->update($validated))
        {
            return back()->withSuccess("Mise à jour réussi !");
        }
    }

    public function delete(int $id)
    {
        $user = User::where('id', $id)->first();
        if($user->delete())
        {
            return back()->withInfo("Suppression réussi !");
        }
    }
}
