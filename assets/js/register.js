  /* 
  TODO: FEAT: WEAK - MODERATE - STRONG PASSWORD INDICATOR | RED | ORANGE | GREEN
  TODO: ADD API FOR COMMON PASSWORDS
  * CRITERIA: 
  ? WEAK
  * * NO COMBINATION || < 8 CHARS 
  ? MODERATE
  * * IN THE API COMMON PASSWORDS || 8-12 CHARS
  ? STRONG 
  * * > 12 CHARS || ALL COMBINATIONS CHECK || NOT IN API COMMON PASSWORD DICTIONARY

  TODO:
  1. Create a function for input validity
  2. The flow must be firstname > lastname > username > password > confirm_password
  3. if there's a problem with first name return the error message
  4. get the message if there is: get the errorMsg on respective error message div
  ?ADD A NEW PHP TO CHECK IF USERNAME IS AVAILABLE? 
  */

document.addEventListener("DOMContentLoaded", () => {
  function showErrorMsg(errorMsgId, msg, seconds) {
    errorMsgId.querySelector("p").textContent = msg;
    errorMsgId.style.display = "flex";
    setTimeout(() => {
      errorMsgId.style.display = "none";
    }, seconds);
  }

  // FIXME: MAKE THIS AND INPUT VALIDATION INTO ONE
  function usernameValidation(username){
    const errorId = "userErrorMsg";
    var errorMsg = null;

    if (username.length < 8) {
      errorMsg = "Username must be at least 8 characters long.";
      return [errorId, errorMsg];  
    }
    if (!/[A-Z]/.test(username)){
      errorMsg = "Username must include at least one uppercase letter.";
      return [errorId, errorMsg];  
    }
    if (!/[a-z]/.test(username)){
      errorMsg = "Username must include at least one lowercase letter.";
      return [errorId, errorMsg];  
    }
    if(!/[^a-zA-Z0-9]/.test(username)){
      errorMsg = "Username must include at least one symbol.";
      return [errorId, errorMsg];  
    }
    return null;
  }

  function inputValidation(
    firstname,
    lastname,
    username,
    password,
    passwordConfirm
  ) {
    var errorId = "";
    var errorMsg = "";

    if (firstname === "") {
      errorId = "fnameErrorMsg";
      errorMsg = "Firstname cannot be empty.";
      return [errorId, errorMsg];
    }
    if (lastname === "") {
      errorId = "lnameErrorMsg";
      errorMsg = "Lastname cannot be empty.";
      return [errorId, errorMsg];
    }
    if(usernameValidation(username) !== null){
      [errorId, errorMsg] = usernameValidation(username);
    }

    return [null, null];
  }

  document
    .getElementById("registration-form")
    .addEventListener("submit", async (e) => {
      e.preventDefault();

      const username = DOMPurify.sanitize(
        document.getElementById("userInput").value.trim()
      );
      const password = DOMPurify.sanitize(
        document.getElementById("passInput").value.trim()
      );
      const passInputConfirm = DOMPurify.sanitize(
        document.getElementById("passInputConfirm").value.trim()
      );
      const errorMsg = document.getElementById("errorMsg"); // remove this

      const userErrorMsg = document.getElementById("userErrorMsg");
      const passErrorMsg = document.getElementById("passErrorMsg");
      const seconds = 3000;

      if (password !== passInputConfirm) {
        showErrorMsg(errorMsg, "Password doesn't match", 3000);
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
          // Hides error message after 3 seconds
          showErrorMsg(errorMsg, data.message, 3000);
        }
      } catch (error) {
        console.error("An error occurred:", error);
        showErrorMsg(errorMsg, error.msg, 3000);
      }
    });
});
