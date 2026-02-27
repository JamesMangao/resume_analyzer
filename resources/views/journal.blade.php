<div id="journal" class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Journal</h1>
            <p class="page-subtitle">Your private space to write and reflect.</p>
        </div>
        <button class="btn btn-primary" onclick="openJournalModal()">+ New Entry</button>
    </div>
    <div class="form-group" style="max-width:400px; margin-bottom:20px">
        <input type="search" id="journal-search" class="form-input" placeholder="Search entries..." onkeyup="filterJournals()">
    </div>
    <div id="journal-list"></div>
</div>