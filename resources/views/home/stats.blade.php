<section
    class="w-full bg-brand-green text-base"
    x-data="{ inView: false }"
    x-init="
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduceMotion) {
            inView = true;
            return;
        }
        const observer = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting) {
                inView = true;
                observer.disconnect();
            }
        }, { threshold: 0.4 });
        observer.observe($el);
    "
>
    <div class="mx-auto max-w-5xl px-6 py-10 md:py-12 grid grid-cols-1 sm:grid-cols-3 gap-8 md:gap-4 text-center">
        <div
            class="transition-all duration-700 ease-out"
            :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
        >
            <p class="font-heading text-4xl md:text-5xl tracking-wide">Thousands</p>
            <p class="mt-1 text-sm md:text-base uppercase tracking-[0.2em] text-base/80">of Campers</p>
        </div>
        <div
            class="transition-all duration-700 ease-out delay-100 sm:border-x sm:border-base/25"
            :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
        >
            <p class="font-heading text-4xl md:text-5xl tracking-wide">30+</p>
            <p class="mt-1 text-sm md:text-base uppercase tracking-[0.2em] text-base/80">Years</p>
        </div>
        <div
            class="transition-all duration-700 ease-out delay-200"
            :class="inView ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
        >
            <p class="font-heading text-4xl md:text-5xl tracking-wide">Southern Indiana</p>
            <p class="mt-1 text-sm md:text-base uppercase tracking-[0.2em] text-base/80">Rooted Here</p>
        </div>
    </div>
</section>
