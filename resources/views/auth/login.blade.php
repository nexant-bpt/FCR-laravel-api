@extends('layouts.app')

@section('content')

    <div class="flex justify-center">
        <div class="w-4/12 bg-white p-6 rounded-lg">

            @if(session('status'))
                {{ session('status') }}
            @endif

            Login

            <form action="{{ route('register') }}" method="post">
                @csrf

  

                <div class="mb-4">

                    <input type="text" name="email" id="email" placeholder="Email" class="bg-gray-100 border-2 w-full p-4 rounded-lg
                                @error('email') border-red-500 @enderror

                                " value={{ old('email') }} />


                    @error('email')
                        <div class="text-red-500 m5-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">

                    <input type="password" name="password" id="password" placeholder="Choose a password" class="bg-gray-100 border-2 w-full p-4 rounded-lg
                                @error('password') border-red-500 @enderror

                                
                                " />

                    @error('password')
                        <div class="text-red-500 m5-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember">Remember Me</label>
                    </div>
                </div>
         
                <div>
                    <button class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" type="submit">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>


@endsection
