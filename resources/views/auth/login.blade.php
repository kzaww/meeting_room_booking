<x-guest-layout>
    <x-authentication-card>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="employee_id" value="{{ __('User Id') }}" />
                <x-input id="employee_id" class="block mt-1 w-full" type="text" name="employee_id" :value="old('employee_id')" placeholder="user id"  autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password"  name="password" placeholder="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}

                <x-button type="submit  " class="ml-4 bg-emerald-500 hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900" id="login_btn">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    @push('script')
        <script>

        </script>

    @endpush
</x-guest-layout>

