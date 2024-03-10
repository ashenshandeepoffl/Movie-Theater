const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

    document.addEventListener("DOMContentLoaded", function () {
        const signUpForm = document.querySelector(".sign-up-form");

        signUpForm.addEventListener("submit", function (event) {
            const usernameInput = document.querySelector('input[name="username"]');
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');

            // Validate username
            if (!validateUsername(usernameInput.value)) {
                alert("Please enter a valid username");
                event.preventDefault();
            }

            // Validate email
            else if (!validateEmail(emailInput.value)) {
                alert("Please enter a valid email address");
                event.preventDefault();
            }

            // Validate password
            else if (!validatePassword(passwordInput.value)) {
                alert("Password must be at least 6 characters long");
                event.preventDefault();
            }
        });

        function validateUsername(username) {
            return username.trim() !== "";
        }

        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function validatePassword(password) {
            return password.length >= 6;
        }
    });

