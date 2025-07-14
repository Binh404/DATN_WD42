<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-[30%] bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                {{ __('Quên mật khẩu?') }}
            </h2>

            <p class="text-sm text-gray-600 mb-6 text-center">
                {{ __('Không sao cả. Vui lòng nhập email và chúng tôi sẽ gửi cho bạn liên kết để đặt lại mật khẩu.') }}
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-indigo-200"
                        type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-center">
                    <x-primary-button class="w-full justify-center">
                        {{ __('Gửi liên kết đặt lại mật khẩu') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>