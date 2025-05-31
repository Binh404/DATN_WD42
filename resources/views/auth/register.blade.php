<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf



        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

{{-- Phòng ban --}}
<div class="mt-4">
    <x-input-label for="phong_ban_id" :value="__('Phòng ban')" />
    <select id="phong_ban_id" name="phong_ban_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        <option value="">-- Chọn phòng ban --</option>
        @foreach ($phongban as $phongBan)
            <option value="{{ $phongBan->id }}">{{ $phongBan->ten_phong_ban }}</option>
        @endforeach
    </select>
</div>

{{-- Chức vụ --}}
<div class="mt-4">
    <x-input-label for="chuc_vu_id" :value="__('Chức vụ')" />
    <select id="chuc_vu_id" name="chuc_vu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        <option value="">-- Chọn chức vụ --</option>
        {{-- Options sẽ được load bằng JavaScript --}}
    </select>
</div>

        

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
<script>
    document.getElementById('phong_ban_id').addEventListener('change', function () {
        const phongBanId = this.value;
        const chucVuSelect = document.getElementById('chuc_vu_id');

        // Xóa danh sách chức vụ hiện tại
        chucVuSelect.innerHTML = '<option value="">-- Chọn chức vụ --</option>';

        if (phongBanId) {
            fetch(`/chuc-vus/${phongBanId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(chucVu => {
                        const option = document.createElement('option');
                        option.value = chucVu.id;
                        option.textContent = chucVu.ten;
                        chucVuSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi tải danh sách chức vụ:', error);
                });
        }
    });
</script>