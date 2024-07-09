
<div id="posts" class="mt-10 grid grid-cols-4 gap-12">

    <div class="w-full text-pts30woRem my-4 lg:mx-0 lg:px-0 left-0 col-span-1">
        <div class="border-b border-gray-100 ml-5">
            <div id="filter-selector" class="font-light flex flex-col">
                <button class="{{$sort === '' ? 'text-gray-900 border-b border-gray-700 bg-white w-full text-pts30woRem' :
                    'bg-gray-200 text-gray-500 text-pts25 hover:text-gray-900 hover:bg-white hover:w-full hover:text-pts30woRem transition-all'}}
                    py-8 font-sans font-semibold w-11/12 rounded-lg shadow-xl"
                    wire:click="setSort('')">All</button>
                <button class="{{$this->isBronze() === True ? 'text-gray-900 border-b border-gray-700 bg-bronze w-full text-pts30woRem' :
                    'bg-gray-200 text-gray-500 text-pts25 hover:text-gray-900 hover:bg-bronze hover:w-full hover:text-pts30woRem transition-all'}}
                    py-8 font-sans font-semibold w-11/12 rounded-lg shadow-xl"
                    wire:click="setSort('Bronze')">Bronze</button>
                <button class="{{$this->isSilver() === True ? 'text-gray-900 border-b border-gray-700 bg-silver w-full text-pts30woRem' :
                    'bg-gray-200 text-gray-500 text-pts25 hover:text-gray-900 hover:bg-silver hover:w-full hover:text-pts30woRem transition-all'}}
                    py-8 font-sans font-semibold w-11/12 rounded-lg shadow-xl"
                    wire:click="setSort('Silver')">Silver</button>
                <button class="{{$this->isGold() === True ? 'text-gray-900 border-b border-gray-700 bg-gold w-full text-pts30woRem' :
                    'bg-gray-200 text-gray-500 text-pts25 hover:text-gray-900 hover:bg-gold hover:w-full hover:text-pts30woRem transition-all'}}
                    py-8 font-sans font-semibold w-11/12 rounded-lg shadow-xl"
                    wire:click="setSort('Gold')">Gold</button>
                <button class="{{$this->isPlatinum() === True ? 'text-gray-900 border-b border-gray-700 bg-gray-700 w-full text-pts30woRem text-white' :
                    'bg-gray-200 text-gray-500 text-pts25 hover:text-gray-900 hover:bg-gray-700 hover:w-full hover:text-pts30woRem hover:text-white transition-all'}}
                    py-8 font-sans font-semibold w-11/12 rounded-lg shadow-xl"
                    wire:click="setSort('Platinum')">Platinum</button>
            </div>
        </div>
    </div>

    <div class="col-span-3 grid grid-cols-4 mt-10 gap-x-40 gap-y-10">
        @foreach ($this->rewardsList as $item)
        <x-rewards.rewards-item :rewards="$item"/>
        @endforeach
    </div>

    <div class="my-3 ml-40">
        {{$this->rewardsList->onEachSide(1)->links()}}
    </div>

</div>


