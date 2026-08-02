@extends('layouts.app')

@section('title', 'درخواست ثبت شد')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 text-center">
        <div class="text-6xl mb-4">✅</div>
        <h1 class="text-2xl font-bold text-green-700 mb-4">درخواست شما با موفقیت ثبت شد!</h1>
        <p class="text-gray-600 mb-6">
            درخواست شما برای تأیید به ادمین ارسال شد. 
            پس از تأیید، اطلاعات ورود به ایمیل شما ارسال خواهد شد.
        </p>
        <a href="{{ route('home') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
            بازگشت به صفحه اصلی
        </a>
    </div>
</div>
@endsection