<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Image;
use App\Http\Requests\FormUserRequest;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('can:isMaster');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::latest()->paginate(5);

        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormUserRequest $request)
    {
        $password = bcrypt($request->password);
        $request->merge(['password' => $password]);

        if ($request->foto) {
            $fileExploded = explode(';', $request->foto);
            $fileExtension = explode('/', $fileExploded[0]);
            $filename = str_slug($request->nip).'-'.time().'.'.$fileExtension[1];
            
            Image::make($request->foto)->resize(500, 500)->save(public_path('img/profile/'.$filename));
        } else {
            $filename = 'profile.png';
        }
        
        $request->merge(['foto' => $filename]);

        $user = User::create($request->all());

        return response()->json([
            'data' => $user,
            'message' => 'User '.$request->username.' ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->password) {
            $password = bcrypt($request->password);
            $request->merge(['password' => $password]);
        }

        $currentFoto = $user->foto;
        if ($request->foto != $currentFoto) {
            $fileExploded = explode(';', $request->foto);
            $fileExtension = explode('/', $fileExploded[0]);
            $filename = str_slug($request->nip).'-'.time().'.'.$fileExtension[1];
            

            Image::make($request->foto)->resize(500, 500)->save(public_path('img/profile/'.$filename));
            if ($currentFoto!='profile.png') {
                @unlink(public_path('img/profile/').$currentFoto);
            }

            $request->merge(['foto' => $filename]);
        }

        $user->update($request->all());

        return response()->json([
            'data' => $user,
            'message' => 'Data User '.$user->username.' telah diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->foto!='profile.png') {
            @unlink(public_path('img/profile/').$user->foto);
        }

        $user->delete();

        return response()->json([
            'message' => 'User '.$user->username.' telah dihapus'
        ]);
    }

    public function search(Request $request)
    {
        if ($keywords = $request->keywords) {
            $user = User::where(function($query) use ($keywords) {
                $query->where('nip', 'LIKE', "%$keywords%")
                        ->orWhere('nama', 'LIKE', "%$keywords%")
                        ->orWhere('username', 'LIKE', "%$keywords%")
                        ->orWhere('tipe', 'LIKE', "%$keywords%");
            })->paginate(5);
        }

        return response()->json([
            'data' => $user
        ]);
    }
}
