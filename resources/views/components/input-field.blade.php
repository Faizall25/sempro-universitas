@props(['name', 'label', 'value' => '', 'type' => 'text', 'required' => false])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 mb-2 font-medium">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none"
           @if($required) required @endif>
    @error($name)
        <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
