<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\RoleModel;
use App\Models\UserModel as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index()
    {
        $title = 'User';
        $data = ModelsUser::select('users.id', 'name', 'email', 'bs_role.nama as nama_role')
                            ->leftJoin('bs_role', 'users.id_role', '=', 'bs_role.id')
                            ->get();
        $button = $this->button;
        return view('user.index', compact('data', 'title', 'button'));
    }

    public function store(Request $request)
    {
        if($request->isMethod('POST')){
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|unique:users',
                'id_role' => 'required',
                'password' => 'required',
            ]);
    
            $validatedData['password'] = Hash::make($validatedData['password']);
    
            ModelsUser::create($validatedData);
            return redirect($this->button->formEtc('User'))->with('success', 'Input data berhasil');
        }else{
            $title = 'User';
            $button = $this->button;
            $role = RoleModel::all();
            return view('user.add', compact('title', 'role', 'button'));
        }
        
    }

    public function update(Request $request, $id=null)
    {
        if($request->isMethod('POST')){
            $user = ModelsUser::findOrFail($request->id);
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required',
                'id_role' => 'required',
            ]);

            if ($validatedData) {
                $user->update([
                    'name'    => $request->name,
                    'email'   => $request->email,
                    'id_role' => $request->id_role
                ]);
                return redirect($this->button->formEtc('User'))->with('success', 'Edit data berhasil');
            }
        }else{
            $title = 'User';
            $data = ModelsUser::find($id);
            $role = RoleModel::all();
            $button = $this->button;
            return view('user.edit', compact('data', 'title', 'role', 'button'));
        }
    }

    public function delete($id)
    {
        ModelsUser::findOrFail($id)->delete();
        return redirect($this->button->formEtc('User'))->with('success', 'Hapus data berhasil');
    }

    public function api_user()
    {
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "http://localhost/stock/public/api/user");
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_POST, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		$response = curl_exec($curl);
		curl_close($curl);
        $title = 'API User';
        $data = json_decode($response, true)['data'];
        return view('user.api', compact('data', 'title'));
    }
}
