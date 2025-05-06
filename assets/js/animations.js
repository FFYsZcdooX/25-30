document.addEventListener('DOMContentLoaded', function () {
    const projectRows = document.querySelectorAll('.project-row');
    gsap.fromTo(
        projectRows,
        { opacity: 0, y: 50 },
        { opacity: 1, y: 0, duration: 0.5, stagger: 0.2, ease: "power2.out" }
    );
});