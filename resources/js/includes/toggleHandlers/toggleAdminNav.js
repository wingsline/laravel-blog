export default class toggleAdminNav {
    constructor(el, target) {
        this.el = el;
        this.target = target;
    }

    toggle() {
        let status = this.target.getAttribute("aria-expanded") !== "true",
            icons = this.el.querySelectorAll('svg');
        this.target.setAttribute("aria-expanded", status);
        // switch the svg
        icons[0].classList.toggle('hidden', status);
        icons[1].classList.toggle('hidden', !status);
        // toggle the sr-only class on the target
        this.target.classList.toggle('sr-only', !status);
        // block scrolling on the body
        document.querySelector('body').classList.toggle('block-scroll', status);
    }
}
