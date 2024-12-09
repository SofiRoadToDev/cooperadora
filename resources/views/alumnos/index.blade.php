<x-base-layout>
    <x-header/>
    <div class="flex  justify-center p-4 bg-slate-300 h-[100vh]">
        <div class="flex flex-col">
            <button class="px-3 py-2 w-1/2 mx-auto bg-slate-800 text-white"><a href="{{route('alumnos.crear')}}">Nuevo</a></button>
        <x-alumno-list  :$alumnos/>
        </div>
        
    </div>

    @if (session('success'))
    <div class="bg-green-100 text-green-800 border border-green-300 p-4 rounded-md w-1/4" id="success-alert">
        {{ session('success') }}
        <button id="close-success" class="border border-slate-900 px-2 py-1">Close</button>
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-800 border border-red-300 p-4 rounded-md w-1/4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    
</x-base-layout>