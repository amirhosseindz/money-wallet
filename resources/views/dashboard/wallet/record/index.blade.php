<x-app-layout>
    <x-dashboard.header :title="'List of Wallet Records'"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('record_success'))
                        <div class="font-medium text-green-600">
                            Record added successfully to your wallet!
                        </div>
                    @endif

                    <form method="GET" action="{{ route('record.index') }}" class="mt-4">
                        <div>
                            <x-label for="wallet" :value="'Wallet'" />

                            <x-select name="wallet_id" id="wallet" class="block mt-1 w-full">
                                @foreach($wallets as $wallet)
                                    <option value="{{ $wallet->id }}" @if($wallet->id === $selectedWalletId) selected @endif>
                                        {{ $wallet->name }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button> Apply </x-button>
                        </div>
                    </form>

                    <table class="mt-4 w-full">
                        <thead>
                            <tr class="border-b-2">
                                <th class="px-2 py-4 text-center">Amount</th>
                                <th class="px-2 py-4 text-center">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $record)
                            <tr class="border-b">
                                <td class="p-2 text-center">{{ $record->amount }}</td>
                                <td class="p-2 text-center">{{ $record->type }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
