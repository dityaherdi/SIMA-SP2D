<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Image;
use App\Http\Requests\FormProfileRequest;

class ProfileController extends Controller
{
    public function updateProfile(FormProfileRequest $request)
    {
        $user = User::findOrFail($request->id_user);

        $user['nama'] = $request->nama;
        $user['username'] = $request->username;
        if ($request->password) {
            $user['password'] = bcrypt($request->password);
        }

        if ($request->foto != $user->foto) {
            $fileExploded = explode(';', $request->foto);
            $fileExtension = explode('/', $fileExploded[0]);
            $filename = str_slug($request->nip).'-'.time().'.'.$fileExtension[1];
            
            Image::make($request->foto)->resize(500, 500)->save(public_path('img/profile/'.$filename));
            $user['foto'] = $filename;
        }

        $user->save();

        return response()->json([
            'data' => $user,
            'message' => 'Profil anda telah diperbarui'
        ]);
        
    }
}
