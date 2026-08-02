# Roles & Permissions

The platform controls what a user is allowed to do through roles and permissions — a standard role-based access control (RBAC) model. A permission represents a specific allowed operation, a role is a named bundle of permissions, and users are granted access by being assigned to roles.

## Key Capabilities

- A library of built-in roles (for example, a basic member role and several administrative roles) ranked by privilege level
- Create custom roles and attach permissions to them
- Assign roles to users, scoped to a specific account
- Fine-grained permissions defined per service and method, not just per resource
- A self-service endpoint for a user to see their own roles

## Roles

A role has a name, a description, and a numeric privilege level (1 is highest privilege, 255 is lowest), which lets the platform reason about whether one role outranks another. The platform ships with several built-in roles out of the box — including a general member role and administrative roles for platform operators — and custom roles can be created on top of these.

## Permissions

A permission is defined at a granular level: a namespace, a service, and a method — meaning permissions map directly to specific operations rather than broad, generic categories like "read" or "write." This allows precise control over exactly which actions a role is allowed to perform.

## Assigning Roles and Permissions

Permissions are attached to roles, and roles are then assigned to users. A role assignment is scoped to a specific account, so the same user can hold different roles in different accounts they belong to (for example, an administrator in their own account but a basic member in someone else's).

## API Examples

**Create a role**

```
POST /iam/roles
```
```json
{
  "name": "billing-manager",
  "level": 100,
  "description": "Can manage billing for the account"
}
```

**Create a permission**

```
POST /iam/permissions
```
```json
{
  "namespace": "Accounting",
  "service": "InvoiceService",
  "method": "create",
  "name": "Create Invoice"
}
```

**Attach a permission to a role**

```
POST /iam/role-permission
```
```json
{
  "iam_role_id": "7c1d...-uuid",
  "iam_permission_id": "9f2a...-uuid",
  "is_active": true
}
```

**Assign a role to a user within an account**

```
POST /iam/role-user
```
```json
{
  "iam_role_id": "7c1d...-uuid",
  "iam_user_id": "3f9c1a20-...-uuid",
  "iam_account_id": "9d4e...-uuid",
  "is_active": true
}
```

**Get your own roles**

```
GET /iam/my/roles
```

## Related Features

- [Users & Accounts](user-accounts.md) — roles are assigned to users within a specific account
- [Authentication](authentication.md) — a user must be authenticated before their roles take effect
