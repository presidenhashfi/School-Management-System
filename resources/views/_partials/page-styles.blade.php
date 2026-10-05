<style>
/* ============================================================
   SHARED PAGE STYLES — Used by all index/form pages
   ============================================================ */

/* Hero blobs */
.hero-blob1 { position:absolute; width:280px; height:280px; background:rgba(255,255,255,.07); border-radius:50%; top:-100px; right:-60px; pointer-events:none; }
.hero-blob2 { position:absolute; width:160px; height:160px; background:rgba(255,255,255,.05); border-radius:50%; bottom:-60px; right:200px; pointer-events:none; }
.hero-blob3 { position:absolute; width:80px; height:80px; background:rgba(255,255,255,.06); border-radius:50%; top:20px; left:60%; pointer-events:none; }

.hero-icon-wrap { width:60px; height:60px; background:rgba(255,255,255,.16); border:1.5px solid rgba(255,255,255,.3); border-radius:18px; display:flex; align-items:center; justify-content:center; font-size:1.7rem; color:white; margin-bottom:1.1rem; backdrop-filter:blur(6px); box-shadow:0 4px 15px rgba(0,0,0,.12); }

.hero-stats { display:flex; gap:1.25rem; flex-wrap:wrap; }
.hero-stat { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2); border-radius:12px; padding:.5rem 1rem; backdrop-filter:blur(6px); text-align:center; }
.hero-stat .s-num { display:block; color:white; font-size:1.3rem; font-weight:800; line-height:1; }
.hero-stat .s-lbl { color:rgba(255,255,255,.7); font-size:.68rem; font-weight:600; text-transform:uppercase; letter-spacing:.7px; }

.btn-hero-add { background:white; color:#5b21b6; border:none; padding:.8rem 1.75rem; border-radius:14px; font-weight:800; font-size:.88rem; display:inline-flex; align-items:center; gap:.45rem; text-decoration:none; transition:all .25s; box-shadow:0 4px 20px rgba(0,0,0,.18); white-space:nowrap; flex-shrink:0; }
.btn-hero-add:hover { transform:translateY(-3px) scale(1.02); box-shadow:0 10px 30px rgba(0,0,0,.25); color:#4f46e5; }

/* Table card */
.pg-card { background:white; border-radius:22px; box-shadow:0 2px 12px rgba(0,0,0,.05), 0 8px 32px rgba(0,0,0,.04); overflow:hidden; border:1px solid #eef2f7; }
.pg-toolbar { padding:1.1rem 1.75rem; background:#fafaff; border-bottom:1px solid #f0f0fa; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.75rem; }
.pg-toolbar-title { font-weight:700; font-size:.92rem; color:#1e293b; }
.pg-count-pill { background:linear-gradient(135deg,#ede9fe,#ddd6fe); color:#5b21b6; font-size:.72rem; font-weight:800; padding:.25rem .75rem; border-radius:20px; border:1px solid #c4b5fd; }

.pg-table { margin:0; }
.pg-table thead th { background:#f8f9ff; border-bottom:1.5px solid #eef2f7; font-size:.7rem; text-transform:uppercase; letter-spacing:1.2px; font-weight:800; color:#94a3b8; padding:.9rem 1.5rem; white-space:nowrap; }
.pg-table tbody td { padding:1rem 1.5rem; vertical-align:middle; border-color:#f8f9ff; font-size:.875rem; }
.pg-table tbody tr { transition:background .18s; border-bottom:1px solid #f8f9ff; }
.pg-table tbody tr:hover { background:linear-gradient(90deg,#fafbff,#f5f3ff); }
.pg-table tbody tr:last-child { border-bottom:none; }
.pg-table tbody tr { animation:fadeRowIn .35s ease both; }
@keyframes fadeRowIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
.pg-table tbody tr:nth-child(1){animation-delay:.04s} .pg-table tbody tr:nth-child(2){animation-delay:.08s}
.pg-table tbody tr:nth-child(3){animation-delay:.12s} .pg-table tbody tr:nth-child(4){animation-delay:.16s}
.pg-table tbody tr:nth-child(5){animation-delay:.20s} .pg-table tbody tr:nth-child(6){animation-delay:.24s}
.pg-table tbody tr:nth-child(7){animation-delay:.28s} .pg-table tbody tr:nth-child(8){animation-delay:.32s}
.pg-table tbody tr:nth-child(9){animation-delay:.36s} .pg-table tbody tr:nth-child(10){animation-delay:.40s}

/* Row chips & avatars */
.row-chip { width:30px; height:30px; border-radius:8px; background:linear-gradient(135deg,#f1f5f9,#e2e8f0); display:inline-flex; align-items:center; justify-content:center; font-size:.75rem; font-weight:700; color:#94a3b8; }
.item-avatar { width:38px; height:38px; border-radius:11px; display:flex; align-items:center; justify-content:center; color:white; font-size:.8rem; font-weight:800; flex-shrink:0; box-shadow:0 3px 10px rgba(0,0,0,.2); }
.teacher-mini-avatar { width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#10b981,#059669); display:flex; align-items:center; justify-content:center; color:white; font-size:.7rem; font-weight:800; flex-shrink:0; box-shadow:0 2px 8px rgba(16,185,129,.35); }

/* Chips & badges */
.code-chip { display:inline-flex; align-items:center; gap:.3rem; font-family:'Courier New',monospace; background:linear-gradient(135deg,#fff1f2,#ffe4e6); color:#be123c; border:1px solid #fecdd3; padding:4px 10px; border-radius:8px; font-size:.8rem; font-weight:700; letter-spacing:.5px; }
.nip-chip { display:inline-flex; align-items:center; gap:.3rem; font-family:'Courier New',monospace; background:linear-gradient(135deg,#f0fdf4,#dcfce7); color:#15803d; border:1px solid #bbf7d0; padding:4px 10px; border-radius:8px; font-size:.8rem; font-weight:700; }
.year-badge { display:inline-flex; align-items:center; gap:.3rem; background:linear-gradient(135deg,#dbeafe,#bfdbfe); color:#1d4ed8; border:1px solid #93c5fd; padding:4px 12px; border-radius:20px; font-size:.74rem; font-weight:700; }
.subj-badge { display:inline-flex; align-items:center; gap:.3rem; background:linear-gradient(135deg,#ede9fe,#ddd6fe); color:#5b21b6; padding:5px 12px; border-radius:20px; font-size:.74rem; font-weight:700; border:1px solid #c4b5fd; }
.sks-badge { display:inline-flex; align-items:center; gap:.3rem; background:linear-gradient(135deg,#f0fdf4,#dcfce7); color:#15803d; border:1px solid #bbf7d0; padding:5px 12px; border-radius:20px; font-size:.74rem; font-weight:700; }
.empty-val { color:#e2e8f0; font-size:.8rem; font-style:italic; }

/* Action buttons */
.act-wrap { display:flex; align-items:center; justify-content:center; gap:.4rem; }
.act-btn { width:34px; height:34px; border-radius:10px; border:none; display:inline-flex; align-items:center; justify-content:center; font-size:.82rem; transition:all .22s cubic-bezier(.34,1.56,.64,1); text-decoration:none; cursor:pointer; position:relative; }
.act-btn::after { content:attr(data-tip); position:absolute; bottom:calc(100% + 6px); left:50%; transform:translateX(-50%) scale(.8); background:#1e293b; color:white; font-size:.65rem; font-weight:600; padding:3px 8px; border-radius:6px; white-space:nowrap; opacity:0; pointer-events:none; transition:all .2s; }
.act-btn:hover::after { opacity:1; transform:translateX(-50%) scale(1); }
.act-btn.edit { background:linear-gradient(135deg,#fef3c7,#fde68a); color:#92400e; }
.act-btn.edit:hover { background:linear-gradient(135deg,#f59e0b,#f97316); color:white; transform:translateY(-3px) scale(1.08); box-shadow:0 6px 16px rgba(245,158,11,.45); }
.act-btn.del { background:linear-gradient(135deg,#fee2e2,#fecaca); color:#991b1b; }
.act-btn.del:hover { background:linear-gradient(135deg,#ef4444,#dc2626); color:white; transform:translateY(-3px) scale(1.08); box-shadow:0 6px 16px rgba(239,68,68,.45); }

/* Empty state */
.empty-state { padding:5rem 2rem; text-align:center; }
.empty-icon { width:90px; height:90px; background:linear-gradient(135deg,#f8fafc,#f1f5f9); border-radius:28px; display:inline-flex; align-items:center; justify-content:center; font-size:2.5rem; color:#cbd5e1; margin-bottom:1.5rem; border:2px dashed #e2e8f0; }
.empty-state h6 { color:#475569; font-weight:700; font-size:1rem; margin:0 0 .4rem; }
.empty-state p { color:#94a3b8; font-size:.83rem; margin:0; }

/* ============================================================
   SHARED FORM STYLES
   ============================================================ */
.sf-outer { display:grid; grid-template-columns:300px 1fr; gap:1.75rem; max-width:960px; margin:0 auto; align-items:start; }
@media(max-width:860px){.sf-outer{grid-template-columns:1fr;}}

/* Sidebar */
.sf-sidebar { position:sticky; top:82px; }
.sf-sidebar-card { border-radius:24px; padding:2rem 1.75rem; color:white; position:relative; overflow:hidden; }
.sf-sidebar-card::before { content:''; position:absolute; top:-60px; right:-60px; width:200px; height:200px; background:rgba(255,255,255,.08); border-radius:50%; }
.sf-sidebar-card::after  { content:''; position:absolute; bottom:-40px; left:-30px; width:140px; height:140px; background:rgba(255,255,255,.05); border-radius:50%; }
.sf-side-icon { width:64px; height:64px; background:rgba(255,255,255,.18); border:1.5px solid rgba(255,255,255,.3); border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:1.8rem; margin-bottom:1.25rem; backdrop-filter:blur(6px); position:relative; z-index:1; }
.sf-side-title { font-size:1.2rem; font-weight:800; margin:0 0 .4rem; position:relative; z-index:1; }
.sf-side-desc { font-size:.82rem; opacity:.75; margin:0 0 1.5rem; line-height:1.5; position:relative; z-index:1; }

/* Steps */
.sf-steps { list-style:none; margin:0; padding:0; position:relative; z-index:1; }
.sf-steps::before { content:''; position:absolute; left:17px; top:28px; width:2px; height:calc(100% - 56px); background:rgba(255,255,255,.2); }
.sf-step { display:flex; align-items:flex-start; gap:.9rem; margin-bottom:1.2rem; }
.sf-step:last-child { margin-bottom:0; }
.sf-step-dot { width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,.2); border:2px solid rgba(255,255,255,.4); display:flex; align-items:center; justify-content:center; font-size:.8rem; font-weight:800; flex-shrink:0; color:white; position:relative; z-index:1; }
.sf-step-dot.done { background:white; border-color:white; }
.sf-step-info strong { display:block; font-size:.85rem; font-weight:700; margin-bottom:.1rem; }
.sf-step-info span { font-size:.73rem; opacity:.65; }

/* Preview card */
.sf-preview-card { background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25); border-radius:16px; padding:1rem 1.25rem; backdrop-filter:blur(6px); position:relative; z-index:1; }
.sf-preview-label { font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; opacity:.7; margin-bottom:.65rem; }
.sf-preview-avatar { width:44px; height:44px; border-radius:12px; background:rgba(255,255,255,.25); border:2px solid rgba(255,255,255,.4); display:flex; align-items:center; justify-content:center; font-size:1rem; font-weight:800; flex-shrink:0; }
.sf-preview-name { font-weight:700; font-size:.9rem; margin-bottom:.15rem; }
.sf-preview-sub { font-family:'Courier New',monospace; font-size:.75rem; opacity:.7; }

/* Edit note */
.sf-edit-note { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.22); border-radius:12px; padding:.75rem 1rem; font-size:.77rem; opacity:.85; display:flex; align-items:flex-start; gap:.5rem; margin-top:1rem; line-height:1.45; position:relative; z-index:1; }

/* Tips card */
.sf-tips-card { background:white; border-radius:16px; padding:1.25rem 1.4rem; margin-top:1.25rem; box-shadow:0 4px 20px rgba(0,0,0,.06); border:1px solid #eef2f7; }
.sf-tips-title { font-size:.78rem; font-weight:800; text-transform:uppercase; letter-spacing:.8px; margin-bottom:.75rem; display:flex; align-items:center; gap:.4rem; }
.sf-tips-card ul { margin:0; padding:0; list-style:none; }
.sf-tips-card li { font-size:.78rem; color:#64748b; padding:.3rem 0; display:flex; align-items:flex-start; gap:.5rem; border-bottom:1px solid #f8fafc; font-weight:500; line-height:1.4; }
.sf-tips-card li:last-child { border-bottom:none; }
.sf-tips-card li i { font-size:.8rem; flex-shrink:0; margin-top:2px; }

/* Main form card */
.sf-main-card { background:white; border-radius:24px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.06),0 1px 4px rgba(0,0,0,.04); border:1px solid #eef2f7; }
.sf-form-banner { border-bottom:1px solid; padding:1rem 2rem; display:flex; align-items:center; gap:.75rem; }
.sf-form-banner span { font-size:.82rem; font-weight:600; }
.sf-edit-badge { margin-left:auto; font-size:.7rem; font-weight:800; padding:3px 10px; border-radius:20px; display:inline-flex; align-items:center; gap:.3rem; }

/* Section header */
.sf-sec-hdr { display:flex; align-items:center; gap:.75rem; padding:1.4rem 2rem 0; margin-bottom:1.25rem; }
.sf-sec-num { width:28px; height:28px; border-radius:8px; color:white; font-size:.75rem; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.sf-sec-title { font-size:.85rem; font-weight:700; color:#1e293b; }
.sf-sec-line { flex:1; height:1px; background:linear-gradient(90deg,#e2e8f0,transparent); }

/* Fields */
.sf-fields { padding:0 2rem; }
.sf-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:0 1.25rem; }
@media(max-width:600px){.sf-grid2{grid-template-columns:1fr;}}
.sf-field { margin-bottom:1.3rem; position:relative; }
.sf-field label { display:flex; align-items:center; gap:.4rem; font-size:.8rem; font-weight:700; color:#475569; margin-bottom:.45rem; }
.sf-field label i { font-size:.78rem; }
.sf-field .req { color:#ef4444; margin-left:1px; }
.opt-pill { background:#f1f5f9; color:#94a3b8; font-size:.62rem; font-weight:700; padding:1px 7px; border-radius:10px; text-transform:uppercase; letter-spacing:.5px; }
.sf-field input, .sf-field select, .sf-field textarea { width:100%; border:2px solid #e8ecf4; border-radius:12px; padding:.72rem 1rem; font-size:.875rem; color:#1e293b; background:#f9fafb; transition:all .25s; font-family:'Inter',sans-serif; outline:none; -webkit-appearance:none; appearance:none; }
.sf-field textarea { resize:vertical; min-height:90px; }
.sf-field select { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236366f1' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 1rem center; padding-right:2.5rem; cursor:pointer; }
.sf-field input::placeholder { color:#c8d0dd; font-weight:400; }
.sf-field::after { content:''; position:absolute; left:0; bottom:0; width:0; height:2px; border-radius:2px; transition:width .3s; pointer-events:none; }
.sf-field:focus-within::after { width:100%; }
.sf-divider { height:1px; background:linear-gradient(90deg,transparent,#e8ecf4 30%,#e8ecf4 70%,transparent); margin:.5rem 0 0; }
.sf-error { display:flex; align-items:center; gap:.35rem; color:#ef4444; font-size:.75rem; font-weight:600; margin-top:.4rem; padding:.35rem .6rem; background:#fff5f5; border-radius:7px; border-left:3px solid #ef4444; }

/* Footer */
.sf-footer { padding:1.5rem 2rem 2rem; border-top:1px solid; display:flex; align-items:center; gap:1rem; flex-wrap:wrap; }
.sf-req-note { margin-left:auto; font-size:.75rem; color:#94a3b8; }
.sf-req-note span { color:#ef4444; }
.btn-sf { border:none; padding:.82rem 2rem; border-radius:14px; font-weight:800; font-size:.9rem; display:inline-flex; align-items:center; gap:.5rem; transition:all .25s cubic-bezier(.34,1.56,.64,1); cursor:pointer; }
.btn-sf:hover { transform:translateY(-3px) scale(1.02); }
.btn-sf:active { transform:translateY(-1px) scale(.99); }
.btn-sf-cancel { background:transparent; color:#64748b; border:2px solid #e2e8f0; padding:.8rem 1.5rem; border-radius:14px; font-weight:700; font-size:.875rem; display:inline-flex; align-items:center; gap:.45rem; transition:all .2s; text-decoration:none; }
.btn-sf-cancel:hover { background:#f1f5f9; color:#374151; border-color:#cbd5e1; transform:translateY(-1px); }
</style>
