# Directory Integration

Accounts that already manage their users in an external directory (such as an LDAP server) can connect it to the platform instead of recreating every user manually. This is aimed at organizations migrating existing identity infrastructure onto the platform.

## Key Capabilities

- Connect an account to an external LDAP directory
- Configure connection details: server address, port, base DN, and bind credentials
- Map directory fields (user ID, password, email, name, surname, alias) to the platform's user fields
- Restrict which directory entries are imported using a filter and a "member of" group constraint
- Use a secure (encrypted) connection to the directory server
- Track whether the directory is currently connected and usable

## Backend Directories

A backend directory record represents one external directory connection for an account. It stores the LDAP server's hostname/URL and port, the base distinguished name (DN) to search under, and bind credentials used to authenticate to the directory itself. A default filter and "member of" group can be set so only relevant entries are pulled in, rather than an entire directory.

## Field Mapping

Because directory schemas vary, the platform lets you map which directory attribute corresponds to each of its own user fields — user ID, password, email, alias, name, and surname — so directories that don't follow a standard schema can still be integrated.

## Connection Status

A directory connection tracks whether it is currently connected, whether the connection is secure (encrypted), and whether it's considered usable — giving early visibility into a misconfigured or unreachable directory before it affects logins.

## API Examples

**Connect an LDAP directory**

```
POST /iam/backend-directories
```
```json
{
  "name": "corporate-ldap",
  "iam_backend_types": "ldap",
  "ldap_server_name": "ldap.example.com",
  "ldap_server_url": "ldaps://ldap.example.com",
  "ldap_server_port": 636,
  "ldap_base_dn": "dc=example,dc=com",
  "ldap_bind_username": "cn=admin,dc=example,dc=com",
  "ldap_bind_password": "bind-password",
  "default_userid_field": "uid",
  "default_email_field": "mail",
  "is_connection_secure": true
}
```

**Check directory connection status**

```
GET /iam/backend-directories/{id}
```

## Related Features

- [Users & Accounts](user-accounts.md) — directory-synced users become regular platform users
- [Authentication](authentication.md) — directory credentials can be used as a login mechanism
