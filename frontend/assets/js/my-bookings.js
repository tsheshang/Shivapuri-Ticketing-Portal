const API = "/shivapuri-ticketing/backend/controllers/";

async function loadMyBookings() {
    const res = await fetch(API + "getMyBookings.php");

    if (res.status === 401) {
        window.location.href = "login.html";
        return;
    }

    const bookings = await res.json();
    const container = document.getElementById('myBookingsList');

    if (!bookings.length) {
        container.innerHTML = "<p class='empty-text'>You haven't booked any tickets yet. <a href='tickets.html'>Book one now →</a></p>";
        return;
    }

    container.innerHTML = bookings.map(b => `
        <div class="booking-card ${b.status === 'cancelled' ? 'is-cancelled' : ''}">
            <div class="booking-main">
                <div class="booking-ref">${b.booking_ref}</div>
                <div class="booking-category">${b.category_name} × ${b.quantity}</div>
                <div class="booking-meta">
                    <span>📅 ${b.visit_date}</span>
                    <span class="status-badge status-${b.status}">${b.status}</span>
                </div>
            </div>
            <div class="booking-side">
                <div class="booking-price">NPR ${b.total_price}</div>
                ${b.status === 'confirmed'
                    ? `<button class="booking-cancel-btn" onclick="cancelBooking(${b.id})">Cancel</button>`
                    : ''
                }
            </div>
        </div>
    `).join('');
}

async function cancelBooking(id) {
    if (!confirm("Cancel this booking? This cannot be undone.")) return;

    const res = await fetch(API + "cancelMyBooking.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });

    if (res.ok) {
        loadMyBookings();
    } else {
        alert("Something went wrong. Please try again.");
    }
}

loadMyBookings();
