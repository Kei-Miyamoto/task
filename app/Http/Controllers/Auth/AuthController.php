<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

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
  
  
    $credentials = $request->only('email','password');
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      \Session::flash('msg_success', 'ログイン成功しました');
      return redirect()->route('home');
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
  public function register(registerRequest $request) {
    \DB::beginTransaction();
    $users = User::all();
    $user = new User;
    //メールアドレスが重複しないか
    $request->validate([
      'email' => [Rule::unique('users')->ignore($user->id)],
    ]);
    
    //新規登録
    try {
      //Usersテーブルに作成
      $inputs = [
        $user->user_name = $request->user_name,
        $user->email =  $request->email,
        $user->password = Hash::make($request->password),
      ];
      //dd($inputs);
      //DBに保存
      $user->fill($inputs)->save();
      \DB::commit();
      \Session::flash('msg_success', 'ユーザ登録に成功しました');
    } catch (\Throwable $e){
      \DB::rollback();
      abort(500);
      \Session::flash('msg_error', 'ユーザ登録に失敗しました');
      return redirect(route('showRegister'));
    } 
    return redirect(route('showLogin'));
  }
  
  
}
