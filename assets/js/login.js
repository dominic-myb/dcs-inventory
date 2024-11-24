document.addEventListener("DOMContentLoaded", () => {
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
