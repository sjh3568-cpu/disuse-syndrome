# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Running the Project

No build step required. This is a pure static site (HTML/CSS/JS).

- **Browser:** Open any `.html` file directly in a browser.
- **Local server:** `python -m http.server 8000` then visit `http://localhost:8000`
- **PHP features:** `save.php` (legacy local file storage) requires a PHP server (e.g., `php -S localhost:8000`), but the app currently uses JSONBin API instead.

## Architecture

Four-page static application targeting Korean hospital staff (모바일 우선 / mobile-first):

```
index.html          ← Landing / menu hub
├── flashcard.html  ← 10-card flip-card learning module
├── quiz.html       ← 10-question multiple-choice assessment
└── admin.html      ← Password-protected analytics dashboard
```

All JS and CSS are **inline** within each HTML file — there are no separate `.js` or `.css` files.

## Data Flow

1. **quiz.html** — On completion, POSTs results to JSONBin API (cloud JSON store).
2. **admin.html** — GETs the same JSONBin bin to render statistics and per-respondent data.
3. **save.php / data/results.json** — Legacy fallback; not actively used by the current UI.

JSONBin credentials (`JSONBIN_ID`, `JSONBIN_KEY`) and the admin password (`ADMIN_PW`) are hardcoded as JS constants inside `quiz.html` and `admin.html`.

## Key Implementation Details

- **Flashcard module:** 10 embedded Q&A cards with CSS 3D flip animation; user marks each card 알았어요/모르겠어요 and progress is tracked in-memory.
- **Quiz module:** Questions and answer choices are shuffled on each load; final score, name, and department are saved to JSONBin.
- **Admin dashboard:** Fetches all JSONBin records, computes averages, renders per-question bar charts and department breakdowns; delete functionality calls JSONBin PUT to remove a record.
- **Font stack:** `'Apple SD Gothic Neo', 'Noto Sans KR', sans-serif` — Korean-optimized throughout.
- **Color theming:** Each page has its own gradient — index (dark blue), flashcard (purple), quiz (teal/green), admin (light gray).
