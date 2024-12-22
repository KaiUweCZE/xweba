export function validateForm(form) {
  const email = form.querySelector('input[name="email"]');
  const firstname = form.querySelector('input[name="firstname"]');
  const lastname = form.querySelector('input[name="lastname"]');
  const password = form.querySelector('input[name="password"]');

  let isValid = true;
  let errors = [];

  // Email validace
  if (!email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
    email.classList.add("is-invalid");
    errors.push("Email není ve správném formátu");
    isValid = false;
  } else {
    email.classList.remove("is-invalid");
  }

  // Jméno validace
  if (firstname.value.length < 2) {
    firstname.classList.add("is-invalid");
    errors.push("Jméno musí mít alespoň 2 znaky");
    isValid = false;
  } else {
    firstname.classList.remove("is-invalid");
  }

  // Příjmení validace
  if (lastname.value.length < 2) {
    lastname.classList.add("is-invalid");
    errors.push("Příjmení musí mít alespoň 2 znaky");
    isValid = false;
  } else {
    lastname.classList.remove("is-invalid");
  }

  // Heslo validace (jen pro nové uživatele)
  if (
    form.querySelector('input[name="action"]').value === "add" &&
    password.value.length < 4
  ) {
    password.classList.add("is-invalid");
    errors.push("Heslo musí mít alespoň 4 znaky");
    isValid = false;
  } else {
    password.classList.remove("is-invalid");
  }

  if (!isValid) {
    showNotification(errors.join("<br>"), "danger");
  }

  return isValid;
}

export function showNotification(message, type = "success") {
  // Odstraníme existující notifikace
  const existingNotifications = document.querySelectorAll(
    ".custom-notification"
  );
  existingNotifications.forEach((notification) => notification.remove());

  // Vytvoříme novou notifikaci
  const notification = document.createElement("div");
  notification.className = `custom-notification alert alert-${type} alert-dismissible fade show position-fixed`;
  notification.style.cssText =
    "top: 20px; right: 20px; z-index: 1050; max-width: 500px;";
  notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

  document.body.appendChild(notification);

  // Automatické zmizení po 3 sekundách
  setTimeout(() => {
    notification.classList.remove("show");
    setTimeout(() => notification.remove(), 150);
  }, 3000);
}

export async function deleteUser(userId) {
  if (!confirm("Opravdu chcete smazat tohoto uživatele?")) {
    return;
  }

  try {
    const formData = new URLSearchParams();
    formData.append("action", "delete");
    formData.append("id", userId);

    const response = await fetch("index.php?page=users", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: formData.toString(),
    });

    if (response.ok) {
      // Odstraníme řádek z tabulky
      document.querySelector(`tr[data-user-id="${userId}"]`)?.remove();
      showNotification("Uživatel byl úspěšně smazán.");
    } else {
      showNotification("Při mazání uživatele došlo k chybě.", "danger");
    }
  } catch (error) {
    showNotification("Při mazání uživatele došlo k chybě.", "danger");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Přidáme validaci na všechny formuláře
  document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", function (e) {
      if (!validateForm(this)) {
        e.preventDefault();
      }
    });
  });

  // Přidáme potvrzení pro mazání
  /* document.querySelectorAll('button[onclick*="confirm"]').forEach((button) => {
    button.onclick = function (e) {
      e.preventDefault();
      if (confirm("Opravdu chcete smazat tohoto uživatele?")) {
        this.closest("form").submit();
      }
    };
  });*/
});
