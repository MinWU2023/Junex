<style>
:root, .pf-page, .layui-layer {
    --pf-accent:#656EE6; --pf-accent-hover:#555dcf; --pf-accent-soft:#7a82eb;
    --pf-ink:#1f2a37; --pf-muted:#6b7280; --pf-line:#e8ecf1; --pf-soft:#f7f9fc; --pf-card:#fff;
}
.pf-page .layui-card { border:0; box-shadow:0 8px 28px rgba(31,42,55,.06); border-radius:12px; overflow:hidden; }
.pf-page .layui-card-body { padding:22px 24px 28px; }
.pf-hero {
    display:flex; align-items:flex-start; justify-content:space-between; gap:16px; flex-wrap:wrap;
    margin:-6px 0 20px; padding:18px 20px; border-radius:12px;
    background:linear-gradient(135deg,#fff 0%,#f5f8fb 48%,#f7f9fc 100%);
    border:1px solid #e6edf3;
}
.pf-hero-main { min-width:0; }
.pf-hero-kicker {
    display:inline-flex; align-items:center; gap:6px; padding:3px 10px; border-radius:999px;
    background:rgba(101,110,230,.1); color:var(--pf-accent); font-size:12px; font-weight:600; letter-spacing:.02em;
}
.pf-hero-title { margin:10px 0 6px; font-size:22px; line-height:1.25; color:var(--pf-ink); font-weight:700; }
.pf-hero-desc { margin:0; color:var(--pf-muted); font-size:13px; line-height:1.6; max-width:640px; }
.pf-hero-actions { display:flex; flex-wrap:wrap; gap:8px; align-items:center; }
.pf-toolbar {
    display:flex; flex-wrap:wrap; gap:10px 12px; align-items:center; justify-content:space-between;
    margin-bottom:16px; padding:14px 16px; background:var(--pf-soft); border:1px solid var(--pf-line); border-radius:10px;
}
.pf-toolbar-left, .pf-toolbar-right { display:flex; flex-wrap:wrap; gap:8px; align-items:center; }
.pf-search-label { color:var(--pf-muted); font-size:13px; margin-right:2px; }
.pf-search-input { width:240px !important; border-radius:8px !important; }
.pf-btn { border-radius:8px !important; box-shadow:none !important; }
.pf-btn-ghost {
    background:#fff !important; border:1px solid #e8ecf1 !important; color:#1f2a37 !important;
}
.pf-btn-ghost:hover { border-color:#d0d7e2 !important; color:#1f2a37 !important; }
.pf-btn-primary {
    background:#656EE6 !important; border-color:#656EE6 !important; color:#fff !important;
}
.pf-btn-primary:hover {
    background:#555dcf !important; border-color:#555dcf !important; color:#fff !important;
}
.pf-btn-soft {
    background:#7a82eb !important; border-color:#7a82eb !important; color:#fff !important;
}
.pf-btn-soft:hover {
    background:#656EE6 !important; border-color:#656EE6 !important; color:#fff !important;
}
.pf-btn-primary .layui-icon,
.pf-btn-soft .layui-icon,
.pf-btn-danger .layui-icon { color:#fff !important; }
.pf-btn-danger { background:#c74a4a !important; border-color:#c74a4a !important; color:#fff !important; }
.pf-btn-danger:hover { background:#b03d3d !important; border-color:#b03d3d !important; color:#fff !important; }
.layui-layer .pf-btn,
.layui-layer .layui-btn {
    display:inline-block !important; height:38px !important; line-height:38px !important;
    padding:0 18px !important; opacity:1 !important; visibility:visible !important;
}
.layui-layer .pf-btn-primary,
.layui-layer .layui-btn.pf-btn-primary {
    background:#656EE6 !important; border-color:#656EE6 !important; color:#fff !important;
}
.layui-layer .pf-btn-ghost,
.layui-layer .layui-btn.pf-btn-ghost {
    background:#fff !important; border:1px solid #d0d7e2 !important; color:#1f2a37 !important;
}
.pf-alert {
    display:flex; align-items:flex-start; gap:10px; padding:12px 14px; margin-bottom:16px;
    border-radius:10px; font-size:13px; line-height:1.5;
}
.pf-alert-success { background:#f0f9eb; color:#3f8f45; border:1px solid #d9efc8; }
.pf-alert-error { background:#fff1f0; color:#cf3b3b; border:1px solid #fad2d0; }
.pf-table-wrap { border:1px solid var(--pf-line); border-radius:12px; overflow:hidden; background:#fff; }
.pf-table { margin:0 !important; }
.pf-table thead tr { background:#f8fafc !important; }
.pf-table th {
    font-size:12px !important; font-weight:700 !important; color:#4b5563 !important;
    letter-spacing:.04em; text-transform:uppercase; border-bottom:1px solid var(--pf-line) !important;
    padding:12px 14px !important; background:transparent !important;
}
.pf-table td {
    padding:14px !important; vertical-align:top !important; border-color:#f1f4f8 !important;
    color:var(--pf-ink); font-size:13px; line-height:1.55;
}
.pf-table tbody tr:hover { background:#fcfdff !important; }
.pf-id {
    display:inline-flex; min-width:34px; height:24px; align-items:center; justify-content:center;
    padding:0 8px; border-radius:6px; background:#eef2f7; color:#526074; font-weight:600; font-size:12px;
}
.pf-subject { font-weight:600; color:var(--pf-ink); max-width:340px; word-break:break-word; }
.pf-tag-list { display:flex; flex-wrap:wrap; gap:6px; max-width:240px; }
.pf-tag {
    display:inline-flex; align-items:center; max-width:100%; padding:3px 9px; border-radius:999px;
    font-size:12px; line-height:1.4; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.pf-tag-cat { background:#eef5ff; color:#2f6fed; border:1px solid #d7e6ff; }
.pf-tag-prod { background:#eaf8f5; color:#0f8f7a; border:1px solid #c8ebe4; }
.pf-tag-more { background:#f3f4f6; color:#6b7280; border:1px solid #e5e7eb; }
.pf-empty-inline { color:#9aa3af; font-size:12px; }
.pf-status {
    display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:999px;
    font-size:12px; font-weight:600;
}
.pf-status::before { content:""; width:6px; height:6px; border-radius:50%; background:currentColor; }
.pf-status-on { background:#eaf8ef; color:#1f9d57; }
.pf-status-off { background:#f3f4f6; color:#8b93a1; }
.pf-sort { font-variant-numeric:tabular-nums; color:#526074; font-weight:600; }
.pf-actions { display:flex; flex-wrap:wrap; gap:6px; }
.pf-empty {
    text-align:center; padding:48px 20px !important; color:var(--pf-muted);
}
.pf-empty-icon {
    width:56px; height:56px; margin:0 auto 12px; border-radius:14px;
    display:flex; align-items:center; justify-content:center;
    background:rgba(101,110,230,.1); color:var(--pf-accent); font-size:24px;
}
.pf-pagination { margin-top:16px; }
.pf-form-section {
    margin:0 0 18px; padding:18px 18px 8px; border:1px solid var(--pf-line);
    border-radius:12px; background:#fff;
}
.pf-form-section-title {
    display:flex; align-items:center; gap:8px; margin:0 0 14px; padding-bottom:12px;
    border-bottom:1px dashed #e7ebf1; font-size:14px; font-weight:700; color:var(--pf-ink);
}
.pf-form-section-title i { color:var(--pf-accent); }
.pf-form-hint { margin:4px 0 0; color:#8b93a1; font-size:12px; line-height:1.5; }
.pf-relation-box {
    margin-top:10px; min-height:44px; padding:12px; border:1px dashed #d9e0ea; border-radius:10px;
    background:var(--pf-soft);
}
.pf-relation-empty { color:#9aa3af; font-size:12px; }
.pf-footer-actions {
    display:flex; gap:10px; justify-content:flex-end; margin-top:8px; padding-top:16px;
    border-top:1px solid var(--pf-line);
}
.pf-modal-body {
    display:flex; flex-direction:column; min-height:0; padding:8px 4px 0; height:100%; box-sizing:border-box;
}
.pf-modal-tools { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px; align-items:center; flex:none; }
.pf-modal-list {
    flex:1 1 auto; min-height:180px; max-height:none; overflow:auto; border:1px solid var(--pf-line); border-radius:10px;
    padding:12px; background:var(--pf-soft);
}
.pf-modal-footer {
    flex:none; display:flex !important; gap:10px; justify-content:flex-end; align-items:center;
    margin-top:14px; padding:12px 0 4px; border-top:1px solid #e8ecf1; text-align:right;
}
.pf-modal-list .layui-form-checkbox {
    margin:4px 0 !important; display:flex !important; align-items:flex-start; white-space:normal !important;
}
.pf-modal-list .layui-form-checkbox > span {
    display:inline-block !important; color:#1f2a37 !important; line-height:1.45; padding-right:8px;
}
.pf-cat-item { margin:4px 0; }
.pf-rel-cell {
    cursor:pointer; border-radius:8px; padding:4px; margin:-4px;
    transition:background .15s ease, box-shadow .15s ease;
}
.pf-rel-cell:hover { background:#eef5fb; box-shadow:inset 0 0 0 1px #d5e4f0; }
.pf-rel-btn {
    display:inline-flex !important; align-items:center; gap:4px;
    height:28px !important; line-height:28px !important; padding:0 10px !important;
    border-radius:6px !important; font-size:12px !important;
    background:#656EE6 !important; border:1px solid #656EE6 !important; color:#fff !important;
}
.pf-rel-btn .layui-icon { color:#fff !important; font-size:12px; }
.pf-rel-btn:hover { background:#555dcf !important; border-color:#555dcf !important; color:#fff !important; }
@media (max-width: 768px) {
    .pf-page .layui-card-body { padding:16px; }
    .pf-search-input { width:160px !important; }
    .pf-hero-title { font-size:18px; }
}
</style>
