MtaaLink STYLE GUIDE

Purpose
- Provide quick reference for the redesigned UI using Tailwind tokens and components.

Colors (Tailwind tokens)
- `primary-50/100/200/.../900` — brand green gradient (used for CTAs and accents)
- `sky-*` — interactive links, focus states
- `slate-*` — body text and surface backgrounds

Typography
- Base font sizes are Tailwind defaults; headings use `font-extrabold`/`font-bold`.

Spacing & Radii
- Cards use `rounded-xl` / custom `rounded-xl-2` in `tailwind.config.js`.

Components
- `layouts.app` — base layout with header/nav and footer.
- `components.nav` — primary nav with CTAs.
- `components.card` — content card wrapper.
- `components/input/select/textarea/file` — form inputs with consistent styles.
- `components/modal` — accessible modal with keyboard trapping.
- `components/notification` — toast message with `role="status"`.
- `components/profile-card` — compact profile display for lists.
- `components/paginated-list` — wrapper for lists and table with pagination.

Accessibility
- Focus outlines show only for keyboard users (`user-is-tabbing` class toggled by JS).
- Modal uses `role="dialog"` and `aria-modal="true"` and traps focus via Alpine.
- Buttons and interactive elements have accessible labels.

How to use
1. Extend the base layout in your Blade views: `@extends('layouts.app')` and provide `@section('content')`.
2. Use components with `<x-card>`, `<x-input name="email" label="Email" />`, etc.
3. Run `npm run dev` and `php artisan serve` to preview.

Tailwind token map
- See `tailwind.config.js` for color, radius and shadow tokens.

Notes
- This guide is minimal — expand with visual examples and component variants as you iterate.
