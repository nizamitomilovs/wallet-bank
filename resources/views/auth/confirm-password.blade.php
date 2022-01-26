<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Unicorn') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css" />
    <div class="py-12 flex items-center justify-center ">
        <div class="flex flex-col bg-white shadow-md px-4 sm:px-6 md:px-8 lg:px-10 py-10 rounded-md w-full max-w-md">
            <div class="font-medium self-center text-xl sm:text-2xl uppercase text-gray-800">{{ __('Confirm Password') }}</div>
            <div class="relative mt-10 h-px bg-gray-300">
                <div class="absolute left-0 top-0 flex justify-center w-full -mt-2">

                </div>
            </div>
            <div class="mt-10">
                <form action="{{ route('password.confirm') }}" method="post">
                    @csrf
                    <div class="flex flex-col mb-6">
                        <label for="password" class="text-center mb-1 text-sm sm:text-sm tracking-wide text-gray-600">{{ __('Password') }}</label>
                        <div class="relative">
                            <div class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400">
                            </div>
                            <input id="password" type="password" class="text-sm sm:text-base placeholder-gray-500 pl-2 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong class="text-red-500 ">{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex w-full">
                        <button type="submit" class="flex items-center justify-center focus:outline-none text-white text-sm sm:text-base bg-gray-600 hover:bg-gray-900 rounded py-2 w-full transition duration-150 ease-in">
                            <span class="mr-2 uppercase">{{ __('Confirm Password') }}</span>
                            <span>
              <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
