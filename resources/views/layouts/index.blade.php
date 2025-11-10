@extends('layouts.app')
@section('Title', 'Dashboard Overview')
@section('content')
    <section class="grid grid-cols-3 gap-3">
        <div class="col-span-2 border space-y-3">
            {{-- card data --}}
            <div class="grid grid-cols-3 gap-2">
                <div class="h-36 box-border grid gap-3 border col-span-1 rounded-lg bg-white p-2">
                    <div class="flex items-center gap-2 text-zinc-900">
                        <x-heroicon-o-user-circle class="h-7 w-auto bg-orange-600 text-white rounded-md p-[1.5px]" />
                        <span class="font-semibold">Total Tenaga Kerja</span>
                    </div>
                    <h1 class="font-bold text-2xl py-1">90456</h1>
                    <span class="border-t w-full py-2 text-zinc-500 text-sm font-medium">More Details</span>
                </div>
                <div class="h-36 box-border grid gap-3 border col-span-1 rounded-lg bg-white p-2">
                    <div class="flex items-center gap-2 text-zinc-900">
                        <x-heroicon-o-user-circle class="h-7 w-auto bg-orange-600 text-white rounded-md p-[1.5px]" />
                        <span class="font-semibold">Total Tenaga Kerja</span>
                    </div>
                    <h1 class="font-bold text-2xl py-1">90456</h1>
                    <span class="border-t w-full py-2 text-zinc-500 text-sm font-medium">More Details</span>
                </div>
                <div class="h-36 box-border grid gap-3 border col-span-1 rounded-lg bg-white p-2">
                    <div class="flex items-center gap-2 text-zinc-900">
                        <x-heroicon-o-user-circle class="h-7 w-auto bg-orange-600 text-white rounded-md p-[1.5px]" />
                        <span class="font-semibold">Total Tenaga Kerja</span>
                    </div>
                    <h1 class="font-bold text-2xl py-1">90456</h1>
                    <span class="border-t w-full py-2 text-zinc-500 text-sm font-medium">More Details</span>
                </div>
            </div>
            <div class="grid w-full border h-80 rounded-lg bg-white">

            </div>
        </div>
        <div class="col-span-1 border h-[30rem] bg-white p-4">
            o
        </div>
        <div class="grid col-span-3 w-full border rounded-lg bg-white p-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-clipboard-document-list class="h-7 w-auto rounded-md p-[1.5px]" />
                    <h3 class="font-semibold text-xl">Recent Add</h3>
                </div>
                <a href="#">
                    <x-heroicon-o-arrow-right-circle class="h-7 w-auto -rotate-45" />
                </a>
            </div>
            <div class="h-60 p-2">
                <div>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eum, ea error placeat eligendi facilis itaque sunt ex repellendus esse odio aliquid perspiciatis veritatis. Nesciunt, similique aspernatur aut voluptate enim debitis.
                </div>
            </div>
        </div>
    </section>
@endsection
