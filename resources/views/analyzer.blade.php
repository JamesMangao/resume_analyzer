<div id="page-analyzer" class="page">
    <h1 class="page-title">AI Resume Analyzer</h1>
    <p class="page-subtitle">Upload your resume and a job description to get an AI-powered analysis and match score.</p>

    <div class="content-box">
        <form id="analysisForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="resumeMarkdown">
            
            <div class="analyzer-form-grid">
                <!-- Column 1: Uploads -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="resumeFile">1. Upload Your Resume</label>
                        <label for="resumeFile" class="btn file-upload-btn">
                            <span id="resumeFileName">Choose File...</span>
                        </label>
                        <input type="file" id="resumeFile" name="resume_file" accept=".pdf,.doc,.docx" required style="display:none;">
                        <p class="form-help">Accepted formats: PDF, DOC, DOCX.</p>
                    </div>

                    <div class="form-group">
                        <label for="jobDescription">2. Paste Job Description</label>
                        <textarea id="jobDescription" name="job_description" rows="12" required placeholder="Paste the full job description here..."></textarea>
                    </div>
                     <button type="submit" id="submitButton" class="btn btn-primary w-full" disabled>
                        <span id="buttonText">Analyze Resume</span>
                        <div id="loadingSpinner" class="spinner" style="display:none;"></div>
                    </button>
                </div>

                <!-- Column 2: Preview & Suggestions -->
                <div class="form-column">
                    <div class="form-group">
                        <label>Resume Preview</label>
                        <div class="resume-preview-wrapper" id="resumeContentWrapper">
                            <div id="resumeLoader" class="resume-loader">
                                <div class="spinner"></div>
                            </div>
                            <div id="resumeContent" class="resume-content-placeholder">
                                @if(session('resume'))
                                    {!! session('resume')->resume_content !!}
                                @else
                                    <div class="empty-state mini">
                                        <div class="empty-icon">📄</div>
                                        <div class="empty-text">Your resume preview will appear here.</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="resumeSuggestions" class="form-group" style="display:none;">
                         <label>AI Suggestions</label>
                         <div id="suggestions-content" class="suggestions-box"></div>
                         <button type="button" id="downloadDocx" class="btn btn-secondary w-full mt-2" data-url="{{ route('resume.download.docx') }}">
                            Download Updated Resume (DOCX)
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* ── FIX: Job Description textarea — force dark background ── */
#jobDescription {
    background: var(--surface2) !important;
    color: var(--text) !important;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 12px 14px;
    font-family: 'Newsreader', serif;
    font-size: .95rem;
    font-weight: 300;
    line-height: 1.65;
    outline: none;
    resize: vertical;
    width: 100%;
    transition: border-color .2s, box-shadow .2s;
}
#jobDescription::placeholder {
    color: var(--muted);
    opacity: .7;
}
#jobDescription:focus {
    border-color: rgba(79, 142, 247, .5);
    box-shadow: 0 0 0 3px rgba(79, 142, 247, .1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('analysisForm');
    const resumeInput = document.getElementById('resumeFile');
    const resumeFileName = document.getElementById('resumeFileName');
    const jobDescriptionInput = document.getElementById('jobDescription');
    const submitButton = document.getElementById('submitButton');
    const buttonText = document.getElementById('buttonText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resumeContentDiv = document.getElementById('resumeContent');
    const suggestionsContainer = document.getElementById('resumeSuggestions');
    const suggestionsContent = document.getElementById('suggestions-content');

    let resumeFileValid = false;
    const allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];

    function validateForm() {
        const isJobDescFilled = jobDescriptionInput.value.trim() !== '';
        submitButton.disabled = !resumeFileValid || !isJobDescFilled;
    }

    resumeInput.addEventListener('change', function () {
        const file = resumeInput.files[0];
        if (!file) {
            resumeFileValid = false;
            resumeFileName.textContent = 'Choose File...';
        } else {
            const ext = file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(ext)) {
                toast('Invalid file type. Please use PDF, DOC, or DOCX.', '❌');
                resumeInput.value = '';
                resumeFileValid = false;
                resumeFileName.textContent = 'Choose File...';
            } else {
                resumeFileValid = true;
                resumeFileName.textContent = file.name;
            }
        }
        validateForm();
    });

    jobDescriptionInput.addEventListener('input', validateForm);

    const loader = document.getElementById('resumeLoader');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!resumeFileValid) {
            toast('Please upload a valid resume file.', '⚠️');
            return;
        }

        submitButton.disabled = true;
        buttonText.style.display = 'none';
        loadingSpinner.style.display = 'block';
        loader.style.display = 'flex';

        const formData = new FormData(form);

        fetch('{{ route("analyze.resume.ajax") }}', { 
            method: 'POST', 
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
        })
        .then(async res => {
            if (!res.ok) {
                const errorData = await res.json().catch(() => ({ message: 'An unknown error occurred.' }));
                throw errorData;
            }
            return res.json();
        })
        .then(data => {
            if (!data.success) { throw data; }
            
            resumeContentDiv.innerHTML = data.resume.resume_content;
            resumeContentDiv.classList.remove('resume-content-placeholder');

            if (data.resume.suggestions_html) {
                suggestionsContainer.style.display = 'block';
                suggestionsContent.innerHTML = data.resume.suggestions_html;
                document.getElementById('resumeMarkdown').value = data.resume.suggestions_markdown;
            } else {
                suggestionsContainer.style.display = 'none';
            }
            toast('Analysis complete!', '✅');
        })
        .catch(err => {
            console.error('Analysis error:', err);
            const errorMessage = err?.errors ? Object.values(err.errors)[0][0] : (err?.message || 'Analysis failed. Please try again.');
            toast(errorMessage, '❌');
        })
        .finally(() => {
            loader.style.display = 'none';
            submitButton.disabled = false;
            buttonText.style.display = 'inline';
            loadingSpinner.style.display = 'none';
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'downloadDocx') {
            const button = e.target;
            const url = button.dataset.url;
            const markdown = document.getElementById('resumeMarkdown').value;

            if (!markdown) {
                toast('No resume content to download.', '⚠️');
                return;
            }

            const downloadForm = document.createElement('form');
            downloadForm.method = 'POST';
            downloadForm.action = url;
            downloadForm.style.display = 'none';

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('input[name="_token"]').value;

            const contentInput = document.createElement('input');
            contentInput.type = 'hidden';
            contentInput.name = 'resume_markdown';
            contentInput.value = markdown;

            downloadForm.appendChild(csrfInput);
            downloadForm.appendChild(contentInput);
            document.body.appendChild(downloadForm);
            downloadForm.submit();
            document.body.removeChild(downloadForm);
        }
    });
});
</script>