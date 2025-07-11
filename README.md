# XPTrackr

XPTrackr is a gamified habit tracker designed to reward consistency, not just completion. Build real-life momentum by earning XP, leveling up, and collecting Grit—your personal currency for progress.

---

## 🚀 Purpose

To create a fun, personalized way to track habits and self-discipline using XP-based progression. This tool is built for developers, productivity nerds, and anyone who enjoys leveling up their life like it’s an RPG.

---

## 🧱 Stack

- **Frontend:** Nuxt 3 (Vue 3 + Composition API + Pinia)
- **Backend:** Ruby on Rails API
- **Database:** PostgreSQL
- **Auth:** Magic link (passwordless)
- **Dev Tools:** Docker, GitHub Actions, RSpec

---

## 🔐 Authentication

XPTrackr uses a **passwordless, magic link–based login system** to reduce friction and support a more user-friendly experience.

- Users enter their email and receive a time-limited login link
- If the email is not yet registered, an account is created automatically
- No passwords are stored or required at any point
- All sessions are cookie-based to support simple, secure authentication

During development, a **dev-only endpoint** is available:

```
POST /dev/instant_login/:email
```

This allows developers to instantly simulate a login session for any valid email, bypassing the need to check email clients while testing.

This setup replaces the originally proposed Devise/session approach to prioritize simplicity and flexibility in a solo or small-team context.

---

## 🎮 XP System

XP is awarded based on consistency and effort—not just raw completion. A formula like the following will guide XP distribution:

```ruby
xp = (habit.difficulty * 10) + (streak_days * 2)
```

XP increases with both task difficulty and habit streaks, rewarding not just what you do, but how consistently you do it.

This can be adjusted as the system evolves.

---

## 🪙 Currency: Grit

**Grit** is the in-app currency, earned alongside XP. It can be spent to unlock in-app rewards and serve as a symbol of long-term consistency.

Grit can be spent to unlock:
- Cosmetic badges or UI themes
- Temporary XP multipliers
- Personal milestones or motivational boosts

These features are still evolving and will expand post-MVP.

---

## 🐳 Local Development

XPTrackr uses Docker for a consistent development environment across systems.

To get started:

1. Copy `.env.example` to `.env` and configure your `DATABASE_URL`
2. Run `docker-compose up --build`
3. Backend will be available at `http://localhost:3000`
4. Frontend (Nuxt) will be available at `http://localhost:3001` (TBD) across all platforms.

**Quick Start:**
1. `cp .env.sample .env`
2. `docker-compose up`
3. Backend available at `localhost:3000`

📋 **For detailed setup instructions, see [Getting Started Guide](doc/GETTING_STARTED.md)**

The guide covers database setup, common commands, troubleshooting, and development workflows.

---

## ✅ MVP Features

- [ ] Habit creation & streak tracking
- [ ] XP gain system
- [ ] Grit rewards
- [ ] Magic link–based auth
- [ ] Healthcheck endpoint
- [ ] GitHub Actions integration (tests/lint)

---

## 🧠 Why This Stack?

- **Vue + Pinia** over React/Redux for safer reactivity and less boilerplate
- **Rails API** for rapid backend dev and support for server-side auth/session cookies
- **Docker** for consistency across dev/test environments
- **GitHub Projects** to simulate team-style planning and tracking

---

## 📝 License

TBD — currently closed for development, intended to be open-sourced.

---

## 🤖 AI Disclaimer

This project was scoped and refined with the help of ChatGPT, but **all design and implementation decisions are mine**. AI was used to structure ideas and support rapid iteration—not to replace my thinking.

---

## 🌍 Open Source Announcement

XPTrackr will be open source and fully transparent. You can view the live GitHub board and project progress here:

- 🗂️ [Project Board](https://github.com/users/bbommarito/projects/1)
- 📦 [Repository](https://github.com/bbommarito/XPTrackr)

Feedback welcome!
