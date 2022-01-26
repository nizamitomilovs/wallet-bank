<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Your Accounts') }}
        </h2>
    </x-slot>

    <head>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/alert.css') }}">
    </head>
    <body x-data="{showDeleteModal:false}" x-bind:class="{ 'model-open': showDeleteModal }">
    @if(session()->has('message'))
        @include('layouts.alert')
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Account
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Balance
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Currency
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Transfer</span>
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Deposit</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($accounts as $account)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                                    <a href="{{route('accounts.show', $account)}}"
                                                       class="underline text-gray-600 hover:text-indigo-900">
                                                        {{$account->number}}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        @convertMoney($account->balance)
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5  font-semibold rounded-full bg-green-100 text-green-800">
                                                  {{strtoupper($account->currency)}}
                                                </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{route('transactions.transferTable', $account)}}"
                                                       name="transfer"
                                                       class="modal-open-transfer text-indigo-600 hover:text-indigo-900">
                                                        Transfer
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{route('accounts.edit', $account)}}" name="deposit"
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        Deposit
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button"  @click={showDeleteModal=true} name="delete"
                                                       class="text-red-600 hover:text-indigo-900">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </body>
    @include('transactions.index')
</x-app-layout>
@include('layouts.delete-modal')

