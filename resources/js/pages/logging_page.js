document.addEventListener("DOMContentLoaded", function () {
    // Erweiterung der bestehenden Logik zur Handhabung der Sichtbarkeit von Inhalten
    function toggleContent(summaryElement, contentClass) {
        summaryElement.addEventListener("click", function () {
            const content = this.nextElementSibling;
            if (content && content.classList.contains(contentClass)) {
                content.style.display =
                    content.style.display === "none" ? "block" : "none";
            }
        });
    }

    // Funktion, um Summary-Elemente anhand ihres Textinhalts zu finden
    function findSummaryElementByText(text) {
        const summaries = document.querySelectorAll("summary");
        for (const summary of summaries) {
            if (summary.textContent.trim() === text) {
                return summary;
            }
        }
        return null;
    }

    // Bereiche initial ausblenden
    document
        .querySelectorAll(
            ".session-data-content, .headers-content, .Cookies-content"
        )
        .forEach((content) => {
            content.style.display = "none";
        });

    // Umschaltung für "Session Data"
    const sessionDataSummary = findSummaryElementByText("Session Data:");
    if (sessionDataSummary) {
        toggleContent(sessionDataSummary, "session-data-content");
    }

    // Umschaltung für "Headers"
    const headersSummary = findSummaryElementByText("Headers");
    if (headersSummary) {
        toggleContent(headersSummary, "headers-content");
    }

    // Umschaltung für "Cookies"
    const cookiesSummary = findSummaryElementByText("Cookies");
    if (cookiesSummary) {
        toggleContent(cookiesSummary, "Cookies-content");
    }
});

document.addEventListener("DOMContentLoaded", function () {
    var screenshotButton = document.getElementById("screenshot-button");
    console.log("DOM fully loaded and parsed");

    if (screenshotButton) {
        console.log("Screenshot button found");

        screenshotButton.addEventListener("click", function () {
            console.log("Screenshot button clicked");

            // Schließe alle geöffneten <details>-Elemente, einschließlich verschachtelter
            document.querySelectorAll('details').forEach(detail => {
                detail.removeAttribute('open');
            });

            // Verberge alle <div> Elemente innerhalb der klappbaren Bereiche (einschließlich verschachtelter)
            document.querySelectorAll('.code-details div').forEach(div => {
                div.style.display = 'none';
            });

            // Definiere targetElement innerhalb des Eventhandlers
            var targetElement = document.querySelector(".logging-container");

            if (!targetElement) {
                console.error("Target element for screenshot not found.");
                return;
            }

            html2canvas(targetElement)
                .then(function (canvas) {
                    console.log("Canvas generated");
                    canvas.toBlob(function (blob) {
                        var formData = new FormData();
                        formData.append("screenshot", blob, "screenshot.png");

                        // Hole das CSRF-Token aus dem Meta-Tag
                        var csrfToken = document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content");

                        fetch("http://127.0.0.1:8000/screenshot/save", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                            },
                            body: formData,
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                console.log("Screenshot gespeichert:", data);
                                alert("Screenshot erfolgreich gespeichert!");
                            })
                            .catch((error) => {
                                console.error(
                                    "Fehler beim Speichern des Screenshots:",
                                    error
                                );
                                alert("Fehler beim Speichern des Screenshots.");
                            });
                    });

                    // Nach dem Screenshot die <div> Elemente wieder anzeigen
                    document.querySelectorAll('.code-details div').forEach(div => {
                        div.style.display = '';
                    });
                })
                .catch(function (error) {
                    console.error("Error during canvas generation:", error);
                });
        });
    } else {
        console.error("Screenshot button not found");
    }
});
