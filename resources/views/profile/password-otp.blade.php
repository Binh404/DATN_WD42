<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Xác minh OTP để đổi mật khẩu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.verify-otp') }}">
                @csrf

                <div class="mt-4">
                    <label for="otp" class="block font-medium text-sm text-gray-700">Mã OTP</label>
                    <input id="otp" name="otp" type="text" required
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Mật khẩu mới</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Xác nhận mật
                        khẩu</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent 
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                        Đổi mật khẩu
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>