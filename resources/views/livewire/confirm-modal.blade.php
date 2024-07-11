<div class="z-80 justify-center items-center inset-0 h-auto max-h-full w-auto">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Redeeming {{$this->rewards->rewards_name}}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" wire:click="$dispatch('closeModal')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <form wire:submit="save">
                    <div class="text-lg leading-relaxed dark:text-gray-400">
                        Please select the amount you want to redeem.
                    </div>

                    <div class="grid justify-center">

                        <div class="p-2 rounded-lg border border-black my-2 bg-gray-100 grid justify-center grid-cols-2 place-items-center">
                            <h2>Amount to be redeemed: {{ $quantity }}</h2>
                            <div class="grid justify-center grid-cols-2 place-items-center">

                                @if ($this->rewards->rewards_quantity != $quantity)
                                <button class="absolute p-1 size-10 bg-green-500 rounded-lg text-white" type="button" wire:click.prevent="increment">+</button>
                                @endif

                                @if ($quantity != 0)
                                <button class="absolute p-1 size-10 bg-red-500 rounded-lg text-white ml-24" type="button" wire:click.prevent="decrement">-</button>
                                @endif

                            </div>
                        </div>

                         <div class="p-2 rounded-lg border border-black my-2 bg-gray-100">
                            <h2>Cost: {{ $this->rewards->rewards_points * $quantity }}</h2>
                        </div>

                    </div>



                    <div class="text-base leading-relaxed dark:text-gray-400 my-2">
                        Place a note if an item may vary in size like shirts
                        <textarea type="text" class="w-full resize-y" wire:model="note"></textarea>
                    </div>

                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <p class="text-base leading-relaxed dark:text-gray-400">
                            When you are done, click Redeem.
                        </p>
                        <button type="submit" class="p-2 border rounded-lg bg-gray-100">Redeem</button>

                        <button type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200
                        hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                        dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" wire:click="$dispatch('closeModal')">Exit</button>
                    </div>

                </form>
            </div>
            <!-- Modal footer -->

        </div>
    </div>
</div>
