<div class="flex">
    <!-- Pillars -->
    <div class="grid grid-cols-4 w-full ml-20">

        <div class="bg-blue_cus1 size-52 rounded-full shadow-lg">
            <div id="tooltip-srs" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-3 text-xs font-extralight text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Social Responsibility & Sustainability
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div data-tooltip-target="tooltip-srs" class="text-pts45 text-gray_cus1 mt-16 font-sans font-bold">
                SRS
            </div>
            <div class="text-pts55 font-sans font-bold mt-16 justify-self-center text-white">
                {{Auth::user()->srs_points}}
            </div>
        </div>

        <div class="bg-blue_cus1 size-52 rounded-full shadow-lg">
            <div id="tooltip-hw" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-extralight text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Health & Wellness
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div data-tooltip-target="tooltip-hw" class="text-pts45 text-gray_cus1 mt-16 font-sans font-bold">
                HW
            </div>
            <div class="text-pts55 font-sans font-bold mt-16 justify-self-center text-white">
                {{Auth::user()->hw_points}}
            </div>
        </div>

        <div class="bg-blue_cus1 size-52 rounded-full shadow-lg">
            <div id="tooltip-tw" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-extralight text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Teamwork
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div data-tooltip-target="tooltip-tw" class="text-pts45 text-gray_cus1 mt-16 font-sans font-bold">
                TW
            </div>
            <div class="text-pts55 font-sans font-bold mt-16 justify-self-center text-white">
                {{Auth::user()->tw_points}}
            </div>
        </div>


        <!-- Quarterly -Breakdown -->
        <div class="space-y-6 justify-self-center mr-6">
            <div class="bg-tier h-10 w-80 rounded-lg p-1 shadow-lg">
                <div class="flex">
                    <span class="text-regular font-sans font-normal text-white mb-5 ml-5 flex-none"> Q1 </span>
                    <span class="text-bold font-sans font-bold text-white flex-1 content-start mb-7">
                        {{Auth::user()->q1_points}}

                        <span class="text-regular font-sans font-normal text-white"> PTS </span>
                    </span>

                </div>

            </div>

            <div class="bg-tier h-10 w-80 rounded-lg p-1 shadow-lg">
                <div class="flex">
                    <span class="text-regular font-sans font-normal text-white mb-5 ml-5 flex-none"> Q2 </span>
                    <span class="text-bold font-sans font-bold text-white flex-1 content-start mb-7">
                        {{Auth::user()->q2_points}}

                        <span class="text-regular font-sans font-normal text-white"> PTS </span>
                    </span>

                </div>

            </div>

            <div class="bg-tier h-10 w-80 rounded-lg p-1 shadow-lg">
                <div class="flex">
                    <span class="text-regular font-sans font-normal text-white mb-5 ml-5 flex-none"> Q3 </span>
                    <span class="text-bold font-sans font-bold text-white flex-1 content-start mb-7">
                        {{Auth::user()->q3_points}}

                        <span class="text-regular font-sans font-normal text-white"> PTS </span>
                    </span>

                </div>

            </div>

            <div class="bg-tier h-10 w-80 rounded-lg p-1 shadow-lg">
                <div class="flex">
                    <span class="text-regular font-sans font-normal text-white mb-5 ml-5 flex-none"> Q4 </span>
                    <span class="text-bold font-sans font-bold text-white flex-1 content-start mb-7">
                        {{Auth::user()->q4_points}}

                        <span class="text-regular font-sans font-normal text-white"> PTS </span>
                    </span>

                </div>

            </div>

        </div>
    </div>
</div>

<!-- Divider -->
<div class="flex w-full bg-tier h-1.5 rounded-full mt-5"></div>
