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
        document.getElementById("pass-input").value.trim()
      );
      const errorMsg = document.getElementById("error-message");

      try {
        const response = await fetch("../backend/login.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ username, password }),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        if (data.status === "success") {
          console.log("Login successful:", data.message);
          window.location.href = "../index.php";
        } else {
          console.error("Login failed:", data.message);
          errorMsg.getElementsByTagName("p").value = data.message;
          errorMsg.style.display = "flex";

          // hides error message after 3 secs
          setTimeout(() => {
            errorMsg.style.display = "none";
          }, 3000);
        }
      } catch (error) {
        console.error("An error occurred:", error);
      }
    });
});

/***** DETECT IF INCORRECT PASS IS SHOWN *****/

// const errorMsg = document.getElementById("error-message p");
// const submitBtn = document.getElementById("submit-btn");
// // errorMsg.hasAttribute;
// if (errorMsg.hasAttribute("display") === "flex") {
//   submitBtn.style.marginTop = 0;
// } else {
//   submitBtn.style.marginTop = "1rem";
// }
