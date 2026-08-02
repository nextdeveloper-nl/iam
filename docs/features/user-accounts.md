# Users & Accounts

Every person on the platform is a user, and every user belongs to one or more accounts. An account is the billing and ownership boundary — it's what owns resources, gets invoiced, and groups people together — while a user is the individual identity that can belong to multiple accounts (for example, being a member of their own account and a guest collaborator on someone else's).

## Key Capabilities

- Create and manage user profiles (name, email, phone, language, country, profile picture)
- Create accounts and account types (e.g. individual vs. organization)
- Add or remove users from an account, with an active/inactive flag per membership
- A user can belong to multiple accounts, and an account can have multiple users
- Track verification status per user: email verified, phone verified, profile verified, and national ID (NIN) verified
- Self-service endpoints for a logged-in user to view or update their own profile and account memberships

## Users

A user record holds identity information — name, surname, username, email, phone number, birthday, preferred language and country — plus a set of verification flags (`is_email_verified`, `is_phone_number_verified`, `is_nin_verified`, `is_profile_verified`) that other parts of the platform can check before allowing sensitive actions. A user is also where login history and SSH keys are attached.

## Accounts and Account Types

An account represents the entity that owns resources — it has a name, an owning user, an optional domain, country, and an account type (for example, distinguishing an individual account from a registered organization). Account types are themselves a managed resource, so new categories of account can be added without code changes.

## Account Membership

Because a user and an account are separate concepts, membership between them is tracked explicitly: a user can be linked to an account (and an account can list its users) with the membership itself carrying an active/inactive state. This is what allows a single person to operate multiple accounts, or multiple people to collaborate within one account.

## Self-Service ("My") Endpoints

A logged-in user can read and update their own profile, see which accounts they belong to, and see which roles they hold — without needing to know their own user ID up front.

## API Examples

**Create a user**

```
POST /iam/users
```
```json
{
  "name": "Jane",
  "surname": "Doe",
  "email": "jane@example.com",
  "username": "janedoe",
  "phone_number": "+15551234567"
}
```

**Create an account**

```
POST /iam/accounts
```
```json
{
  "name": "Acme Corp",
  "iam_user_id": "3f9c1a20-...-uuid",
  "iam_account_type_id": "8b2d...-uuid"
}
```

**Add a user to an account**

```
POST /iam/account-user
```
```json
{
  "iam_user_id": "3f9c1a20-...-uuid",
  "iam_account_id": "9d4e...-uuid",
  "is_active": true
}
```

**Get your own profile**

```
GET /iam/my/profile
```

**Get the accounts you belong to**

```
GET /iam/my/accounts
```

## Related Features

- [Authentication](authentication.md) — how a user proves their identity to access an account
- [Roles & Permissions](roles-and-permissions.md) — what a user is allowed to do within an account
- [SSH Key Management](ssh-key-management.md) — keys are owned by a user
