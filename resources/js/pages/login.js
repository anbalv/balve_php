// Funktion, um die "hovered"-Klasse auf alle relevanten Elemente gleichzeitig anzuwenden
function addHoverTouchEffect(elements) {
    elements.forEach((element) => {
        if (element) {
            // Überprüfen, ob das Element existiert
            element.addEventListener("mouseenter", function () {
                elements.forEach((el) => el.classList.add("hovered"));
            });

            element.addEventListener("mouseleave", function () {
                elements.forEach((el) => el.classList.remove("hovered"));
            });

            element.addEventListener(
                "touchstart",
                function () {
                    elements.forEach((el) => el.classList.add("hovered"));
                },
                { passive: true }
            ); // 'passive' zu 'touchstart' hinzufügen

            element.addEventListener(
                "touchend",
                function () {
                    elements.forEach((el) => el.classList.remove("hovered"));
                },
                { passive: true }
            ); // 'passive' zu 'touchend' hinzufügen
        }
    });
}

// Elemente auswählen
const loginContainer = document.querySelector(".login-container");
const background = document.querySelector(".background");
const container = document.querySelector(".container");

// Array mit allen relevanten Elementen
const elements = [loginContainer, background, container].filter(Boolean); // Entferne alle `null` Werte

// Hover- und Touch-Effekte auf alle Elemente gleichzeitig anwenden
addHoverTouchEffect(elements);
