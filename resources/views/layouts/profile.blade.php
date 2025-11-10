@extends('layouts.app')

@section('content')
    <section class="p-8">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-md p-8">
            {{-- Header Profile --}}
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <img src="{{ asset('asset/user/default.png') }}" alt="user-image"
                    class="w-32 h-32 rounded-full object-cover ring-4 ring-slate-200 shadow-sm">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-800">Karyadi</h2>
                    <p class="text-slate-500 text-sm"><span class="text-amber-600 font-semibold">Admin</span> • Joined Jan
                        2025</p>
                    <div class="mt-3 flex gap-3">
                        <button class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">Edit
                            Profile</button>
                        <button class="px-4 py-2 text-sm bg-slate-100 text-slate-700 rounded-md hover:bg-slate-200">Change
                            Password</button>
                    </div>
                </div>
            </div>

            <hr class="my-8">

            {{-- Profile Info --}}
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm text-slate-500">Nama Lengkap</label>
                    <p class="font-medium text-slate-800">Legum Wardana</p>
                </div>
                <div>
                    <label class="text-sm text-slate-500">Email</label>
                    <p class="font-medium text-slate-800">legum@example.com</p>
                </div>
                <div>
                    <label class="text-sm text-slate-500">No. Telepon</label>
                    <p class="font-medium text-slate-800">+62 812 3456 7890</p>
                </div>
                <div>
                    <label class="text-sm text-slate-500">Alamat</label>
                    <p class="font-medium text-slate-800">Praya, Lombok Tengah</p>
                </div>
            </div>

            <hr class="my-8">

            {{-- Additional Info --}}
            <div>
                <h3 class="text-lg font-semibold text-slate-800 mb-3">Tentang Saya</h3>
                <p class="text-slate-600 leading-relaxed">
                    Saya seorang pengembang fullstack yang fokus pada teknologi Laravel, TailwindCSS, dan Alpine.js.
                    Senang membangun sistem yang efisien, bersih, dan mudah dikelola untuk jangka panjang.
                </p>
            </div>
        </div>
    </section>
@endsection
