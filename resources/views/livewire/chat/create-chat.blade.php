<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <ul class="list-group w-75 mx-auto mt-3 container-fluid" style="height: 1000px">
        @foreach ($users as $user)
            <li class="list-group-item list-group-item-action bg-gray-100 dark:bg-gray-800 hover:gray-200 dark:hover:bg-gray-900 text-gray-800 dark:text-gray-200 dark:hover:text-gray-100"
                wire:click='checkconversation({{ $user->id }})'>
                {{ $user->username }}</li>
        @endforeach
    </ul>
</div>
