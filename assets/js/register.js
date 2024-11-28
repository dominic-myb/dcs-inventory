document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("registration-form")
    .addEventListener("submit", async (e) => {
      e.preventDefault();
      const username = DOMPurify.sanitize(
        document.getElementById("username-input").value.trim()
      );
      const password = DOMPurify.sanitize(
        document.getElementById("password-input").value.trim()
      );
      const confirmPassword = DOMPurify.sanitize(
        document.getElementById("confirm-password-input").value.trim()
      );
      const errorMsg = document.getElementById("error-message");

      // Check if passwords match
      if (password !== confirmPassword) {
        errorMsg.querySelector("p").textContent = "Password doesn't match";
        errorMsg.style.display = "flex";
        return;
      }

      const firstname = DOMPurify.sanitize(
        document.getElementById("firstname-input").value.trim()
      );
      const lastname = DOMPurify.sanitize(
        document.getElementById("lastname-input").value.trim()
      );

      try {
        const response = await fetch("../backend/register.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ firstname, lastname, username, password }),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        if (data.status === "success") {
          console.log("Registration Successful:", data.message);
          window.location.href = "login.php";
        } else {
          console.error("Registration failed:", data.message);
          errorMsg.querySelector("p").textContent = data.message;
          errorMsg.style.display = "flex";

          // Hides error message after 3 seconds
          setTimeout(() => {
            errorMsg.style.display = "none";
          }, 3000);
        }
      } catch (error) {
        console.error("An error occurred:", error);
      }
    });
});
