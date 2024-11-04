<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Exception;
use File;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        return view('profil.index', compact('user'));
    }
    public function edit(Request $request){
        $user = $request->user();

        return view('profil.edit', compact('user'));
    }
    public function update(Request $request, $id){
        $user = $request->user();
        if($user->id != $id){
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses.');
        }
        $request->validate([
            'name' => 'required|string|max:250',
            'photo' => 'image|nullable|max:1999'
        ]);
        if($request->hasFile('photo')){
            $previousPhoto = public_path()."/storage/".$user->photo;
            try {
                if(File::exists($previousPhoto)){
                    File::delete($previousPhoto);
                }
            } catch (Exception $e){
                
            }
            $fileNameWithExt = $request->file('photo')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $request->file('photo')->getClientOriginalExtension();
            $fileNameSimpan = $fileName . "_". time() .  "." . $fileExt;
            $path = $request->file('photo')->storeAs('photos', $fileNameSimpan); 
        } else {
            $path = null;
        }
        $userData = User::findOrFail($id);
        $userData->name = $request->name;
        if($path){
            $userData->photo = $path;
        }        
        $userData->save();

        return redirect()->route('profil.index');
    }
    public function destroy(Request $request, $id){
        $user = $request->user();
        if($user->id != $id){
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses.');
        }
        $userData = User::findOrFail($id);
        $userPhoto = public_path() . '/storage/' .$user->photo;
        try {
            if(File::exists($userPhoto)){
                File::delete($userPhoto);
            }
            $user->delete();
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('success', 'You have logged out successsfully!');
        } catch(Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Gagal menghapus akun!');
        }
    }
}
