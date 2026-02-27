<div id="settings" class="page">
    <h1 class="page-title">Settings</h1>
    <p class="page-subtitle">Manage your account and data.</p>

    <div class="card" style="max-width:600px">
        <div class="card-title">Data Management</div>
        <p style="font-size:.85rem;color:var(--muted);margin-bottom:16px">Export all your data as a single JSON file. You can import this file in the future to restore your vault.</p>
        <button class="btn" onclick="exportAsJSON()">Export Data</button>
    </div>

    <div class="card" style="max-width:600px;margin-top:20px">
        <div class="card-title">Account</div>
        <p style="font-size:.85rem;color:var(--muted);margin-bottom:16px">You are signed in as <strong id="settings-email"></strong>.</p>
        <button class="btn" style="background:rgba(248,113,113,.1);border-color:var(--rose);color:var(--rose)" onclick="signOutUser()">Sign Out</button>
    </div>
</div>