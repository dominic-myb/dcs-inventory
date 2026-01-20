"use strict";
document.addEventListener("DOMContentLoaded", () => {
  /***** SHOW AND HIDE ERROR *****/
  function showErrorMsg(id, msg, time) {
    const pTag = document.createElement("p");

    pTag.textContent = msg;
    id.style.backgroundColor = "#fff";
    id.appendChild(pTag);

    setTimeout(() => {
      id.style.backgroundColor = "transparent";
      pTag.remove();
    }, time);
  }

  /***** SHOW AND HIDE OF PASSWORD *****/
  const passToggle = document.getElementById("passToggle");
  const passInput = document.getElementById("passInput");

  passToggle.addEventListener("click", () => {
    passInput.style.margin = 0;

    if (passInput.type === "password") {
      passInput.type = "text";
      passToggle.value = "Hide";
    } else {
      passInput.type = "password";
      passToggle.value = "Show";
    }
  });

  /***** FORM SUBMISSION *****/
  document.getElementById("login-form").addEventListener("submit", async e => {
    e.preventDefault();
    try {
      const submitBtn = document.getElementById("submitBtn");
      const errorMsg = document.getElementById("errorMsg");
      if (!errorMsg || !submitBtn) throw new Error("Reference Id not found.");

      submitBtn.disabled = true;
      setTimeout(() => {
        submitBtn.disabled = false;
      }, 3000);

      const username = DOMPurify.sanitize(
        document.getElementById("userInput").value.trim(),
      );
      const password = DOMPurify.sanitize(
        document.getElementById("passInput").value.trim(),
      );
      const token = document.getElementById("csrfToken").value;
      const formData = {
        username: username,
        password: password,
        csrf_token: token,
      };

      const response = await fetch("../backend/login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "CSRF-Token": csrfToken,
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json();

      if (data.status === "success") {
        console.log(`Login successful: ${data.message}`);
        window.location.href = "../index.php";
      } else {
        console.error(`Login failed: ${data.message}`);
        showErrorMsg(errorMsg, data.message, 3000);
      }
    } catch (error) {
      console.error(`An error occurred: ${error}`);
    }
  });
  /***** END *****/
});
