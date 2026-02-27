<div id="dashboard" class="page active">
    <div class="page-header">
        <div>
            <h1 class="page-title">Welcome back!</h1>
            <p class="page-subtitle">Here's a snapshot of your LifeVault.</p>
        </div>
        <div style="display:flex;gap:8px">
            <button class="btn btn-primary" onclick="openJournalModal()">+ New Entry</button>
            <button class="btn" onclick="openTaskModal()">+ Add Task</button>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Journal Entries</div>
            <div id="stat-entries" class="stat-value">0</div>
            <div class="stat-change">All time</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tasks Done</div>
            <div id="stat-tasks" class="stat-value">0</div>
            <div class="stat-change">Last 7 days</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Goals</div>
            <div id="stat-goals" class="stat-value">0</div>
            <div class="stat-change">In progress</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Writing Streak</div>
            <div id="stat-streak" class="stat-value">0</div>
            <div class="stat-change">days</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Fav Mood</div>
            <div id="stat-mood" class="stat-value" style="font-size:1.8rem">😐</div>
            <div class="stat-change">All time</div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-title">Recent Journal Entries</div>
            <div id="dash-journal-list"></div>
        </div>
        <div class="card">
            <div class="card-title">Pending Tasks</div>
            <div id="dash-task-list"></div>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px">
        <div class="card-title">Goal Progress</div>
        <div id="dash-goals-list"></div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-title">Weekly Mood</div>
            <div id="mood-chart"></div>
        </div>
        <div class="card">
            <div class="card-title">Activity Summary</div>
            <div id="activity-summary"></div>
        </div>
    </div>
</div>