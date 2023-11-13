<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RecoverRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Mail\RecoverPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Toastr;

class UserController extends Controller
{
    public function index()
    {
        return view('user.home', [
            'title' => 'Trang người dùng',
            'user' => Auth::user(),
        ]);
    }

    public function login()
    {
        return view('user.login.index', [
            'title' => 'Đăng nhập'
        ]);
    }

    public function forgot()
    {
        return view('user.forgot.index');
    }

    public function recover(RecoverRequest $request)
    {
        if (!$user = User::firstWhere('email', $request->input('email'))) {
            Toastr::error('Email không tồn tại!', __('title.toastr.error'));
            return redirect()->back();
        }
        $source = [
            'a', 'b', 'c', 'd', 'e', 'g', 1, 2, 3, 4, 5, 6
        ];
        $new_password = '';
        foreach ($source as $s) {
            $new_password .= $source[rand(0, count($source) - 1)];
        }
        $reset_password = $user->update([
            'password' => Hash::make($new_password)
        ]);
        if ($reset_password) {
            Mail::to($request->input('email'))->send(new RecoverPasswordMail($new_password));
        }

        Toastr::success('Lấy mật khẩu thành công! Hãy kiểm tra email của bạn', __('title.toastr.success'));
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('users.login');
    }

    public function checkLogin(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            Toastr::success(__('message.success.login'), __('title.toastr.success'));
            $user = Auth::user();
            return redirect()->route($user->role == 1 ? 'admin.index' : 'users.home');
        }
        Toastr::error(__('message.fail.login'), __('title.toastr.fail'));
        return redirect()->back();
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $rs = User::firstWhere('email', $request->input('email'))->update([
            'password' => Hash::make($request->input('password'))
        ]);
        if ($rs) {
            Toastr::success(__('message.success.change_password'), __('title.toastr.success'));
            return response()->json([
                'status' => 0,
                'message' => __('message.success.change_password')
            ]);
        }
        Toastr::success(__('message.fail.change_password'), __('title.toastr.fail'));

        return response()->json([
            'status' => 1,
            'message' => __('message.fail.change_password')
        ]);
    }

    public function register()
    {
        return view('user.register.index', [
            'title' => 'Register',
        ]);
    }

    public function checkRegister(RegisterRequest $request)
    {
        if (User::firstWhere('email', $request->input('email'))) {
            Toastr::error('Email đã có người đăng ký!', __('title.toastr.fail'));
            return redirect()->back();
        }
        if (User::create($request->except('repassword'))) {
            Toastr::success(__('message.success.register'), __('title.toastr.success'));
            return redirect()->route('users.login');
        }
        Toastr::error(__('message.fail.register'), __('title.toastr.fail'));
        return redirect()->back();
    }
}
