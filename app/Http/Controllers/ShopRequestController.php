<?php

namespace App\Http\Controllers;

use App\Models\ShopRequest;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopRequestController extends Controller
{
    public function create()
    {
        $packages = Package::where('is_active', true)->get();
        return view('shop-request.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // اطلاعات فروشگاه
            'shop_name' => 'required|string|max:255',
            'shop_slug' => 'required|string|max:255|unique:shop_requests,shop_slug|regex:/^[a-z0-9-]+$/',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'about_text' => 'nullable|string',
            'package_id' => 'nullable|exists:packages,id',
            
            // اطلاعات کاربر
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255|unique:shop_requests,user_email|unique:users,email',
            'user_password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            // ایجاد درخواست
            $shopRequest = ShopRequest::create([
                'shop_name' => $validated['shop_name'],
                'shop_slug' => $validated['shop_slug'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'about_text' => $validated['about_text'],
                'user_name' => $validated['user_name'],
                'user_email' => $validated['user_email'],
                'user_password' => Hash::make($validated['user_password']),
                'package_id' => $validated['package_id'] ?? null,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('shop.request.success')
                ->with('success', 'درخواست شما با موفقیت ثبت شد. پس از تأیید ادمین، اطلاعات ورود برای شما ارسال می‌شود.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'خطا در ثبت درخواست: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('shop-request.success');
    }
}