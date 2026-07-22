<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showLogin()
    {
        if (session_has('user_id')) {
            $this->redirect('dashboard');
        }
        $this->view('auth.login');
    }

    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        // Check for brute force
        if ($this->userModel->getFailedAttempts($username, $ip) >= 5) {
            $this->json(['status' => 'error', 'message' => 'Too many failed attempts. Please try again later.']);
        }

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] !== 'active') {
                $this->json(['status' => 'error', 'message' => 'Your account is inactive. Please contact admin.']);
            }

            // Success
            session_set('user_id', $user['id']);
            session_set('username', $user['username']);
            session_set('user_role', $this->userModel->getRoles($user['id'])[0]['slug'] ?? 'user');
            
            $this->userModel->logLogin([
                'user_id' => $user['id'],
                'username' => $username,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'status' => 'success'
            ]);

            $this->json(['status' => 'success', 'redirect' => url('dashboard')]);
        } else {
            // Failed
            $this->userModel->logLogin([
                'user_id' => $user['id'] ?? null,
                'username' => $username,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'status' => 'failed'
            ]);

            $this->json(['status' => 'error', 'message' => 'Invalid username or password.']);
        }
    }

    public function showSignup()
    {
        $this->view('auth.signup');
    }

    public function signup()
    {
        $data = [
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT),
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'status' => 'pending' // Require verification or admin approval
        ];

        if ($this->userModel->findByEmail($data['email'])) {
            $this->json(['status' => 'error', 'message' => 'Email already exists.']);
        }

        if ($this->userModel->findByUsername($data['username'])) {
            $this->json(['status' => 'error', 'message' => 'Username already exists.']);
        }

        if ($this->userModel->create($data)) {
            $this->json(['status' => 'success', 'message' => 'Registration successful! Please wait for admin approval.', 'redirect' => url('login')]);
        } else {
            $this->json(['status' => 'error', 'message' => 'Something went wrong.']);
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('login');
    }

    public function showForgotPassword()
    {
        $this->view('auth.forgot-password');
    }

    public function forgotPassword()
    {
        $email = $_POST['email'] ?? '';
        $user = $this->userModel->findByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $this->userModel->updateResetToken($email, $token, $expiry);
            // In a real app, send email here.
            $this->json(['status' => 'success', 'message' => 'Password reset link has been sent to your email. (Simulated: ' . url('reset-password/' . $token) . ')']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Email not found.']);
        }
    }

    public function showResetPassword($token)
    {
        $user = $this->userModel->findByResetToken($token);
        if (!$user) {
            die("Invalid or expired token.");
        }
        $this->view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword()
    {
        $token = $_POST['token'] ?? '';
        $password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);

        $user = $this->userModel->findByResetToken($token);
        if ($user) {
            $this->userModel->updatePassword($user['id'], $password);
            $this->json(['status' => 'success', 'message' => 'Password updated successfully!', 'redirect' => url('login')]);
        } else {
            $this->json(['status' => 'error', 'message' => 'Invalid or expired token.']);
        }
    }
}
