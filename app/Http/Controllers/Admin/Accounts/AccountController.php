<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Accounts\CreateAccountRequest;
use App\Http\Requests\Admin\Accounts\UpdateAccountRequest;
use App\Models\DetailInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Toastr;

class AccountController extends Controller
{
    public function create()
    {
        return view('admin.account.add', [
            'title' => 'Add account'
        ]);
    }

    public function store(CreateAccountRequest $request)
    {
        if (User::firstWhere('email', $request->input('email'))) {
            Toastr::error('Email đã có người đăng ký!', __('title.toastr.fail'));
            return redirect()->back();
        }
        if ($user = User::create($request->validated())) {
            DetailInfo::create(['user_id' => $user->id]);
            Toastr::success(__('message.success.register'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.register'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function update(UpdateAccountRequest $request)
    {
        $data = $request->validated();
        unset($data['id']);
        $update = User::where('id', $request->input('id'))->update($data);
        if ($update) {
            Toastr::success(__('message.success.update'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.update'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function delete( $id)
    {
        $delete = User::firstWhere('id', $id)->delete();
        if ($delete) {
            Toastr::success(__('message.success.delete'), __('title.toastr.success'));
        } else Toastr::error(__('message.fail.delete'), __('title.toastr.fail'));

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.account.list', [
            'title' => 'List account',
            'users' => User::all()
        ]);
    }

    public function show($id)
    {
        return view('admin.account.edit', [
            'title' => 'List account',
            'user' => User::firstWhere('id', $id)
        ]);
    }
}
