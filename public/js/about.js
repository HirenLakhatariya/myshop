// Add a magical glow effect to certification cards on hover
const cards = document.querySelectorAll(".certification-card");

cards.forEach(card => {
    card.addEventListener("mouseenter", () => {
        card.classList.add("highlight");
    });

    card.addEventListener("mouseleave", () => {
        card.classList.remove("highlight");
    });
});