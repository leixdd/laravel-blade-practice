<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="/account/save">
                        @csrf

                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <div class="mt-3">
                            <x-label for="first_name" :value="__('First Name')" />
                            <x-input id="first_name" name="first_name" type="text" class="border border-gray-200" :value="$acc['firstname'] ?? old('first_name')" />
                        </div>

                        <div class="mt-3">
                            <x-label for="middle_name" :value="__('Middle Name')" />
                            <x-input id="middle_name" name="middle_name" type="text" class="border border-gray-200" :value="$acc['lastname'] ?? old('last_name')" />
                        </div>

                        <div class="mt-3">
                            <x-label for="last_name" :value="__('Last Name')" />
                            <x-input id="lastname" name="last_name" type="text" class="border border-gray-200" :value="$acc['middlename'] ?? old('middle_name')" />
                        </div>

                        <div class="mt-3">
                            <x-label for="contact_number" :value="__('Contact Number')" />
                            <x-input id="contact_number" name="contact_number" type="number" class="border border-gray-200" :value="$acc['contact_number'] ??  old('contact_number')" />
                        </div>

                        <div class="mt-3">
                            <x-label for="birthdate" :value="__('Birthdate')" />
                            <x-date-picker name="birthdate" id="birthdate" allow-input clearable :value="$acc['birthdate'] ??  old('birthdate')" />
                        </div>

                        
                        <div class="mt-3">
                            <x-label for="barangay" :value="__('Chosen Barangay')" />
                            <x-custom-select id="barangay" name="barangay" :options="$barangays" value-field="id" text-field="barangay_name" filterable :value="$acc['barangay_id'] ?? old('barangay')" />
                        </div>

                        <x-button class="mt-4">
                            Save your account details
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>