<div class="bottom top w-full  md:px-12 pt-6 md:pt-12 pb-24 bg-black ">
    <h2 class="w-full text-center my-8 text-6xl font-heading text-base shrink-0">Step 2:Choose week</h2>
    <div class="flex w-full flex-wrap gap-6 justify-center">
        <button class="flex flex-col items-center w-42 shrink-0" @click="week = '1'" :class="week == '1' ? '' : 'opacity-40'" href="#" x-show="type == 'teen'" >
            <div class="relative w-full h-48 overflow-hidden"  style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                <img src="/shirley.jpg" alt="Speaker Name" class="w-full h-full object-cover">
            </div>
            <div class="mt-4 text-right text-base">
                <p class="text-lg md:text-xl">Teen Camp 1</p>
                <p class="text-lg md:text-xl">June 2-6</p>
                <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">Tony <br>Shirley</h3>
            </div>
        </button>
        <button class="flex flex-col items-center w-42 shrink-0" href="#" x-show="type == 'teen'" @click="week = '2'" :class="week == '2' ? '' : 'opacity-40'">
            <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                <img src="/judeh.jpeg" alt="Speaker Name" class="w-full h-full object-cover object-top">
            </div>
            <div class="mt-4 text-right text-base">
                <p class="text-lg md:text-xl">Teen Camp 2</p>
                <p class="text-lg md:text-xl">June 9-13</p>
                <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">Abdel <br>Judeh</h3>
            </div>
        </button>
        <button class="flex flex-col items-center w-42 shrink-0" href="#" x-show="type == 'teen'" @click="week = '3'" :class="week == '3' ? '' : 'opacity-40'">
            <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                <img src="/loney.jpg" alt="Speaker Name" class="w-full h-full object-cover">
            </div>
            <div class="mt-4 text-right text-base">
                <p class="text-lg md:text-xl">Teen Camp 3</p>
                <p class="text-lg md:text-xl">June 16-20</p>
                <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">Ed <br>Loney</h3>
            </div>
        </button>
        <button class="flex flex-col items-center w-42 shrink-0" href="#" x-show="type == 'teen'" @click="week = '3'" :class="week == '3' ? '' : 'opacity-40'">
            <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                <img src="/miller.jpg" alt="Speaker Name" class="w-full h-full object-cover">
            </div>
            <div class="mt-4 text-right text-base">
                <p class="text-lg md:text-xl">Teen Camp 3</p>
                <p class="text-lg md:text-xl">June 16-20</p>
                <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">Dean <br>Miller</h3>
            </div>
        </button>
        <button class="flex flex-col items-center w-42 shrink-0" href="#" x-show="type == 'teen'" @click="week = '4'" :class="week == '4' ? '' : 'opacity-40'">
            <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                <img src="/clark.jpg" alt="Speaker Name" class="w-full h-full object-cover">
            </div>
            <div class="mt-4 text-right text-base">
                <p class="text-lg md:text-xl">Teen Camp 4</p>
                <p class="text-lg md:text-xl">June 23-27</p>
                <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">Mike <br>Clark</h3>
            </div>
        </button>
        <button class="flex flex-col items-center w-42 shrink-0" href="#" x-show="type == 'junior'" @click="week = '5'" :class="week == '5' ? '' : 'opacity-40'">
            <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                <img src="/verzella.png" alt="Speaker Name" class="w-full h-full object-cover">
            </div>
            <div class="mt-4 text-right text-base">
                <p class="text-lg md:text-xl">Junior Camp</p>
                <p class="text-lg md:text-xl">July 7-11</p>
                <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">Tony <br>Shirley</h3>
            </div>
        </button>
        <button class="flex flex-col items-center w-42 shrink-0" href="#" x-show="type == 'combo'" @click="week = '6'" :class="week == '6' ? '' : 'opacity-40'">
            <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                <img src="/dignan.jpg" alt="Speaker Name" class="w-full h-full object-cover">
            </div>
            <div class="mt-4 text-right text-base">
                <p class="text-lg md:text-xl">Combo Camp</p>
                <p class="text-lg md:text-xl">July 21-25</p>
                <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">Randy <br>Dignan</h3>
            </div>
        </button>
        <button class="flex flex-col items-center w-42 shrink-0" href="#" x-show="type == 'combo'" @click="week = '6'" :class="week == '6' ? '' : 'opacity-40'">
            <div class="relative w-full h-48 overflow-hidden" style="clip-path: polygon(20% 0%, 100% 0%, 80% 100%, 0% 100%)">
                <img src="/russ.jpg" alt="Speaker Name" class="w-full h-full object-cover">
            </div>
            <div class="mt-4 text-right text-base">
                <p class="text-lg md:text-xl">Combo Camp</p>
                <p class="text-lg md:text-xl">July 21-25</p>
                <h3 class="text-3xl md:text-5xl font-bold font-heading md:leading-12">Stephen <br>Russ</h3>
            </div>
        </button>
    </div>
    <p class="text-2xl text-base text-center max-w-md mx-auto mt-12" x-show="week == 1"><span class="block font-bold">Almost Full</span> Pastor Tony Shirley is the pastor of New Manna Baptist Church in Marion, NC.  He's a faithful preacher and popular revival speaker around the country.</p>
    <p class="text-2xl text-base text-center max-w-md mx-auto mt-12" x-show="week == 2"><span class="block font-bold">Almost Full</span> Bro. Judeh was saved as a teenager through the bus ministry at a Baptist church in northern Illinois. He graduated from Hyles-Anderson College in 2001.  He serves as Youth Pastor at the First Baptist Church of Hammond, IN.</p>
    <p class="text-2xl text-base text-center max-w-md mx-auto mt-12" x-show="week == 3"><span class="block font-bold">Almost Full</span> Ed Loney is the staff evangelist at Jacksonville Baptist Tabernacle in Jacksonville, AR where he previously served as youth pastor.</p>
    <p class="text-2xl text-base text-center max-w-md mx-auto mt-12" x-show="week == 3">Pastor Dean Miller has been a favorite regular speaker at ICBC. He serves as Pastor at Front Range Baptist Church in Fort Collins, CO.</p>
    <p class="text-2xl text-base text-center max-w-md mx-auto mt-12" x-show="week == 4"><span class="block font-bold">Almost Full</span> Michael Clark serves as the Executive Vice President at Vision Baptist College in Berlin, NJ</p>
    <p class="text-2xl text-base text-center max-w-md mx-auto mt-12" x-show="week == 5"> Jud Verzella runs the children's ministries at the Solid Rock Baptist Church in Berlin, NJ.</p>
    <p class="text-2xl text-base text-center max-w-md mx-auto mt-12" x-show="week == 6"> A regular favorite at ICBC, Randy Dignan serves as pastor at Bible Baptist Church in Jacksonville, AR.</p>
    <p class="text-2xl text-base text-center max-w-md mx-auto mt-12" x-show="week == 6"> Stephen Russ serves as pastor at Faithway Baptist Church in Evansville, IN.</p>
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="text-base size-10 block mt-2 mx-auto"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5v.5m0 3v1.5m0 3v6" /><path d="M18 13l-6 6" /><path d="M6 13l6 6" /></svg>
</div>
