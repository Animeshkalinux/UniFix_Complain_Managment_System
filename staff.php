<?php session_start(); if(!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['staff', 'admin'])){ header('Location: index.php'); exit; } ?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UniFix — Staff Portal</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#eef2ff',
              100: '#e0e7ff',
              500: '#6366f1',
              600: '#4f46e5',
              700: '#4338ca',
              900: '#312e81',
            }
          }
        }
      }
    };
  </script>
  <style>
    /* Custom subtle scrollbars and smooth transitions */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 9999px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    .drawer-enter {
      transform: translateX(100%);
    }

    .drawer-open {
      transform: translateX(0);
    }

    .logo {
      border-radius: 12px;
      width: 42px;
      height: 42px;
    }
  </style>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">
  <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 sm:h-16 gap-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div
              class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center shadow-md shadow-brand-600/20">
              <img src="logo.png" alt="">
              <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h1 class="text-lg font-bold text-slate-900 tracking-tight leading-none">UniFix</h1>
              </div>
              <p class="text-xs text-slate-500 mt-0.5">Campus Complaint Management System</p>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-end gap-3">
          <button
            type="button"
            onclick="handleLogout()"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-md shadow-brand-600/20 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 w-full sm:w-auto"
            aria-label="Log out"
          >
            <i data-lucide="log-out" class="w-4 h-4"></i>
            <span>Logout</span>
          </button>
        </div>
      </div>
    </div>
  </header>

  <div class="bg-brand-900 text-white text-xs sm:text-sm py-2.5 px-4">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-1">
      <div class="flex items-center gap-2">
        <i data-lucide="wrench" class="w-4 h-4 text-brand-100 shrink-0"></i>
        <span>You are viewing the <strong>Staff Portal</strong>. Review assigned campus complaints, update their status,
          and add official remarks.</span>
      </div>
      <span class="text-brand-100/80 text-xs hidden md:inline">Default status: Pending</span>
    </div>
  </div>

  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <section class="space-y-6">
      <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
          <p class="text-xs font-bold uppercase tracking-wider text-brand-600">Staff Workspace</p>
          <h2 class="text-2xl font-bold text-slate-900 mt-1">Complaint Resolution Queue</h2>
          <p class="text-sm text-slate-500 mt-1">View campus complaints, filter by priority, and update each complaint
            as work progresses.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
          <div class="bg-white border border-slate-200 rounded-xl px-4 py-3 min-w-[120px]">
            <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400">Total</p>
            <p id="count-total" class="text-xl font-bold text-slate-900 mt-0.5">0</p>
          </div>
          <div class="bg-white border border-amber-200 rounded-xl px-4 py-3 min-w-[120px]">
            <p class="text-[11px] font-bold uppercase tracking-wide text-amber-600">Pending</p>
            <p id="count-pending" class="text-xl font-bold text-slate-900 mt-0.5">0</p>
          </div>
          <div class="bg-white border border-blue-200 rounded-xl px-4 py-3 min-w-[120px]">
            <p class="text-[11px] font-bold uppercase tracking-wide text-blue-600">In Progress</p>
            <p id="count-progress" class="text-xl font-bold text-slate-900 mt-0.5">0</p>
          </div>
          <div class="bg-white border border-emerald-200 rounded-xl px-4 py-3 min-w-[120px]">
            <p class="text-[11px] font-bold uppercase tracking-wide text-emerald-600">Resolved</p>
            <p id="count-resolved" class="text-xl font-bold text-slate-900 mt-0.5">0</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 sm:p-5 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
          <div>
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2"><i data-lucide="filter"
                class="w-4 h-4 text-brand-600"></i>Filter Complaints</h3>
            <p class="text-xs text-slate-500 mt-0.5">Click a priority to show only complaints at that level.</p>
          </div>
          <div class="flex flex-wrap gap-2" id="priority-filters">
            <button data-priority="ALL" onclick="setPriorityFilter('ALL')"
              class="priority-filter px-3.5 py-2 rounded-xl text-xs font-semibold bg-brand-600 text-white transition">All
              Priorities</button>
            <button data-priority="Urgent" onclick="setPriorityFilter('Urgent')"
              class="priority-filter px-3.5 py-2 rounded-xl text-xs font-semibold bg-white text-slate-700 border border-slate-200 hover:border-rose-300 hover:text-rose-700 transition">Urgent</button>
            <button data-priority="High" onclick="setPriorityFilter('High')"
              class="priority-filter px-3.5 py-2 rounded-xl text-xs font-semibold bg-white text-slate-700 border border-slate-200 hover:border-orange-300 hover:text-orange-700 transition">High</button>
            <button data-priority="Medium" onclick="setPriorityFilter('Medium')"
              class="priority-filter px-3.5 py-2 rounded-xl text-xs font-semibold bg-white text-slate-700 border border-slate-200 hover:border-sky-300 hover:text-sky-700 transition">Medium</button>
            <button data-priority="Low" onclick="setPriorityFilter('Low')"
              class="priority-filter px-3.5 py-2 rounded-xl text-xs font-semibold bg-white text-slate-700 border border-slate-200 hover:border-slate-300 transition">Low</button>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div class="relative md:col-span-2">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
            <input id="staff-search" oninput="renderStaff()" type="text"
              placeholder="Search by Ticket ID, complaint, student, or location..."
              class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-400 transition">
          </div>
          <select id="staff-status-filter" onchange="renderStaff()"
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-400">
            <option value="ALL">All Statuses</option>
            <option>Pending</option>
            <option>In Progress</option>
            <option>Resolved</option>
            <option>Rejected</option>
          </select>
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between gap-3">
          <div>
            <h3 class="text-sm font-bold text-slate-900">All Campus Complaints</h3>
            <p id="result-count" class="text-xs text-slate-500 mt-0.5">0 complaints</p>
          </div>
          <span class="hidden sm:inline-flex items-center gap-1.5 text-xs text-slate-500"><i
              data-lucide="mouse-pointer-click" class="w-3.5 h-3.5"></i>Click a complaint to update it</span>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full min-w-[900px]">
            <thead class="bg-slate-50 text-[11px] uppercase tracking-wide text-slate-500">
              <tr>
                <th class="text-left py-3.5 px-4">Ticket</th>
                <th class="text-left py-3.5 px-4">Complaint & Location</th>
                <th class="text-left py-3.5 px-4">Category</th>
                <th class="text-left py-3.5 px-4">Priority</th>
                <th class="text-left py-3.5 px-4">Status</th>
                <th class="text-left py-3.5 px-4">Remark</th>
                <th class="text-right py-3.5 px-4">Action</th>
              </tr>
            </thead>
            <tbody id="staff-table-body" class="divide-y divide-slate-100 text-sm"></tbody>
          </table>
        </div>
        <div id="staff-empty" class="hidden py-14 px-4 text-center">
          <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
            <i data-lucide="inbox" class="w-6 h-6"></i>
          </div>
          <p class="text-sm font-semibold text-slate-700">No matching complaints found</p>
          <p class="text-xs text-slate-500 mt-1">Try another priority, status, or search term.</p>
        </div>
      </div>
    </section>
  </main>

  <div id="staff-drawer-backdrop" onclick="closeStaffDrawer()"
    class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 hidden"></div>
  <aside id="staff-drawer"
    class="fixed top-0 right-0 h-full w-full max-w-lg bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
      <div>
        <div class="flex items-center gap-2"><span id="drawer-id"
            class="text-xs font-mono font-bold px-2.5 py-0.5 rounded-md bg-brand-100 text-brand-800"></span><span
            id="drawer-date" class="text-xs text-slate-500"></span></div>
        <h3 class="text-base font-bold text-slate-900 mt-1">Update Complaint</h3>
      </div>
      <button onclick="closeStaffDrawer()"
        class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-200/70 transition"><i data-lucide="x"
          class="w-5 h-5"></i></button>
    </div>
    <form onsubmit="saveStaffUpdate(event)" class="flex-1 overflow-y-auto p-6 space-y-5">
      <input type="hidden" id="edit-id">
      <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/70 space-y-3">
        <div>
          <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400">Complaint</p>
          <p id="drawer-title" class="font-bold text-slate-900 mt-1"></p>
        </div>
        <p id="drawer-description" class="text-sm text-slate-600 leading-relaxed"></p>
        <div class="grid grid-cols-2 gap-3 text-xs">
          <div><span class="text-slate-400">Category</span>
            <p id="drawer-category" class="font-semibold text-slate-700 mt-0.5"></p>
          </div>
          <div><span class="text-slate-400">Priority</span>
            <p id="drawer-priority" class="font-semibold text-slate-700 mt-0.5"></p>
          </div>
          <div><span class="text-slate-400">Student</span>
            <p id="drawer-student" class="font-semibold text-slate-700 mt-0.5"></p>
          </div>
          <div><span class="text-slate-400">Location</span>
            <p id="drawer-location" class="font-semibold text-slate-700 mt-0.5"></p>
          </div>
        </div>
      </div>
      <div><label for="edit-status" class="block text-xs font-bold text-slate-700 mb-1.5">Set Status</label><select
          id="edit-status"
          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:ring-2 focus:ring-brand-200 focus:border-brand-400">
          <option>Pending</option>
          <option>In Progress</option>
          <option>Resolved</option>
          <option>Rejected</option>
        </select>
        <p class="text-[11px] text-slate-400 mt-1.5">If no action is taken, the complaint remains Pending.</p>
      </div>
      <div><label for="edit-remark" class="block text-xs font-bold text-slate-700 mb-1.5">Staff Remark /
          Update</label><textarea id="edit-remark" rows="6"
          placeholder="Write a note, action taken, progress update, resolution details, or other information..."
          class="w-full px-3.5 py-3 rounded-xl border border-slate-200 bg-white text-sm outline-none resize-none focus:ring-2 focus:ring-brand-200 focus:border-brand-400"></textarea>
        <div class="flex flex-wrap gap-2 mt-2"><button type="button"
            onclick="quickRemark('Complaint received and is under review.')"
            class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-[11px] font-semibold hover:bg-slate-200">Under
            review</button><button type="button"
            onclick="quickRemark('Action has been initiated by the concerned staff/team.')"
            class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-[11px] font-semibold hover:bg-slate-200">Action
            initiated</button><button type="button"
            onclick="quickRemark('Complaint has been resolved and the issue is no longer active.')"
            class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-[11px] font-semibold hover:bg-slate-200">Resolved</button>
        </div>
      </div>
      <div class="pt-2 flex gap-3"><button type="button" onclick="closeStaffDrawer()"
          class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</button><button
          type="submit"
          class="flex-1 px-4 py-2.5 rounded-xl bg-brand-600 text-white text-sm font-semibold hover:bg-brand-700 shadow-sm">Save
          Update</button></div>
    </form>
  </aside>

  <div id="toast"
    class="fixed right-4 bottom-4 z-[60] hidden max-w-sm px-4 py-3 rounded-xl bg-slate-900 text-white text-sm shadow-xl">
  </div>

  <script>
    const STORAGE_KEY = 'unifix_campus_complaints_v1';
    const DEFAULT_COMPLAINTS = [
      {
        id: 'CMP-2026-101',
        studentName: 'Rohan Verma',
        studentId: 'ECE-2025-042',
        isAnonymous: false,
        location: 'CV Raman Hostel — Block C, 2nd Floor',
        category: 'IT & Wi-Fi',
        priority: 'High',
        title: 'Complete Wi-Fi router outage in Block C corridor',
        description: 'The access point near Room C-208 has been blinking red since yesterday evening. Around 30 students are unable to access LMS or submit assignments.',
        status: 'In Progress',
        assignedDept: 'Network & IT Cell',
        remarks: 'Network engineer dispatched to replace faulty PoE switch on 2nd floor. Expected restoration by 5:00 PM today.',
        createdAt: 'Nov 11, 2026 · 09:40 AM',
        updatedAt: 'Nov 12, 2026 · 10:15 AM'
      },
      {
        id: 'CMP-2026-102',
        studentName: 'Ananya Nair',
        studentId: 'CSE-2026-119',
        isAnonymous: false,
        location: 'Academic Block A — Smart Lab 302',
        category: 'Academic & Labs',
        priority: 'Medium',
        title: 'Overhead HDMI projector flickering & color distortion',
        description: 'During the Data Structures lecture, the main ceiling projector kept cutting out every 5 minutes and displaying a heavy green tint.',
        status: 'Pending',
        assignedDept: 'Dean Academics & Lab Support',
        remarks: '',
        createdAt: 'Nov 12, 2026 · 11:20 AM',
        updatedAt: 'Nov 12, 2026 · 11:20 AM'
      },
      {
        id: 'CMP-2026-103',
        studentName: 'Anonymous Student',
        studentId: 'HIDDEN',
        isAnonymous: true,
        location: 'Tagore Girls Hostel — Wing B Washroom',
        category: 'Hostel & Mess',
        priority: 'Urgent',
        title: 'Solar water heater & geyser tripping main MCB',
        description: 'Hot water supply is completely down in Wing B. Switching on the backup geyser immediately trips the floor circuit breaker.',
        status: 'Pending',
        assignedDept: 'Chief Warden & Hostel Office',
        remarks: '',
        createdAt: 'Nov 12, 2026 · 07:15 AM',
        updatedAt: 'Nov 12, 2026 · 07:15 AM'
      },
      {
        id: 'CMP-2026-104',
        studentName: 'Siddharth Kulkarni',
        studentId: 'MECH-2024-018',
        isAnonymous: false,
        location: 'Central Library — Silent Reading Hall (1st Floor)',
        category: 'Library',
        priority: 'Low',
        title: 'Central AC vent leaking water onto study desk #14',
        description: 'Condensation water is dripping steadily from the ceiling duct above the corner reading table, damaging notebooks.',
        status: 'Resolved',
        assignedDept: 'Estate & Civil Maintenance',
        remarks: 'HVAC drain pipe unclogged and insulation sealed. Desk #14 cleaned and reopened for student use.',
        createdAt: 'Nov 09, 2026 · 03:30 PM',
        updatedAt: 'Nov 10, 2026 · 04:45 PM'
      },
      {
        id: 'CMP-2026-105',
        studentName: 'Meera Krishnan',
        studentId: 'BIO-2026-063',
        isAnonymous: false,
        location: 'North Gate Shuttle Stop',
        category: 'Transport',
        priority: 'Medium',
        title: 'Evening 6:30 PM campus shuttle running 25 mins late',
        description: 'For the past three days, the evening shuttle connecting North Gate to the Metro Station has arrived after 6:55 PM without prior notice.',
        status: 'In Progress',
        assignedDept: 'Campus Transport & Security',
        remarks: 'Reviewed GPS logs with transport vendor. Added a standby shuttle during peak 6:00–7:00 PM evening hours.',
        createdAt: 'Nov 10, 2026 · 07:05 PM',
        updatedAt: 'Nov 11, 2026 · 02:10 PM'
      },
      {
        id: 'CMP-2026-106',
        studentName: 'Kabir Das',
        studentId: 'IT-2025-091',
        isAnonymous: false,
        location: 'Sports Complex — Main Entrance',
        category: 'Security',
        priority: 'High',
        title: 'Streetlight near badminton court pathway fused',
        description: 'The pathway between the Sports Complex and Boys Hostel Gate 2 is pitch dark after 6 PM, creating a safety hazard.',
        status: 'Resolved',
        assignedDept: 'Estate & Civil Maintenance',
        remarks: 'Replaced burnt-out 60W LED street luminaire and verified timer sensor.',
        createdAt: 'Nov 08, 2026 · 08:10 PM',
        updatedAt: 'Nov 09, 2026 · 05:00 PM'
      }
    ];
    let complaints = [];
    let priorityFilter = 'ALL';

    function handleLogout() {
      const confirmed = window.confirm('Are you sure you want to log out?');
      if (!confirmed) return;
      window.location.href = 'login.html';
    }

    function goTo(page) { window.location.href = page; }
    function escapeHTML(str) { return String(str ?? '').replace(/[&<>'"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[c])); }
    function loadComplaints() {
      try { const saved = localStorage.getItem(STORAGE_KEY); complaints = saved ? JSON.parse(saved) : JSON.parse(JSON.stringify(DEFAULT_COMPLAINTS)); if (!saved) saveComplaints(); }
      catch (e) { complaints = JSON.parse(JSON.stringify(DEFAULT_COMPLAINTS)); }
      complaints = complaints.map(c => ({ ...c, status: c.status || 'Pending', remarks: c.remarks || '' }));
    }
    function saveComplaints() { try { localStorage.setItem(STORAGE_KEY, JSON.stringify(complaints)); } catch (e) { } }
    function statusBadge(status) { const map = { Pending: ['bg-amber-50', 'text-amber-700', 'border-amber-200', 'bg-amber-500'], 'In Progress': ['bg-blue-50', 'text-blue-700', 'border-blue-200', 'bg-blue-500'], Resolved: ['bg-emerald-50', 'text-emerald-700', 'border-emerald-200', 'bg-emerald-500'], Rejected: ['bg-rose-50', 'text-rose-700', 'border-rose-200', 'bg-rose-500'] }; const s = map[status] || map.Pending; return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border ${s[0]} ${s[1]} ${s[2]}"><span class="w-1.5 h-1.5 rounded-full ${s[3]}"></span>${escapeHTML(status)}</span>`; }
    function priorityBadge(priority) { const map = { Urgent: 'bg-rose-100 text-rose-700 font-bold', High: 'bg-orange-50 text-orange-700', Medium: 'bg-sky-50 text-sky-700', Low: 'bg-slate-100 text-slate-600' }; return `<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold ${map[priority] || map.Medium}">${escapeHTML(priority || 'Medium')}</span>`; }
    function setPriorityFilter(filter) { priorityFilter = filter; document.querySelectorAll('.priority-filter').forEach(b => { const active = b.dataset.priority === filter; b.className = 'priority-filter px-3.5 py-2 rounded-xl text-xs font-semibold transition ' + (active ? 'bg-brand-600 text-white' : 'bg-white text-slate-700 border border-slate-200 hover:border-brand-300 hover:text-brand-700'); }); renderStaff(); }
    function renderStaff() {
      const q = (document.getElementById('staff-search').value || '').toLowerCase().trim(); const sf = document.getElementById('staff-status-filter').value;
      const filtered = complaints.filter(c => { const text = [c.id, c.title, c.studentName, c.location, c.category].join(' ').toLowerCase(); return (!q || text.includes(q)) && (priorityFilter === 'ALL' || c.priority === priorityFilter) && (sf === 'ALL' || c.status === sf); });
      document.getElementById('count-total').textContent = complaints.length; document.getElementById('count-pending').textContent = complaints.filter(c => c.status === 'Pending').length; document.getElementById('count-progress').textContent = complaints.filter(c => c.status === 'In Progress').length; document.getElementById('count-resolved').textContent = complaints.filter(c => c.status === 'Resolved').length; document.getElementById('result-count').textContent = `${filtered.length} complaint${filtered.length === 1 ? '' : 's'}`;
      const body = document.getElementById('staff-table-body'), empty = document.getElementById('staff-empty');
      if (!filtered.length) { body.innerHTML = ''; empty.classList.remove('hidden'); lucide.createIcons(); return; } empty.classList.add('hidden');
      body.innerHTML = filtered.map(c => `<tr onclick="openStaffDrawer('${escapeHTML(c.id)}')" class="hover:bg-slate-50/90 transition-colors cursor-pointer group"><td class="py-4 px-4 align-top"><span class="font-mono text-xs font-bold text-slate-800">${escapeHTML(c.id)}</span><span class="block text-[11px] text-slate-400 mt-0.5">${escapeHTML((c.createdAt || '').split('·')[0])}</span></td><td class="py-4 px-4 align-top max-w-xs"><p class="font-semibold text-slate-900 line-clamp-1">${escapeHTML(c.title)}</p><p class="text-xs text-slate-500 mt-0.5 line-clamp-1">${escapeHTML(c.location)} · <span class="text-slate-600 font-medium">${escapeHTML(c.studentName || 'Anonymous Student')}</span></p></td><td class="py-4 px-4 align-top"><span class="text-xs font-medium px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700">${escapeHTML(c.category)}</span></td><td class="py-4 px-4 align-top">${priorityBadge(c.priority)}</td><td class="py-4 px-4 align-top">${statusBadge(c.status || 'Pending')}</td><td class="py-4 px-4 align-top max-w-[220px]"><p class="text-xs text-slate-500 line-clamp-2">${escapeHTML(c.remarks || 'No remark added yet.')}</p></td><td class="py-4 px-4 align-top text-right"><button onclick="event.stopPropagation(); openStaffDrawer('${escapeHTML(c.id)}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-brand-50 text-brand-700 hover:bg-brand-600 hover:text-white border border-brand-200/70 transition"><i data-lucide="pencil" class="w-3.5 h-3.5"></i><span>Update</span></button></td></tr>`).join(''); lucide.createIcons();
    }
    function openStaffDrawer(id) { const c = complaints.find(x => x.id === id); if (!c) return; document.getElementById('edit-id').value = c.id; document.getElementById('drawer-id').textContent = c.id; document.getElementById('drawer-date').textContent = c.createdAt || ''; document.getElementById('drawer-title').textContent = c.title || ''; document.getElementById('drawer-description').textContent = c.description || ''; document.getElementById('drawer-category').textContent = c.category || ''; document.getElementById('drawer-priority').textContent = c.priority || 'Medium'; document.getElementById('drawer-student').textContent = c.isAnonymous ? 'Anonymous Student' : `${c.studentName || 'Unknown'} (${c.studentId || '—'})`; document.getElementById('drawer-location').textContent = c.location || ''; document.getElementById('edit-status').value = c.status || 'Pending'; document.getElementById('edit-remark').value = c.remarks || ''; document.getElementById('staff-drawer-backdrop').classList.remove('hidden'); requestAnimationFrame(() => document.getElementById('staff-drawer').classList.remove('translate-x-full')); lucide.createIcons(); }
    function closeStaffDrawer() { const d = document.getElementById('staff-drawer'); d.classList.add('translate-x-full'); setTimeout(() => document.getElementById('staff-drawer-backdrop').classList.add('hidden'), 280); }
    function quickRemark(text) { document.getElementById('edit-remark').value = text; document.getElementById('edit-remark').focus(); }
    function saveStaffUpdate(e) { e.preventDefault(); const id = document.getElementById('edit-id').value; const i = complaints.findIndex(c => c.id === id); if (i < 0) return; complaints[i].status = document.getElementById('edit-status').value || 'Pending'; complaints[i].remarks = document.getElementById('edit-remark').value.trim(); complaints[i].updatedAt = new Date().toLocaleString('en-US', { month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }); saveComplaints(); renderStaff(); closeStaffDrawer(); showToast(`Updated <strong>${escapeHTML(id)}</strong> to <strong>${escapeHTML(complaints[i].status)}</strong>.`); }
    function showToast(msg) { const t = document.getElementById('toast'); t.innerHTML = msg; t.classList.remove('hidden'); setTimeout(() => t.classList.add('hidden'), 2600); }
    document.addEventListener('DOMContentLoaded', () => { loadComplaints(); renderStaff(); lucide.createIcons(); });
  </script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const res = await fetch('api/get_complaints.php');
        const data = await res.json();
        if(data.success) {
            console.log("Staff portal complaints loaded:", data.complaints);
        }
    } catch(e) { console.error(e); }
});
</script>
</body>


</html>