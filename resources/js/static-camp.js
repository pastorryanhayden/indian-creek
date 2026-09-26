document.addEventListener('alpine:init', () => {
    Alpine.data('campSelector', () => ({
        type: '',
        week: '',
        choices: [],
        onPopState: null,
        init() {
            this.choices = Array.from(this.$root.querySelectorAll('[data-camp-type][data-camp-week]'), (button) => ({
                type: button.dataset.campType,
                week: button.dataset.campWeek,
            }));
            this.readQueryParams();
            this.onPopState = () => this.readQueryParams();
            window.addEventListener('popstate', this.onPopState);
        },
        destroy() {
            window.removeEventListener('popstate', this.onPopState);
        },
        readQueryParams() {
            const params = new URLSearchParams(window.location.search);
            const defaultType = this.$root.dataset.defaultType;
            const requestedType = params.get('type');
            this.type = this.choices.some(choice => choice.type === requestedType)
                ? requestedType : defaultType;
            const available = this.choices.filter(choice => choice.type === this.type);
            const requestedWeek = params.get('week');
            this.week = available.some(choice => choice.week === requestedWeek)
                ? requestedWeek : (available[0]?.week ?? '0');
        },
        updateQueryParams() {
            const url = new URL(window.location.href);
            url.searchParams.set('type', this.type);
            url.searchParams.set('week', this.week);
            history.pushState({}, '', url.pathname + url.search + url.hash);
        },
    }));
});
