// Redirects to login if visitor is not authenticated
// Used on pages that require login (tickets.html, my-bookings.html)

fetch("/shivapuri-ticketing/backend/controllers/checkSession.php")
    .then(res => res.json())
    .then(data => {
        if (!data.loggedIn) {
            const currentPage = window.location.pathname.split('/').pop();
            window.location.href = "login.html?redirect=" + encodeURIComponent(currentPage);
        }
    })
    .catch(err => console.error("Session check failed:", err));
