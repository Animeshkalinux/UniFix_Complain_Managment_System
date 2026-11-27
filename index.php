<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UniFix — Welcome & Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --brand: #4f46e5;
      --brand-dark: #4338ca;
      --brand-soft: #eef2ff;
      --slate-50: #f8fafc;
      --slate-100: #f1f5f9;
      --slate-200: #e2e8f0;
      --slate-300: #cbd5e1;
      --slate-500: #64748b;
      --slate-600: #475569;
      --slate-700: #334155;
      --slate-800: #1e293b;
      --slate-900: #0f172a;
      --green: #059669;
      --red: #e11d48;
      --amber: #d97706;
      --shadow: 0 10px 30px rgba(15, 23, 42, .08);
    }

    * {
      box-sizing: border-box
    }

    body {
      margin: 0;
      min-height: 100vh;
      background: var(--slate-50);
      color: var(--slate-800);
      font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      -webkit-font-smoothing: antialiased;
    }

    button,
    input,
    select {
      font: inherit
    }

    button {
      cursor: pointer
    }

    .navbar {
      position: sticky;
      top: 0;
      z-index: 20;
      height: 72px;
      background: rgba(255, 255, 255, .96);
      border-bottom: 1px solid var(--slate-200);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 5.5%;
      backdrop-filter: blur(12px);
    }

    .brand-wrap {
      display: flex;
      align-items: center;
      gap: 12px
    }

    .brand-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;

      color: #fff;
      display: grid;
      place-items: center;
      box-shadow: 0 5px 12px rgba(79, 70, 229, .22);
    }

    .brand-icon img {
      width: 42px;
      height: 42px;
      object-fit: contain;
      border-radius: 12px
    }

    .brand-icon svg {
      width: 23px;
      height: 23px
    }

    .brand-name {
      font-size: 19px;
      font-weight: 800;
      letter-spacing: -.03em;
      color: var(--slate-900)
    }

    .brand-sub {
      font-size: 11px;
      color: var(--slate-500);
      margin-top: 2px
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 4px;
      background: #f8fafc;
      border: 1px solid var(--slate-200);
      border-radius: 13px;
      padding: 4px;
    }

    .nav-btn {
      border: 0;
      background: transparent;
      color: var(--slate-600);
      padding: 9px 13px;
      border-radius: 9px;
      font-size: 13px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 7px;
      transition: .2s;
    }

    .nav-btn:hover {
      background: #fff;
      color: var(--slate-900);
      box-shadow: 0 2px 8px rgba(15, 23, 42, .06)
    }

    .nav-btn.active {
      background: #fff;
      color: var(--brand);
      box-shadow: 0 2px 8px rgba(15, 23, 42, .08)
    }

    .nav-btn svg {
      width: 16px;
      height: 16px
    }

    .page {
      width: min(1180px, 90%);
      margin: 0 auto;
      padding: 52px 0 70px
    }

    .hero {
      text-align: center;
      max-width: 800px;
      margin: 0 auto 38px
    }

    .eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 7px 12px;
      border-radius: 999px;
      background: var(--brand-soft);
      color: var(--brand);
      font-size: 12px;
      font-weight: 700;
      margin-bottom: 15px;
    }

    .hero h1 {
      margin: 0;
      color: var(--slate-900);
      font-size: clamp(30px, 5vw, 48px);
      line-height: 1.08;
      letter-spacing: -.045em;
    }

    .hero h1 span {
      color: var(--brand)
    }

    .hero p {
      margin: 16px auto 0;
      max-width: 690px;
      color: var(--slate-500);
      font-size: 15px;
      line-height: 1.7;
    }

    .role-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 18px;
      max-width: 1000px;
      margin: 0 auto;
    }

    .role-card {
      background: #fff;
      border: 1px solid var(--slate-200);
      border-radius: 18px;
      padding: 25px;
      box-shadow: 0 4px 16px rgba(15, 23, 42, .04);
      text-align: left;
      transition: .22s;
      position: relative;
      overflow: hidden;
    }

    .role-card:hover {
      transform: translateY(-3px);
      border-color: #c7d2fe;
      box-shadow: var(--shadow);
    }

    .role-card.selected {
      border-color: #818cf8;
      box-shadow: 0 0 0 3px #e0e7ff, var(--shadow)
    }

    .role-icon {
      width: 48px;
      height: 48px;
      border-radius: 13px;
      background: var(--brand-soft);
      color: var(--brand);
      display: grid;
      place-items: center;
      margin-bottom: 18px;
    }

    .role-icon svg {
      width: 25px;
      height: 25px
    }

    .role-card h2 {
      margin: 0;
      color: var(--slate-900);
      font-size: 18px
    }

    .role-card p {
      color: var(--slate-500);
      font-size: 13px;
      line-height: 1.6;
      margin: 9px 0 18px
    }

    .role-select {
      width: 100%;
      border: 1px solid var(--slate-200);
      background: #fff;
      color: var(--brand);
      padding: 10px 13px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      transition: .2s;
    }

    .role-select:hover {
      background: var(--brand-soft);
      border-color: #c7d2fe
    }

    .role-arrow {
      position: absolute;
      right: 21px;
      bottom: 29px;
      color: var(--brand);
      pointer-events: none;
    }

    .hint {
      text-align: center;
      color: var(--slate-500);
      font-size: 12px;
      margin-top: 22px;
    }

    .auth-wrap {
      display: none;
      max-width: 900px;
      margin: 0 auto
    }

    .auth-wrap.show {
      display: block;
      animation: fadeUp .28s ease
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(8px)
      }

      to {
        opacity: 1;
        transform: none
      }
    }

    .auth-card {
      background: #fff;
      border: 1px solid var(--slate-200);
      border-radius: 20px;
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    .auth-head {
      padding: 26px 30px 22px;
      border-bottom: 1px solid var(--slate-200);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 15px;
    }

    .auth-head h2 {
      margin: 0;
      font-size: 20px;
      color: var(--slate-900)
    }

    .auth-head p {
      margin: 5px 0 0;
      color: var(--slate-500);
      font-size: 12px
    }

    .selected-role {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 8px 11px;
      border-radius: 999px;
      background: var(--brand-soft);
      color: var(--brand);
      font-size: 12px;
      font-weight: 700;
      white-space: nowrap;
    }

    .tabs {
      display: flex;
      gap: 4px;
      padding: 14px 30px 0
    }

    .tab {
      border: 0;
      background: transparent;
      color: var(--slate-500);
      padding: 10px 14px;
      border-bottom: 2px solid transparent;
      font-size: 13px;
      font-weight: 700;
    }

    .tab.active {
      color: var(--brand);
      border-bottom-color: var(--brand)
    }

    .form {
      padding: 24px 30px 30px
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 17px
    }

    .field {
      display: flex;
      flex-direction: column;
      gap: 7px
    }

    .field.full {
      grid-column: 1/-1
    }

    label {
      font-size: 12px;
      font-weight: 700;
      color: var(--slate-700)
    }

    .required {
      color: var(--red)
    }

    input,
    select.form-control {
      width: 100%;
      height: 44px;
      border: 1px solid var(--slate-200);
      border-radius: 10px;
      background: #fff;
      color: var(--slate-800);
      padding: 0 13px;
      outline: none;
      font-size: 13px;
      transition: .18s;
    }

    input::placeholder {
      color: #94a3b8
    }

    input:focus,
    select.form-control:focus {
      border-color: #818cf8;
      box-shadow: 0 0 0 3px #eef2ff;
    }

    .password-wrap {
      position: relative
    }

    .password-wrap input {
      padding-right: 45px
    }

    .eye {
      position: absolute;
      right: 9px;
      top: 50%;
      transform: translateY(-50%);
      border: 0;
      background: transparent;
      color: var(--slate-500);
      padding: 6px;
      display: grid;
      place-items: center;
    }

    .eye svg {
      width: 17px;
      height: 17px
    }

    .form-actions {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-top: 23px;
      padding-top: 20px;
      border-top: 1px solid var(--slate-100);
    }

    .secondary {
      border: 1px solid var(--slate-200);
      background: #fff;
      color: var(--slate-600);
      padding: 11px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
    }

    .secondary:hover {
      background: var(--slate-50)
    }

    .primary {
      border: 0;
      background: var(--brand);
      color: #fff;
      padding: 11px 21px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      box-shadow: 0 5px 12px rgba(79, 70, 229, .2);
      transition: .2s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .primary:hover {
      background: var(--brand-dark);
      transform: translateY(-1px)
    }

    .switch-auth {
      margin-top: 16px;
      text-align: center;
      color: var(--slate-500);
      font-size: 12px;
    }

    .link-btn {
      border: 0;
      background: transparent;
      color: var(--brand);
      font-weight: 700;
      padding: 0;
      text-decoration: underline;
      text-underline-offset: 2px;
    }

    .back-row {
      margin-bottom: 15px
    }

    .back-btn {
      border: 0;
      background: transparent;
      color: var(--slate-500);
      font-size: 12px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .back-btn:hover {
      color: var(--brand)
    }

    .notice {
      display: none;
      padding: 11px 13px;
      border-radius: 10px;
      margin-bottom: 16px;
      font-size: 12px;
      line-height: 1.5;
    }

    .notice.show {
      display: block
    }

    .notice.error {
      background: #fff1f2;
      color: #be123c;
      border: 1px solid #fecdd3
    }

    .notice.success {
      background: #ecfdf5;
      color: #047857;
      border: 1px solid #a7f3d0
    }

    .footer {
      text-align: center;
      color: #94a3b8;
      font-size: 11px;
      margin-top: 28px;
    }

    .toast {
      position: fixed;
      right: 22px;
      bottom: 22px;
      z-index: 50;
      background: var(--slate-900);
      color: #fff;
      padding: 12px 15px;
      border-radius: 11px;
      font-size: 12px;
      box-shadow: 0 10px 25px rgba(15, 23, 42, .22);
      transform: translateY(20px);
      opacity: 0;
      pointer-events: none;
      transition: .25s;
      max-width: 360px;
    }

    .toast.show {
      transform: none;
      opacity: 1
    }

    .demo-note {
      margin-top: 17px;
      padding: 11px 13px;
      border-radius: 10px;
      background: var(--slate-50);
      border: 1px solid var(--slate-200);
      color: var(--slate-500);
      font-size: 11px;
      line-height: 1.55;
    }

    @media(max-width:850px) {
      .navbar {
        padding: 0 3%
      }

      .nav-btn {
        padding: 8px 9px;
        font-size: 12px
      }

      .brand-sub {
        display: none
      }

      .page {
        width: 94%
      }

      .role-grid {
        grid-template-columns: 1fr
      }

      .role-card {
        padding: 20px
      }
    }

    @media(max-width:650px) {
      .navbar {
        height: auto;
        min-height: 70px;
        flex-wrap: wrap;
        padding: 10px 4%;
        gap: 8px
      }

      .nav-actions {
        width: 100%;
        justify-content: stretch
      }

      .nav-btn {
        flex: 1;
        justify-content: center
      }

      .hero {
        margin-top: 10px
      }

      .form-grid {
        grid-template-columns: 1fr
      }

      .field.full {
        grid-column: auto
      }

      .auth-head {
        align-items: flex-start;
        flex-direction: column
      }

      .form {
        padding: 20px
      }

      .tabs {
        padding-left: 20px;
        padding-right: 20px
      }

      .form-actions {
        flex-direction: column-reverse;
        align-items: stretch
      }

      .primary,
      .secondary {
        width: 100%;
        justify-content: center
      }
    }
  </style>
</head>

<body>

  <header class="navbar">
    <div class="brand-wrap">
      <div class="brand-icon" aria-hidden="true">
        <img src="logo.png" alt="">

      </div>
      <div>
        <div class="brand-name">UniFix</div>
        <div class="brand-sub">Campus Complaint Management System</div>
      </div>
    </div>

    <div class="nav-actions">

    </div>
  </header>

  <main class="page">
    <section id="welcomeView">
      <div class="hero">
        <div class="eyebrow">
          <span>●</span> One platform. Every campus concern.
        </div>
        <h1>Welcome to <span>UniFix</span></h1>
        <p>
          Your one-stop place to <strong>report, resolve and organise</strong> university problems.
          Choose your portal below to continue securely.
        </p>
      </div>

      <div class="role-grid">
        <article class="role-card" id="card-student">
          <div class="role-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
              <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
            </svg>
          </div>
          <h2>Student</h2>
          <p>Report campus issues, track your complaints and follow resolution updates.</p>
          <button class="role-select" onclick="chooseRole('student')">Continue as Student <span>→</span></button>
        </article>

        <article class="role-card" id="card-staff">
          <div class="role-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" />
              <path
                d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-1.8 1.8-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V20h-2.5v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1-1.8-1.8.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H6v-2.5h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1 1.8-1.8.1.1a1.7 1.7 0 0 0 1.9.3 1.7 1.7 0 0 0 1-1.6V5h2.5v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1 1.8 1.8-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1h.1v2.5h-.1a1.7 1.7 0 0 0-1.6 1Z" />
            </svg>
          </div>
          <h2>Staff</h2>
          <p>Manage assigned complaints, update status and provide official remarks.</p>
          <button class="role-select" onclick="chooseRole('staff')">Continue as Staff <span>→</span></button>
        </article>

        <article class="role-card" id="card-admin">
          <div class="role-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="7" height="7" rx="1" />
              <rect x="14" y="3" width="7" height="7" rx="1" />
              <rect x="3" y="14" width="7" height="7" rx="1" />
              <rect x="14" y="14" width="7" height="7" rx="1" />
            </svg>
          </div>
          <h2>Admin</h2>
          <p>Oversee complaints, assign departments, monitor progress and manage resolutions.</p>
          <button class="role-select" onclick="chooseRole('admin')">Continue as Admin <span>→</span></button>
        </article>
      </div>

      <div class="hint">Select a portal to open the UniFix secure sign-in page.</div>
    </section>

    <section class="auth-wrap" id="authView">
      <div class="back-row">
        <button class="back-btn" onclick="backToRoles()">← Back to portal selection</button>
      </div>

      <div class="auth-card">
        <div class="auth-head">
          <div>
            <h2 id="authTitle">Sign in to UniFix</h2>
            <p id="authSubtitle">Use your registered UniFix account to continue.</p>
          </div>
          <div class="selected-role" id="selectedRoleBadge">Student</div>
        </div>

        <div class="tabs">
          <button class="tab active" id="signInTab" onclick="showAuth('signin')">Sign In</button>
          <button class="tab" id="signUpTab" onclick="showAuth('signup')">New User? Get Registered</button>
        </div>

        <div class="form">
          <div class="notice" id="notice"></div>

          <form id="signinForm" onsubmit="handleSignIn(event)">
            <div class="form-grid">
              <div class="field">
                <label>Full Name <span class="required">*</span></label>
                <input id="loginName" type="text" placeholder="Enter your full name" autocomplete="name" required>
              </div>
              <div class="field">
                <label>Registered ID <span class="required">*</span></label>
                <input id="loginId" type="text" placeholder="Student / Staff / Admin ID" required>
              </div>
              <div class="field">
                <label>Email ID <span class="required">*</span></label>
                <input id="loginEmail" type="email" placeholder="Enter your email address" autocomplete="email"
                  required>
              </div>
              <div class="field">
                <label>Password <span class="required">*</span></label>
                <div class="password-wrap">
                  <input id="loginPassword" type="password" placeholder="Type your password"
                    autocomplete="current-password" required>
                  <button type="button" class="eye" onclick="togglePassword('loginPassword',this)"
                    aria-label="Show password">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" />
                      <circle cx="12" cy="12" r="2.5" />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="field full">
                <label>Role <span class="required">*</span></label>
                <select class="form-control" id="loginRole" required>
                  <option value="student">Student</option>
                  <option value="staff">Staff</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>

            <div class="form-actions">
              <button type="button" class="secondary" onclick="showAuth('signup')">New user? Get registered</button>
              <button type="submit" class="primary">
                Sign In
                <span>→</span>
              </button>
            </div>
            <div class="demo-note">
              Demo frontend mode: registered accounts are stored locally in this browser for testing.
              The PHP/MySQL authentication will replace this local storage when the backend is connected.
            </div>
          </form>

          <form id="signupForm" style="display:none" onsubmit="handleSignUp(event)">
            <div class="form-grid">
              <div class="field">
                <label>Full Name <span class="required">*</span></label>
                <input id="signupName" type="text" placeholder="Enter your full name" autocomplete="name" required>
              </div>
              <div class="field">
                <label>Email ID <span class="required">*</span></label>
                <input id="signupEmail" type="email" placeholder="Enter your email address" autocomplete="email"
                  required>
              </div>
              <div class="field">
                <label>Phone Number <span class="required">*</span></label>
                <input id="signupPhone" type="tel" placeholder="Enter your phone number" autocomplete="tel" required>
              </div>
              <div class="field">
                <label>Registered ID <span class="required">*</span></label>
                <input id="signupId" type="text" placeholder="Student / Staff / Admin ID" required>
              </div>
              <div class="field">
                <label>Password <span class="required">*</span></label>
                <div class="password-wrap">
                  <input id="signupPassword" type="password" placeholder="Create a password" autocomplete="new-password"
                    required>
                  <button type="button" class="eye" onclick="togglePassword('signupPassword',this)"
                    aria-label="Show password">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" />
                      <circle cx="12" cy="12" r="2.5" />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="field">
                <label>Confirm Password <span class="required">*</span></label>
                <div class="password-wrap">
                  <input id="signupConfirm" type="password" placeholder="Confirm your password"
                    autocomplete="new-password" required>
                  <button type="button" class="eye" onclick="togglePassword('signupConfirm',this)"
                    aria-label="Show password">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" />
                      <circle cx="12" cy="12" r="2.5" />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="field full">
                <label>Role <span class="required">*</span></label>
                <select class="form-control" id="signupRole" required>
                  <option value="student">Student</option>
                  <option value="staff">Staff</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>

            <div class="form-actions">
              <button type="button" class="secondary" onclick="showAuth('signin')">Already registered? Sign in</button>
              <button type="submit" class="primary">
                Sign Up
                <span>→</span>
              </button>
            </div>
            <div class="demo-note">
              In the current frontend version, registration is stored locally only for demonstration.
              We will later move users, passwords and roles into the secure PHP/MySQL authentication system.
            </div>
          </form>
        </div>
      </div>
    </section>

    <div class="footer">UniFix • Campus Complaint Management System</div>
  </main>

  <div class="toast" id="toast"></div>

  <script>
    let selectedRole = "student";

    const roleNames = { student: "Student", staff: "Staff", admin: "Admin" };

    function chooseRole(role) {
      selectedRole = role;
      document.querySelectorAll(".nav-btn").forEach(b => b.classList.toggle("active", b.dataset.role === role));
      document.querySelectorAll(".role-card").forEach(c => c.classList.remove("selected"));
      const card = document.getElementById("card-" + role);
      if (card) card.classList.add("selected");

      document.getElementById("welcomeView").style.display = "none";
      document.getElementById("authView").classList.add("show");
      document.getElementById("selectedRoleBadge").textContent = roleNames[role];
      document.getElementById("loginRole").value = role;
      document.getElementById("signupRole").value = role;
      clearNotice();
      showAuth("signin");
      window.scrollTo({ top: 0, behavior: "smooth" });
    }

    function backToRoles() {
      document.getElementById("authView").classList.remove("show");
      document.getElementById("welcomeView").style.display = "block";
      document.querySelectorAll(".nav-btn").forEach(b => b.classList.remove("active"));
      document.querySelectorAll(".role-card").forEach(c => c.classList.remove("selected"));
      clearNotice();
      window.scrollTo({ top: 0, behavior: "smooth" });
    }

    function showAuth(type) {
      const signin = type === "signin";
      document.getElementById("signinForm").style.display = signin ? "block" : "none";
      document.getElementById("signupForm").style.display = signin ? "none" : "block";
      document.getElementById("signInTab").classList.toggle("active", signin);
      document.getElementById("signUpTab").classList.toggle("active", !signin);
      document.getElementById("authTitle").textContent = signin ? "Sign in to UniFix" : "Create your UniFix account";
      document.getElementById("authSubtitle").textContent = signin
        ? "Use your registered UniFix account to continue."
        : "Register once to access the appropriate UniFix portal.";
      clearNotice();
      if (!signin) document.getElementById("signupRole").value = selectedRole;
      else document.getElementById("loginRole").value = selectedRole;
    }

    function togglePassword(id, btn) {
      const input = document.getElementById(id);
      input.type = input.type === "password" ? "text" : "password";
      btn.setAttribute("aria-label", input.type === "password" ? "Show password" : "Hide password");
    }

    function getUsers() {
      try { return JSON.parse(localStorage.getItem("unifixUsers") || "[]"); }
      catch (e) { return []; }
    }

    function saveUsers(users) {
      localStorage.setItem("unifixUsers", JSON.stringify(users));
    }

    function handleSignUp(e) {
      e.preventDefault();
      clearNotice();

      const name = document.getElementById("signupName").value.trim();
      const email = document.getElementById("signupEmail").value.trim().toLowerCase();
      const phone = document.getElementById("signupPhone").value.trim();
      const id = document.getElementById("signupId").value.trim().toLowerCase();
      const password = document.getElementById("signupPassword").value;
      const confirm = document.getElementById("signupConfirm").value;
      const role = document.getElementById("signupRole").value;

      if (password !== confirm) {
        return showNotice("Passwords do not match. Please check both password fields.", "error");
      }
      if (password.length < 6) {
        return showNotice("Password should contain at least 6 characters.", "error");
      }

      const users = getUsers();
      const duplicate = users.some(u => u.email === email || u.id === id);
      if (duplicate) {
        return showNotice("An account with this Email ID or Registered ID already exists.", "error");
      }

      users.push({ name, email, phone, id, password, role });
      saveUsers(users);

      document.getElementById("signupForm").reset();
      selectedRole = role;
      document.getElementById("loginRole").value = role;
      showAuth("signin");
      document.getElementById("loginName").value = name;
      document.getElementById("loginId").value = id;
      document.getElementById("loginEmail").value = email;
      showNotice("Registration successful. Please enter your password to sign in.", "success");
      showToast("Account registered successfully.");
    }

    function handleSignIn(e) {
      e.preventDefault();
      clearNotice();

      const name = document.getElementById("loginName").value.trim().toLowerCase();
      const id = document.getElementById("loginId").value.trim().toLowerCase();
      const email = document.getElementById("loginEmail").value.trim().toLowerCase();
      const password = document.getElementById("loginPassword").value;
      const role = document.getElementById("loginRole").value;

      const users = getUsers();
      const user = users.find(u =>
        u.name.toLowerCase() === name &&
        u.id === id &&
        u.email === email &&
        u.password === password &&
        u.role === role
      );

      if (!user) {
        return showNotice("Sign-in details could not be verified. Check your Name, Registered ID, Email, Password and Role.", "error");
      }

      localStorage.setItem("unifixCurrentUser", JSON.stringify({
        name: user.name, id: user.id, email: user.email, role: user.role
      }));

      showNotice("Sign-in successful. " + roleNames[role] + " portal access verified.", "success");
      showToast("Welcome back, " + user.name + "!");
    }

    function showNotice(message, type) {
      const box = document.getElementById("notice");
      box.textContent = message;
      box.className = "notice show " + type;
    }

    function clearNotice() {
      const box = document.getElementById("notice");
      box.textContent = "";
      box.className = "notice";
    }

    function showToast(message) {
      const t = document.getElementById("toast");
      t.textContent = message;
      t.classList.add("show");
      clearTimeout(window.__toastTimer);
      window.__toastTimer = setTimeout(() => t.classList.remove("show"), 2800);
    }
  </script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Handle Login Form
    const loginForm = document.querySelector('form[action*="login"]') || document.querySelector('#loginForm') || document.forms[0];
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            try {
                const res = await fetch('api/login.php', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'Login failed');
                }
            } catch (err) {
                console.error(err);
                alert('An error occurred during login.');
            }
        });
    }

    // Handle Register Form
    const registerForm = document.querySelector('form[action*="register"]') || document.querySelector('#registerForm') || document.forms[1];
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(registerForm);
            try {
                const res = await fetch('api/register.php', { method: 'POST', body: formData });
                const data = await res.json();
                alert(data.message);
                if (data.success) {
                    location.reload();
                }
            } catch (err) {
                console.error(err);
                alert('An error occurred during registration.');
            }
        });
    }
});
</script>
</body>


</html>