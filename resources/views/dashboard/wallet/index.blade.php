<x-app-layout>
    <x-dashboard.header :title="'List of Your Wallets'"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('wallet_success'))
                        <div class="font-medium text-green-600">
                            Your wallet has been created successfully!
                        </div>
                    @endif

                    <table class="mt-4 w-full">
                        <thead>
                            <tr class="border-b-2">
                                <th class="px-2 py-4 text-center">Name</th>
                                <th class="px-2 py-4 text-center">Type</th>
                                <th class="px-2 py-4 text-center">Balance</th>
                            </tr>
                        </thead>
                        <tbody class="border-b-2">
                        @foreach($wallets as $wallet)
                            <tr class="border-b">
                                <td class="p-2 text-center">{{ $wallet->name }}</td>
                                <td class="p-2 text-center">{{ $wallet->type }}</td>
                                <td class="p-2 text-center">{{ $wallet->balance }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td class="p-2 text-center"><b>Total :</b> {{ $totalBalance }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
