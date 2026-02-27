<div class="journal-expand-overlay" id="journal-expand-overlay" onclick="event.target === this && closeJournalExpand()">
    <div class="journal-expanded-card">
        <div class="expanded-card-header">
            <div>
                <h2 id="expanded-card-title" class="expanded-card-title"></h2>
                <div class="expanded-card-meta">
                    <span id="expanded-card-date" class="expanded-card-date"></span>
                    <span id="expanded-mood-badge" class="expanded-mood-badge"></span>
                </div>
            </div>
            <button class="expanded-close-btn" onclick="closeJournalExpand()">✕</button>
        </div>
        <div class="expanded-card-body">
            <div id="expanded-card-content" class="expanded-card-content"></div>
            <div id="expanded-photos" class="expanded-photos"></div>
            <div id="expanded-tags" class="expanded-tags"></div>
        </div>
        <div class="expanded-card-footer">
            <button class="btn" id="expanded-edit-btn">Edit</button>
            <button class="btn" id="expanded-del-btn">Delete</button>
        </div>
    </div>
</div>