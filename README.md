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
   git clone https://github.com/krupalsolanki8/sip-system.git
   cd sip-system
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment setup:**
   - If `.env` does not exist, copy `.env.example` to `.env`:
     - **Windows:**
       ```cmd
       copy .env.example .env
       ```
     - **Linux/macOS:**
       ```bash
       cp .env.example .env
       ```
   - Generate app key:
     ```bash
     php artisan key:generate
     ```

4. **Database and mail configuration:**
   - Create a database for the project.
   - Update your `.env` file with the correct database credentials and mail settings.
   - **Note:** If you encounter SSL problems while sending mail, add or uncomment the following in your `.env` file:
     ```env
     VERIFY_PEER=false
     ```

5. **Run migrations:**
   ```bash
   php artisan migrate
   ```

6. **Set up Laravel Passport:**
   ```bash
   php artisan passport:keys
   php artisan passport:client --personal
   ```

7. **Start the development server:**
   ```bash
   php artisan serve
   ```

8. **Set up the scheduler (handles both scheduled tasks and queue workers):**
   - **Linux/Ubuntu:** Add the following to your crontab using `crontab -e`:
     ```cron
     * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
     ```
   - **Windows:** Run the following command manually (or set up a scheduled task):
     ```bash
     php artisan schedule:run
     ```
   - **Note:** If the scheduler is running, you do NOT need to run `php artisan queue:work` separately; the scheduler will process queued jobs automatically.
   - **Linux production tip:** For advanced queue management, you can use a process manager like Supervisor (Recommended).

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

## Notes
- All mail sending is queued and robustly error-handled.
- DataTables are fully responsive for mobile and desktop.
- PDF invoices are generated and stored in `storage/app/invoices/`.
- For production, configure mail, storage, and scheduler as needed.

---

## License
MIT

---

## Need Help?

If you face any problems during setup, please contact krupalsolanki9421@gmail.com for assistance.