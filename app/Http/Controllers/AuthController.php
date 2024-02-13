<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function renderReset()
    {
        return view('pages.auth.reset-password');
    }

    public function renderChange(Request $request)
    {
        $card_number = $request->query('card_number');
        return view('pages.auth.change-password', compact('card_number'));
    }

    public function handleReset(Request $request)
    {
        $card_number = $request->no_kk;
        $find_profile = UserProfile::where('no_kk', $card_number)->first();

        if (!$find_profile) {
            toastr()->error('Akun tidak di temukan di aplikasi kami');
            return redirect('admin/reset-password');
        }

        toastr()->success('Anda akan dialihkan ke form reset');
        return redirect()->route('change-password', ['card_number' => $card_number]);
    }

    public function handleChange(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $card_number = $request->no_kk;

        $find_profile = UserProfile::where('no_kk', $card_number)->first();

        $find_user = User::where('id', $find_profile['user_id'])->first();

        $hashedPassword = Hash::make($request->password);

        $find_user->update(['password' => $hashedPassword]);

        toastr()->success('Password berhasil diubah');

        return redirect('/admin/login');
    }
}
