<?php

namespace App\Http\Controllers;

use App\Services\FileStorageService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected $fileStorageService;

    public function __construct (FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function registration (Request $request , FileStorageService $fileService)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if($fileService->userExists($username)) {
            return back()->withErrors(['registrationError' => 'User already exists']);
        }

        $fileService->saveUser($username , $password);

        session(['user' => $username]);
        return redirect()->route('profile')->with('user' , $username);
    }

    public function login (Request $request , FileStorageService $fileService)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if($request->session()->has('login_attempts')) {
            $attempts = $request->session()->get('login_attempts');
            $blockedUntil = $request->session()->get('blocked_until');

            if($attempts >= 3) {
                if(now()->lessThan($blockedUntil)) {
                    return back()->withErrors(['loginError' => 'Try again in seconds']);
                } else {
                    // Скидаємо спроби, якщо час блокування вичерпався
                    $request->session()->forget('login_attempts');
                    $request->session()->forget('blocked_until');
                }
            }
        }


        if($fileService->verifyUser($username , $password)) {
            session(['user' => $username]);
            return redirect()->route('profile');
        } else {
            $request->session()->increment('login_attempts' , 1);

            if($request->session()->get('login_attempts') >= 3) {
                $request->session()->put('blocked_until' , now()->addMinutes(5));
                return back()->withErrors(['loginError' => 'Try again in seconds']);
            }

            return back()->withErrors(['loginError' => 'Wrong credentials']);
        }
    }

    public function logout (Request $request)
    {
        $request->session()->flush();
        return redirect()->route('home');
    }
}
