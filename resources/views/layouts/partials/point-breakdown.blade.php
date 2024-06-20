<div class="flex">
    <!-- Pillars -->
    <div class="grid grid-cols-4 w-full ml-20">
        <div class="bg-blue_cus1 size-52 rounded-full">
            <div class="text-pts45 text-gray_cus1 mt-16 font-sans font-bold">
                SRS
            </div>
            <div class="text-pts55 font-sans font-bold mt-16 justify-self-center text-white">
                {{Auth::user()->srs_points}}
            </div>
        </div>

        <div class="bg-blue_cus1 size-52 rounded-full">
            <div class="text-pts45 text-gray_cus1 mt-16 font-sans font-bold">
                HW
            </div>
            <div class="text-pts55 font-sans font-bold mt-16 justify-self-center text-white">
                {{Auth::user()->hw_points}}
            </div>
        </div>

        <div class="bg-blue_cus1 size-52 rounded-full">
            <div class="text-pts45 text-gray_cus1 mt-16 font-sans font-bold">
                TW
            </div>
            <div class="text-pts55 font-sans font-bold mt-16 justify-self-center text-white">
                {{Auth::user()->tw_points}}
            </div>
        </div>

        <!-- Quarterly -Breakdown -->
        <div class="space-y-6 justify-self-center mr-6">
            <div class="bg-tier h-10 w-80 rounded-lg p-1">
                <div class="flex">
                    <span class="text-regular font-sans font-normal text-white mb-5 ml-5 flex-none"> Q1 </span>
                    <span class="text-bold font-sans font-bold text-white flex-1 content-start mb-7">
                        {{Auth::user()->q1_points}}

                        <span class="text-regular font-sans font-normal text-white"> PTS </span>
                    </span>

                </div>

            </div>

            <div class="bg-tier h-10 w-80 rounded-lg p-1">
                <div class="flex">
                    <span class="text-regular font-sans font-normal text-white mb-5 ml-5 flex-none"> Q1 </span>
                    <span class="text-bold font-sans font-bold text-white flex-1 content-start mb-7">
                        {{Auth::user()->q2_points}}

                        <span class="text-regular font-sans font-normal text-white"> PTS </span>
                    </span>

                </div>

            </div>

            <div class="bg-tier h-10 w-80 rounded-lg p-1">
                <div class="flex">
                    <span class="text-regular font-sans font-normal text-white mb-5 ml-5 flex-none"> Q1 </span>
                    <span class="text-bold font-sans font-bold text-white flex-1 content-start mb-7">
                        {{Auth::user()->q3_points}}

                        <span class="text-regular font-sans font-normal text-white"> PTS </span>
                    </span>

                </div>

            </div>

            <div class="bg-tier h-10 w-80 rounded-lg p-1">
                <div class="flex">
                    <span class="text-regular font-sans font-normal text-white mb-5 ml-5 flex-none"> Q1 </span>
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
