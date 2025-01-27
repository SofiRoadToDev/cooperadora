<div class="grid grid-cols-2 gap-2">
    <a href="{{route($editRoute, $id)}}">
        <i class="fa-solid fa-pen-to-square text-green-500"></i>
    </a>   
    <form action="{{route($$deleteRoute, $id)}}" class="ml-2">
        @csrf
        @method('DELETE')
            <button type="submit">
                <i class="fa-solid fa-trash text-red-500"></i>
            </button>                  
    </form>                     
</div>