# HyperSwipe – Tinder-Style MVP

For demoo use Swagger doc 
     https://tinderphp-production.up.railway.app/api/documentation#/
For the mobile Scan this with Expo Go installed on you Mobile device 


<img width="234" height="230" alt="Screenshot 2025-11-11 at 8 58 17 PM" src="https://github.com/user-attachments/assets/61c6fb81-e2d2-44ff-80dc-8bdd03f17a22" />






This workspace contains a Laravel 11 backend and an Expo React Native frontend that together deliver a Tinder-style experience: swipe cards, like/dislike flows, liked list, swagger docs, and an automated popularity alert.

## Project Structure

- `backend/` – Laravel API (`Person` + `Like` resources, cron email alert, Swagger docs)
- `tinder-clone/` – Expo/React Native app (Recoil + React Query + React Navigation + deck swiper)

---

## Backend (Laravel)

### Prerequisites

- PHP 8.2+
- Composer
- MySQL 8 (production) or SQLite (default `.env`)
- Mailtrap (or another SMTP provider) for notifications

### Setup

```bash
cd backend
cp .env.example .env            # adjust DB + mail settings
php artisan key:generate
php artisan migrate --seed      # seeds a demo user + 40 sample profiles
php artisan serve               # http://127.0.0.1:8000
```

Key environment variables to review:

```env
DB_CONNECTION=mysql          # or sqlite for local quick start
MAIL_MAILER=log              # switch to smtp + Mailtrap credentials for email testing
MAIL_ADMIN_ADDRESS=admin@example.com
POPULAR_PEOPLE_THRESHOLD=50
```

### API Endpoints

- `GET /api/people?page=1` – paginated people feed
- `POST /api/people/{id}/like` – like person, increments `likes_count`
- `POST /api/people/{id}/dislike` – dislike, decrements count
- `GET /api/liked` – current user’s liked people

### Cron + Mail

`app:check-popular-people` runs hourly (see `bootstrap/app.php`). Once a person reaches the configured threshold, an email is sent to `MAIL_ADMIN_ADDRESS`. During local dev the mailer defaults to the log channel—switch to SMTP (e.g. Mailtrap) to verify delivery.

### Swagger

```bash
php artisan l5-swagger:generate
```

Docs are served at `http://127.0.0.1:8000/api/documentation`.

### Tests

```bash
php artisan test
```

---

## Frontend (Expo React Native)

### Prerequisites

- Node 18+ (Expo SDK 54 recommends Node 20+; current workspace runs on Node 18 with warnings)
- Expo CLI / Expo Go (for device testing)

### Setup

```bash
cd tinder-clone
npm install
npx expo start
```

Set the API base URL in an environment variable (Expo automatically exposes `EXPO_PUBLIC_*` values):

```bash
echo "EXPO_PUBLIC_API_URL=http://127.0.0.1:8000/api" >> .env
```

The app provides:

- `Splash` → `Main` → `LikedList` navigation
- Tinder-style card stack (`react-native-deck-swiper`)
- Recoil + React Query for state + data fetching
- Like/Dislike actions wired to the Laravel API

### Type Checking

```bash
npx tsc --noEmit
```

*(Expected npm audit alerts stem from Expo SDK dependencies.)*

---

## Deployment Notes

- **Backend:** target Render / Railway or similar. Remember to configure cron (e.g. Scheduler or `php artisan schedule:run`).
- **Frontend:** publish with Expo EAS; update `EXPO_PUBLIC_API_URL` for production builds.

---

## Next Steps

- Add authentication + real user context
- Implement push notifications for matches
- Expand test coverage (feature tests + component-level tests)

