@if(session('success') || $errors->any())
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 px-4 py-2 rounded shadow-lg 
                {{ session('success') ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}"
    >
        {{ session('success') ?? $errors->first() }}
    </div>
@endif
