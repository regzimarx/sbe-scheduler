<span class="hover:bg-blue-300 hover:text-white text-gray-600 ml-1 rounded-md px-1 py-1 cursor-pointer"
    wire:click="orderby('{{ $field }}', 'desc')">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
    </svg>
</span>
<span class="hover:bg-green-300 hover:text-white text-gray-600 ml-1 rounded-md px-1 py-1 cursor-pointer"
    wire:click="orderby('{{ $field }}', 'asc')">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</span>
