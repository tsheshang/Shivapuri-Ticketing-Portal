const API = "/shivapuri-ticketing/backend/controllers/";

function showAdminTab(tab) {
    document.getElementById('bookingsPanel').style.display = tab === 'bookings' ? 'block' : 'none';
    document.getElementById('categoriesPanel').style.display = tab === 'categories' ? 'block' : 'none';
    document.getElementById('messagesPanel').style.display = tab === 'messages' ? 'block' : 'none';
    document.getElementById('bookingsTab').classList.toggle('active', tab === 'bookings');
    document.getElementById('categoriesTab').classList.toggle('active', tab === 'categories');
    document.getElementById('messagesTab').classList.toggle('active', tab === 'messages');
}

async function loadBookings() {
    const res = await fetch(API + "adminGetBookings.php");
    const bookings = await res.json();
    const tbody = document.getElementById('bookingsBody');

    if (!bookings.length) {
        tbody.innerHTML = "<tr><td colspan='8' class='loading-row'>No bookings yet.</td></tr>";
    } else {
        tbody.innerHTML = bookings.map(b => `
            <tr>
                <td>${b.booking_ref}</td>
                <td>${b.full_name}<br><small style="color:#999;">${b.email}</small></td>
                <td>${b.category_name}</td>
                <td>${b.visit_date}</td>
                <td>${b.quantity}</td>
                <td>NPR ${b.total_price}</td>
                <td><span class="status-badge status-${b.status}">${b.status}</span></td>
                <td>
                    ${b.status === 'confirmed'
                        ? `<button class="danger" onclick="updateBookingStatus(${b.id}, 'cancelled')">Cancel</button>`
                        : `<button onclick="updateBookingStatus(${b.id}, 'confirmed')">Restore</button>`
                    }
                </td>
            </tr>
        `).join('');
    }

    // Update stat cards
    const total = bookings.length;
    const confirmed = bookings.filter(b => b.status === 'confirmed').length;
    const cancelled = bookings.filter(b => b.status === 'cancelled').length;
    const revenue = bookings.filter(b => b.status === 'confirmed').reduce((sum, b) => sum + parseFloat(b.total_price), 0);

    document.getElementById('statTotalBookings').textContent = total;
    document.getElementById('statConfirmed').textContent = confirmed;
    document.getElementById('statCancelled').textContent = cancelled;
    document.getElementById('statRevenue').textContent = revenue.toLocaleString();
}

async function updateBookingStatus(id, status) {
    await fetch(API + "adminUpdateBookingStatus.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, status })
    });
    loadBookings();
}

async function loadCategories() {
    const res = await fetch(API + "adminGetCategories.php");
    const categories = await res.json();
    const tbody = document.getElementById('categoriesBody');

    tbody.innerHTML = categories.map(c => `
        <tr>
            <td>${c.name}</td>
            <td>${c.code}</td>
            <td>NPR ${c.price}</td>
            <td>
                <button onclick="editCategory(${c.id}, '${c.name}', ${c.price})">Edit</button>
                <button class="danger" onclick="deleteCategory(${c.id})">Delete</button>
            </td>
        </tr>
    `).join('');
}

async function editCategory(id, currentName, currentPrice) {
    const name = prompt("Category name:", currentName);
    if (name === null) return;
    const price = prompt("Price (NPR):", currentPrice);
    if (price === null) return;

    await fetch(API + "adminUpdateCategory.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, name, price: parseFloat(price) })
    });
    loadCategories();
}

async function deleteCategory(id) {
    if (!confirm("Delete this category? This cannot be undone.")) return;

    await fetch(API + "adminDeleteCategory.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });
    loadCategories();
}

document.getElementById('addCategoryForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const name = document.getElementById('newCatName').value.trim();
    const code = document.getElementById('newCatCode').value.trim();
    const price = parseFloat(document.getElementById('newCatPrice').value);

    await fetch(API + "adminAddCategory.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name, code, price })
    });

    document.getElementById('addCategoryForm').reset();
    loadCategories();
});

async function loadMessages() {
    const res = await fetch(API + "adminGetMessages.php");
    const messages = await res.json();
    const container = document.getElementById('messagesList');

    if (!messages.length) {
        container.innerHTML = "<p style='color:#999;'>No messages yet.</p>";
        return;
    }

    container.innerHTML = messages.map(m => `
        <div class="message-card">
            <div class="message-header">
                <div>
                    <strong>${m.name}</strong>
                    <span style="color:#999; font-size:0.82rem;"> — ${m.email}</span>
                </div>
                <button class="danger" onclick="deleteMessage(${m.id})">Delete</button>
            </div>
            <p class="message-body">${m.message}</p>
            <span class="message-date">${new Date(m.created_at).toLocaleString()}</span>
        </div>
    `).join('');
}

async function deleteMessage(id) {
    if (!confirm("Delete this message?")) return;

    await fetch(API + "adminDeleteMessage.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });
    loadMessages();
}

loadBookings();
loadCategories();
loadMessages();
