document.addEventListener("DOMContentLoaded", () => {
  /***** SHOW AND HIDE ERROR FUNCTION *****/
  function showErrorMsg(id, msg, time) {
    const pTag = document.createElement("p");
    pTag.textContent = msg;
    id.appendChild(pTag);
    id.style.backgroundColor = "rgba(255, 255, 255, 0.7)";

    setTimeout(() => {
      id.style.backgroundColor = "transparent";
      pTag.remove();
    }, time);
  }

  function inputFieldColorChange(inputField) {
    const _inputField = document.querySelector(inputField);
    _inputField.style.border = "2px solid #FF5733";
    _inputField.addEventListener("focus", () => {
      _inputField.style.border = "none";
    });
  }

  /***** PASSWORD STRENGTH CHECKER RETURNS INT *****/
  function passwordStrengthChecker(password) {
    const standardLength = password.length >= 8;
    const hasLowercase = /[a-z]/.test(password);
    const hasUppercase = /[A-Z]/.test(password);
    const hasNumber = /\d/.test(password);
    const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    const isLongEnough = password.length >= 12;
    if (!standardLength) return 0;
    const strengthScore = [hasLowercase, hasUppercase, hasNumber, hasSymbol, isLongEnough].filter(Boolean).length;

    return strengthScore;
  }

  /***** PASSWORD TYPING LISTENER *****/
  document.getElementById("passInput").addEventListener("keyup", async (e) => {
    e.preventDefault();
    const password = document.getElementById("passInput").value.trim();
    const passStrengthMeterId = document.getElementById("passStrength");
    const strengthScore = passwordStrengthChecker(password);
    passStrengthMeterId.value = strengthScore;

    const passStrengthTextId = document.getElementById("passStrengthText");

    if (strengthScore >= 5) passStrengthTextId.textContent = "Strong";
    else if (strengthScore >= 3) passStrengthTextId.textContent = "Moderate";
    else passStrengthTextId.textContent = "Weak";
  });

  /***** FORM SUBMISSION LISTENER *****/
  document.getElementById("registrationForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const submitBtn = document.getElementById("submitBtn");
    submitBtn.disabled = true;

    setTimeout(() => {
      submitBtn.disabled = false;
    }, 3000);

    const username = DOMPurify.sanitize(document.getElementById("userInput").value.trim());
    const password = DOMPurify.sanitize(document.getElementById("passInput").value.trim());
    const passInputConfirm = DOMPurify.sanitize(document.getElementById("passInputConfirm").value.trim());

    const errorMsgId = document.getElementById("errorMsg");
    const seconds = 3000;

    if (username.length < 8) {
      let msg = "Minimum length 8 characters";
      showErrorMsg(errorMsgId, msg, 3000);
      inputFieldColorChange("#userInput");
      return;
    }

    if (!/^[a-z_0-9]+$/.test(username)) {
      let msg = "Only a-z, 0-9, or _ are allowed.";
      showErrorMsg(errorMsgId, msg, seconds);
      inputFieldColorChange("#userInput");
      return;
    }

    if (password !== passInputConfirm) {
      let msg = "Password doesn't match";
      showErrorMsg(errorMsgId, msg, 3000);
      inputFieldColorChange("#passInput");
      inputFieldColorChange("#passInputConfirm");
      return;
    }

    const firstname = DOMPurify.sanitize(document.getElementById("fnameInput").value.trim());
    const lastname = DOMPurify.sanitize(document.getElementById("lnameInput").value.trim());

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
        showErrorMsg(errorMsgId, data.message, 3000);
      }
    } catch (error) {
      console.error("An error occurred:", error);
      showErrorMsg(errorMsgId, error, 3000);
    }
  });
});
