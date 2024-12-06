/* 
  TODO: FEAT: WEAK - MODERATE - STRONG PASSWORD INDICATOR | RED | ORANGE | GREEN
  TODO: ADD API FOR COMMON PASSWORDS
  * CRITERIA: 
  ? WEAK === 0-2 POINTS + < 8 CHARS
  * * NO COMBINATION || < 8 CHARS 
  ? MODERATE === >= 3 POINTS + !> 12 CHARS
  * * IN THE API COMMON PASSWORDS || 8-12 CHARS
  ? STRONG === >12 CHARS + 5 POINTS
  * * > 12 CHARS || ALL COMBINATIONS CHECK || NOT IN API COMMON PASSWORD DICTIONARY

  TODO:
  1. FIND HEX COLOR FOR RED, ORANGE, GREEM
  ?ADD A NEW PHP TO CHECK IF USERNAME IS AVAILABLE? 
  RED: #FF6961
  ORANGE: #FFB54C
  GREEN: #7ABD7E
  */

document.addEventListener("DOMContentLoaded", () => {
  function showErrorMsg(errorMsgId, msg, seconds) {
    const pTag = document.createElement("p");
    pTag.textContent = msg;
    errorMsgId.appendChild(pTag);
    errorMsgId.style.display = "flex";
    setTimeout(() => {
      errorMsgId.style.display = "none";
      pTag.textContent = "";
    }, seconds);
  }

  // ?MAKE THIS RETURNS INTEGER?
  function passwordStrengthChecker(password) {
    const standardLength = password.length >= 8;
    const hasLowercase = /[a-z]/.test(password);
    const hasUppercase = /[A-Z]/.test(password);
    const hasNumber = /\d/.test(password);
    const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    if (!standardLength) return "Weak";
    const strengthScore = [
      hasLowercase,
      hasUppercase,
      hasNumber,
      hasSymbol,
    ].filter(Boolean).length;
    if (strengthScore === 4 && password.length >= 12) return "Strong";
    if (strengthScore >= 2) return "Moderate";

    return "Weak";
  }

  //? REMOVE THIS? OR CONTINUE? IF CONTINUE GET A TXT FILE OF PWNED PASSWORDS THEN CONVERT INTO HASH THEN CONVERT TO JSON
  async function isPasswordPwned(password) {
    const sha1 = new Hashes.SHA1().hex(password);
    const prefix = sha1.substring(0, 5);
    const suffix = sha1.substring(5);

    const response = await fetch(
      `https://api.pwnedpasswords.com/range/${prefix}`
    );
    const data = await response.text();

    return data.includes(suffix);
  }

  document.getElementById("passInput").addEventListener("keyup", async (e) => {
    e.preventDefault();
    const password = document.getElementById("passInput").value.trim();
    const passwordStrength = passwordStrengthChecker(password);
    // console.log(`Password Strength: ${passwordStrength}`);
  });

  document
    .getElementById("registration-form")
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
      const passInputConfirm = DOMPurify.sanitize(
        document.getElementById("passInputConfirm").value.trim()
      );

      const userErrorMsg = document.getElementById("userErrorMsg");
      const passErrorMsg = document.getElementById("passErrorMsg");
      const seconds = 3000;
      
      if (username.length < 8){
        let msg = "Username must be at least 8 characters long.";
        showErrorMsg(userErrorMsg, msg, 3000);
        return;
      }

      if (!/^[a-z_0-9]+$/.test(username)){
        let msg = "Username must only have a-z, 0-9 and underscore";
        showErrorMsg(userErrorMsg, msg, seconds);
        return;
      }
      
      if (password !== passInputConfirm) {
        let msg = "Password doesn't match";
        showErrorMsg(passErrorMsg, msg, 3000);
        return;
      }

      const firstname = DOMPurify.sanitize(
        document.getElementById("fnameInput").value.trim()
      );

      const lastname = DOMPurify.sanitize(
        document.getElementById("lnameInput").value.trim()
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
          showErrorMsg(passErrorMsg, data.message, 3000);
        }
      } catch (error) {
        console.error("An error occurred:", error);
        showErrorMsg(passErrorMsg, error, 3000);
      }
    });
});
