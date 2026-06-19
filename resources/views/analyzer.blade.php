{{-- resources/views/analyzer.blade.php --}}
<div id="page-analyzer" class="page">

  {{-- ══ PAGE HEADER ════════════════════════════════════════════ --}}
  <div class="page-header">
    <div>
      <div class="page-title">📄 Resume
        <span style="background:linear-gradient(135deg,var(--accent),var(--teal));-webkit-background-clip:text;-webkit-text-fill-color:transparent">Analyzer</span>
      </div>
      <div class="page-subtitle">Upload your resume and a job description to get an AI-powered analysis and match score</div>
    </div>
    {{-- Top "Analyze Resume" button — mirrors the submit button below --}}
    <button class="btn" id="analyzeTopBtn"
            onclick="document.getElementById('analysisForm').requestSubmit()"
            disabled
            style="background:linear-gradient(135deg,rgba(79,142,247,.15),rgba(45,212,191,.15));border-color:rgba(79,142,247,.35);color:var(--accent);font-weight:700">
      🔍 Analyze Resume
    </button>
  </div>

  {{-- ══ AI ANALYSIS BANNER ════════════════════════════════════════ --}}
  <div style="background:linear-gradient(135deg,rgba(79,142,247,.07),rgba(45,212,191,.07));border:1px solid rgba(79,142,247,.2);border-radius:16px;padding:18px 22px;margin-bottom:28px;display:flex;align-items:flex-start;gap:14px">
    <span style="font-size:1.4rem;flex-shrink:0;margin-top:2px">🎯</span>
    <div>
      <div style="font-size:.82rem;font-weight:700;margin-bottom:4px;color:var(--text)">Your AI Career Co-pilot</div>
      <div style="font-family:'Newsreader',serif;font-size:.85rem;color:var(--muted);line-height:1.65;font-weight:300">
        The Resume Analyzer gives you an edge in your job search. It provides an instant Match Score, identifies Keyword Gaps, offers ATS-friendly tips, and suggests Quick Wins to make your resume stand out to recruiters.
      </div>
    </div>
  </div>

  <form id="analysisForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="resumeMarkdown">

    <div style="display:grid;grid-template-columns:1fr 1fr;align-items:start;gap:20px;min-width:0">

      {{-- ══════════════════════════════════════
           LEFT — Inputs + Preview
      ══════════════════════════════════════ --}}
      <div style="display:flex;flex-direction:column;gap:14px;min-width:0">

        {{-- Upload card --}}
        <div class="ra-card">
          <div class="ra-card-label">
            <span class="ra-card-num">01</span>
            Resume File
          </div>

          <div id="dropZone" class="ra-dropzone"
               onclick="document.getElementById('resumeFile').click()"
               ondragover="event.preventDefault();this.classList.add('drag-over')"
               ondragleave="this.classList.remove('drag-over')"
               ondrop="raHandleDrop(event)">
            <div class="ra-dz-icon">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/>
              </svg>
            </div>
            <div class="ra-dz-title">Drop your resume or click to browse</div>
            <div class="ra-dz-sub">PDF · DOC · DOCX &nbsp;·&nbsp; max 5 MB</div>
          </div>
          <input type="file" id="resumeFile" name="resume_file" accept=".pdf,.doc,.docx" style="display:none">

          <div id="fileChosen" class="ra-file-chosen" style="display:none">
            <div class="ra-file-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
              </svg>
            </div>
            <div style="flex:1;min-width:0">
              <div id="chosenName" class="ra-file-name"></div>
              <div id="chosenSize" class="ra-file-size"></div>
            </div>
            <button type="button" onclick="raClearFile()" class="ra-file-remove" title="Remove">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
              </svg>
            </button>
          </div>
        </div>

        {{-- Job Description card --}}
        <div class="ra-card">
          <div class="ra-card-label">
            <span class="ra-card-num">02</span>
            Job Description
            <span id="jdCount" class="ra-jd-count">0 chars</span>
          </div>
          <textarea id="jobDescription" name="job_description" rows="10" required
                    class="ra-textarea"
                    placeholder="Paste the full job description here — the more detail, the better the analysis…"></textarea>
        </div>

        {{-- Resume Preview --}}
        <div id="ra-preview" class="ra-card" style="display:none">
          <div class="ra-preview-header" onclick="raTogglePreview()">
            <div style="display:flex;align-items:center;gap:10px">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
              </svg>
              <span class="ra-preview-title">Resume Preview</span>
              <span id="previewFilename" class="ra-preview-filename"></span>
            </div>
            <div id="previewChevron" class="ra-preview-chev">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="18 15 12 9 6 15"/>
              </svg>
            </div>
          </div>
          <div id="previewBody" class="ra-preview-body">
            <div id="previewContent" class="ra-preview-content"></div>
          </div>
        </div>


      </div>

      {{-- ══════════════════════════════════════
           RIGHT — Results
      ══════════════════════════════════════ --}}
      <div style="display:flex;flex-direction:column;gap:14px;min-width:0">

        {{-- Empty state --}}
        <div id="ra-empty" class="ra-card ra-empty-state">
          <div class="ra-empty-icon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
              <line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>
            </svg>
          </div>
          <div class="ra-empty-title">Ready to analyze</div>
          <div class="ra-empty-sub">Upload your resume and paste a job description<br>to get your AI-powered improvement report</div>
          <div class="ra-empty-steps">
            <div class="ra-empty-step"><span>01</span> Upload resume</div>
            <div class="ra-empty-step-div">→</div>
            <div class="ra-empty-step"><span>02</span> Add job description</div>
            <div class="ra-empty-step-div">→</div>
            <div class="ra-empty-step"><span>03</span> Get your report</div>
          </div>
        </div>

        {{-- Loading state --}}
        <div id="ra-loading" class="ra-card ra-loading-state" style="display:none">
          <div class="ra-loader-ring">
            <svg width="64" height="64" viewBox="0 0 36 36">
              <circle cx="18" cy="18" r="15.9" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="2"/>
              <circle cx="18" cy="18" r="15.9" fill="none" stroke="url(#loadGrad)" stroke-width="2"
                      stroke-dasharray="40 60" stroke-linecap="round"
                      style="animation:ra-spin 1.2s linear infinite;transform-origin:center"/>
              <defs><linearGradient id="loadGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#2dd4bf"/><stop offset="100%" stop-color="#4f8ef7"/>
              </linearGradient></defs>
            </svg>
          </div>
          <div class="ra-loading-title">Analyzing your resume</div>
          <div id="ra-step" class="ra-loading-step">Reading file…</div>
          <div class="ra-loading-dots"><span></span><span></span><span></span></div>
        </div>

        {{-- Match Score Hero --}}
        <div id="ra-score" class="ra-score-hero" style="display:none">
          <div class="ra-score-left">
            <div class="ra-score-eyebrow">MATCH SCORE</div>
            <div class="ra-score-number-wrap">
              <span id="scoreNum" class="ra-score-number">0</span>
              <span class="ra-score-denom">/100</span>
            </div>
            <div id="scoreLabel" class="ra-score-label"></div>
          </div>
          <div class="ra-score-right">
            <div class="ra-score-ring-wrap">
              <svg viewBox="0 0 36 36" class="ra-score-svg">
                <circle cx="18" cy="18" r="14" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="3"/>
                <circle id="scoreRing" cx="18" cy="18" r="14" fill="none"
                        stroke="url(#scoreGrad)" stroke-width="3"
                        stroke-dasharray="0 87.96" stroke-linecap="round"
                        style="transition:stroke-dasharray 1.4s cubic-bezier(.4,0,.2,1);transform:rotate(-90deg);transform-origin:center"/>
                <defs><linearGradient id="scoreGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#2dd4bf"/><stop offset="100%" stop-color="#4f8ef7"/>
                </linearGradient></defs>
              </svg>
              <div id="scoreRingNum" class="ra-score-ring-num">0</div>
            </div>
          </div>
          <div class="ra-score-bar-wrap">
            <div class="ra-score-bar-track">
              <div id="scoreBar" class="ra-score-bar-fill"></div>
            </div>
          </div>
        </div>

        {{-- AI Report --}}
        <div id="ra-report" class="ra-card" style="display:none">
          <div class="ra-report-header">
            <div class="ra-report-title">
              <div class="ra-report-dot"></div>
              AI Analysis Report
            </div>
            <div class="ra-report-badge">groq · llama-3.3-70b</div>
          </div>
          <div id="ra-sections" class="ra-sections-list"></div>
        </div>

        {{-- Action Buttons --}}
        <div id="ra-actions" style="display:none;flex-direction:column;gap:10px">
          <button type="button" id="saveAnalysisBtn" onclick="saveResumeToSaved()" class="ra-btn-save">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
              <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
            </svg>
            🔖 Save Analysis to Saved Items
          </button>
          <button type="button" id="downloadDocx" data-url="{{ route('resume.download.docx') }}" class="ra-btn-download">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Download Optimised Resume (DOCX)
          </button>
        </div>

      </div>
    </div>
  </form>
</div>

{{-- ══ STYLES ══════════════════════════════════════════════════ --}}
<style>
@keyframes ra-spin   { to { transform:rotate(360deg) } }
@keyframes ra-fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
@keyframes ra-pulse  { 0%,100%{opacity:.3} 50%{opacity:1} }
@keyframes ra-dot1   { 0%,80%,100%{transform:scale(0);opacity:0} 40%{transform:scale(1);opacity:1} }

.ra-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:20px; animation:ra-fadeUp .3s cubic-bezier(.4,0,.2,1) both; }
.ra-card-label { display:flex; align-items:center; gap:8px; font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.1em; color:var(--muted); margin-bottom:14px; }
.ra-card-num   { font-family:'JetBrains Mono',monospace; font-size:.58rem; color:var(--accent); background:rgba(79,142,247,.1); border:1px solid rgba(79,142,247,.2); padding:2px 7px; border-radius:5px; }

.ra-dropzone { border:1.5px dashed var(--border); border-radius:12px; background:rgba(255,255,255,.02); padding:28px 20px; text-align:center; cursor:pointer; transition:all .2s; position:relative; overflow:hidden; }
.ra-dropzone:hover, .ra-dropzone.drag-over { border-color:var(--accent); background:rgba(79,142,247,.04); }
.ra-dropzone::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(79,142,247,.03),transparent); pointer-events:none; }
.ra-dz-icon  { width:48px; height:48px; border-radius:12px; background:rgba(79,142,247,.08); border:1px solid rgba(79,142,247,.15); display:flex; align-items:center; justify-content:center; color:var(--accent); margin:0 auto 12px; transition:transform .2s; }
.ra-dropzone:hover .ra-dz-icon { transform:translateY(-2px); }
.ra-dz-title { font-size:.82rem; font-weight:700; color:var(--text); margin-bottom:5px; }
.ra-dz-sub   { font-family:'JetBrains Mono',monospace; font-size:.58rem; color:var(--muted); opacity:.6; text-transform:uppercase; letter-spacing:.08em; }

.ra-file-chosen { display:flex; align-items:center; gap:12px; margin-top:12px; padding:11px 14px; background:rgba(79,142,247,.06); border:1px solid rgba(79,142,247,.18); border-radius:10px; animation:ra-fadeUp .2s ease; }
.ra-file-icon   { width:32px; height:32px; border-radius:8px; background:rgba(79,142,247,.1); border:1px solid rgba(79,142,247,.2); display:flex; align-items:center; justify-content:center; color:var(--accent); flex-shrink:0; }
.ra-file-name   { font-size:.79rem; font-weight:700; color:var(--accent); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ra-file-size   { font-family:'JetBrains Mono',monospace; font-size:.58rem; color:var(--muted); margin-top:2px; }
.ra-file-remove { background:transparent; border:1px solid var(--border); color:var(--muted); cursor:pointer; width:28px; height:28px; border-radius:7px; display:flex; align-items:center; justify-content:center; transition:all .18s; flex-shrink:0; }
.ra-file-remove:hover { border-color:var(--rose); color:var(--rose); background:rgba(248,113,113,.08); }

.ra-textarea { width:100%; background:rgba(255,255,255,.02); color:var(--text); border:1.5px solid var(--border); border-radius:10px; padding:13px 14px; font-family:'Newsreader',serif; font-size:.9rem; font-weight:300; line-height:1.75; outline:none; resize:vertical; transition:border-color .2s, box-shadow .2s, background .2s; box-sizing:border-box; }
.ra-textarea::placeholder { color:var(--muted); opacity:.5; }
.ra-textarea:focus { border-color:rgba(79,142,247,.5); background:rgba(79,142,247,.02); box-shadow:0 0 0 3px rgba(79,142,247,.08); }
.ra-jd-count { font-family:'JetBrains Mono',monospace; font-size:.56rem; color:var(--muted); margin-left:auto; font-weight:400; }

/* ── Primary submit button ── */
.ra-analyze-btn { width:100%; padding:15px; background:linear-gradient(135deg,var(--accent),#3b6fd4); border:none; border-radius:12px; color:white; font-family:'Syne',sans-serif; font-size:.88rem; font-weight:800; letter-spacing:.04em; text-transform:uppercase; cursor:pointer; transition:all .2s; position:relative; overflow:hidden; }
.ra-analyze-btn::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,.08),transparent); pointer-events:none; }
.ra-analyze-btn:hover:not(:disabled) { transform:translateY(-1px); box-shadow:0 8px 24px rgba(79,142,247,.35); }
.ra-analyze-btn:disabled { opacity:.4; cursor:not-allowed; transform:none; box-shadow:none; }
.ra-spin-sm { width:16px; height:16px; flex-shrink:0; border:2px solid rgba(255,255,255,.25); border-top-color:white; border-radius:50%; animation:ra-spin 1s linear infinite; display:inline-block; }

.ra-empty-state   { text-align:center; padding:48px 24px; border-style:dashed; }
.ra-empty-icon    { width:68px; height:68px; border-radius:18px; background:rgba(255,255,255,.03); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--muted); opacity:.4; margin:0 auto 18px; }
.ra-empty-title   { font-size:.92rem; font-weight:800; color:var(--muted); margin-bottom:7px; }
.ra-empty-sub     { font-family:'Newsreader',serif; font-style:italic; font-size:.8rem; color:var(--muted); opacity:.55; line-height:1.7; margin-bottom:24px; }
.ra-empty-steps   { display:flex; align-items:center; justify-content:center; gap:8px; flex-wrap:wrap; }
.ra-empty-step    { font-family:'JetBrains Mono',monospace; font-size:.6rem; color:var(--muted); opacity:.5; text-transform:uppercase; letter-spacing:.06em; }
.ra-empty-step span { color:var(--accent); margin-right:5px; opacity:1; }
.ra-empty-step-div  { color:var(--border); font-size:.7rem; }
.ra-loading-state { text-align:center; padding:48px 24px; }
.ra-loader-ring   { display:flex; justify-content:center; margin-bottom:20px; }
.ra-loading-title { font-size:.9rem; font-weight:800; color:var(--text); margin-bottom:6px; }
.ra-loading-step  { font-family:'JetBrains Mono',monospace; font-size:.6rem; color:var(--muted); text-transform:uppercase; letter-spacing:.1em; margin-bottom:16px; }
.ra-loading-dots  { display:flex; justify-content:center; gap:6px; }
.ra-loading-dots span { width:6px; height:6px; border-radius:50%; background:var(--accent); }
.ra-loading-dots span:nth-child(1) { animation:ra-dot1 1.2s infinite; }
.ra-loading-dots span:nth-child(2) { animation:ra-dot1 1.2s .16s infinite; }
.ra-loading-dots span:nth-child(3) { animation:ra-dot1 1.2s .32s infinite; }

.ra-score-hero { background:linear-gradient(135deg,rgba(79,142,247,.08),rgba(45,212,191,.05)); border:1px solid rgba(79,142,247,.18); border-radius:16px; padding:24px; display:grid; grid-template-columns:1fr auto; grid-template-rows:auto auto; gap:0; position:relative; overflow:hidden; animation:ra-fadeUp .3s ease both; }
.ra-score-hero::before { content:''; position:absolute; top:-40px; right:-40px; width:160px; height:160px; border-radius:50%; background:radial-gradient(circle,rgba(45,212,191,.06),transparent 70%); pointer-events:none; }
.ra-score-left     { grid-column:1; grid-row:1; }
.ra-score-right    { grid-column:2; grid-row:1; display:flex; align-items:center; padding-left:20px; }
.ra-score-bar-wrap { grid-column:1/-1; grid-row:2; margin-top:18px; }
.ra-score-eyebrow  { font-family:'JetBrains Mono',monospace; font-size:.56rem; font-weight:700; letter-spacing:.16em; color:rgba(255,255,255,.35); text-transform:uppercase; margin-bottom:8px; }
.ra-score-number-wrap { display:flex; align-items:baseline; gap:6px; margin-bottom:8px; }
.ra-score-number   { font-size:4.2rem; font-weight:900; line-height:1; letter-spacing:-.06em; background:linear-gradient(135deg,#e2e8ff,#a0c4ff); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
.ra-score-denom    { font-size:1.4rem; font-weight:700; color:rgba(255,255,255,.3); }
.ra-score-label    { font-family:'JetBrains Mono',monospace; font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; }
.ra-score-svg      { width:100px; height:100px; }
.ra-score-ring-wrap { position:relative; width:100px; height:100px; }
.ra-score-ring-num  { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:.85rem; font-weight:900; color:rgba(255,255,255,.8); }
.ra-score-bar-track { height:5px; background:rgba(255,255,255,.07); border-radius:99px; overflow:hidden; }
.ra-score-bar-fill  { height:100%; border-radius:99px; background:linear-gradient(90deg,var(--teal),var(--accent)); width:0%; transition:width 1.4s cubic-bezier(.4,0,.2,1); }

.ra-report-header  { display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; padding-bottom:14px; border-bottom:1px solid var(--border); }
.ra-report-title   { display:flex; align-items:center; gap:10px; font-size:.82rem; font-weight:800; color:var(--text); }
.ra-report-dot     { width:8px; height:8px; border-radius:50%; background:var(--teal); box-shadow:0 0 8px rgba(45,212,191,.5); animation:ra-pulse 2.5s infinite; }
.ra-report-badge   { font-family:'JetBrains Mono',monospace; font-size:.56rem; color:var(--muted); background:rgba(255,255,255,.04); border:1px solid var(--border); padding:3px 9px; border-radius:6px; letter-spacing:.04em; }
.ra-sections-list  { display:flex; flex-direction:column; gap:8px; }

.ras-card  { border-radius:12px; overflow:hidden; border:1px solid var(--border); background:rgba(255,255,255,.025); transition:border-color .2s; animation:ra-fadeUp .28s cubic-bezier(.4,0,.2,1) both; }
.ras-card:hover { border-color:rgba(255,255,255,.1); }
.ras-header { display:flex; align-items:center; gap:10px; padding:11px 14px; cursor:pointer; user-select:none; transition:background .15s; }
.ras-header:hover { background:rgba(255,255,255,.02); }
.ras-icon  { width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; font-size:.85rem; flex-shrink:0; }
.ras-title { font-size:.77rem; font-weight:700; flex:1; }
.ras-chev  { color:var(--muted); transition:transform .25s; flex-shrink:0; display:flex; align-items:center; }
.ras-body  { padding:14px 15px; font-family:'Newsreader',serif; font-size:.875rem; line-height:1.8; font-weight:300; color:rgba(232,234,240,.82); max-height:800px; overflow:hidden; transition:max-height .3s cubic-bezier(.4,0,.2,1),padding .25s; border-top:1px solid var(--border); }
.ras-body.closed { max-height:0!important; padding-top:0!important; padding-bottom:0!important; border-top-color:transparent; }
.ras-body p  { margin:0 0 8px; }
.ras-body ul { margin:0 0 8px; padding-left:18px; }
.ras-body li { margin-bottom:5px; }
.ras-body strong { color:rgba(232,234,240,.95); font-weight:700; }
.ras-body h3 { font-family:'Syne',sans-serif; font-size:.78rem; font-weight:800; color:var(--text); margin:10px 0 4px; }
.ras-body h3:first-child { margin-top:0; }
.ras-body code { font-family:'JetBrains Mono',monospace; font-size:.75rem; background:rgba(79,142,247,.1); padding:1px 5px; border-radius:4px; color:var(--accent); }
.ra-chip   { display:inline-flex; align-items:center; font-family:'JetBrains Mono',monospace; font-size:.58rem; padding:4px 10px; border-radius:6px; margin:3px 3px 3px 0; background:rgba(79,142,247,.08); border:1px solid rgba(79,142,247,.2); color:var(--accent); letter-spacing:.04em; transition:all .15s; }
.ra-chip:hover { background:rgba(79,142,247,.15); border-color:rgba(79,142,247,.35); }
.ra-qw      { display:flex; align-items:flex-start; gap:12px; padding:10px 0; border-bottom:1px solid rgba(255,255,255,.05); }
.ra-qw:last-child { border-bottom:none; padding-bottom:0; }
.ra-qw-n    { width:24px; height:24px; min-width:24px; border-radius:6px; background:linear-gradient(135deg,var(--teal),var(--accent)); display:flex; align-items:center; justify-content:center; font-size:.65rem; font-weight:900; color:white; font-family:'JetBrains Mono',monospace; }

.ra-preview-header  { display:flex; align-items:center; justify-content:space-between; cursor:pointer; user-select:none; }
.ra-preview-title   { font-size:.77rem; font-weight:700; color:var(--text); }
.ra-preview-filename{ font-family:'JetBrains Mono',monospace; font-size:.56rem; color:var(--muted); margin-left:4px; }
.ra-preview-chev    { width:24px; height:24px; border-radius:7px; background:rgba(255,255,255,.04); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--muted); transition:transform .25s; }
.ra-preview-body    { margin-top:14px; overflow:hidden; max-height:520px; opacity:1; transition:max-height .35s cubic-bezier(.4,0,.2,1),opacity .25s,margin-top .25s; }
.ra-preview-content { max-height:490px; overflow-y:auto; padding:18px 20px; background:rgba(0,0,0,.25); border-radius:10px; border:1px solid rgba(255,255,255,.06); word-break:break-word; }
.ra-preview-content::-webkit-scrollbar       { width:4px; }
.ra-preview-content::-webkit-scrollbar-track  { background:transparent; }
.ra-preview-content::-webkit-scrollbar-thumb  { background:rgba(255,255,255,.1); border-radius:99px; }

.rp-doc        { font-family:'Newsreader',serif; font-size:.84rem; line-height:1.7; color:rgba(232,234,240,.78); }
.rp-name       { font-family:'Syne',sans-serif; font-size:1.2rem; font-weight:800; color:rgba(232,234,240,1); letter-spacing:-.02em; margin-bottom:3px; }
.rp-heading    { font-family:'Syne',sans-serif; font-size:.67rem; font-weight:800; letter-spacing:.15em; text-transform:uppercase; color:var(--accent); margin:14px 0 5px; padding-bottom:4px; border-bottom:1px solid rgba(79,142,247,.2); }
.rp-subheading { font-family:'Syne',sans-serif; font-size:.8rem; font-weight:700; color:rgba(232,234,240,.9); margin:6px 0 2px; }
.rp-contact    { font-family:'JetBrains Mono',monospace; font-size:.6rem; color:rgba(232,234,240,.4); margin-bottom:8px; letter-spacing:.02em; }
.rp-meta       { font-family:'JetBrains Mono',monospace; font-size:.62rem; color:rgba(232,234,240,.45); margin-bottom:2px; letter-spacing:.02em; }
.rp-line       { color:rgba(232,234,240,.72); margin-bottom:2px; }
.rp-bullet     { display:flex; gap:7px; align-items:baseline; color:rgba(232,234,240,.72); margin-bottom:3px; padding-left:2px; }
.rp-bull-dot   { color:var(--teal); flex-shrink:0; font-size:.65rem; line-height:1.7; }
.rp-spacer     { height:5px; }
.rp-rule       { height:1px; background:rgba(255,255,255,.07); margin:8px 0; }

.ra-btn-save { width:100%; padding:13px 18px; border-radius:12px; border:1.5px solid rgba(167,139,250,.3); background:rgba(167,139,250,.06); color:var(--lavender); font-family:'Syne',sans-serif; font-size:.8rem; font-weight:700; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; gap:8px; letter-spacing:.02em; }
.ra-btn-save:hover:not(:disabled) { background:rgba(167,139,250,.14); border-color:rgba(167,139,250,.5); transform:translateY(-1px); }
.ra-btn-save:disabled { opacity:.5; cursor:not-allowed; transform:none; }
.ra-btn-download { width:100%; padding:13px 18px; border-radius:12px; border:1.5px solid rgba(52,211,153,.25); background:rgba(52,211,153,.05); color:var(--green); font-family:'Syne',sans-serif; font-size:.8rem; font-weight:700; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; gap:8px; letter-spacing:.02em; }
.ra-btn-download:hover { background:rgba(52,211,153,.12); border-color:rgba(52,211,153,.45); transform:translateY(-1px); }

.ra-session-banner { display:flex; align-items:center; gap:10px; padding:10px 14px; margin-top:12px; background:rgba(45,212,191,.05); border:1px solid rgba(45,212,191,.18); border-radius:10px; animation:ra-fadeUp .25s ease; }
.ra-session-banner-text { font-family:'JetBrains Mono',monospace; font-size:.62rem; color:var(--teal); flex:1; }
.ra-session-banner-close { background:transparent; border:none; color:var(--muted); cursor:pointer; font-size:.75rem; padding:2px 6px; opacity:.6; }
.ra-session-banner-close:hover { opacity:1; }
</style>

<script>
(function(){
'use strict';

const STORAGE_KEY = 'ra_last_analysis';

const form      = document.getElementById('analysisForm');
const fileInput = document.getElementById('resumeFile');
const jobInput  = document.getElementById('jobDescription');
const submitBtn = document.getElementById('submitButton');   // ← now exists in HTML
const topBtn    = document.getElementById('analyzeTopBtn');
const jdCount   = document.getElementById('jdCount');

let fileValid = false;
window._latestResumeAnalysis = null;

function revalidate(){
  const ok = fileValid && jobInput.value.trim().length > 0;
  if (submitBtn) submitBtn.disabled = !ok;
  if (topBtn)    topBtn.disabled    = !ok;
}

fileInput.addEventListener('change', () => attachFile(fileInput.files[0]));

window.raHandleDrop = function(e){
  e.preventDefault();
  document.getElementById('dropZone').classList.remove('drag-over');
  const f = e.dataTransfer?.files[0];
  if(f){ fileInput.files = e.dataTransfer.files; attachFile(f); }
};

let _lastAnalysedFile = null;
function fileFingerprint(f){ return `${f.name}::${f.size}::${f.lastModified}`; }

function attachFile(f){
  if(!f) return;
  const ext = f.name.split('.').pop().toLowerCase();
  if(!['pdf','doc','docx'].includes(ext)){
    toast('Please use PDF, DOC, or DOCX ❌'); raClearFile(); return;
  }
  const fp = fileFingerprint(f);
  if(_lastAnalysedFile && _lastAnalysedFile === fp) showDuplicateWarning(f.name);
  else hideDuplicateWarning();

  fileValid = true;
  document.getElementById('dropZone').style.display   = 'none';
  document.getElementById('fileChosen').style.display = 'flex';
  document.getElementById('chosenName').textContent   = f.name;
  document.getElementById('chosenSize').textContent   = fmtBytes(f.size);
  document.getElementById('previewFilename').textContent = f.name;
  revalidate();
}

function showDuplicateWarning(filename){
  let el = document.getElementById('dup-warning');
  if(!el){
    el = document.createElement('div');
    el.id = 'dup-warning';
    el.style.cssText = 'display:flex;align-items:flex-start;gap:10px;margin-top:12px;padding:12px 14px;background:rgba(251,191,36,.07);border:1px solid rgba(251,191,36,.2);border-radius:10px;animation:ra-fadeUp .25s ease';
    el.innerHTML = `
      <span style="font-size:1rem;flex-shrink:0;margin-top:1px">⚠️</span>
      <div style="flex:1">
        <div style="font-size:.76rem;font-weight:700;color:var(--amber);margin-bottom:2px">Same file detected</div>
        <div id="dup-warning-msg" style="font-family:'Newsreader',serif;font-size:.75rem;color:var(--muted);line-height:1.5;font-weight:300"></div>
      </div>
      <button onclick="hideDuplicateWarning()" style="background:transparent;border:none;color:var(--muted);cursor:pointer;font-size:.75rem;padding:2px 6px;flex-shrink:0;opacity:.6">✕</button>`;
    const fc = document.getElementById('fileChosen');
    fc.parentNode.insertBefore(el, fc.nextSibling);
  }
  el.style.display = 'flex';
  const msg = document.getElementById('dup-warning-msg');
  if(msg) msg.textContent = `"${filename}" was already analysed. Re-running will give similar results unless you change the job description.`;
}

function hideDuplicateWarning(){
  const el = document.getElementById('dup-warning');
  if(el) el.style.display = 'none';
}
window.hideDuplicateWarning = hideDuplicateWarning;

window.raClearFile = function(){
  fileInput.value = ''; fileValid = false;
  document.getElementById('dropZone').style.display   = 'block';
  document.getElementById('fileChosen').style.display = 'none';
  hideDuplicateWarning();
  sessionStorage.removeItem(STORAGE_KEY);
  hideRightPanels();
  showPanel('ra-empty');
  revalidate();
};

function fmtBytes(b){ return b < 1048576 ? (b/1024).toFixed(1)+' KB' : (b/1048576).toFixed(1)+' MB'; }

jobInput.addEventListener('input', () => {
  jdCount.textContent = jobInput.value.length.toLocaleString()+' chars';
  revalidate();
});

const RIGHT_PANELS = ['ra-empty','ra-loading','ra-score','ra-report','ra-actions'];
function hideRightPanels(){ RIGHT_PANELS.forEach(id => { const el = document.getElementById(id); if(el) el.style.display = 'none'; }); }
function showPanel(id){
  const el = document.getElementById(id); if(!el) return;
  el.style.display = id === 'ra-actions' ? 'flex' : 'block';
}

window.raTogglePreview = function(){
  const b = document.getElementById('previewBody');
  const c = document.getElementById('previewChevron');
  if(!b) return;
  const open = b.style.maxHeight !== '0px';
  b.style.maxHeight = open ? '0px'   : '520px';
  b.style.opacity   = open ? '0'     : '1';
  b.style.marginTop = open ? '0'     : '14px';
  if(c) c.style.transform = open ? 'rotate(180deg)' : 'rotate(0deg)';
};

function startSteps(){
  const msgs = ['Reading file…','Extracting layout…','Reconstructing columns…','Running AI…','Building report…'];
  let i = 0;
  const el = document.getElementById('ra-step');
  return setInterval(() => { if(el) el.textContent = msgs[i++ % msgs.length]; }, 1500);
}

function animateScore(score){
  if(score == null) return;
  const numEl  = document.getElementById('scoreNum');
  const ringEl = document.getElementById('scoreRing');
  const rnlEl  = document.getElementById('scoreRingNum');
  const barEl  = document.getElementById('scoreBar');
  const lblEl  = document.getElementById('scoreLabel');
  let cur = 0;
  const inc = score / 50;
  const t = setInterval(() => {
    cur = Math.min(cur + inc, score);
    const r = Math.round(cur);
    if(numEl) numEl.textContent = r;
    if(rnlEl) rnlEl.textContent = r;
    if(cur >= score) clearInterval(t);
  }, 20);
  setTimeout(() => { if(barEl) barEl.style.width = score + '%'; }, 60);
  setTimeout(() => { if(ringEl) ringEl.setAttribute('stroke-dasharray', `${(score/100*87.96).toFixed(1)} 87.96`); }, 60);
  const strong = score >= 75, mid = score >= 50;
  const col = strong ? '#34d399' : mid ? '#fbbf24' : '#f87171';
  const lbl = strong ? '✅ Strong Match' : mid ? '⚠️ Moderate Match' : '❌ Needs Work';
  if(lblEl){ lblEl.textContent = lbl; lblEl.style.color = col; }
  if(barEl) barEl.style.background = strong
    ? 'linear-gradient(90deg,#34d399,#2dd4bf)'
    : mid ? 'linear-gradient(90deg,#fbbf24,#f97316)'
    : 'linear-gradient(90deg,#f87171,#e879a0)';
}

function mdToHtml(md){
  if(!md) return '';
  let s = md
    .replace(/\*\*(.+?)\*\*/g,'<strong>$1</strong>')
    .replace(/\*([^*\n]+?)\*/g,'<em>$1</em>')
    .replace(/`([^`]+)`/g,'<code>$1</code>')
    .replace(/^### (.+)$/gm,'<h3>$1</h3>')
    .replace(/^## (.+)$/gm,'<h3>$1</h3>')
    .replace(/^# (.+)$/gm,'<h3>$1</h3>');
  const lines = s.split('\n');
  const out = []; let inUl = false;
  for(const raw of lines){
    const line     = raw.trimEnd();
    const isBullet = /^[-*•]\s+/.test(line);
    const isTag    = /^<(h[1-6]|ul|ol|li|p|div|blockquote|hr)/.test(line.trim());
    if(isBullet){
      if(!inUl){ out.push('<ul>'); inUl = true; }
      out.push('<li>' + line.replace(/^[-*•]\s+/,'') + '</li>');
    } else {
      if(inUl){ out.push('</ul>'); inUl = false; }
      if(!line.trim()) continue;
      if(isTag) out.push(line); else out.push('<p>' + line + '</p>');
    }
  }
  if(inUl) out.push('</ul>');
  return out.join('\n');
}

function buildKeywords(md){
  const items = md.split('\n')
    .map(l => l.replace(/^[-*•\d.]+\s*/,'').replace(/\*\*/g,'').trim())
    .filter(Boolean).flatMap(l => l.split(/[,;]/))
    .map(s => s.trim()).filter(s => s.length > 1 && s.length < 60);
  return '<div style="display:flex;flex-wrap:wrap;padding-top:4px">'
    + items.map(k => `<span class="ra-chip">${k}</span>`).join('') + '</div>';
}

function buildQuickWins(html){
  const tmp = document.createElement('div'); tmp.innerHTML = html;
  const items = [...tmp.querySelectorAll('li')];
  if(!items.length) return html;
  return items.map((li,i) => `
    <div class="ra-qw">
      <div class="ra-qw-n">${i+1}</div>
      <div style="flex:1;font-family:'Newsreader',serif;font-size:.875rem;line-height:1.75;font-weight:300;color:rgba(232,234,240,.82)">${li.innerHTML}</div>
    </div>`).join('');
}

const SEC_DEFS = [
  { keys:['executive summary'],                                              icon:'📊', bg:'rgba(79,142,247,.08)',  br:'rgba(79,142,247,.2)',   tc:'var(--accent)',   open:true  },
  { keys:['key strength'],                                                   icon:'💪', bg:'rgba(52,211,153,.07)',  br:'rgba(52,211,153,.2)',   tc:'var(--green)',    open:true  },
  { keys:['critical gap'],                                                   icon:'🎯', bg:'rgba(248,113,113,.08)', br:'rgba(248,113,113,.2)',  tc:'var(--rose)',     open:true  },
  { keys:['keyword optim','keyword opt','keywords'],                         icon:'🔑', bg:'rgba(167,139,250,.07)', br:'rgba(167,139,250,.2)',  tc:'var(--lavender)', open:false },
  { keys:['section-by-section','section by section','section improvements'],icon:'✏️', bg:'rgba(251,191,36,.06)',  br:'rgba(251,191,36,.2)',   tc:'var(--amber)',    open:false },
  { keys:['ats'],                                                            icon:'🤖', bg:'rgba(45,212,191,.06)',  br:'rgba(45,212,191,.2)',   tc:'var(--teal)',     open:false },
  { keys:['quick win'],                                                      icon:'⚡', bg:'rgba(79,142,247,.08)',  br:'rgba(79,142,247,.2)',   tc:'var(--accent)',   open:true  },
];
function getDef(h){ const l = h.toLowerCase().trim(); return SEC_DEFS.find(d => d.keys.some(k => l.includes(k))); }

window.raToggleSec = function(bodyId, chevId){
  const b = document.getElementById(bodyId);
  const c = document.getElementById(chevId);
  if(!b) return;
  const closed = b.classList.toggle('closed');
  if(c) c.style.transform = closed ? 'rotate(180deg)' : 'rotate(0deg)';
};

function renderReport(markdown){
  const container = document.getElementById('ra-sections');
  container.innerHTML = '';
  let md = markdown.replace(/^#[^#].*?\n/m,'').replace(/^##\s+Match Score[\s\S]*?(?=^##\s|\s*$)/im,'').trim();
  const chunks = md.split(/(?=^## )/m).map(s => s.trim()).filter(Boolean);
  if(!chunks.length){ container.innerHTML = `<div class="ras-body" style="padding:0">${mdToHtml(markdown)}</div>`; return; }
  chunks.forEach((chunk, idx) => {
    const firstNL = chunk.indexOf('\n');
    const heading = (firstNL > 0 ? chunk.slice(2, firstNL) : chunk.slice(2)).trim();
    const body    = (firstNL > 0 ? chunk.slice(firstNL+1) : '').trim();
    const def     = getDef(heading) || { icon:'📝', bg:'rgba(255,255,255,.03)', br:'rgba(255,255,255,.08)', tc:'var(--text)', open:idx<2 };
    const bid = `ras-b-${idx}`, cid = `ras-c-${idx}`;
    const isKw = def.keys && def.keys.some(k => k.includes('keyword'));
    const isQw = def.keys && def.keys.some(k => k.includes('quick win'));
    let bodyHtml = isKw ? buildKeywords(body) : mdToHtml(body);
    const div = document.createElement('div');
    div.className = 'ras-card';
    div.style.cssText = `border-color:${def.br};animation-delay:${idx*45}ms`;
    div.innerHTML = `
      <div class="ras-header" style="background:${def.bg}" onclick="raToggleSec('${bid}','${cid}')">
        <div class="ras-icon" style="background:rgba(0,0,0,.2);border:1px solid ${def.br}">${def.icon}</div>
        <div class="ras-title" style="color:${def.tc}">${heading}</div>
        <div class="ras-chev" id="${cid}" style="transform:${def.open?'rotate(0)':'rotate(180deg)'}">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
        </div>
      </div>
      <div class="ras-body${def.open?'':' closed'}" id="${bid}">${bodyHtml}</div>`;
    if(isQw){ const b = div.querySelector('.ras-body'); b.innerHTML = buildQuickWins(b.innerHTML); }
    container.appendChild(div);
  });
}

/* ── Save to Saved Items ──────────────────────────────────── */
window.saveResumeToSaved = function(){
  const a = window._latestResumeAnalysis;
  if(!a){ toast('No analysis to save yet ⚠️'); return; }
  const btn = document.getElementById('saveAnalysisBtn');
  if(typeof window.savedAddItem === 'function'){
    window.savedAddItem({
      type:     'resume',
      title:    a.fileName || 'Resume Analysis',
      subtitle: (a.jobDescription || '').substring(0, 60) + (a.jobDescription?.length > 60 ? '…' : ''),
      score:    a.matchScore,
      markdown: a.suggestionsMarkdown || '',
    });
    if(btn){ btn.textContent = '✅ Saved!'; btn.disabled = true; }
    setTimeout(() => {
      if(btn){ btn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> 🔖 Save Analysis to Saved Items'; btn.disabled = false; }
    }, 2500);
  } else {
    toast('Saved Items not available ⚠️');
  }
};

/* ── Session persistence ────────────────────────────────────── */
function saveStateToSession(data, fileName, jobDesc){
  try {
    sessionStorage.setItem(STORAGE_KEY, JSON.stringify({
      score:    data.resume.match_score,
      markdown: data.resume.suggestions_markdown,
      content:  data.resume.resume_content,
      fileName: fileName,
      jobDesc:  jobDesc,
    }));
  } catch(e) {}
}

function restoreStateFromSession(){
  let saved;
  try { saved = JSON.parse(sessionStorage.getItem(STORAGE_KEY)); } catch(e) {}
  if(!saved) return;

  if(saved.jobDesc){
    jobInput.value = saved.jobDesc;
    jdCount.textContent = saved.jobDesc.length.toLocaleString() + ' chars';
  }

  hideRightPanels();
  showPanel('ra-score');  animateScore(saved.score);
  showPanel('ra-report'); renderReport(saved.markdown);
  showPanel('ra-actions');

  const pc = document.getElementById('previewContent');
  if(pc) pc.innerHTML = saved.content ?? '';
  document.getElementById('previewFilename').textContent = saved.fileName ?? '';
  showPanel('ra-preview');

  document.getElementById('resumeMarkdown').value = saved.markdown ?? '';

  window._latestResumeAnalysis = {
    fileName:            saved.fileName,
    jobDescription:      (saved.jobDesc ?? '').substring(0, 500),
    suggestionsMarkdown: saved.markdown,
    matchScore:          saved.score,
    createdAt:           new Date(),
  };

  fileValid = true;
  document.getElementById('dropZone').style.display   = 'none';
  document.getElementById('fileChosen').style.display = 'flex';
  document.getElementById('chosenName').textContent   = saved.fileName ?? 'Resume';
  document.getElementById('chosenSize').textContent   = 'Session restored — re-upload to re-analyze';
  revalidate();

  const card = document.getElementById('fileChosen')?.closest('.ra-card');
  if(card && !document.getElementById('ra-session-banner')){
    const banner = document.createElement('div');
    banner.id = 'ra-session-banner';
    banner.className = 'ra-session-banner';
    banner.innerHTML = `
      <span style="font-size:.9rem">🔄</span>
      <span class="ra-session-banner-text">Results restored from your last session</span>
      <button class="ra-session-banner-close" onclick="
        sessionStorage.removeItem('${STORAGE_KEY}');
        document.getElementById('ra-session-banner').remove();
      ">✕</button>`;
    card.appendChild(banner);
  }
}

/* ── SUBMIT ─────────────────────────────────────────────────── */
form.addEventListener('submit', function(e){
  e.preventDefault();
  if(!fileValid){ toast('Please upload a valid resume file ⚠️'); return; }

  if(submitBtn){ submitBtn.disabled = true; }
  if(topBtn)    topBtn.disabled = true;

  const btnLabel   = document.getElementById('btnLabel');
  const btnLoading = document.getElementById('btnLoading');
  if(btnLabel)   btnLabel.style.display   = 'none';
  if(btnLoading) btnLoading.style.display = 'flex';

  const sb = document.getElementById('saveAnalysisBtn');
  if(sb){ sb.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> 🔖 Save Analysis to Saved Items'; sb.disabled = false; }

  hideRightPanels();
  showPanel('ra-loading');
  const timer = startSteps();

  fetch('{{ route("analyze.resume.ajax") }}', {
    method: 'POST',
    body: new FormData(form),
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || '',
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    },
    credentials: 'same-origin'
  })
  .then(async res => {
    const j = await res.json().catch(() => ({ message:'Unknown error' }));
    if(!res.ok || !j.success) throw j;
    return j;
  })
  .then(data => {
    clearInterval(timer);
    const score    = data.resume.match_score ?? null;
    const markdown = data.resume.suggestions_markdown ?? '';

    hideRightPanels();
    showPanel('ra-score');  animateScore(score);
    showPanel('ra-report'); renderReport(markdown);
    showPanel('ra-actions');

    const pc = document.getElementById('previewContent');
    pc.innerHTML = data.resume.resume_content ?? '(No resume content returned)';
    showPanel('ra-preview');

    document.getElementById('resumeMarkdown').value = markdown;
    window._latestResumeAnalysis = {
      fileName:            fileInput.files[0]?.name ?? 'Resume',
      jobDescription:      jobInput.value.trim().substring(0, 500),
      suggestionsHtml:     data.resume.suggestions_html ?? '',
      suggestionsMarkdown: markdown,
      matchScore:          score,
      createdAt:           new Date(),
    };
    _lastAnalysedFile = fileInput.files[0] ? fileFingerprint(fileInput.files[0]) : null;
    hideDuplicateWarning();

    saveStateToSession(data, fileInput.files[0]?.name ?? 'Resume', jobInput.value.trim());

    // ── Cache plain-text resume for Holistic Career Advisor prefill ──
    // clear any previous value first (prevents stale markdown from lingering)
    sessionStorage.removeItem('lifevault_resume_text');
    // also clear the source flag so we don't accidentally show the badge
    sessionStorage.removeItem('lifevault_resume_source');
    if (data.resume?.resume_content) {
      const _tmpDiv = document.createElement('div');
      _tmpDiv.innerHTML = data.resume.resume_content;
      // remove style/script blocks so their CSS/JS doesn't end up in plain text
      _tmpDiv.querySelectorAll('style,script').forEach(el=>el.remove());
      let _plainText = (_tmpDiv.textContent || _tmpDiv.innerText || '').trim();
      // remove any leftover CSS rules or PHPWord header that slipped through
      _plainText = _plainText
          .replace(/@page\s+[^\{]+\{[^\}]*\}/gi, '')
          .replace(/\.[a-zA-Z0-9_-]+\s*\{[^\}]*\}/g, '')
          .replace(/PHPWord/gi, '')
          .replace(/\r?\n{2,}/g, '\n')
          .trim();
      // don't cache if it looks like the AI report (begins with **Score:)
      if (_plainText.length > 50 && !/\*\*Score:/i.test(_plainText)) {
          sessionStorage.setItem('lifevault_resume_text', _plainText);
          // remember that this text came from the analyzer so the HCA badge
          // can display appropriately later
          sessionStorage.setItem('lifevault_resume_source', 'analyzer');
      }
    }

    toast('Analysis complete! ✅');
  })
  .catch(err => {
    clearInterval(timer);
    hideRightPanels();
    showPanel('ra-empty');
    const msg = err?.errors
      ? Object.values(err.errors)[0][0]
      : (err?.message || 'Analysis failed.');
    toast('❌ ' + msg);
    console.error('[ResumeAnalyzer]', err);
  })
  .finally(() => {
    if(submitBtn){ submitBtn.disabled = false; }
    if(topBtn)    topBtn.disabled = false;
    const btnLabel   = document.getElementById('btnLabel');
    const btnLoading = document.getElementById('btnLoading');
    if(btnLabel)   btnLabel.style.display   = 'flex';
    if(btnLoading) btnLoading.style.display = 'none';
  });
});

/* ── Download DOCX ──────────────────────────────────────────── */
document.addEventListener('click', function(e){
  const btn = e.target.closest('#downloadDocx');
  if(!btn) return;
  const md = document.getElementById('resumeMarkdown').value;
  if(!md){ toast('No content to download ⚠️'); return; }
  const f = document.createElement('form');
  f.method = 'POST'; f.action = btn.dataset.url; f.style.display = 'none';
  [['_token', document.querySelector('input[name="_token"]').value], ['resume_markdown', md]]
    .forEach(([n,v]) => { const i = document.createElement('input'); i.type='hidden'; i.name=n; i.value=v; f.appendChild(i); });
  document.body.appendChild(f); f.submit(); document.body.removeChild(f);
});

restoreStateFromSession();

})();
</script>