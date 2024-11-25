document.addEventListener("DOMContentLoaded", () => {
  /***** SHOW AND HIDE OF PASSWORD *****/
  const passToggle = document.getElementById("pass-toggle");
  const passInput = document.getElementById("pass-input");
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
  document
    .getElementById("login-form")
    .addEventListener("submit", async (e) => {
      e.preventDefault();
      const username = DOMPurify.sanitize(
        document.getElementById("username").value.trim()
      );
      const password = DOMPurify.sanitize(
        document.getElementById("username").value.trim()
      );

      fetch("../backend/login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ username, password }),
      })
        .then((response) => response.json())
        .then((data) => console.log(data))
        .catch((error) => console.error("Error:", error));
    });
});

/***** DETECT IF INCORRECT PASS IS SHOWN *****/

const incorrectPassMsg = document.getElementById("pass-incorrect");
const submitBtn = document.getElementById("submit-btn");
// incorrectPassMsg.hasAttribute;
if (incorrectPassMsg.hasAttribute("display") === "flex") {
  submitBtn.style.marginTop = 0;
} else {
  submitBtn.style.marginTop = "1rem";
}
