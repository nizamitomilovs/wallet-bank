<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Make Deposit') }}
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css" />
    <div class="py-12 flex items-center justify-center ">
        <div class="flex flex-col bg-white shadow-md px-4 sm:px-6 md:px-8 lg:px-10 py-10 rounded-md w-full max-w-md">
            <div class="font-medium self-center text-xl sm:text-2xl uppercase text-gray-800">Make Deposit</div>
            <div class="relative mt-10 h-px bg-gray-300">
                <div class="absolute left-0 top-0 flex justify-center w-full -mt-2">
                    <span class="bg-white px-4 text-xs text-gray-500 uppercase">Fast Deposit</span>
                </div>
            </div>
            <div class="mt-10">
                <form action="{{route('accounts.update', $account)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col mb-6">
                        <label for="balance" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">Your Account Number:</label>
                        <div class="relative">
                            <div class="text-sm sm:text-base placeholder-gray-500 pr-4 w-full py-2 focus:outline-none focus:border-blue-400">
                                {{$account->number}}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="balance" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">Balance Of Account</label>
                        <div class="relative">
                            <div class="text-sm sm:text-base placeholder-gray-500 pr-4 w-full py-2 focus:outline-none focus:border-blue-400">
                                @convertMoney($account->balance) {{strtoupper($account->currency)}}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col mb-6">
                        <label for="deposit" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">Deposit:</label>
                        <div class="relative">
                            <div class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400">
                            </div>
                            <input
                                id="deposit"
                                type="deposit"
                                name="deposit"
                                class="@error('deposit') is-danger @enderror
                                    text-sm sm:text-base placeholder-gray-500 pl-2 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                                placeholder="0.00"
                                value="{{old('deposit')}}"
                            />
                            @error('deposit')
                            <p class="help is-danger text-red-800 py-3">{{$errors->first('deposit')}}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="flex w-full">
                        <button type="submit" class="flex items-center justify-center focus:outline-none text-white text-sm sm:text-base bg-blue-600 hover:bg-blue-700 rounded py-2 w-full transition duration-150 ease-in">
                            <span class="mr-2 uppercase">Deposit</span>
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
