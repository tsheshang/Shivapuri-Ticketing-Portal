const API = "/shivapuri-ticketing/backend/controllers/";

async function loadMyBookings() {
    const res = await fetch(API + "getMyBookings.php");

    if (res.status === 401) {
        window.location.href = "login.html";
        return;
    }

    const bookings = await res.json();
    const tbody = document.getElementById('myBookingsBody');

    if (!bookings.length) {
        tbody.innerHTML = "<tr><td colspan='7' class='loading-row'>You haven't booked any tickets yet. <a href='tickets.html' style='color:#d4a24c;'>Book one now →</a></td></tr>";
        return;
    }

    tbody.innerHTML = bookings.map(b => `
        <tr>
            <td>${b.booking_ref}</td>
            <td>${b.category_name}</td>
            <td>${b.visit_date}</td>
            <td>${b.quantity}</td>
            <td>NPR ${b.total_price}</td>
            <td><span class="status-badge status-${b.status}">${b.status}</span></td>
            <td>
                ${b.status === 'confirmed'
                    ? `<button class="danger" onclick="cancelBooking(${b.id})">Cancel</button>`
                    : `<span style="color:#777; font-size:0.85rem;">—</span>`
                }
            </td>
        </tr>
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
