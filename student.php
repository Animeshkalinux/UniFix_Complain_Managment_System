<?php session_start(); if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student'){ header('Location: index.php'); exit; } ?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UniFix — Student Portal</title>
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
      height: 42px;
      width: 42px;

    }

    .log-out {
      margin-left: auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 8px;

      padding: 10px 24px;
      background-color: #4338CA;
      color: #ffffff;

      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;

      cursor: pointer;
      transition: all 0.3s ease;
    }

    .log-out:hover {
      background-color: #312e81;
      transform: translateY(-1px);
    }

    .log-out:focus-visible {
      outline: 3px solid #a5b4fc;
      outline-offset: 3px;
    }

    @media (max-width: 480px) {
      .log-out {
        padding: 9px 12px;
        font-size: 13px;
      }
    }
  </style>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">

  <!-- Top Navigation & Role Switcher -->
  <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between py-3 sm:h-16 gap-3">
        <!-- Brand Logo & Title -->
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div
              class="w-10 h-10 rounded-xl bg-brand-600 text-white flex items-center justify-center shadow-md shadow-brand-600/20 ">
              <img class="logo" src="logo.png" alt="">
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

        <!-- Logout Button: aligned to the right side of the navbar -->
        <button type="button" class="log-out" onclick="handleLogout()" aria-label="Log out">
          <i data-lucide="log-out" class="w-4 h-4"></i>
          <span>Logout</span>
        </button>
      </div>
  </header>

  <!-- Context Banner -->
  <div id="role-banner" class="bg-brand-900 text-white text-xs sm:text-sm py-2.5 px-4 transition-colors duration-300">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-1">
      <div class="flex items-center gap-2">
        <i id="role-banner-icon" data-lucide="info" class="w-4 h-4 text-brand-100 shrink-0"></i>
        <span id="role-banner-text">You are viewing the <strong>Student Portal</strong>. Raise a grievance or track
          real-time resolutions from campus authorities.</span>
      </div>
      <span class="text-brand-100/80 text-xs hidden md:inline">Tip: Toggle to Admin Dashboard anytime to resolve your
        submitted tickets.</span>
    </div>
  </div>


  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <!-- VIEW 1: STUDENT PORTAL                     -->
    <!-- ========================================== -->
    <section id="view-student" class="space-y-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Column: Raise a New Complaint Form -->
        <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
          <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/60 flex items-center justify-between">
            <div>
              <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="file-plus-2" class="w-5 h-5 text-brand-600"></i>
                Raise a New Complaint
              </h2>
              <p class="text-xs text-slate-500 mt-0.5">Submit an issue directly to the concerned campus department.</p>
            </div>
          </div>

          <form id="complaint-form" onsubmit="handleComplaintSubmit(event)" class="p-6 space-y-4">
            <!-- Anonymous Toggle -->
            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/80">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-slate-200/70 text-slate-700 flex items-center justify-center">
                  <i data-lucide="eye-off" class="w-4 h-4"></i>
                </div>
                <div>
                  <label for="is-anonymous" class="text-xs font-semibold text-slate-800 cursor-pointer block">Submit
                    Anonymously</label>
                  <span class="text-[11px] text-slate-500">Hide your name & ID from public logs</span>
                </div>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="is-anonymous" onchange="toggleAnonymousFields()" class="sr-only peer" />
                <div
                  class="w-10 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-600">
                </div>
              </label>
            </div>

            <!-- Student Identity Fields -->
            <div id="identity-fields" class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 transition-opacity duration-200">
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Student Name <span
                    class="text-rose-500">*</span></label>
                <input type="text" id="student-name" value="Aarav Sharma" required placeholder="e.g. Priya Patel"
                  class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Roll / ID Number <span
                    class="text-rose-500">*</span></label>
                <input type="text" id="student-id" value="CS-2026-084" required placeholder="e.g. CS-2026-084"
                  class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition" />
              </div>
            </div>

            <!-- Department / Location -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Hostel / Academic Block / Location <span
                  class="text-rose-500">*</span></label>
              <input type="text" id="student-location" required
                placeholder="e.g. Aryabhatta Hostel Room 204, or CSE Block Lab 3"
                class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition" />
            </div>

            <!-- Category & Priority -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Category <span
                    class="text-rose-500">*</span></label>
                <select id="complaint-category" required
                  class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition">
                  <option value="IT & Wi-Fi">IT & Wi-Fi</option>
                  <option value="Hostel & Mess">Hostel & Mess</option>
                  <option value="Academic & Labs">Academic & Labs</option>
                  <option value="Infrastructure & Maintenance">Infrastructure & Maintenance</option>
                  <option value="Library">Library</option>
                  <option value="Transport">Transport</option>
                  <option value="Security">Security</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Urgency / Priority <span
                    class="text-rose-500">*</span></label>
                <select id="complaint-priority" required
                  class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition">
                  <option value="Low">Low — Routine issue</option>
                  <option value="Medium" selected>Medium — Needs attention</option>
                  <option value="High">High — Disrupting work</option>
                  <option value="Urgent">Urgent — Safety / Critical</option>
                </select>
              </div>
            </div>

            <!-- Complaint Title -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Complaint Title <span
                  class="text-rose-500">*</span></label>
              <input type="text" id="complaint-title" required placeholder="Brief summary of the problem..."
                class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition" />
            </div>

            <!-- Detailed Description -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Detailed Description <span
                  class="text-rose-500">*</span></label>
              <textarea id="complaint-desc" rows="3" required
                placeholder="Describe when the issue started, exact room/equipment details, and any impact..."
                class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition resize-none"></textarea>
            </div>

            <button type="submit"
              class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 active:scale-[0.99] text-white font-semibold text-sm rounded-xl shadow-md shadow-brand-600/20 flex items-center justify-center gap-2 transition">
              <i data-lucide="send" class="w-4 h-4"></i>
              <span>Submit Complaint Ticket</span>
            </button>
          </form>
        </div>

        <!-- Right Column: Student Ticket Tracker -->
        <div class="lg:col-span-7 space-y-4">
          <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
              <div>
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                  <i data-lucide="ticket" class="w-5 h-5 text-brand-600"></i>
                  Campus & My Complaints Feed
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Track ticket statuses, assigned departments, and official
                  authority remarks.</p>
              </div>

              <!-- Status Filter Pills -->
              <div class="flex flex-wrap gap-1.5" id="student-status-filters">
                <button onclick="setStudentFilter('ALL')" data-filter="ALL"
                  class="student-filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-600 text-white transition">All</button>
                <button onclick="setStudentFilter('Pending')" data-filter="Pending"
                  class="student-filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Pending</button>
                <button onclick="setStudentFilter('In Progress')" data-filter="In Progress"
                  class="student-filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">In
                  Progress</button>
                <button onclick="setStudentFilter('Resolved')" data-filter="Resolved"
                  class="student-filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Resolved</button>
              </div>
            </div>
          </div>

          <!-- Tickets List Container -->
          <div id="student-tickets-list" class="space-y-4">
            <!-- Dynamically populated cards -->
          </div>
        </div>

      </div>
    </section>
  </main>

  <!-- ========================================== -->
  <!-- ADMIN SLIDE-OVER DRAWER (MANAGE TICKET)    -->
  <!-- ========================================== -->
  <div id="manage-drawer-backdrop" onclick="closeManageDrawer()"
    class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 hidden transition-opacity"></div>
  <aside id="manage-drawer"
    class="fixed top-0 right-0 h-full w-full max-w-lg bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">

    <!-- Drawer Header -->
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
      <div>
        <div class="flex items-center gap-2">
          <span id="drawer-ticket-id"
            class="text-xs font-mono font-bold px-2.5 py-0.5 rounded-md bg-brand-100 text-brand-800">CMP-2026-101</span>
          <span id="drawer-ticket-date" class="text-xs text-slate-500">Nov 12, 2026</span>
        </div>
        <h3 class="text-base font-bold text-slate-900 mt-1">Manage & Resolve Complaint</h3>
      </div>
      <button onclick="closeManageDrawer()"
        class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-200/70 transition">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <!-- Drawer Body -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">

      <!-- Complaint Read-Only Details Card -->
      <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 space-y-3">
        <div class="flex items-start justify-between gap-2">
          <h4 id="drawer-title" class="font-bold text-slate-900 text-base leading-snug">Title</h4>
          <span id="drawer-category-badge"
            class="shrink-0 text-xs font-medium px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-slate-700">Category</span>
        </div>
        <p id="drawer-desc" class="text-sm text-slate-600 leading-relaxed">Description goes here...</p>

        <div class="pt-2 border-t border-slate-200/80 grid grid-cols-2 gap-2 text-xs">
          <div>
            <span class="text-slate-400 block">Submitted By</span>
            <span id="drawer-student" class="font-semibold text-slate-800">Student Name</span>
          </div>
          <div>
            <span class="text-slate-400 block">Campus Location</span>
            <span id="drawer-location" class="font-semibold text-slate-800">Block / Room</span>
          </div>
        </div>
      </div>

      <!-- Authority Action Form -->
      <form id="manage-form" onsubmit="saveTicketChanges(event)" class="space-y-4">
        <input type="hidden" id="edit-ticket-id" />

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Ticket Status</label>
            <select id="edit-status"
              class="w-full px-3.5 py-2.5 text-sm font-medium rounded-xl border border-slate-300 bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none">
              <option value="Pending">Pending</option>
              <option value="In Progress">In Progress</option>
              <option value="Resolved">Resolved</option>
              <option value="Rejected">Rejected</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Priority Level</label>
            <select id="edit-priority"
              class="w-full px-3.5 py-2.5 text-sm font-medium rounded-xl border border-slate-300 bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none">
              <option value="Low">Low</option>
              <option value="Medium">Medium</option>
              <option value="High">High</option>
              <option value="Urgent">Urgent</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Assigned Department /
            Cell</label>
          <select id="edit-department"
            class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none">
            <option value="Unassigned">Unassigned</option>
            <option value="Network & IT Cell">Network & IT Cell</option>
            <option value="Chief Warden & Hostel Office">Chief Warden & Hostel Office</option>
            <option value="Estate & Civil Maintenance">Estate & Civil Maintenance</option>
            <option value="Dean Academics & Lab Support">Dean Academics & Lab Support</option>
            <option value="Central Library Committee">Central Library Committee</option>
            <option value="Campus Transport & Security">Campus Transport & Security</option>
          </select>
        </div>

        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Official Authority
              Remarks</label>
            <span class="text-[11px] text-slate-400">Visible to student</span>
          </div>
          <textarea id="edit-remarks" rows="4"
            placeholder="Enter action taken, technician dispatch ETA, or resolution notes..."
            class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none resize-none"></textarea>
        </div>

        <!-- Quick Canned Responses for Easy Testing -->
        <div>
          <span class="text-[11px] font-semibold text-slate-400 block mb-1.5">Quick Fill Templates:</span>
          <div class="flex flex-wrap gap-1.5">
            <button type="button"
              onclick="applyQuickRemark('Technician has been assigned and will inspect the site within 4 hours.')"
              class="text-xs px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition">+ Assign
              Technician</button>
            <button type="button"
              onclick="applyQuickRemark('Issue has been resolved and verified on-site. Please reopen if problem persists.')"
              class="text-xs px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 transition">+
              Mark Resolved</button>
          </div>
        </div>
      </form>

    </div>

    <!-- Drawer Footer -->
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex items-center justify-end gap-3">
      <button type="button" onclick="closeManageDrawer()"
        class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900 bg-white border border-slate-300 rounded-xl transition">Cancel</button>
      <button type="submit" form="manage-form"
        class="px-5 py-2 text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-xl shadow-md shadow-brand-600/20 flex items-center gap-2 transition">
        <i data-lucide="check" class="w-4 h-4"></i>
        <span>Update Ticket</span>
      </button>
    </div>
  </aside>

  <!-- ========================================== -->
  <!-- CUSTOM RESET CONFIRMATION MODAL            -->
  <!-- ========================================== -->
  <div id="reset-modal"
    class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-100 space-y-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
          <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
        </div>
        <div>
          <h3 class="text-base font-bold text-slate-900">Reset Demo Data?</h3>
          <p class="text-xs text-slate-500">This will restore the 6 sample campus complaints and clear any tickets you
            added or edited.</p>
        </div>
      </div>
      <div class="flex justify-end gap-2.5 pt-2">
        <button onclick="closeResetModal()"
          class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Cancel</button>
        <button onclick="confirmResetDemoData()"
          class="px-4 py-2 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition">Yes,
          Reset Data</button>
      </div>
    </div>
  </div>

  <!-- ========================================== -->
  <!-- TOAST NOTIFICATION CONTAINER               -->
  <!-- ========================================== -->
  <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2.5 pointer-events-none"></div>

  <!-- ========================================== -->
  <!-- APPLICATION LOGIC & MOCK DATA              -->
  <!-- ========================================== -->
  <script>
    const STORAGE_KEY = 'unifix_campus_complaints_v1';

    // Realistic initial dataset
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
    let currentRole = 'student';
    let studentStatusFilter = 'ALL';

    // Category color palette for visual chart
    const CATEGORY_COLORS = {
      'IT & Wi-Fi': 'bg-indigo-500',
      'Hostel & Mess': 'bg-amber-500',
      'Academic & Labs': 'bg-sky-500',
      'Infrastructure & Maintenance': 'bg-emerald-500',
      'Library': 'bg-purple-500',
      'Transport': 'bg-rose-500',
      'Security': 'bg-slate-600'
    };

    // Initialize Application
    document.addEventListener('DOMContentLoaded', () => {
      loadComplaints();
      renderAll();
      lucide.createIcons();
    });

    function loadComplaints() {
      try {
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
          complaints = JSON.parse(saved);
        } else {
          complaints = JSON.parse(JSON.stringify(DEFAULT_COMPLAINTS));
          saveComplaints();
        }
      } catch (e) {
        complaints = JSON.parse(JSON.stringify(DEFAULT_COMPLAINTS));
      }
    }

    function saveComplaints() {
      try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(complaints));
      } catch (e) {
        console.warn('LocalStorage unavailable:', e);
      }
    }

    function renderAll() {
      updateNavBadge();
      renderStudentTickets();
      renderAdminDashboard();
      lucide.createIcons();
    }

    // Role Switcher Logic
    function switchRole(role) {
      currentRole = role;
      const btnStudent = document.getElementById('btn-role-student');
      const btnAdmin = document.getElementById('btn-role-admin');
      const viewStudent = document.getElementById('view-student');
      const viewAdmin = document.getElementById('view-admin');
      const banner = document.getElementById('role-banner');
      const bannerText = document.getElementById('role-banner-text');

      if (role === 'student') {
        btnStudent.className = 'flex-1 sm:flex-initial flex items-center justify-center gap-2 px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-brand-700 shadow-sm';
        btnAdmin.className = 'flex-1 sm:flex-initial flex items-center justify-center gap-2 px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all duration-200 text-slate-600 hover:text-slate-900';
        viewStudent.classList.remove('hidden');
        viewAdmin.classList.add('hidden');
        banner.className = 'bg-brand-900 text-white text-xs sm:text-sm py-2.5 px-4 transition-colors duration-300';
        bannerText.innerHTML = 'You are viewing the <strong>Student Portal</strong>. Raise a grievance or track real-time resolutions from campus authorities.';
      } else {
        btnAdmin.className = 'flex-1 sm:flex-initial flex items-center justify-center gap-2 px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-slate-900 shadow-sm';
        btnStudent.className = 'flex-1 sm:flex-initial flex items-center justify-center gap-2 px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all duration-200 text-slate-600 hover:text-slate-900';
        viewAdmin.classList.remove('hidden');
        viewStudent.classList.add('hidden');
        banner.className = 'bg-slate-900 text-white text-xs sm:text-sm py-2.5 px-4 transition-colors duration-300';
        bannerText.innerHTML = 'You are viewing the <strong>Admin / Authority Dashboard</strong>. Click <em>Manage</em> on any ticket to assign departments and post resolutions.';
      }
      renderAll();
    }

    // Toggle Anonymous Student Inputs
    function toggleAnonymousFields() {
      const isAnon = document.getElementById('is-anonymous').checked;
      const fieldsDiv = document.getElementById('identity-fields');
      const nameInput = document.getElementById('student-name');
      const idInput = document.getElementById('student-id');

      if (isAnon) {
        fieldsDiv.classList.add('opacity-40', 'pointer-events-none');
        nameInput.required = false;
        idInput.required = false;
      } else {
        fieldsDiv.classList.remove('opacity-40', 'pointer-events-none');
        nameInput.required = true;
        idInput.required = true;
      }
    }

    // Generate Formatted Timestamp
    function getFormattedTimestamp() {
      const now = new Date();
      const datePart = now.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
      const timePart = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
      return `${datePart} · ${timePart}`;
    }

    // Handle Student New Complaint Submission
    function handleComplaintSubmit(event) {
      event.preventDefault();

      const isAnonymous = document.getElementById('is-anonymous').checked;
      const studentName = isAnonymous ? 'Anonymous Student' : document.getElementById('student-name').value.trim();
      const studentId = isAnonymous ? 'HIDDEN' : document.getElementById('student-id').value.trim();
      const location = document.getElementById('student-location').value.trim();
      const category = document.getElementById('complaint-category').value;
      const priority = document.getElementById('complaint-priority').value;
      const title = document.getElementById('complaint-title').value.trim();
      const description = document.getElementById('complaint-desc').value.trim();

      // Generate sequential ticket ID
      const nextNum = 101 + complaints.length;
      const newId = `CMP-2026-${nextNum}`;
      const timestamp = getFormattedTimestamp();

      const newTicket = {
        id: newId,
        studentName,
        studentId,
        isAnonymous,
        location,
        category,
        priority,
        title,
        description,
        status: 'Pending',
        assignedDept: 'Unassigned',
        remarks: '',
        createdAt: timestamp,
        updatedAt: timestamp
      };

      complaints.unshift(newTicket);
      saveComplaints();
      renderAll();

      // Reset fields (keep student name & ID convenient for next test)
      document.getElementById('student-location').value = '';
      document.getElementById('complaint-title').value = '';
      document.getElementById('complaint-desc').value = '';

      showToast(`Ticket <strong>${newId}</strong> submitted successfully!`, 'success');
    }

    // Badge Helpers
    function getStatusBadgeHTML(status) {
      const styles = {
        'Pending': 'bg-amber-50 text-amber-700 border-amber-200 dot-amber',
        'In Progress': 'bg-blue-50 text-blue-700 border-blue-200 dot-blue',
        'Resolved': 'bg-emerald-50 text-emerald-700 border-emerald-200 dot-emerald',
        'Rejected': 'bg-rose-50 text-rose-700 border-rose-200 dot-rose'
      };
      const dots = {
        'Pending': 'bg-amber-500',
        'In Progress': 'bg-blue-500',
        'Resolved': 'bg-emerald-500',
        'Rejected': 'bg-rose-500'
      };
      const cls = styles[status] || styles['Pending'];
      const dotCls = dots[status] || 'bg-slate-400';

      return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border ${cls}">
        <span class="w-1.5 h-1.5 rounded-full ${dotCls}"></span>
        ${status}
      </span>`;
    }

    function getPriorityBadgeHTML(priority) {
      const map = {
        'Low': 'bg-slate-100 text-slate-600',
        'Medium': 'bg-sky-50 text-sky-700',
        'High': 'bg-orange-50 text-orange-700',
        'Urgent': 'bg-rose-100 text-rose-700 font-bold'
      };
      return `<span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold ${map[priority] || map['Medium']}">${priority}</span>`;
    }

    // Student View Filtering & Rendering
    function setStudentFilter(filter) {
      studentStatusFilter = filter;
      document.querySelectorAll('.student-filter-btn').forEach(btn => {
        if (btn.dataset.filter === filter) {
          btn.className = 'student-filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-600 text-white transition';
        } else {
          btn.className = 'student-filter-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition';
        }
      });
      renderStudentTickets();
      lucide.createIcons();
    }

    function renderStudentTickets() {
      const container = document.getElementById('student-tickets-list');
      const filtered = studentStatusFilter === 'ALL'
        ? complaints
        : complaints.filter(c => c.status === studentStatusFilter);

      if (filtered.length === 0) {
        container.innerHTML = `
          <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center">
            <p class="text-sm font-semibold text-slate-700">No complaints under "${studentStatusFilter}"</p>
            <p class="text-xs text-slate-500 mt-1">Switch filter tabs above or submit a new ticket on the left.</p>
          </div>`;
        return;
      }

      container.innerHTML = filtered.map(ticket => `
        <article class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition-shadow space-y-3.5">
          <!-- Top Meta Row -->
          <div class="flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
              <span class="font-mono text-xs font-bold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">${ticket.id}</span>
              <span class="text-xs font-medium px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700">${ticket.category}</span>
              ${getPriorityBadgeHTML(ticket.priority)}
            </div>
            ${getStatusBadgeHTML(ticket.status)}
          </div>

          <!-- Title & Description -->
          <div>
            <h3 class="text-base font-bold text-slate-900 leading-snug">${escapeHTML(ticket.title)}</h3>
            <p class="text-sm text-slate-600 mt-1 leading-relaxed">${escapeHTML(ticket.description)}</p>
          </div>

          <!-- Location & Author Footer -->
          <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500 pt-1">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
              <span class="inline-flex items-center gap-1">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                ${escapeHTML(ticket.location)}
              </span>
              <span class="inline-flex items-center gap-1">
                <i data-lucide="user" class="w-3.5 h-3.5 text-slate-400"></i>
                ${escapeHTML(ticket.studentName)} ${ticket.isAnonymous ? '' : `(${escapeHTML(ticket.studentId)})`}
              </span>
            </div>
            <span>${ticket.createdAt}</span>
          </div>

          <!-- Official Authority Response Box (if remarks or department assigned) -->
          ${(ticket.remarks || ticket.assignedDept !== 'Unassigned') ? `
            <div class="mt-3 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1.5">
              <div class="flex items-center justify-between text-xs">
                <span class="font-bold text-slate-800 flex items-center gap-1.5">
                  <i data-lucide="shield-alert" class="w-3.5 h-3.5 text-brand-600"></i>
                  Official Authority Update
                </span>
                <span class="text-[11px] font-medium text-slate-500">Dept: ${escapeHTML(ticket.assignedDept)}</span>
              </div>
              <p class="text-xs text-slate-700 leading-relaxed">
                ${ticket.remarks ? escapeHTML(ticket.remarks) : '<span class="italic text-slate-400">Ticket assigned to department. Awaiting detailed remarks.</span>'}
              </p>
            </div>
          ` : ''}
        </article>
      `).join('');
    }

    // Admin Dashboard KPIs, Chart & Table Rendering
    function updateNavBadge() {
      const pendingCount = complaints.filter(c => c.status === 'Pending').length;
      document.getElementById('nav-pending-badge').textContent = pendingCount;
    }

    function renderAdminDashboard() {
      const total = complaints.length;
      const pending = complaints.filter(c => c.status === 'Pending').length;
      const inProgress = complaints.filter(c => c.status === 'In Progress').length;
      const resolved = complaints.filter(c => c.status === 'Resolved').length;
      const rate = total > 0 ? Math.round((resolved / total) * 100) : 0;

      document.getElementById('kpi-total').textContent = total;
      document.getElementById('kpi-pending').textContent = pending;
      document.getElementById('kpi-progress').textContent = inProgress;
      document.getElementById('kpi-resolved').textContent = resolved;
      document.getElementById('kpi-rate').textContent = `${rate}% resolution rate`;

      renderCategoryBreakdown();

      // Filter logic
      const query = document.getElementById('admin-search').value.toLowerCase().trim();
      const statusFilter = document.getElementById('admin-filter-status').value;
      const categoryFilter = document.getElementById('admin-filter-category').value;
      const priorityFilter = document.getElementById('admin-filter-priority').value;

      const filtered = complaints.filter(c => {
        const matchesQuery = !query ||
          c.id.toLowerCase().includes(query) ||
          c.title.toLowerCase().includes(query) ||
          c.studentName.toLowerCase().includes(query) ||
          c.location.toLowerCase().includes(query);
        const matchesStatus = statusFilter === 'ALL' || c.status === statusFilter;
        const matchesCat = categoryFilter === 'ALL' || c.category === categoryFilter;
        const matchesPrio = priorityFilter === 'ALL' || c.priority === priorityFilter;
        return matchesQuery && matchesStatus && matchesCat && matchesPrio;
      });

      const tbody = document.getElementById('admin-table-body');
      const emptyState = document.getElementById('admin-empty-state');

      if (filtered.length === 0) {
        tbody.innerHTML = '';
        emptyState.classList.remove('hidden');
        return;
      }

      emptyState.classList.add('hidden');
      tbody.innerHTML = filtered.map(c => `
        <tr class="hover:bg-slate-50/90 transition-colors group">
          <td class="py-3.5 px-4 align-top">
            <span class="font-mono text-xs font-bold text-slate-800">${c.id}</span>
            <span class="block text-[11px] text-slate-400 mt-0.5">${c.createdAt.split('·')[0]}</span>
          </td>
          <td class="py-3.5 px-4 align-top max-w-xs">
            <p class="font-semibold text-slate-900 line-clamp-1">${escapeHTML(c.title)}</p>
            <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">${escapeHTML(c.location)} · <span class="text-slate-600 font-medium">${escapeHTML(c.studentName)}</span></p>
          </td>
          <td class="py-3.5 px-4 align-top hidden md:table-cell">
            <span class="text-xs font-medium px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700">${c.category}</span>
          </td>
          <td class="py-3.5 px-4 align-top hidden sm:table-cell">
            ${getPriorityBadgeHTML(c.priority)}
          </td>
          <td class="py-3.5 px-4 align-top">
            ${getStatusBadgeHTML(c.status)}
          </td>
          <td class="py-3.5 px-4 align-top hidden lg:table-cell">
            <span class="text-xs ${c.assignedDept === 'Unassigned' ? 'text-slate-400 italic' : 'text-slate-700 font-medium'}">${escapeHTML(c.assignedDept)}</span>
          </td>
          <td class="py-3.5 px-4 align-top text-right">
            <button onclick="openManageDrawer('${c.id}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-brand-50 text-brand-700 hover:bg-brand-600 hover:text-white border border-brand-200/70 transition">
              <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5"></i>
              <span>Manage</span>
            </button>
          </td>
        </tr>
      `).join('');

      lucide.createIcons();
    }

    function renderCategoryBreakdown() {
      const bar = document.getElementById('category-breakdown-bar');
      const legend = document.getElementById('category-breakdown-legend');
      const total = complaints.length;

      if (total === 0) {
        bar.innerHTML = '';
        legend.innerHTML = '<span class="text-slate-400">No tickets available.</span>';
        return;
      }

      const counts = {};
      complaints.forEach(c => {
        counts[c.category] = (counts[c.category] || 0) + 1;
      });

      const entries = Object.entries(counts).sort((a, b) => b[1] - a[1]);

      bar.innerHTML = entries.map(([cat, count]) => {
        const pct = (count / total) * 100;
        const color = CATEGORY_COLORS[cat] || 'bg-slate-400';
        return `<div style="width: ${pct}%" class="${color} h-full transition-all duration-500" title="${cat}: ${count}"></div>`;
      }).join('');

      legend.innerHTML = entries.map(([cat, count]) => {
        const color = CATEGORY_COLORS[cat] || 'bg-slate-400';
        return `
          <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full ${color}"></span>
            <span class="font-medium text-slate-700">${cat}</span>
            <span class="text-slate-400">(${count})</span>
          </div>`;
      }).join('');
    }

    // Slide-Over Drawer Controls
    function openManageDrawer(ticketId) {
      const ticket = complaints.find(c => c.id === ticketId);
      if (!ticket) return;

      document.getElementById('edit-ticket-id').value = ticket.id;
      document.getElementById('drawer-ticket-id').textContent = ticket.id;
      document.getElementById('drawer-ticket-date').textContent = ticket.createdAt;
      document.getElementById('drawer-title').textContent = ticket.title;
      document.getElementById('drawer-desc').textContent = ticket.description;
      document.getElementById('drawer-category-badge').textContent = ticket.category;
      document.getElementById('drawer-student').textContent = ticket.isAnonymous
        ? 'Anonymous Student'
        : `${ticket.studentName} (${ticket.studentId})`;
      document.getElementById('drawer-location').textContent = ticket.location;

      document.getElementById('edit-status').value = ticket.status;
      document.getElementById('edit-priority').value = ticket.priority;
      document.getElementById('edit-department').value = ticket.assignedDept;
      document.getElementById('edit-remarks').value = ticket.remarks || '';

      const backdrop = document.getElementById('manage-drawer-backdrop');
      const drawer = document.getElementById('manage-drawer');
      backdrop.classList.remove('hidden');
      requestAnimationFrame(() => {
        drawer.classList.remove('translate-x-full');
      });
      lucide.createIcons();
    }

    function closeManageDrawer() {
      const backdrop = document.getElementById('manage-drawer-backdrop');
      const drawer = document.getElementById('manage-drawer');
      drawer.classList.add('translate-x-full');
      setTimeout(() => {
        backdrop.classList.add('hidden');
      }, 280);
    }

    function applyQuickRemark(text) {
      const textarea = document.getElementById('edit-remarks');
      textarea.value = text;
      textarea.focus();
    }

    function saveTicketChanges(event) {
      event.preventDefault();
      const id = document.getElementById('edit-ticket-id').value;
      const index = complaints.findIndex(c => c.id === id);
      if (index === -1) return;

      complaints[index].status = document.getElementById('edit-status').value;
      complaints[index].priority = document.getElementById('edit-priority').value;
      complaints[index].assignedDept = document.getElementById('edit-department').value;
      complaints[index].remarks = document.getElementById('edit-remarks').value.trim();
      complaints[index].updatedAt = getFormattedTimestamp();

      saveComplaints();
      renderAll();
      closeManageDrawer();
      showToast(`Updated <strong>${id}</strong> to <strong>${complaints[index].status}</strong>.`, 'info');
    }

    // Reset Modal Controls
    function openResetModal() {
      document.getElementById('reset-modal').classList.remove('hidden');
    }

    function closeResetModal() {
      document.getElementById('reset-modal').classList.add('hidden');
    }

    function confirmResetDemoData() {
      complaints = JSON.parse(JSON.stringify(DEFAULT_COMPLAINTS));
      saveComplaints();
      renderAll();
      closeResetModal();
      showToast('Demo dataset restored to initial state.', 'success');
    }

    // Toast Notification Utility
    function showToast(htmlMessage, type = 'success') {
      const container = document.getElementById('toast-container');
      const toast = document.createElement('div');
      const iconName = type === 'success' ? 'check-circle-2' : 'info';
      const accent = type === 'success' ? 'border-emerald-500 text-emerald-600' : 'border-brand-500 text-brand-600';

      toast.className = `pointer-events-auto bg-white border-l-4 ${accent} shadow-xl rounded-xl px-4 py-3 flex items-center gap-3 text-sm text-slate-800 max-w-sm transition-all duration-300 translate-y-2 opacity-0`;
      toast.innerHTML = `
        <i data-lucide="${iconName}" class="w-5 h-5 shrink-0"></i>
        <span class="leading-snug">${htmlMessage}</span>
      `;

      container.appendChild(toast);
      lucide.createIcons();

      requestAnimationFrame(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
      });

      setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => toast.remove(), 300);
      }, 3500);
    }

    // Logout handler
    function handleLogout() {
      const shouldLogout = confirm('Are you sure you want to log out?');
      if (shouldLogout) {
        window.location.href = 'login.html';
      }
    }

    // Prevent XSS on user inputs
    function escapeHTML(str) {
      if (!str) return '';
      return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }
  </script>

<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: index.php");
    exit;
}
$username = $_SESSION['user_name'];
?>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    // Inject username if element exists
    const userEl = document.querySelector('#userName, .user-name, [data-user-name]');
    if(userEl) userEl.textContent = "<?php echo $username; ?>";

    // Fetch and render complaints dynamically
    async function loadComplaints() {
        try {
            const res = await fetch('api/get_complaints.php');
            const data = await res.json();
            if (data.success) {
                const container = document.querySelector('#complaintsTableBody, #complaintsList, .complaints-container');
                // If the frontend has a rendering function, we update or populate tables
                console.log("Loaded complaints:", data.complaints);
            }
        } catch(e) { console.error(e); }
    }
    loadComplaints();

    // Handle complaint form submission
    const complaintForm = document.querySelector('form#complaintForm, form.complaint-form, #newComplaintModal form');
    if (complaintForm) {
        complaintForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(complaintForm);
            try {
                const res = await fetch('api/create_complaint.php', { method: 'POST', body: formData });
                const data = await res.json();
                alert(data.message);
                if (data.success) {
                    complaintForm.reset();
                    location.reload();
                }
            } catch(err) { console.error(err); alert('Error submitting complaint.'); }
        });
    }
});
</script>
</body>


</html>