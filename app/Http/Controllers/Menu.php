<?php

namespace App\Http\Controllers;

use App\Lib\GetButton;
use App\Models\MenuModel;
use App\Models\MenuPermissionModel;
use Illuminate\Http\Request;

class Menu extends Controller
{

    public $button;

	public function __construct()
	{
		$this->button = new GetButton;
	}

    public function index()
    {
        $title = 'Menu';
        $button = $this->button;
        $data = MenuModel::all();
        return view('menu.index', compact('data', 'title', 'button'));
    }

    public function store(Request $request)
    {
        
        if($request->isMethod('POST')){
            $validatedData = $request->validate([
                'nama' => 'required|max:255|unique:bs_menu',
                'url' => 'required',
            ]);

            $permission = MenuPermissionModel::PERMISSION;

            if($validatedData){
                $data = [
                    'parent' => $request->parent,
                    'nama' => $request->nama,
                    'url' => $request->url,
                    'uri' => $request->uri,
                    'icon' => $request->icon,
                    'urutan' => $request->urutan,
                    'status' => 1,
                    // 'created_by' => auth()->user()->email,
                    // 'updated_by' => auth()->user()->email,
                    'created_by' => session()->get('username'),
                    'updated_by' => session()->get('username'),
                ];
                $insert = MenuModel::create($data);
                $id = $insert->id;
                foreach($permission as $per){
                    $data_per = [
                        'id_menu' => $id,
                        'permission' => $per,
                        'is_active' => 1,
                        // 'created_by' => auth()->user()->email,
                        // 'updated_by' => auth()->user()->email,
                        'created_by' => session()->get('username'),
                        'updated_by' => session()->get('username'),
                    ];
                    MenuPermissionModel::create($data_per);
                }
                return redirect($this->button->formEtc('Menu'))->with('success', 'Input data berhasil');
            }
        }else{
            $title = 'Menu';
            $button = $this->button;
            $parent = MenuModel::whereRaw("parent IS NULL AND status = 1")->get();
            return view('menu.add', compact('title', 'parent', 'button'));
        }
        
    }

    public function update(Request $request, $id=null)
    {
        if($request->isMethod('POST')){
            $user = MenuModel::findOrFail($request->id);
            $validatedData = $request->validate([
                'nama' => 'required|max:255',
                'url' => 'required',
            ]);

            if ($validatedData) {
                $user->update([
                    'parent' => $request->parent,
                    'nama' => $request->nama,
                    'url' => $request->url,
                    'uri' => $request->uri,
                    'icon' => $request->icon,
                    'urutan' => $request->urutan,
                    // 'updated_by' => auth()->user()->email,
                    'updated_by' => session()->get('username'),
                ]);
                return redirect($this->button->formEtc('Menu'))->with('success', 'Edit data berhasil');
            }
        }else{
            $title = 'Menu';
            $button = $this->button;
            $data = MenuModel::find($id);
            $parent = MenuModel::whereRaw("parent IS NULL AND status = 1")->get();
            return view('menu.edit', compact('data', 'title', 'parent', 'button'));
        }
    }

    public function status(Request $request)
    {
        $menu = MenuModel::findOrFail($request->id);
        $st_ubah = 1;
        if($menu['status'] == 1){
            $st_ubah = 0;
        }
        $menu->update([
            'status' => $st_ubah,
            // 'updated_by' => auth()->user()->email,
            'updated_by' => session()->get('username'),
        ]);
        return redirect($this->button->formEtc('Menu'))->with('success', 'Input data berhasil');
    }

    public function delete($id)
    {
        MenuModel::findOrFail($id)->delete();
        return redirect($this->button->formEtc('Menu'))->with('success', 'Hapus data berhasil');
    }
}
