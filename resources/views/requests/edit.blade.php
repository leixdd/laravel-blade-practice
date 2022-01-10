<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barangay Form Request') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="mb-3">
                @if(session('message') ?? false)
                    <x-alerts message="{{session('message') }}" status="{{ session('status') }}" />
                @endif

            </div>
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6  bg-white border-b border-gray-200">
                        <h1><b>CODE</b>: {{ __('EF_') . base64_encode($br->id . '_' . $br->created_at) }}</h1>
                        <br/>
                        <h2>{{ $br->forms->title }}</h2>
                        <small>{{ $br->forms->description }}</small>
                        <br/>
                        <br/>

                        <form action=" {{ route('requests.update') }}" method="POST">
                            @csrf
                            <input hidden value="{{ $br->id }}" name="id" />
                            @foreach($br->forms->questions as $q)
                                @if($q->input_type === 'select')
                                    <div class="mt-3">
                                        <?php $l = explode(',', $q->input_defaults); ?>
                                        <x-label for="{{ $q->input_name }}" >{{ Illuminate\Support\Str::ucfirst($q->input_name) }}</x-label>
                                        <x-custom-select id="{{ $q->input_name }}" name="{{ $q->input_name }}" :options="$l"  filterable value="{{ $answers[$q->id] ?? '' }}"></x-custom-select>
                                    </div>
                                @endif

                                @if($q->input_type === 'text')
                                   <div class="mt-3">
                                       <x-label for="{{ $q->input_name }}" >{{ Illuminate\Support\Str::ucfirst($q->input_name) }}</x-label>
                                       <x-input id="{{ $q->input_name }}" name="{{ $q->input_name }}" type="text" class="border border-gray-200" >value="{{ $answers[$q->id] ?? '' }}" </x-input>
                                   </div>
                                @endif

                            @endforeach

                            <x-button class="mt-4">
                                Save your document details
                            </x-button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
