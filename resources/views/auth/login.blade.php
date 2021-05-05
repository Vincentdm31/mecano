@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card light-shadow-2 rounded-2 mx-auto mt-4 container dark">
            <div class="card-header txt-gl4">{{ __('Login') }}</div>
            <div class="card-content">
                <form class="form-material" method="POST" action="{{ route('login') }}" autocomplete="false">
                    @csrf
                    <div class="grix xs1 sm2 gutter-sm2">
                        <div class="form-field">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input type="email" name="email" id="email" class="form-control txt-gl4" value="{{ old('email') }}" required autocomplete="false">
                            @error('email')
                            <p class="txt-center form-helper txt-red">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" name="password" id="password" class="form-control txt-gl4" required autocomplete="false">
                            @error('password')
                            <p class="txt-center form-helper txt-red">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-field col-sm2">
                            <label class="form-check">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <span class="txt-gl4">{{ __('Remember Me') }}</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn outline opening txt-orange txt-dark-1 rounded-1 mx-auto mt-2">
                        <span class="outline-text">{{ __('Login') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
