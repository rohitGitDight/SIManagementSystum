{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<!DOCTYPE html>
<html>

<head>
    <title>Login & Registration</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/login/style.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="cont">
        <div class="form sign-in">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2>Sign In</h2>
                <label>
                    <span>Email Address</span>
                    <input type="email" name="email" id="email" :value="old('email')" required autofocus
                        autocomplete="username" />
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" id="password" class="block mt-1 w-full" required
                        autocomplete="current-password" />
                </label>
                <button class="submit" type="submit">Sign In</button>
                <p class="forgot-pass">Forgot Password ?</p>
            </form>
            <div class="social-media">
                <ul>
                    <li><img src="{{ asset('/images/theme_img/facebook.png') }}" /></li>
                    <li><img src="{{ asset('/images/theme_img/twitter.png') }}" /></li>
                    <li><img src="{{ asset('/images/theme_img/linkedin.png') }}" /></li>
                    <li><img src="{{ asset('/images/theme_img/instagram.png') }}" /></li>
                </ul>
            </div>
        </div>

        <div class="sub-cont">
            <div class="img">
                <div class="img-text m-up">
                    <h2>New here?</h2>
                    <p>Sign up and discover great amount of new opportunities!</p>
                </div>
                <div class="img-text m-in">
                    <h2>One of us?</h2>
                    <p>
                        If you already has an account, just sign in. We've missed you!
                    </p>
                </div>
                <div class="img-btn">
                    <span class="m-up">Sign Up</span>
                    <span class="m-in">Sign In</span>
                </div>
            </div>
            <div class="form sign-up">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h2>Sign Up</h2>
                    <label>
                        <span>Name</span>
                        <input type="text" id="name" name="name" :value="old('name')" required autofocus
                            autocomplete="name" />
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" id="email" name="email" :value="old('email')" required
                            autocomplete="username" />
                    </label>
                    <label>
                        <span>Password</span>
                        <input type="password" id="password" name="password" required autocomplete="new-password" />
                    </label>
                    <label>
                        <span>Confirm Password</span>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            autocomplete="new-password" />
                    </label>
                    <button type="submit" class="submit">Sign Up Now</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('/js/login/script.js') }}"></script>
</body>

</html>
