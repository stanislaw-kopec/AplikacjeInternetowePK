// API Helper - handles communication with backend API endpoints
class ApiHelper {
    static baseUrl = '/api';

    static async request(endpoint, method = 'GET', data = null) {
        const url = `${this.baseUrl}/${endpoint}`;
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            }
        };

        if (data && (method === 'POST' || method === 'PUT')) {
            options.body = JSON.stringify(data);
        }

        try {
            const response = await fetch(url, options);
            const jsonData = await response.json();

            if (response.status === 401) {
                // Unauthorized - send the user to the login page.
                this.handleUnauthorized();
                throw new Error('Unauthorized');
            }

            if (!response.ok) {
                throw new Error(jsonData.error || `HTTP error! status: ${response.status}`);
            }

            return jsonData;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }

    static async get(endpoint) {
        return this.request(endpoint, 'GET');
    }

    static async post(endpoint, data) {
        return this.request(endpoint, 'POST', data);
    }

    static async login(email, password) {
        return this.post('login', { email, password });
    }

    static async logout() {
        return this.post('logout', {});
    }

    static async getSpecialists() {
        return this.get('specialists');
    }

    static async getLocations() {
        return this.get('locations');
    }

    static handleUnauthorized() {
        window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
    }

    static isUserLoggedIn() {
        return !!localStorage.getItem('user_logged_in');
    }

    static setUserLoggedIn(userId, email, role = null) {
        localStorage.setItem('user_logged_in', 'true');
        localStorage.setItem('user_id', userId);
        localStorage.setItem('user_email', email);
        if (role) {
            localStorage.setItem('user_role', role);
        }
    }

    static clearUserSession() {
        localStorage.removeItem('user_logged_in');
        localStorage.removeItem('user_id');
        localStorage.removeItem('user_email');
        localStorage.removeItem('user_role');
    }
}

// Global functions for modal control
function openLoginModal() {
    window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
}

function closeLoginModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.classList.add('modal-hidden');
    }
}

// Login form handler
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const errorDiv = document.getElementById('loginError');
            const submitBtn = loginForm.querySelector('button[type="submit"]');

            // Clear previous errors
            errorDiv.textContent = '';
            errorDiv.classList.remove('show');

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Signing in...';

            try {
                const response = await ApiHelper.login(email, password);
                
                if (response.success) {
                    ApiHelper.setUserLoggedIn(response.user_id, response.email, response.role);
                    closeLoginModal();
                    
                    // Reset form
                    loginForm.reset();
                    submitBtn.textContent = 'Sign In';
                    
                    // Reload or redirect
                    window.location.reload();
                }
            } catch (error) {
                errorDiv.textContent = error.message || 'Login failed. Please try again.';
                errorDiv.classList.add('show');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Sign In';
            }
        });
    }
});
