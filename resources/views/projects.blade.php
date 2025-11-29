<x-app-layout>
    @if(auth()->user()->role == 'admin')
        <div id="create-vue"></div>
    @else
        <div id="create-user"></div>
    @endif
</x-app-layout>
