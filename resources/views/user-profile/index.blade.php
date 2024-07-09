<x-app-layout>
    <div id="side-bar"
            class="rounded-lg shadow-xl border-t bg-white border-t-gray-300 md:border-t-none col-span-4 md:col-span-1 px-3 md:px-3 ml-28 space-y-10 py-6 pt-1 md:border-l border-gray-100 h-32 w-10/12 sticky top-20">
            <livewire:searchbox />
        </div>
    <div class="w-full grid grid-cols-4 gap-10 ml-20">
        <div class="md:col-span-3 col-span-4">
            <div id="posts" class=" px-3 lg:px-7 py-6">
                <livewire:user-list />
            </div>
        </div>
    </div>
</x-app-layout>
