# YPS Gaming WordPress Theme — Setup Guide

## Installation

1. Go to **WordPress Admin → Appearance → Themes → Add New → Upload Theme**
2. Upload `yps-theme.zip`
3. Click **Activate**

---

## Create Required Pages

After activating, create the following pages in **Pages → Add New** and assign the correct template:

| Page Title     | Slug            | Template                |
|----------------|-----------------|-------------------------|
| Home           | `/`             | **Home Page**           |
| Services       | `services`      | **Services Page**       |
| Our Pilots     | `our-pilots`    | **Our Pilots Page**     |
| Track Order    | `track-order`   | **Track Order Page**    |
| About Us       | `about-us`      | **About Us Page**       |
| Contact Us     | `contact-us`    | **Contact Us Page**     |
| Checkout       | `checkout`      | **Checkout Page**       |
| Admin Dashboard| `admin-dashboard`| **Admin Dashboard**    |

---

## Set Homepage

- Go to **Settings → Reading**
- Set "Your homepage displays" to **A static page**
- Select **Home** as the Homepage

---

## Add Background Images

Copy these images into `wp-content/themes/yps-gaming/assets/images/`:
- `hero-bg.jpg` — The anime artwork background (provided)
- `bg-watercolor.jpg` — The watercolor blue background (provided)

---

## Custom Post Types (Auto-registered)

The theme registers these CPTs automatically:
- **Services** (`yps_service`) — Add your service offerings
- **Pilots** (`yps_pilot`) — Add pilot profiles
- **Games** (`yps_game`) — Add supported games
- **Orders** (`yps_order`) — Customer orders (created automatically on booking)

---

## Theme Colors

| Variable        | Value      | Usage                  |
|-----------------|------------|------------------------|
| `--pink`        | `#FF6B9D`  | Primary accent         |
| `--purple`      | `#9B59B6`  | Secondary accent       |
| `--teal-dark`   | `#0D2137`  | Navbar/Footer bg       |
| `--blue-soft`   | `#C8E6F5`  | Section background     |

---

## Features

- ✅ 8 fully designed page templates
- ✅ Custom Post Types: Services, Pilots, Games, Orders
- ✅ AJAX Order Tracking
- ✅ AJAX Booking Submission
- ✅ Responsive mobile design
- ✅ Scroll animations
- ✅ Admin Dashboard with sales stats
- ✅ Google Fonts (Outfit + Nunito)
- ✅ Glassmorphism card design
- ✅ Pink/Purple anime aesthetic

---

© 2025 YPS.CO — All Rights Reserved
