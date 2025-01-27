<x-base-layout>
    
    <div class="flex  justify-center p-4  h-[100vh]">
       <x-conceptos.concepto-form :$concepto/>
    </div>
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border border-green-300 p-4 rounded-md">
                {{ session('success') }}
            </div>
        @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 border border-red-300 p-4 rounded-md">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
</x-base-layout>