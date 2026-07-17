<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings.site_name' => 'required|string|max:255',
            'settings.site_tagline' => 'nullable|string|max:500',
            'settings.contact_email' => 'required|email',
            'settings.contact_phone' => 'nullable|string|max:50',
            'settings.telegram' => 'nullable|string|max:255',
            'settings.whatsapp' => 'nullable|string|max:255',
            'settings.meta_title' => 'nullable|string|max:255',
            'settings.meta_description' => 'nullable|string|max:500',
        ]);

        foreach ($validated['settings'] as $key => $value) {
            \App\Models\Setting::set($key, $value, 'general');
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
