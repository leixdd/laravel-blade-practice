@props(['status' => 'default', 'message' => ''])

@php
$class_color = 'text-gray-600 bg-gray-300';

if($status !== 'default') {

$class_color = ((bool) $status) ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100';
}
@endphp

<div class="flex justify-center m-2">
    <div class="w-1/2 px-4 py-2 {{$class_color}} rounded">
        <p>{{ $message }}</p>
    </div>
</div>