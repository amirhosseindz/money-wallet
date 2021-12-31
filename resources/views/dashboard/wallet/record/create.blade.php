<x-app-layout>
    <x-dashboard.header :title="'Add a Record to Your Wallet'"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-dashboard.validation-errors :erros="$errors"/>

                    @if(session('record_error'))
                        <div class="font-medium text-red-600">
                            {{ session('record_error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('record.store') }}" class="mt-4">
                        @csrf

                        <div>
                            <x-label for="wallet" :value="'Wallet'" />

                            <x-select name="wallet_id" id="wallet" class="block mt-1 w-full">
                                @foreach($wallets as $wallet)
                                    <option value="{{ $wallet->id }}" @if($loop->first) selected @endif>
                                        {{ $wallet->name }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>

                        <div class="mt-4">
                            <x-label for="type" :value="'Type'" />

                            <x-select name="type" id="type" class="block mt-1 w-full">
                                @foreach($types as $type)
                                    <option value="{{ $type }}" @if($loop->first) selected @endif>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>

                        <div class="mt-4">
                            <x-label for="amount" :value="'Amount'" />

                            <x-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button> Add </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
