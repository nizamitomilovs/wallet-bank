<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Create Account') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="shadow-lg sm:flex">
                    <div class="sm:w-2/5 w-full bg-gray-400 bg-cover bg-center text-white"
                         style="background-image: url('/images/createaccountunicorn.png')">
                        <div class="p-8">
                            <h1>NEW<span class="text-indigo-400">ACCOUNT</span></h1>
                        </div>
                    </div>
                    <div class="sm:w-3/5 w-full bg-white">
                        <div class="p-8">
                            <form method="post" action="{{ route('accounts.store') }}">
                                @csrf
                                <label for="balance" class="text-xs text-gray-500">Starting Balance</label>
                                <input
                                    name="balance"
                                    id="balance"
                                    class="@error('balance') is-danger @enderror
                                        bg-transparent border-b m-auto block border-gray-500 w-full mb-6 text-gray-700 pb-1"
                                    type="text"
                                    placeholder="0.00"
                                    value="{{old('deposit')}}"
                                />
                                @error('balance')
                                <p class="help is-danger text-red-800">{{$errors->first('balance')}}</p>
                                @enderror
                                <label id="currencies" class="text-xs text-gray-500">Currency</label>
                                <select name="currency" id="currencies"
                                        class="bg-transparent border-b m-auto block border-gray-500 w-full mb-6 text-grey-700 pb-1"
                                        autofocus>
                                    <option
                                        class="bg-transparent border-b m-auto block border-gray-500 w-full mb-6 text-grey-700 pb-1"
                                        name="currency" value="eur">EUR
                                    </option>
                                    <option
                                        class="bg-transparent border-b m-auto block border-gray-500 w-full mb-6 text-grey-700 pb-1"
                                        name="currency" value="usd">USD
                                    </option>
                                    <option
                                        class="bg-transparent border-b m-auto block border-gray-500 w-full mb-6 text-grey-700 pb-1"
                                        name="currency" value="gbp">GBP
                                    </option>
                                </select>
                                @error('currency')
                                <p class="help is-danger text-red-800 py-3">{{$errors->first('currency')}}</p>
                                @enderror
                                <input
                                    class="@error('currency') is-danger @enderror
                                        shadow-lg pt-3 pb-3 w-full text-white bg-indigo-500 hover:bg-indigo-400 rounded-full cursor-pointer "
                                    type="submit"
                                    value="Create account"
                                >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


