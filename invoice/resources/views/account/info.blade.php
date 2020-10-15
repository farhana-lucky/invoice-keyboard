@extends('layouts.master')

@section('title')
{{ $user->name }}' Information
@endsection

@section('script_vendor')
@endsection

@section('script')
@endsection

@section('content')
<section class="lg:w-1/2 w-full md:mt-5 mt-5 mx-auto">
    <div class="container-fluid px-5 pb-16">
        <div class="flex flex-wrap -mx-4 -mb-10 text-center">
            <div class="w-full mb-10 px-4">
                @include('layouts.alert')
                <form action="{{ route('profile.password_change') }}" method="POST" class="md:w-full px-10 pt-10 pb-5 bg-white rounded-lg shadow-xl border">
                    @csrf
                    <span class="text-left block uppercase text-gray-700 text-2xl font-bold mb-4">Admin Information</span>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                                        Name
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('name') border-red-500 @enderror" value="{{ $user->name }}" name="name" placeholder="Enter your Name">
                                    @error('name')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                                        Email
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="email" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('email') border-red-500 @enderror" value="{{ $user->email }}" name="email" placeholder="example@email.com" autocomplete="new-password" readonly>
                                    @error('email')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                                        Old Password
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="password" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('old_password') border-red-500 @enderror" value="" name="old_password" placeholder="old password" autocomplete="new-password">
                                    @error('old_password')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                                        New-Password
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="password" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('new_password') border-red-500 @enderror" value="" name="new_password" placeholder="new-password" autocomplete="new-password">
                                    @error('new_password')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                                        Confirm New-Password
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="password" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('confirm_password') border-red-500 @enderror" value="" name="confirm_password" placeholder="re new-password" autocomplete="new-password">
                                    @error('confirm_password')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3">
                        <div class="mx-3 ml-auto inline-flex rounded-md shadow">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 block uppercase tracking-wide text-white text-xs font-bold rounded px-8 py-2 focus:outline-none focus:shadow-outline">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection