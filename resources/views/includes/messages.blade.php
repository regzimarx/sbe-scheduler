@if (session()->has('message'))
    <div class="flex items-center bg-blue-700 text-white text-sm font-bold px-4 py-4 my-3 rounded-lg" role="alert">
        <p class="text-sm">{{ session('message') }}</p>
    </div>
    <br>
@endif
@if (session()->has('warning'))
    <div class="flex items-center bg-yellow-400 text-white text-sm font-bold px-4 py-4 my-3 rounded-lg" role="alert">
        <p class="text-sm">{{ session('warning') }}</p>
    </div>
    <br>
@endif
