<x-app-layout>
    <div id="side-bar"
            class="rounded-lg shadow-xl border-t bg-white border-t-gray-300 md:border-t-none col-span-4 md:col-span-1 px-3 md:px-3 space-y-10 py-6 pt-1 md:border-l border-gray-100 h-24 w-5/12 sticky top-24">
            <livewire:searchbox-rewards />
    </div>

    <div class="w-100vh">
        <livewire:rewards-list />
    </div>

</x-app-layout>
