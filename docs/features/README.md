# IAM Platform Features

This is the feature documentation for the platform's Identity & Access Management (IAM) capabilities — users, accounts, authentication, and access control. Each page below explains a feature area in plain language and includes brief API examples for the key operations in that area.

All API paths are relative to the platform's API base URL and prefixed with `/iam`. Most resources are addressed by UUID and follow the same basic operations: list (`GET`), create (`POST`), show/update/delete (`GET` / `PATCH` / `DELETE` on `/{id}`), and custom actions (`POST /{id}/do/{action}`). Authentication uses its own session-based flow rather than simple resource CRUD — see [Authentication](authentication.md) for details.

## Feature Areas

| Feature | What it covers |
| --- | --- |
| [Users & Accounts](user-accounts.md) | User profiles, accounts, account types, and account membership |
| [Authentication](authentication.md) | Login mechanisms, the session-based login flow, password management, login logs |
| [Roles & Permissions](roles-and-permissions.md) | Role-based access control: roles, permissions, and assignments |
| [SSH Key Management](ssh-key-management.md) | Registering and tracking SSH public keys per user |
| [Directory Integration](directory-integration.md) | Connecting an external LDAP directory to an account |

## How These Pages Are Organized

Each page follows the same structure: a short overview, a list of key capabilities, a deeper explanation of each sub-feature, brief API examples for the most common operations, and links to related feature areas.
