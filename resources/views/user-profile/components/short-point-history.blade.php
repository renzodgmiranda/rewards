@php
    $selectedQuarter = request('quarter', '');
    $sortedLogData = collect($pointLog->log_content)->reverse()->sortBy('Quarter');
    $quarters = $sortedLogData->pluck('Quarter')->unique()->sort()->values();

    if ($selectedQuarter) {
        $filteredData = $sortedLogData->where('Quarter', $selectedQuarter);
    } else {
        $filteredData = $sortedLogData;
    }

    $totalPoints = $filteredData->sum('Points');
    $pointsByPillar = $filteredData->groupBy('Pillar')->map->sum('Points');
    $entriesByQuarter = $filteredData->groupBy('Quarter');

    // Store the current scroll position in the session
    if (request()->has('scrollPosition')) {
        session(['scrollPosition' => request('scrollPosition')]);
    }
@endphp

<div class="relative overflow-auto mt-5">
    <form id="quarter-filter-form" method="GET" action="{{ url()->current() }}" class="mb-4">
        <label for="quarter-filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter by Quarter:</label>
        <select name="quarter" id="quarter-filter" onchange="submitFormWithScroll()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option value="">All Quarters</option>
            @foreach($quarters as $quarter)
                <option value="{{ $quarter }}" {{ $selectedQuarter == $quarter ? 'selected' : '' }}>{{ $quarter }}</option>
            @endforeach
        </select>
        <input type="hidden" name="scrollPosition" id="scrollPosition">
    </form>

    <div class="overflow-y-auto" style="height: 500px">
        <table class="w-full text-regular text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Quarter</th>
                    <th scope="col" class="px-6 py-3">Pillar/Rewards</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filteredData as $entry)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">
                            {{ $entry['Quarter'] }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $entry['Pillar'] }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $entry['Description'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $entry['Points'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="my-10 rounded-lg shadow-lg border-4 border-orange-950 overflow-auto" style="height: 500px">
    <div class="mt-8 ml-10">
        <h3 class="text-lg font-semibold mb-4">Summary</h3>
        <ul class="list-disc pl-5">
            <li class="mb-2">Total Points: {{ $totalPoints }}</li>
            @foreach($pointsByPillar as $pillar => $points)
                <li class="mb-2">{{ $pillar }}: {{ $points }} points</li>
            @endforeach
        </ul>
    </div>

    <div class="mt-8 ml-10">
        <h3 class="text-lg font-semibold mb-4">Entries by Quarter</h3>
        @foreach($entriesByQuarter as $quarter => $entries)
            <h4 class="text-md font-medium mb-2">{{ $quarter }}</h4>
            <ul class="list-disc pl-5 mb-4">
                @foreach($entries as $entry)
                    <li class="mb-1">{{ $entry['Description'] }} ({{ $entry['Points'] }} points)</li>
                @endforeach
            </ul>
        @endforeach
    </div>
</div>

<script>
    function submitFormWithScroll() {
        document.getElementById('scrollPosition').value = window.pageYOffset;
        document.getElementById('quarter-filter-form').submit();
    }

    // Restore scroll position after page load
    window.onload = function() {
        window.scrollTo(0, {{ session('scrollPosition', 0) }});
    }
</script>
