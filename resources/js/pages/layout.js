document.addEventListener("DOMContentLoaded", function () {
  const hamburgerMenu = document.getElementById("hamburger-menu");
  const sidebarMenu = document.getElementById("sidebar-menu");

  if (hamburgerMenu && sidebarMenu) {
    hamburgerMenu.addEventListener("click", function (event) {
      hamburgerMenu.classList.toggle("open");
      sidebarMenu.classList.toggle("open");

      if (sidebarMenu.classList.contains("open")) {
        sidebarMenu.style.pointerEvents = "auto";
      } else {
        sidebarMenu.style.pointerEvents = "none";
      }

      event.stopPropagation();
    });

    // Dropdown-Toggle für Sidebar-Menü
    const dropdownToggles = document.querySelectorAll(".dropdown-toggle");
    dropdownToggles.forEach(function (toggle) {
      toggle.addEventListener("click", function (event) {
        const dropdownMenu = this.nextElementSibling;
        dropdownMenu.classList.toggle("open");
        event.stopPropagation();
      });
    });

    // Eventlistener für Klicks außerhalb der Sidebar
    document.addEventListener("click", function (event) {
      if (!sidebarMenu.contains(event.target) && !hamburgerMenu.contains(event.target)) {
        if (sidebarMenu.classList.contains("open")) {
          sidebarMenu.classList.remove("open");
          hamburgerMenu.classList.remove("open");
          sidebarMenu.style.pointerEvents = "none";
        }

        // Schließt das Dropdown-Menü, wenn außerhalb geklickt wird
        dropdownToggles.forEach(function (toggle) {
          const dropdownMenu = toggle.nextElementSibling;
          if (dropdownMenu.classList.contains("open") && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove("open");
          }
        });
      }
    });
  } else {
    if (!hamburgerMenu) console.error("Element 'hamburger-menu' nicht gefunden.");
    if (!sidebarMenu) console.error("Element 'sidebar-menu' nicht gefunden.");
  }

  // Restlicher Code
  updateClock();
  setCurrentMonthYear();
  setInterval(updateClock, 1000);

  const logo = document.querySelector(".logo");
  if (logo) {
    logo.addEventListener("mouseenter", function () {
      this.classList.add("hover-color");
    });
    logo.addEventListener("mouseleave", function () {
      this.classList.remove("hover-color");
    });
  }
});

function updateClock() {
  const now = new Date();
  const hours = String(now.getHours()).padStart(2, "0");
  const minutes = String(now.getMinutes()).padStart(2, "0");
  const seconds = String(now.getSeconds()).padStart(2, "0");
  const clockElement = document.getElementById("clock");
  if (clockElement) {
    clockElement.textContent = `${hours}:${minutes}:${seconds}`;
  }
}

function setCurrentMonthYear() {
  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  const currentDate = new Date();
  const currentMonthYear = monthNames[currentDate.getMonth()] + " " + currentDate.getFullYear();
  const monthYearElement = document.getElementById("current-month-year");
  if (monthYearElement) {
    monthYearElement.textContent = "Your Score in " + currentMonthYear;
  }
}

function getCsrfToken() {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
  return csrfToken;
}

window.ShowSnackbar = function (message, isSuccess) {
  const snackbarContainer = document.getElementById("snackbar-container");
  if (!snackbarContainer) return;
  snackbarContainer.innerHTML = "";
  const snackbar = document.createElement("div");
  snackbar.className = `snackbar ${isSuccess ? "success" : "failure"}`;
  snackbar.textContent = message;
  snackbarContainer.appendChild(snackbar);
  snackbar.classList.add("show");
  setTimeout(() => {
    snackbar.remove();
  }, 3000);
};

function playApprovalSound(taskContainer) {
  console.log(`Sound abgespielt für Task-ID: ${taskContainer.getAttribute("data-task-id")}`);
  const sound = document.getElementById("approvalSound");
  if (sound) {
    console.log("Abspielsound...");
    sound
      .play()
      .then(() => {
        console.log("Sound erfolgreich abgespielt");
        taskContainer.setAttribute("data-sound-played", "true");
      })
      .catch((error) => {
        console.error("Fehler beim Abspielen des Sounds:", error);
      });
  } else {
    console.error("Sound-Element nicht gefunden");
  }
}

function launchConfetti(taskContainer) {
  console.log(`Konfetti gestartet für Task-ID: ${taskContainer.getAttribute("data-task-id")}`);
  if (
    taskContainer.getAttribute("data-status") === "Warten auf Freigabe" &&
    !taskContainer.getAttribute("data-confetti-shown")
  ) {
    const statusLogoImage = taskContainer.querySelector(".task-status-img");
    if (statusLogoImage) {
      const rect = statusLogoImage.getBoundingClientRect();
      const x = rect.left + rect.width / 2;
      const y = rect.top + rect.height / 2;
      const xRelative = x / window.innerWidth;
      const yRelative = y / window.innerHeight;

      for (let i = 0; i < 3; i++) {
        setTimeout(() => {
          confetti({
            particleCount: 100,
            spread: 70,
            origin: { x: xRelative, y: yRelative },
            zIndex: 1050,
          });
        }, i * 2000);
      }
    }
    taskContainer.setAttribute("data-confetti-shown", "true");
  }
}
