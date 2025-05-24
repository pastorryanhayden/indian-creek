<div class="bottom top w-full pt-20 px-6 pb-8 md:px-12 flex flex-col items-center justify-center" style="background-image: url('/textures/green-waves.jpg');" >
    <h2 class=" text-6xl font-heading text-base mb-12">Step 1: Choose Camp Type</h2>
    <div class="w-full  grid grid-cols-12 gap-6 md:gap-8">  <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
        <button  class="cursor-pointer bg-white col-span-full md:col-span-6 flex items-center justify-center text-center p-12  bg-center group relative" :class="type == 'teen' && 'border-6 border-accent'" @click="type = 'teen'; week = '1'" >
            <img src="/teen-week.jpg" alt="" class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full  saturate-10 shadow-2xl group-hover:saturate-100 group-hover:shadow-none" :class="type == 'teen' && 'saturate-100 shadow-none'">
            <div class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full z-10 bg-base opacity-65 group-hover:opacity-25 group-hover:bg-black" :class="type == 'teen' && 'bg-black opacity-25'"></div>
            <h4 class="font-heading text-6xl text-black group-hover:text-base z-20" :class="type == 'teen' && 'text-accent!'">Teen <br>Camps</h4>
        </button>
        <button  class="cursor-pointer bg-white col-span-6 md:col-span-3   flex items-center justify-center text-center p-12 bg-cover bg-center group relative" :class="type == 'junior' && 'border-6 border-accent'" @click="type = 'junior'; week = '5'">
            <img src="/junior-weeks.jpeg" alt="" class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full  saturate-10 shadow-2xl group-hover:saturate-100 group-hover:shadow-none" :class="type == 'junior' && 'saturate-100 shadow-none'">
            <div class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full z-10 bg-base opacity-65 group-hover:opacity-25 group-hover:bg-black" :class="type == 'junior' && 'bg-black opacity-25'"></div>
            <h4 class="font-heading text-6xl text-black group-hover:text-base z-20" :class="type == 'junior' && 'text-accent!'">Junior <br>Camps</h4>
        </button>
        <button  class="cursor-pointer bg-white col-span-6 md:col-span-3  flex items-center justify-center text-center p-12  bg-cover bg-center group relative" :class="type == 'combo' && 'border-6 border-accent'" @click="type = 'combo'; week = '6'">
            <img src="/combo-weeks.jpeg" alt="" class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full  saturate-10 shadow-2xl group-hover:saturate-100 group-hover:shadow-none" :class="type == 'combo' && 'saturate-100 shadow-none'">
            <div class="absolute top-0 bottom-0 left-0 right-0 w-full object-cover h-full z-10 bg-base opacity-65 group-hover:opacity-25 group-hover:bg-black" :class="type == 'combo' && 'bg-black opacity-25'" ></div>
            <h4 class="font-heading text-6xl text-black group-hover:text-base z-20" :class="type == 'combo' && 'text-accent!'">Combo <br>Camps</h4>
        </button>
    </div>
    <p class="text-2xl max-w-md mx-auto mt-12 text-center text-base" x-show="type == 'teen'">Our most popular camp type.  An intense week of fun, preaching, and camaraderie for 7th-12th grade students.</p>
    <p class="text-2xl max-w-md mx-auto mt-12 text-center text-base" x-show="type == 'junior'">Just juniors.  Preaching, fun and lots of noise.  The best week of your 3rd-6th grader's year.</p>
    <p class="text-2xl max-w-md mx-auto mt-12 text-center text-base" x-show="type == 'combo'">Take both groups in one week.  Separate game and preaching time, together at night and for rallies.  Great option for churches who only can do one week of camp.</p>
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="text-base size-10 block mt-2 mx-auto"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5v.5m0 3v1.5m0 3v6" /><path d="M18 13l-6 6" /><path d="M6 13l6 6" /></svg>
</div>
<style>
    .top {
        clip-path: polygon(0 0,100% 0,100% calc(100% - 50px),calc(50% + 50px) calc(100% - 50px),50% 100%,calc(50% - 50px) calc(100% - 50px),0 calc(100% - 50px));
    }
    .bottom {
        clip-path: polygon(0 0,calc(50% - 0px - 50px) 0,50% calc(50px + 0px),calc(50% + 0px + 50px) 0,100% 0,100% 100%,0 100%);
        margin-top: -50px;
    }
</style>
