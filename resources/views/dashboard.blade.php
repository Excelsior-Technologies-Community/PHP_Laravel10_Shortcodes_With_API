<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortcodes Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #2c3e50; }
        .sidebar a { color: #b8c7ce; padding: 12px 20px; display: block; text-decoration: none; }
        .sidebar a:hover, .sidebar a.active { color: #fff; background: #1a252f; }
        .sidebar-brand { padding: 20px; font-size: 1.2rem; font-weight: bold; color: #fff !important; border-bottom: 1px solid #34495e; }
        .main-content { padding: 20px; }
        .card { border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .border-left-primary { border-left: 4px solid #3498db; }
        .border-left-success { border-left: 4px solid #2ecc71; }
        .border-left-warning { border-left: 4px solid #f1c40f; }
        .border-left-info { border-left: 4px solid #17a2b8; }
        #preview-pane { min-height: 400px; background: #fff; border: 1px solid #dee2e6; border-radius: .375rem; padding: 20px; }
        .dropzone { border: 2px dashed #cbd5e1; border-radius: 8px; padding: 40px; text-align: center; background: #f8fafc; cursor: pointer; transition: all 0.2s; }
        .dropzone.dragover { border-color: #3498db; background: #e3f2fd; }
        .dropzone i { font-size: 3rem; color: #94a3b8; }
        .shortcode-badge { display: inline-block; padding: 4px 8px; background: #e3f2fd; color: #1976d2; border-radius: 4px; font-size: 0.85rem; margin: 2px; cursor: pointer; font-family: monospace; }
        .nav-tabs .nav-link { cursor: pointer; }
        .post-row { cursor: pointer; }
        .post-row:hover { background-color: #f8f9fa; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 p-0">
            <div class="sidebar">
                <a href="#" class="sidebar-brand"><i class="fas fa-bolt"></i> Shortcodes</a>
                <a href="#" class="nav-link active" data-tab="editor"><i class="fas fa-edit"></i> Live Editor</a>
                <a href="#" class="nav-link" data-tab="files"><i class="fas fa-cloud-upload-alt"></i> File Manager</a>
                <a href="#" class="nav-link" data-tab="posts"><i class="fas fa-file-alt"></i> Manage Posts</a>
                <a href="#" class="nav-link" data-tab="history"><i class="fas fa-history"></i> History</a>
            </div>
        </div>
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Dashboard</h2>
                <span class="badge bg-success">API Ready</span>
            </div>

            <div class="tab-content">
                <!-- Live Editor -->
                <div class="tab-pane active" id="tab-editor">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0">Editor</h5>
                                </div>
                                <div class="card-body">
                                    <textarea id="shortcode-input" class="form-control font-monospace" rows="12" placeholder="Type shortcodes here..."></textarea>
                                    <div class="mt-3">
                                        <span class="fw-bold">Shortcodes:</span><br>
                                        <span class="shortcode-badge" data-shortcode="[alert]">[alert]</span>
                                        <span class="shortcode-badge" data-shortcode="[badge]">[badge]</span>
                                        <span class="shortcode-badge" data-shortcode='[button url="#"]'>[button]</span>
                                        <span class="shortcode-badge" data-shortcode="[card]">[card]</span>
                                        <span class="shortcode-badge" data-shortcode="[highlight]">[highlight]</span>
                                        <span class="shortcode-badge" data-shortcode='[video url=""]'>[video]</span>
                                        <span class="shortcode-badge" data-shortcode='[quote author=""]'>[quote]</span>
                                        <span class="shortcode-badge" data-shortcode="[list]">[list]</span>
                                        <span class="shortcode-badge" data-shortcode="[gallery]">[gallery]</span>
                                        <span class="shortcode-badge" data-shortcode='[spacer height="20"]'>[spacer]</span>
                                        <span class="shortcode-badge" data-shortcode='[file-upload id=""]'>[file-upload]</span>
                                    </div>
                                    <div class="mt-3 d-flex gap-2">
                                        <button class="btn btn-primary" onclick="parseShortcodes()"><i class="fas fa-magic"></i> Parse Live</button>
                                        <button class="btn btn-success" onclick="savePost()"><i class="fas fa-save"></i> Save as Post</button>
                                        <button class="btn btn-secondary" onclick="clearEditor()"><i class="fas fa-trash"></i> Clear</button>
                                    </div>
                                    <div id="post-id-input" class="mt-2" style="display:none;">
                                        <label class="form-label">Editing Post ID:</label>
                                        <input type="number" id="edit-post-id" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between">
                                    <h5 class="mb-0">Live Preview</h5>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="copyHTML()"><i class="fas fa-copy"></i></button>
                                </div>
                                <div class="card-body">
                                    <div id="preview-pane"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Manager -->
                <div class="tab-pane" id="tab-files" style="display:none;">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0">Upload Files</h5>
                                </div>
                                <div class="card-body">
                                    <form id="dropzone-form" class="dropzone" action="/api/files/upload" method="POST" enctype="multipart/form-data">
                                        <div class="dz-message">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <p class="mt-2 mb-0">Drop files here to upload</p>
                                        </div>
                                    </form>
                                    <div class="mt-3">
                                        <div id="upload-help" class="alert alert-info small">
                                            Supported formats: jpg, png, gif, svg, pdf, doc, txt, mp4, webm (max 5MB)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="mb-0">Uploaded Files</h5>
                                </div>
                                <div class="card-body">
                                    <div id="files-list" class="row g-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Manage Posts -->
                <div class="tab-pane" id="tab-posts" style="display:none;">
                    <div class="card mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0">All Posts</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Content</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="posts-list"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- History -->
                <div class="tab-pane" id="tab-history" style="display:none;">
                    <div class="card">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Parse History</h5>
                            <button class="btn btn-sm btn-outline-danger" onclick="clearHistory()"><i class="fas fa-trash"></i> Clear All</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Original</th>
                                            <th>Parsed</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="history-list"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">

<script>
const API = '/api';

// Tabs
document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.sidebar .nav-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        const tab = this.getAttribute('data-tab');
        document.querySelectorAll('.tab-pane').forEach(p => p.style.display = 'none');
        document.getElementById('tab-' + tab).style.display = 'block';
    });
});

function insertText(text) {
    const ta = document.getElementById('shortcode-input');
    const start = ta.selectionStart;
    const end = ta.selectionEnd;
    const val = ta.value;
    ta.value = val.substring(0, start) + text + val.substring(end);
    ta.focus();
    ta.setSelectionRange(start + text.length, start + text.length);
}

function clearEditor() {
    document.getElementById('shortcode-input').value = '';
    document.getElementById('preview-pane').innerHTML = '';
    document.getElementById('post-id-input').style.display = 'none';
}

function showAlert(msg, type) {
    const div = document.createElement('div');
    div.className = 'alert alert-' + (type || 'success') + ' alert-dismissible fade show';
    div.innerHTML = msg + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
    document.querySelector('.main-content').prepend(div);
    setTimeout(() => div.remove(), 3000);
}

async function parseShortcodes() {
    const content = document.getElementById('shortcode-input').value;
    if (!content) return showAlert('Please enter some content', 'warning');
    try {
        const res = await fetch(API + '/parse', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ content })
        });
        const data = await res.json();
        if (res.ok) {
            document.getElementById('preview-pane').innerHTML = data.parsed;
            loadHistory();
        } else {
            showAlert(data.message || 'Error parsing', 'danger');
        }
    } catch (e) {
        showAlert('Network error', 'danger');
    }
}

async function savePost() {
    const content = document.getElementById('shortcode-input').value;
    const editId = document.getElementById('edit-post-id').value;
    if (!content) return showAlert('Please enter some content', 'warning');
    try {
        const url = editId ? API + '/posts/' + editId : API + '/posts';
        const method = editId ? 'PUT' : 'POST';
        const res = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ content })
        });
        const data = await res.json();
        if (res.ok) {
            showAlert(data.message);
            document.getElementById('post-id-input').style.display = 'none';
            document.getElementById('edit-post-id').value = '';
            loadPosts();
        } else {
            showAlert(data.message || 'Error saving post', 'danger');
        }
    } catch (e) {
        showAlert('Network error', 'danger');
    }
}

function editPost(id) {
    const row = document.querySelector('.post-row[data-id="' + id + '"]');
    if (!row) return;
    const content = document.getElementById('post-content-' + id).value;
    document.getElementById('shortcode-input').value = content;
    document.getElementById('edit-post-id').value = id;
    document.getElementById('post-id-input').style.display = 'block';
    document.querySelector('[data-tab="editor"]').click();
    showAlert('Editing post #' + id + ' — click Save to update', 'info');
}

async function deletePost(id) {
    if (!confirm('Delete this post?')) return;
    try {
        const res = await fetch(API + '/posts/' + id, { method: 'DELETE' });
        const data = await res.json();
        if (res.ok) {
            showAlert(data.message);
            loadPosts();
        } else {
            showAlert(data.message || 'Error deleting', 'danger');
        }
    } catch (e) {
        showAlert('Network error', 'danger');
    }
}

async function loadPosts() {
    try {
        const res = await fetch(API + '/posts');
        const posts = await res.json();
        const tbody = document.getElementById('posts-list');
        tbody.innerHTML = posts.map(p => `
            <tr class="post-row" data-id="${p.id}">
                <td>${p.id}</td>
                <td>
                    <div class="d-flex justify-content-between align-items-start">
                        <div style="max-width:70%;white-space:pre-wrap;">${escapeHtml(p.content.substring(0,120))}${p.content.length>120?'...':''}</div>
                        <input type="hidden" id="post-content-${p.id}" value="${escapeHtml(p.content).replace(/"/g, '&quot;')}">
                    </div>
                </td>
                <td>${new Date(p.created_at).toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="editPost(${p.id})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="deletePost(${p.id})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `).join('');
    } catch (e) {
        showAlert('Failed to load posts', 'danger');
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// History
async function loadHistory() {
    try {
        const res = await fetch(API + '/history');
        const items = await res.json();
        const tbody = document.getElementById('history-list');
        tbody.innerHTML = items.map(h => `
            <tr>
                <td>${h.id}</td>
                <td style="max-width:200px;white-space:pre-wrap;">${escapeHtml(h.original_content.substring(0,100))}</td>
                <td style="max-width:200px;"><a href="#" onclick="showHistoryDetail(${h.id});return false;">View parsed</a></td>
                <td>${new Date(h.created_at).toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="deleteHistory(${h.id})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `).join('');
    } catch (e) {
        showAlert('Failed to load history', 'danger');
    }
}

async function deleteHistory(id) {
    if (!confirm('Delete history item?')) return;
    try {
        const res = await fetch(API + '/history/' + id, { method: 'POST' });
        const data = await res.json();
        if (res.ok) { showAlert(data.message); loadHistory(); }
        else showAlert(data.message || 'Error', 'danger');
    } catch (e) { showAlert('Network error', 'danger'); }
}

async function clearHistory() {
    if (!confirm('Clear ALL history?')) return;
    const tbody = document.getElementById('history-list');
    const rows = tbody.querySelectorAll('tr');
    for (const row of rows) {
        const id = row.querySelector('button')?.getAttribute('onclick')?.match(/\d+/)?.[0];
        if (id) await deleteHistory(parseInt(id));
    }
    showAlert('History cleared');
}

function showHistoryDetail(id) {
    fetch(API + '/history/' + id)
        .then(r => r.json())
        .then(data => {
            const w = window.open('', '_blank');
            w.document.write('<pre>' + data.parsed_content + '</pre>');
        });
}

// Files
async function loadFiles() {
    try {
        const res = await fetch(API + '/files');
        const files = await res.json();
        const container = document.getElementById('files-list');
        if (!files.length) {
            container.innerHTML = '<div class="col-12 text-muted">No files uploaded yet.</div>';
            return;
        }
        container.innerHTML = files.map(f => {
            const isImg = f.mime_type.startsWith('image/');
            let thumb = '';
            if (isImg) {
                thumb = `<img src="${f.url}" class="img-thumbnail" style="height:100px;width:100%;object-fit:cover;">`;
            } else {
                thumb = `<div class="card h-100 d-flex align-items-center justify-content-center" style="min-height:100px;"><i class="fas fa-file fa-2x text-secondary"></i></div>`;
            }
            return `
                <div class="col-md-4">
                    <div class="card h-100">
                        ${thumb}
                        <div class="card-body p-2">
                            <p class="card-text small mb-1 text-truncate" title="${f.filename}">${f.filename}</p>
                                    <a href="${f.url}" target="_blank" class="btn btn-sm btn-outline-primary w-100">Open</a>
                                    <button class="btn btn-sm btn-outline-danger w-100 mt-1" onclick="deleteFile(${f.id})">Delete</button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    } catch (e) {
        showAlert('Failed to load files', 'danger');
    }
}

async function deleteFile(id) {
    if (!confirm('Delete this file?')) return;
    try {
        const res = await fetch(API + '/files/' + id, { method: 'POST' });
        const data = await res.json();
        if (res.ok) { showAlert(data.message); loadFiles(); }
        else showAlert(data.message || 'Error', 'danger');
    } catch (e) { showAlert('Network error', 'danger'); }
}

// Shortcode badge clicks
document.querySelectorAll('.shortcode-badge').forEach(badge => {
    badge.addEventListener('click', () => {
        insertText(badge.getAttribute('data-shortcode'));
    });
});

function copyHTML() {
    const html = document.getElementById('preview-pane').innerHTML;
    if (!html) return showAlert('Nothing to copy', 'warning');
    navigator.clipboard.writeText(html).then(() => showAlert('HTML copied to clipboard'));
}

// Dropzone setup
Dropzone.options.dropzoneForm = {
    paramName: 'file',
    maxFilesize: 5,
    headers: {},
    success: function(file, response) {
        showAlert('File uploaded!');
        loadFiles();
    },
    error: function(file, message) {
        showAlert(message.message || 'Upload failed', 'danger');
    }
};

// Auto load on tab change
document.querySelectorAll('[data-tab]').forEach(link => {
    link.addEventListener('click', function() {
        const tab = this.getAttribute('data-tab');
        if (tab === 'files') loadFiles();
        if (tab === 'posts') loadPosts();
        if (tab === 'history') loadHistory();
    });
});

// Initial load
loadPosts();
loadHistory();
</script>
</body>
</html>