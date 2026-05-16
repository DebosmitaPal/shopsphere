<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'max:100'],
            'phone' => ['nullable', 'max:20'],
            'address' => ['nullable', 'max:1000'],
        ]);

        $request->user()->update($data);

        return back()->with('success', 'Profile updated.');
    }
}
