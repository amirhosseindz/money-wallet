<x-app-layout>
    <x-dashboard.header :title="'Create Your Wallet !'"/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-dashboard.validation-errors :erros="$errors"/>

                    <form method="POST" action="{{ route('wallet.store') }}" class="mt-4">
                        @csrf

                        <div>
                            <x-label for="name" :value="'Name'" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="type" :value="'Type'" />

                            <x-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type')" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button> Create </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
