<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Login/Register</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/app.min.css') }}">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
            <div class="front">
                <img src="{{ URL::asset('assets/images/value8logo.png') }}" alt="">
                <div class="text">
                    <span class="text-1">Ready to be the next <br> Millionaire</span>
                    <span class="text-2">Let's get started</span>
                </div>
            </div>
            <div class="back">
                <!--<img class="backImg" src="images/backImg.jpg" alt="">-->
                <div class="text">
                    <span class="text-1">Ready to be the next <br> Millionaire</span>
                    <span class="text-2">Get Registered Today</span>
                </div>
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <form method="POST" action="{{ route('authenticate') }}">
                        @csrf
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="text" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="text"><a href="#">Forgot password?</a></div>
                            <div class="button input-box">
                                <input type="submit" value="Submit">
                            </div>
                            <div class="text sign-up-text">Don't have an account? <label for="flip">Sigup
                                    now</label></div>
                        </div>
                    </form>
                </div>
                <div class="signup-form">
                    <div class="title">Register</div>
                    <form method="POST" action="{{ route('store') }}">
                        @csrf
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                    :value="old('first_name')" required autofocus autocomplete="first_name"
                                    placeholder="First Name..." />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>

                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                    :value="old('last_name')" required autofocus autocomplete="last_name"
                                    placeholder="Last Name..." />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>

                            <div class="input-box">
                                <i class="fas fa-phone"></i>
                                <x-text-input id="msisdn" class="block mt-1 w-full" type="text" name="msisdn"
                                    :value="old('phone_number')" required autofocus autocomplete="msisdn"
                                    placeholder="Phone Number..." />
                                <x-input-error :messages="$errors->get('msisdn')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autocomplete="username" placeholder="Email..." />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="new-password" placeholder="Password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm Password..." />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="button input-box">
                                <input type="submit" value="Sumbit">
                            </div>
                            <div class="text sign-up-text">Already have an account? <label for="flip">Login
                                    now</label></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
