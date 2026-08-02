# SSH Key Management

Users can register SSH public keys once and reuse them across the platform, instead of copying a key into every server individually. The platform also keeps a history of key-related events for auditing.

## Key Capabilities

- Register one or more SSH public keys per user
- Scope a key for a specific use (for example, restricted to certain resources) rather than blanket access
- Track key type and fingerprint for identification
- Set an expiration date on a key, or deactivate it without deleting it
- Track when a key was last used
- Keep an event history of key-related activity (creation, usage, revocation, etc.)

## SSH Public Keys

Each key record stores the public key material itself, its fingerprint, its type (e.g. RSA, Ed25519), an optional scope limiting where it can be used, and an active/inactive flag. Keys can also carry an expiration date, after which they stop being valid automatically, and the platform tracks the last time a key was actually used — useful for spotting unused or stale keys.

## Key Events

Significant events involving a key — such as it being created, used to authenticate, or deactivated — are recorded as a separate event history per key, giving an audit trail independent of the key's current state.

## API Examples

**Register an SSH public key**

```
POST /iam/ssh-public-keys
```
```json
{
  "name": "laptop-key",
  "public_key": "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAI...",
  "key_type": "ed25519",
  "is_active": true
}
```

**List your SSH keys**

```
GET /iam/ssh-public-keys
```

**View key events**

```
GET /iam/ssh-public-key-events?filter[iam_ssh_public_key_id]=<key_id>
```

## Related Features

- [Users & Accounts](user-accounts.md) — keys are owned by a user
- [Authentication](authentication.md) — alternative way of proving identity for resource access
