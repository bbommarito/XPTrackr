# XPTrackr

> **"Because every habit deserves loot."**

XPTrackr is a gamified habit tracker that transforms daily routines into rewarding quests. Users complete habits, gain XP, collect Grit, level up, and build momentum—just like in your favorite RPG.

---

## 📘 Table of Contents

- [Concept](#concept)
- [Tech Stack](#tech-stack)
- [Folder Structure](#folder-structure)
- [Development Setup](#development-setup)
- [Backend (Rails)](#backend-rails)
- [Frontend (Vite + Vue)](#frontend-vite--vue)
- [Deployment Strategy](#deployment-strategy)
- [Stack Rationale](#stack-rationale)
- [Acknowledgments](#acknowledgments)

---

## 🎯 Concept

- Habits are treated as **daily quests**
- Completing them earns **XP** and **Grit**
- Users **level up** and track streaks
- **Grit** is a secondary currency used for rewards and customization
- Core XP formula:

```ruby
def xp_to_next_level(level)
  (100 * level**1.5).to_i
end
```

---

## 🛠️ Tech Stack

| Layer      | Tech            | Notes                             |
|------------|------------------|-----------------------------------|
| Backend    | Ruby on Rails    | API-first, optional HTML views   |
| Frontend   | Vite + Vue       | Composition API, with Pinia store|
| Auth       | Devise (Rails)   | Cookie or token-based auth       |
| Dev Tools  | Docker (optional)| Containerized local dev          |

---

## 🗂️ Folder Structure

```
xptrackr/
├── backend/             # Rails API app
│   ├── app/
│   ├── config/
│   └── ...
├── frontend/            # Vite + Vue app
│   ├── src/
│   ├── public/
│   └── ...
├── docker-compose.yml   # Optional
└── README.md
```

---

## 🧪 Development Setup

### Backend (Rails)

```bash
cd backend
bundle install
rails db:create db:migrate
rails server
```

Ensure `rack-cors` is configured in `config/initializers/cors.rb`:

```ruby
Rails.application.config.middleware.insert_before 0, Rack::Cors do
  allow do
    origins 'http://localhost:5173'
    resource '*',
      headers: :any,
      methods: [:get, :post, :patch, :put, :delete, :options],
      credentials: true
  end
end
```

---

### Frontend (Vue + Vite)

```bash
cd frontend
npm install
npm run dev
```

Install Vue and Pinia:

```bash
npm install vue@next pinia
```

Set up API proxy in `vite.config.js`:

```js
export default {
  server: {
    proxy: {
      '/api': 'http://localhost:3000',
    },
  },
};
```

Use Composition API and Pinia for state management.

---

## 🌐 Deployment Strategy

| Subdomain        | Purpose             |
|------------------|---------------------|
| app.xptrackr.com | Frontend (Vue/Vite build) |
| api.xptrackr.com | Rails backend API   |

Use cookie-based auth with `domain: .xptrackr.com` to allow session sharing across subdomains.

---

## ✨ Rewards System

### XP (Experience Points)
Used to track user level and overall progression.

### Grit (In-App Currency)
**Grit** is earned by consistent effort and used for in-app rewards.

#### 💰 How to Earn Grit

| Action                             | Grit Earned |
|------------------------------------|-------------|
| Complete a daily habit             | +2 Grit     |
| Complete all habits for the day    | +10 Grit    |
| Maintain a 3-day streak            | +5 Grit     |
| Weekly consistency (7-day streak)  | +15 Grit    |
| First-time completion of new habit | +5 Grit     |
| Level up                           | +20 Grit    |

#### 🛍️ What to Spend Grit On
- Avatar customization
- UI themes and effects
- Titles, stickers, and lore unlocks
- Buffs (e.g. streak protection, XP boost)
- Cosmetic or narrative rewards

---

## 💭 Stack Rationale

This stack was chosen intentionally for clarity, speed, and future scalability:

### Why Rails?
- Rails offers a pragmatic, well-supported API backend.
- Devise makes authentication easy without writing boilerplate.
- Built-in support for both APIs and optional HTML views allows fast MVP development and landing pages.
- It aligns with patterns used in real-world government/enterprise platforms, including VA infrastructure.

### Why Vue + Pinia?
- Vue’s Composition API offers safer, more modular state and logic handling than React's useEffect-driven flow.
- Pinia is lightweight but powerful—it feels natural for both small projects and enterprise-scale state management.
- Vue is approachable but doesn't sacrifice capability, making it ideal for solo or small team development.

### Why Not React?
- While React is ubiquitous, it can become verbose or finicky when handling shared state.
- Redux Toolkit helps, but still introduces conceptual overhead that isn’t necessary for XPTrackr.
- Vue’s ecosystem made faster progress for this project's goals.

---

## 🙏 Acknowledgments

This project was built with brainstorming support from ChatGPT. While AI tools were used to help generate ideas and organize this README, **all concepts, naming, and development choices are my own**.

---

Happy tracking!
