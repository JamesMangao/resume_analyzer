<div class="sidebar">
    <button class="sidebar-close-btn">✕</button>
    <div class="sidebar-logo">LifeVault</div>

    <div class="nav-section-label">Menu</div>
    <div class="nav-item active" onclick="navigateTo('dashboard')"><span class="nav-icon">🏠</span> Dashboard</div>
    <div class="nav-item" onclick="navigateTo('journal')"><span class="nav-icon">📓</span> Journal</div>
    <div class="nav-item" onclick="navigateTo('tasks')"><span class="nav-icon">✅</span> Tasks</div>
    <div class="nav-item" onclick="navigateTo('goals')"><span class="nav-icon">🎯</span> Goals</div>

    <div class="nav-section-label">System</div>
    <div class="nav-item" onclick="navigateTo('settings')"><span class="nav-icon">⚙️</span> Settings</div>

    <div class="sidebar-bottom">
        <div class="user-card">
            <img id="user-avatar" src="" alt="User" class="user-avatar">
            <div class="user-info">
                <div id="user-name" class="user-name"></div>
                <div id="user-email" class="user-email"></div>
            </div>
            <button class="signout-btn" onclick="signOutUser()">⍈</button>
        </div>
    </div>
</div>