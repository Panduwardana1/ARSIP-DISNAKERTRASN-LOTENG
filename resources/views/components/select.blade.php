@props([
    'label' => 'Pilih Opsi',
    'name' => 'select',
    'options' => [],
    'selected' => null,
])

<label for="{{ $name }}" class="block text-sm font-medium text-gray-200">{{ $label }}</label>

<div x-data="{ open: false, selected: '{{ $selected }}' }" class="relative mt-2">
    <button @click="open = !open" type="button"
        class="w-full flex items-center justify-between rounded-md bg-gray-800 text-white px-3 py-2 text-left text-sm shadow-sm ring-1 ring-gray-600 focus:ring-indigo-500">
        <span
            x-text="selected ? $refs.optionList.querySelector(`[data-value='${selected}'] span`)?.innerText : 'Pilih...'"
            class="truncate"></span>
        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                clip-rule="evenodd" />
        </svg>
    </button>

    <ul x-show="open" x-ref="optionList" @click.outside="open = false"
        class="absolute z-10 mt-2 w-full max-h-60 overflow-y-auto rounded-md bg-gray-900 shadow-lg ring-1 ring-gray-700">
        @foreach ($options as $option)
            <li data-value="{{ $option['value'] }}" @click="selected = '{{ $option['value'] }}'; open = false"
                class="flex items-center px-3 py-2 text-sm text-white hover:bg-indigo-600 cursor-pointer">
                @if (isset($option['image']))
                    <img src="{{ $option['image'] }}" alt="" class="h-5 w-5 rounded-full object-cover mr-2">
                @endif
                <span>{{ $option['label'] }}</span>
            </li>
        @endforeach
    </ul>
    <input type="hidden" name="{{ $name }}" :value="selected">
</div>
