# SIP System

A robust, production-style Systematic Investment Plan (SIP) management system built with Laravel. Supports both web and API clients, with secure authentication, SIP/invoice management, event-driven notifications, and PDF invoice generation.

---

## Features
- User registration, login, and email verification (web & API)
- SIP CRUD (create, view, cancel) for authenticated users
- Invoice generation, processing, and status management
- Event-driven, queued email notifications for:
  - Welcome (after verification)
  - SIP created/cancelled
  - Invoice paid (with PDF attachment)
  - Invoice payment failed
- Scheduled commands for invoice generation/processing and SIP status sync
- Downloadable PDF invoices from the user portal
- Responsive DataTables for SIPs and invoices
- Consistent, professional API and web flows

---

## Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd sip-system
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment setup:**
   - Copy `.env.example` to `.env` and update DB/mail settings.
   - Generate app key:
     ```bash
     php artisan key:generate
     ```

4. **Run migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```

5. **Link storage (for PDF downloads):**
   ```bash
   php artisan storage:link
   ```

6. **Start the development server:**
   ```bash
   php artisan serve
   ```

7. **(Optional) Start the scheduler:**
   - Add the following to your server's cron:
     ```
     * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
     ```

---

## API Documentation Sample

### **Authentication**
- `POST /api/register` — Register a new user
- `POST /api/login` — Login and receive token
- `POST /api/logout` — Logout (token required)

### **SIP Management**
- `GET /api/sips` — List user SIPs
- `POST /api/sips` — Create SIP
- `PATCH /api/sips/{sip}/cancel` — Cancel SIP

### **Invoice Management**
- `GET /api/invoices` — List user invoices
- `GET /api/invoices/{id}` — Get invoice details
- `POST /api/invoices/process-payment` — Simulate/process invoice payment (internal/automation)

### **Invoice Download (Web)**
- `GET /invoices/{invoice}/download` — Download invoice PDF (web, authenticated)

---

## Event-Driven Notifications
- All major actions (SIP created/cancelled, invoice paid/failed) trigger queued email notifications.
- Invoice paid emails include a PDF attachment.

---

## Testing
- Run tests with:
  ```bash
  php artisan test
  ```

---

## Notes
- All mail sending is queued and robustly error-handled.
- DataTables are fully responsive for mobile and desktop.
- PDF invoices are generated and stored in `storage/app/invoices/`.
- For production, configure mail, storage, and scheduler as needed.

---

## License
MIT