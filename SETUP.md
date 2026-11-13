# OJS Logistics & Freight Forwarding — Setup Guide

Welcome to the **OJS Logistics & Freight Forwarding Global Portal** setup guide.

- **GitHub Repository**: [https://github.com/JeevananthanV/ojs_new](https://github.com/JeevananthanV/ojs_new)
- **Author**: Jeevananthan V

---

## 📋 System Prerequisites

- Any modern web browser (Chrome, Edge, Firefox, Safari)
- Optional: Python 3, Node.js (for running local development server), or PHP

---

## 📥 1. Clone the Repository

```bash
git clone https://github.com/JeevananthanV/ojs_new.git
cd ojs_new
```

---

## 🚀 2. Running Locally

### Option A: Using Python (Simplest)

```bash
python -m http.server 8080
```
Open `http://localhost:8080` in your web browser.

### Option B: Using Node.js `serve`

```bash
npx serve . -p 8080
```

### Option C: Using PHP Built-in Server

```bash
php -S localhost:8080
```

---

## 🌐 3. Key Portal Landing Pages

- `index.html`: Main home portal & shipment tracking
- `air-freight.html`: Express air cargo & transit schedules
- `sea-freight.html`: Ocean freight & container logistics
- `road-freight.html`: Domestic & overland trucking
- `customs.html`: Customs brokerage & tariff advisory
- `warehouse.html`: Distribution centers & storage
- `contact.html`: Inquiries & worldwide office contacts
