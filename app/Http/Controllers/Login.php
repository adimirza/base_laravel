<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    public function index()
    {
        $data['title'] = 'Login';
        return view('login.index', $data);
    }

    public function register()
    {
        $data['title'] = 'Register';
        return view('login.register', $data);
    }

    public function proses_login(Request $request)
    {
        // $code = $request->CaptchaCode;
        // // $isHuman = captcha_validate($code);
        // $isHuman = Captcha::check();
        // print_r($isHuman);
        // die;
        // Validator::make($request->all(), [
        //     'email' => 'required|email:dns',
        //     'password' => 'required',
            // 'captcha' => 'required|captcha'
            // 'CaptchaCode' => 'required|captcha_validate'
            // 'g-recaptcha-response' => 'recaptcha',
        // ])->validate();

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            // $request->session()->regenerate();
            session()->regenerate();
                $data = [
                    'username' => $request->username,
                    'status' => 1,
                    'id_role' => 1,
                ];
            session()->put($data);
            // print_r(session()->get('username'));
            // die;
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login Failed!');
    }

    // public function reloadCaptcha()
    // {
    //     return response()->json(['captcha'=> captcha_img()]);
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['id_role'] = '1';

        UserModel::create($validatedData);
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
