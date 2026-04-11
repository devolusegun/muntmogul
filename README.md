# Muntmogul — Crypto Investment Platform

![PHP](https://img.shields.io/badge/PHP-7%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=flat-square&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6%2B-F7DF1E?style=flat-square&logo=javascript&logoColor=black)
![Status](https://img.shields.io/badge/Status-Live-brightgreen?style=flat-square)

> A full-stack cryptocurrency investment platform with tiered investment plans, multi-coin wallet management, and separate admin and user dashboards.

🌐 **Live:** [muntmogul.com](https://www.muntmogul.com)

---

## Overview

Muntmogul is a secure web-based investment platform that allows users to invest using cryptocurrency and earn returns across multiple plan tiers. The platform handles the full investment lifecycle — from user registration and KYC onboarding through to deposit management, yield tracking, withdrawal processing, and portfolio reporting.

The system is built on a role-separated architecture with distinct interfaces for end users and platform administrators, each with scoped access and capabilities.

---

## Features

### User-Facing
- **Account registration & authentication** — secure signup with email verification, session management, and password hashing
- **Investment plans** — multiple tiered plans with varying return rates and lock-in periods (minimum 3 months), clearly presented with projected yield calculations
- **Crypto deposits** — users can fund their investment using Bitcoin (BTC), Ethereum (ETH), Litecoin (LTC), or Dogecoin (DOGE)
- **Withdrawal management** — users can request withdrawals to their registered crypto wallet addresses
- **Personal dashboard** — real-time portfolio overview showing active investments, accrued returns, transaction history, and wallet balances
- **Transaction history** — full audit log of all deposits, withdrawals, and investment activity

### Admin Panel (Separate Login)
- **User management** — view, search, and manage all registered users
- **Deposit approval workflow** — review and approve or reject incoming deposit requests
- **Withdrawal approval workflow** — process and authorise user withdrawal requests to crypto wallets
- **Partner/referral management** — oversee partner registrations, validate submissions, and manage commissions
- **Platform moderation** — full oversight of investment activity and user behaviour
- **Reporting** — platform-level analytics on deposits, withdrawals, active plans, and user growth

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 7+ (structured MVC-style) |
| Frontend | HTML5, CSS3, Bootstrap, JavaScript (ES6+), jQuery |
| Database | MySQL / MariaDB |
| Crypto Prices | CoinPaprika API (live price feeds) |
| Authentication | Session-based auth, CSRF protection, role-based access control (RBAC) |
| Email | PHPMailer (SMTP) — notifications for registration, deposits, withdrawals |
| Hosting | Apache / cPanel |

---

## Security Implementation

Security was a primary concern given the financial nature of the platform:

- **Password hashing** — bcrypt hashing for all stored credentials
- **CSRF protection** — token-based form validation across all state-changing requests
- **SQL injection prevention** — prepared statements used throughout all database interactions
- **Role-based access control** — admin and user sessions are strictly separated; admin routes are inaccessible to standard user sessions
- **Input validation** — server-side validation on all user inputs before database interaction
- **Email verification** — mandatory email confirmation before account activation

---

## Architecture

```
muntmogul/
├── admin/              # Separate admin panel (independent login & session)
│   ├── dashboard/      # Platform overview and analytics
│   ├── users/          # User management
│   ├── deposits/       # Deposit approval queue
│   ├── withdrawals/    # Withdrawal processing
│   └── partners/       # Partner/referral management
├── user/               # User-facing application
│   ├── dashboard/      # Portfolio overview
│   ├── invest/         # Plan selection and investment flows
│   ├── wallet/         # Deposit and withdrawal interfaces
│   └── history/        # Transaction history
├── api/                # Internal API endpoints (price feeds, wallet ops)
├── includes/           # Shared config, DB connection, auth helpers
└── assets/             # Frontend assets (CSS, JS, images)
```

---

## Investment Plans

The platform supports multiple plan tiers. Each plan specifies:
- **Minimum investment amount** (in USD equivalent at time of deposit)
- **Return rate** (% yield)
- **Lock-in period** (minimum 3 months, varying by plan tier)
- **Payout frequency** (on maturity or periodic, depending on plan)

Users select a plan at the point of investment and the platform tracks the timeline and calculates returns automatically.

---

## Supported Cryptocurrencies

| Coin | Symbol | Use |
|---|---|---|
| Bitcoin | BTC | Deposit & Withdrawal |
| Ethereum | ETH | Deposit & Withdrawal |
| Litecoin | LTC | Deposit & Withdrawal |
| Dogecoin | DOGE | Deposit & Withdrawal |

Live prices are fetched via the **CoinPaprika API** and displayed in real time across the platform. Fallback handling is implemented for API downtime to ensure uninterrupted price display.

---

## Key Engineering Decisions

- **Separate admin codebase** — admin and user panels run as separate applications sharing the same database, preventing any privilege escalation via URL manipulation
- **Approval workflow pattern** — all financial operations (deposits and withdrawals) go through a manual approval queue rather than auto-processing, giving the platform operator full control and an audit trail
- **API resilience** — after the original crypto price API failed, the integration was rebuilt using CoinPaprika with fallback logic, demonstrating the importance of designing for third-party API instability

---

## Status

✅ Live and operational at [muntmogul.com](https://www.muntmogul.com)

---

## Author

**Abioye Solomon Olusegun**
[github.com/devolusegun](https://github.com/devolusegun) · [LinkedIn](https://linkedin.com/in/kidolu)
