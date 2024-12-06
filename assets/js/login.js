document.addEventListener("DOMContentLoaded", () => {
  /***** SHOW AND HIDE ERROR *****/
  function showErrorMsg(id, msg, time) {
    const pTag = document.createElement("p");
    pTag.textContent = msg;
    id.appendChild(pTag);
    id.style.display = "flex";
    setTimeout(() => {
      id.style.display = "none";
      pTag.textContent = "";
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
  document
    .getElementById("login-form")
    .addEventListener("submit", async (e) => {
      e.preventDefault();
      const submitBtn = document.getElementById("submitBtn");

      submitBtn.disabled = true;
      setTimeout(() => {
        submitBtn.disabled = false;
      }, 3000);

      const username = DOMPurify.sanitize(
        document.getElementById("userInput").value.trim()
      );
      const password = DOMPurify.sanitize(
        document.getElementById("passInput").value.trim()
      );
      const errorMsg = document.getElementById("errorMsg");

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
          // console.error("Login failed:", data.message);
          showErrorMsg(errorMsg, data.message, 3000);
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
