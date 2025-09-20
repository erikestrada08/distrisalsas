export default {
    mounted(el, binding) {
        const animationClass = binding.value || el.dataset.animate || "fade-in";
        el.dataset.animationClass = animationClass;
        el.classList.add("animate-base", animationClass);

        const visibilityMap = new WeakMap();

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    const target = entry.target;
                    const isVisible = visibilityMap.get(target) || false;

                    if (entry.intersectionRatio > 0.3 && !isVisible) {
                        target.classList.add("in-view");
                        target.classList.remove("mirror-out");
                        visibilityMap.set(target, true);
                    } else if (entry.intersectionRatio <= 0.1 && isVisible) {
                        target.classList.remove("in-view");
                        target.classList.add("mirror-out");
                        visibilityMap.set(target, false);
                    }
                });
            },
            {
                threshold: [0, 0.1, 0.3, 1.0],
            }
        );

        observer.observe(el);
    },
};
