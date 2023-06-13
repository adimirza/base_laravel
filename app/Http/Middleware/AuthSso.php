<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthSso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->get('username')){
            print_r(session()->get('username'));
            die;
            return $next($request);
        }elseif(!empty($_COOKIE['token_eoffice'])){
            $nip = $_COOKIE['nip_eoffice'];
            $token = $_COOKIE['token_eoffice'];
            $url = 'http://localhost:8000/api/periksa_token?nip_eoffice='.$nip.'&token_eoffice='.$token;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $req = json_decode(curl_exec($ch), 1);
            curl_close($ch);
            if($req['status'] == '1'){
                $request->session()->regenerate();
                $data = [
                    'username' => $nip,
                    'status' => 1,
                    'id_role' => 1,
                ];
                $request->session()->put($data);
            }
            return $next($request);
        }
        return redirect()->intended('http://localhost:8000/auth?kode=base_laravel');
    }
}
