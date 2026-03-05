# Hima Plus Android Issues - Action Plan

## 1) Report Header
- App Name: Hima Plus
- App Owner: Majed Al-Asiri
- Report Prepared By: Abdulaziz bin Nawaf Khalid Al-Otaibi
- Target Platform: Android
- Purpose: Convert test findings into an actionable implementation checklist.

## 2) Executive Summary
This file organizes the reported technical, UX, and security findings into clear implementation tasks with priorities and acceptance checks.

## 3) Issue Register (Backlog)

| ID | Issue | Area | Severity | Risk/Impact | Status |
|---|---|---|---|---|---|
| SEC-01 | Email accepted without verification | Registration / Login | High | Untrusted/fake accounts, account abuse risk | DONE (Backend) |
| ACC-01 | No phone option in "Forgot Code" | Account Recovery | Medium | Users may fail to recover accounts | DONE (Backend API) |
| SEC-02 | OTP sent to wrong phone number | Login / OTP | Critical | Direct account takeover risk | DONE (Backend API) |
| UX-01 | Contact Us page partially broken | Contact Us | Low | Support friction; poor trust | TODO |
| PERF-01 | App performance is slow | General UX | Medium | High drop-off and poor user experience | TODO |
| DOC-01 | No in-app user guide | UX / Help | Low | Users cannot discover features easily | TODO |
| LEG-01 | Privacy policy / Terms unclear | Legal / Compliance | High | Compliance and trust risk | TODO |
| DOC-02 | No changelog / update history | Product Communication | Low | Low transparency to users | TODO |
| SEC-03 | Sensitive data stored without encryption | Data Security | Critical | Data exposure risk if DB/storage leaked | IN PROGRESS (OTP/Reset secured) |
| SEC-04 | Links/files open without verification | File/Link Handling | High | Malicious content and abuse risk | TODO |
| SEC-05 | Weak password acceptance | Authentication | High | Easy account compromise by guessing | DONE (Backend) |
| SEC-06 | User data visible without proper access control | Authorization | Critical | Privacy breach and data leakage | PARTIAL (Critical API endpoints fixed) |
| SEC-07 | No login attempt limit (rate limiting) | Authentication | Critical | Brute-force and credential stuffing | DONE (Backend) |
| SEC-08 | No alert after repeated failed password attempts | Authentication | Medium | Delayed detection of attack attempts | DONE (Backend API) |
| SEC-09 | No security warning on public Wi-Fi usage | Client Security UX | Low | User security awareness gap | TODO |

## 4) Priority Roadmap

### Phase 1 - Critical (Immediate)
- [x] SEC-02: Fix OTP routing to ensure code reaches only the verified user number.
- [ ] SEC-03: Encrypt sensitive data at rest and in transit.
- [ ] SEC-06: Enforce authorization checks to prevent exposing user data.
- [x] SEC-07: Apply rate limiting and lockout policy for login attempts.

### Phase 2 - High
- [x] SEC-01: Enforce email verification flow before full account activation.
- [ ] SEC-04: Validate and authorize link/file access before opening.
- [x] SEC-05: Enforce strong password policy (length, complexity, blacklist common passwords).
- [ ] LEG-01: Publish clear Privacy Policy and Terms of Use in-app.

### Phase 3 - Medium / Low
- [x] ACC-01: Add account recovery through verified phone number.
- [ ] PERF-01: Profile and optimize slow screens/API calls.
- [x] SEC-08: Notify user/admin on repeated failed login attempts.
- [ ] UX-01: Fix Contact Us channels and test all actions.
- [ ] DOC-01: Add in-app user guide / onboarding hints.
- [ ] DOC-02: Add user-facing changelog for every release.
- [ ] SEC-09: Add optional warning/advice for public Wi-Fi sessions.

## 5) Security Acceptance Criteria

- [x] OTP is sent only to the phone number verified and bound to the account.
- [x] Email verification is mandatory for account activation.
- [x] Password policy rejects weak passwords (e.g., `123456`, `password`).
- [x] Login endpoint has throttling + temporary lock after repeated failures.
- [ ] Sensitive fields are encrypted and never logged in plain text.
- [ ] Authorization tests confirm one user cannot access another user's data.
- [x] Suspicious login attempts trigger user/security notifications.

## 6) Suggested Technical Tasks (Backend)

- [x] Add/confirm Laravel `MustVerifyEmail` flow and email verified middleware.
- [x] Audit OTP generation + mapping logic; bind OTP to `user_id + phone + expiry`.
- [x] Add rate limiters for auth routes (`login`, `otp verify`, `forgot password`).
- [x] Add password validation rules + compromised/common password checks.
- [ ] Ensure encryption/casting for sensitive DB fields where required.
- [ ] Add policy/gate checks on user profile/account endpoints.
- [x] Add automated tests for auth, recovery, authorization, and throttling.

## 7) Test Checklist Before Release

- [ ] New user cannot log in as fully active before email verification.
- [ ] Forgot password works via verified phone path.
- [ ] OTP never reaches a different account or package number.
- [ ] After failed login attempts, throttling/lockout is triggered correctly.
- [ ] Privacy policy and terms are reachable and readable from app.
- [ ] Contact Us options all function as expected.
- [ ] Performance baseline meets target on key screens.

## 8) Notes
- Keep this file as the single source of truth for issue status.
- Update `Status` and checkboxes every sprint.
