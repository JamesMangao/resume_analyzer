<!-- Journal Modal -->
<div id="journal-modal" class="modal-backdrop">
    <div class="modal">
        <div class="modal-header">
            <h2 id="jmodal-title" class="modal-title">New Journal Entry</h2>
            <button class="modal-close" onclick="closeModal('journal-modal')">×</button>
        </div>
        <div class="form-group">
            <label for="journal-title" class="form-label">Title</label>
            <input type="text" id="journal-title" class="form-input" placeholder="What's on your mind?">
        </div>
        <div class="form-group">
            <label for="journal-content" class="form-label">Content</label>
            <textarea id="journal-content" class="form-textarea" placeholder="Start writing..."></textarea>
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label class="form-label">Mood</label>
                <div class="mood-picker">
                    <div class="mood-option" data-mood="5" onclick="selectMood(5, '😄')">😄<span>Great</span></div>
                    <div class="mood-option" data-mood="4" onclick="selectMood(4, '🙂')">🙂<span>Good</span></div>
                    <div class="mood-option selected" data-mood="3" onclick="selectMood(3, '😐')">😐<span>Okay</span></div>
                    <div class="mood-option" data-mood="2" onclick="selectMood(2, '😟')">😟<span>Bad</span></div>
                    <div class="mood-option" data-mood="1" onclick="selectMood(1, '😭')">😭<span>Awful</span></div>
                </div>
            </div>
            <div class="form-group">
                <label for="journal-tags" class="form-label">Tags</label>
                <input type="text" id="journal-tags" class="form-input" placeholder="comma, separated, tags">
            </div>
        </div>
        <div class="form-group">
            <label for="journal-photos" class="form-label">Photos (up to 6)</label>
            <input type="file" id="journal-photos" class="form-input" multiple accept="image/*">
            <div id="photo-preview" style="display:flex;gap:8px;margin-top:10px;flex-wrap:wrap"></div>
        </div>
        <button class="btn btn-primary" style="width:100%" onclick="saveJournalEntry()">Save Entry</button>
    </div>
</div>

<!-- Task Modal -->
<div id="task-modal" class="modal-backdrop">
    <div class="modal">
        <div class="modal-header">
            <h2 id="tmodal-title" class="modal-title">Add Task</h2>
            <button class="modal-close" onclick="closeModal('task-modal')">×</button>
        </div>
        <div class="form-group">
            <label for="task-text" class="form-label">Task</label>
            <input type="text" id="task-text" class="form-input" placeholder="What needs to be done?">
        </div>
        <div class="form-group">
            <label for="task-note" class="form-label">Note (Optional)</label>
            <input type="text" id="task-note" class="form-input" placeholder="Add a little detail...">
        </div>
        <div class="form-group">
            <label for="task-priority" class="form-label">Priority</label>
            <select id="task-priority" class="form-select">
                <option value="high">High</option>
                <option value="med" selected>Medium</option>
                <option value="low">Low</option>
            </select>
        </div>
        <button class="btn btn-primary" style="width:100%" onclick="saveTask()">Save Task</button>
    </div>
</div>

<!-- Goal Modal -->
<div id="goal-modal" class="modal-backdrop">
    <div class="modal">
        <div class="modal-header">
            <h2 id="gmodal-title" class="modal-title">New Goal</h2>
            <button class="modal-close" onclick="closeModal('goal-modal')">×</button>
        </div>
        <div class="form-group">
            <label for="goal-name" class="form-label">Goal Name</label>
            <input type="text" id="goal-name" class="form-input" placeholder="e.g., Learn to play guitar">
        </div>
        <div class="form-group">
            <label for="goal-target" class="form-label">Target (Optional)</label>
            <input type="text" id="goal-target" class="form-input" placeholder="e.g., Master 5 songs">
        </div>
        <div class="form-group">
            <label for="goal-category" class="form-label">Category</label>
            <select id="goal-category" class="form-select">
                <option value="personal" selected>Personal</option>
                <option value="work">Work</option>
                <option value="health">Health</option>
                <option value="finance">Finance</option>
                <option value="learning">Learning</option>
            </select>
        </div>
        <button class="btn btn-primary" style="width:100%" onclick="saveGoal()">Save Goal</button>
    </div>
</div>