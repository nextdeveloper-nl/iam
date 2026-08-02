# Authentication

Authentication is how a user proves who they are before getting access to an account. The platform supports more than a single password check — it builds a short-lived login session that can combine a password, a one-time email code, and device fingerprinting, then exchanges a successful login for an access token.

## Key Capabilities

- Password-based login
- One-time email code (OTP) login, with no password required
- Device fingerprinting recorded per login session for security tracking
- A full login history per user (login logs)
- Self-service password updates
- An authorization-code-style flow that exchanges a verified login session for an access token

## Login Mechanisms

A login mechanism is a way a user can prove their identity. The platform ships with password login and one-time email code login out of the box (additional mechanisms can be added). Each user can have one or more login mechanisms registered, with one marked as their default.

## The Login Flow

Logging in happens through a session rather than a single request, which lets the platform layer multiple checks together:

1. **Create a session** — start a login attempt for a given client application
2. **Check available login mechanisms** — see whether this user can log in with a password, an OTP email, or both
3. **Record a device fingerprint** — the browser/device initiating the login is recorded against the session for security and anomaly detection
4. **Verify identity** — either validate a password, or request and validate a one-time email code
5. **Check validation status** — confirm the session has been fully verified
6. **Get an authorization code, then exchange it for an access token** — the final step that turns a verified session into a usable token for API access

## Password Management

A logged-in user can update their own password directly through a self-service endpoint, without needing administrator involvement.

## Login Logs

Every login attempt is recorded against the user, giving a history that can be reviewed for unusual activity or used as an audit trail.

## API Examples

**Start a login session**

```
GET /iam/authentication/oauth/session?client_id=<client_id>&redirect_uri=<redirect_uri>
```
```json
{
  "session_id": "f3a1...-session",
  "app_config": {
    "client_id": "<client_id>",
    "redirect_uri": "<redirect_uri>"
  }
}
```

**Check available login mechanisms for a user**

```
GET /iam/authentication/oauth/{session}/login-mechanisms?username=janedoe
```

**Record a device fingerprint**

```
POST /iam/authentication/oauth/{session}/fingerprint
```
```json
{
  "user_agent": "Mozilla/5.0 ...",
  "platform": "macOS",
  "fingerprint": "a1b2c3..."
}
```

**Validate with a password**

```
POST /iam/authentication/oauth/{session}/validate-password
```
```json
{
  "password": "your-password"
}
```

**Request and validate a one-time email code**

```
GET /iam/authentication/oauth/{session}/send-otp-email
POST /iam/authentication/oauth/{session}/validate-otp-email
```
```json
{
  "password": "123456"
}
```

**Exchange the verified session for an access token**

```
POST /iam/authentication/oauth/{session}/auth-code
POST /iam/authentication/oauth/{session}/access-token
```

**Update your password**

```
POST /iam/authentication/mechanisms/password
```
```json
{
  "password": "new-password"
}
```

## Related Features

- [Users & Accounts](user-accounts.md) — the identity being authenticated
- [Roles & Permissions](roles-and-permissions.md) — what an authenticated user can access
