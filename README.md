# AplikacjeInternetowePK - FachowiecNaJuz

## 🔄 Recent Updates: Authentication & API Integration

### ✨ What's New

#### 1. **Optional Authentication**
- Default route changed from `/login` to `/home` - users can now browse without logging in
- Login modal appears on demand when clicking "Sign In" button instead of full page redirect
- Session-based authentication with `$_SESSION['user_id']`

#### 2. **API Endpoints**
New JSON API endpoints for frontend integration:

- **`POST /api/login`** - User authentication
  ```json
  Request: { "email": "user@example.com", "password": "password" }
  Response: { "success": true, "user_id": 123, "email": "user@example.com" }
  ```

- **`POST /api/logout`** - User logout
  ```json
  Response: { "success": true, "message": "Logged out successfully" }
  ```

- **`GET /api/specialists`** - List all specialists
  ```json
  Response: { "success": true, "data": [...specialists] }
  ```

- **`GET /api/locations`** - List all locations
  ```json
  Response: { "success": true, "data": [...locations] }
  ```

- **`POST /api/specialists`** - Create specialist (requires auth)
- **`POST /api/locations`** - Create location (requires auth)

#### 3. **Frontend Integration**
- **`api-helper.js`** - Centralized API communication helper
  - Automatic error handling and 401 response management
  - LocalStorage-based session management
  - Methods: `ApiHelper.login()`, `ApiHelper.getSpecialists()`, `ApiHelper.getLocations()`

- **Login Modal** - `partials/login-modal.html`
  - Non-blocking modal instead of full page redirect
  - Form validation and error display
  - Styling with Tailwind-like classes

- **Updated JavaScript**
  - `home.js` - Sign In button opens modal
  - `dashboard.js` - Sign In/Join buttons integrated with modal

### 📁 New Files Created

**Backend:**
- `src/controllers/ApiController.php` - Base API controller with JSON response methods
- `src/controllers/ApiSecurityController.php` - Authentication endpoints
- `src/controllers/ApiSpecialistController.php` - Specialist API endpoints
- `src/controllers/ApiLocationController.php` - Location API endpoints

**Frontend:**
- `public/scripts/api-helper.js` - API communication utility
- `public/views/partials/login-modal.html` - Login modal component

### 🔧 Modified Files

**Backend:**
- `Routing.php` - Added API routes handling and changed default route to `/home`
- `src/controllers/AppController.php` - Added `isLoggedIn()`, `getCurrentUser()`, `requireAuth()` methods
- `src/repositories/UsersRepository.php` - Added `getUserById()` method

**Frontend:**
- `public/views/home.html` - Added login modal and API helper script
- `public/views/dashboard.html` - Added login modal and API helper script
- `public/scripts/home.js` - Added Sign In button handlers
- `public/scripts/dashboard.js` - Added Sign In/Join button handlers

### 🚀 Usage Examples

#### Login with JavaScript
```javascript
try {
    const response = await ApiHelper.login('user@example.com', 'password');
    console.log('Logged in as:', response.email);
} catch (error) {
    console.error('Login failed:', error.message);
}
```

#### Fetch Specialists
```javascript
const data = await ApiHelper.getSpecialists();
console.log('Specialists:', data.data);
```

#### Check Login Status
```javascript
if (ApiHelper.isUserLoggedIn()) {
    console.log('User ID:', localStorage.getItem('user_id'));
}
```

### ⚙️ Configuration

The application uses:
- **PHP Sessions** - Server-side session management via `$_SESSION['user_id']`
- **LocalStorage** - Client-side session state tracking
- **PostgreSQL** - Database with `users` table

### 🔐 Security Notes

- Passwords are hashed with `password_hash()` (PASSWORD_DEFAULT)
- Protected endpoints check `requireAuth()` which validates session
- API returns 401 status for unauthorized requests
- Login modal triggers automatically on 401 responses

### 📝 Next Steps

Future improvements could include:
- JWT tokens for stateless authentication
- Remember me functionality
- Password reset flow
- Two-factor authentication
- API rate limiting
