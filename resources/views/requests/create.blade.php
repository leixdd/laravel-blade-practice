<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barangay Form Request') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Barangay Forms</h2>
            @if(session('message') ?? false)
            <x-alerts message="{{session('message') }}" status="{{ session('status') }}" />
            @endif
            <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

                @foreach($certs as $cert)
                <div class="group relative">
                    <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
                        <img src="/img/{{ $cert->image_path }}" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <b>{{ $cert->title }}</b>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">

                            </p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('requests.save') }}">
                        @csrf
                        <input hidden :value="{{ $cert->id }}" type="number" name="form_id" />
                        <x-button>
                            Request
                        </x-button>
                    </form>
                </div>
                @endforeach



                <!-- More products... -->
            </div>
        </div>
    </div>

</x-app-layout>