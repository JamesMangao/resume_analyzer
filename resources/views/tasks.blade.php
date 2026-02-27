<div id="tasks" class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tasks</h1>
            <p class="page-subtitle">Organize and conquer your to-do list.</p>
        </div>
        <button class="btn btn-primary" onclick="openTaskModal()">+ Add Task</button>
    </div>

    <div class="grid-3" style="align-items:flex-start">
        <div class="card" ondragover="dragOver(event)" ondrop="dropTask(event,'high')">
            <div class="card-title"><span class="priority-dot p-high"></span> High Priority</div>
            <div id="tasks-high"></div>
        </div>
        <div class="card" ondragover="dragOver(event)" ondrop="dropTask(event,'med')">
            <div class="card-title"><span class="priority-dot p-med"></span> Medium Priority</div>
            <div id="tasks-med"></div>
        </div>
        <div class="card" ondragover="dragOver(event)" ondrop="dropTask(event,'low')">
            <div class="card-title"><span class="priority-dot p-low"></span> Low Priority</div>
            <div id="tasks-low"></div>
        </div>
    </div>
</div>

<style>
.grid-3 {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}
</style>