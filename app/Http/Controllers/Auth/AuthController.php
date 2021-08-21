<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;


class AuthController extends Controller
{
  /**
   * ログイン画面表示
   * @return View
   */
  public function showLogin() {
    return view('loginForm');
  }
  
  /**
   * ログイン処理
   * @param App\Http\Requests\UserRequest
   * $request
   */
  public function login(UserRequest $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->route('home')->with('msg_success', 'ログイン成功しました');
    }
    
    \Session::flash('msg_error', 'ログイン失敗しました');
    return back()->withErrors([
      'msg_error' => 'メールアドレスかパスワードが間違っています',
    ]);
  }
  /**
   * ログアウト処理
   * @param \Illuminate\Http\Request
   * $request
   * @return \Illuminate\Http\Response
   */
  public function logout (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('showLogin')->with('msg_success', 'ログアウトしました');
  }

  /**
   * 新規登録画面表示
   * @return View
   */
  public function showRegister() {
    return view('registerForm');
  }
  
  /**
   * 新規登録処理
   * @param App\Http\Requests\UserRequest
   * $request
   */
  public function Register(UserRequest $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->route('home')->with('msg_success', 'ログイン成功しました');
    }
    
    \Session::flash('msg_error', 'ログイン失敗しました');
    return back()->withErrors([
      'msg_error' => 'メールアドレスかパスワードが間違っています',
    ]);
  }
  
  
}
