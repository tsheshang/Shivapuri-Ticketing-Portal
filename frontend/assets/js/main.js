document.addEventListener("DOMContentLoaded", () => {
  console.log("Shivapuri Ticketing Portal loaded ✅");

  // Navbar shadow on scroll
  const navbar = document.querySelector(".navbar");
  window.addEventListener("scroll", () => {
    if (window.scrollY > 10) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  });

  // Live ticket price summary on tickets.html
  const categorySelect = document.getElementById("category");
  const quantityInput = document.getElementById("quantity");

  if (categorySelect && quantityInput) {
        const sumCategory = document.getElementById("sumCategory");
        const sumPrice = document.getElementById("sumPrice");
        const sumQty = document.getElementById("sumQty");
        const sumTotal = document.getElementById("sumTotal");

     function updateSummary() {
      const selected = categorySelect.options[categorySelect.selectedIndex];
      const price = selected.dataset.price
        ? parseInt(selected.dataset.price)
        : 0;
      const qty = parseInt(quantityInput.value) || 0;

      sumCategory.textContent = selected.value
        ? selected.text.split(" - ")[0]
        : "—";
      sumPrice.textContent = "NPR " + price;
      sumQty.textContent = qty;
      sumTotal.textContent = "NPR " + price * qty;
        }

        categorySelect.addEventListener("change", updateSummary);
        quantityInput.addEventListener("input", updateSummary);
  }

  // Smooth scroll for anchor links (e.g. #tickets on same page)
  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener("click", function (e) {
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth" });
      }
    });
  });

  // Check login state and update navbar accordingly
  fetch("/shivapuri-ticketing/backend/controllers/checkSession.php")
    .then(res => res.json())
    .then(data => {
        const loginBtn = document.querySelector(".btn-login");
        if (!loginBtn) return;

        if (data.loggedIn) {
            loginBtn.textContent = data.full_name;
            loginBtn.href = "#";
            loginBtn.classList.add("logged-in");

            // Replace login link behavior with a dropdown-style logout
            loginBtn.addEventListener("click", (e) => {
                e.preventDefault();
                if (confirm("Log out of your account?")) {
                    window.location.href = "/shivapuri-ticketing/backend/controllers/logout.php";
                }
            });
        }
    })
    .catch(err => console.error("Session check failed:", err));
});
