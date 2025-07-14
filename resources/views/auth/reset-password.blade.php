<style>
    .w-\[90\%\].sm\:w-\[80\%\].md\:w-\[60\%\].lg\:w-\[45\%\].xl\:w-\[35\%\].bg-white.p-6.rounded-xl.shadow-md {
    width: 40%;
}
</style>
<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-[90%] sm:w-[80%] md:w-[60%] lg:w-[45%] xl:w-[35%] bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                {{ __('Đặt lại mật khẩu') }}
            </h2>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-indigo-200"
                        type="email" name="email" :value="old('email', $request->email)" required autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Mật khẩu mới')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-indigo-200"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-indigo-200"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-center">
                    <x-primary-button class="w-full justify-center">
                        {{ __('Đặt lại mật khẩu') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>