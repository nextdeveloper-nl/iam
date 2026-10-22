<?php

namespace NextDeveloper\IAM\Database\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NextDeveloper\Commons\Database\Traits\UuidId;

/**
 * A passkey (WebAuthn credential) of a user. A user may have several.
 *
 * Deliberately without the global scopes the generated models register: a passkey is looked up while someone is
 * signing in, before there is any user context for a scope to filter by. Callers always filter by iam_user_id or
 * credential_id themselves.
 *
 * @package  NextDeveloper\IAM\Database\Models
 * @property integer $id
 * @property string $uuid
 * @property integer $iam_user_id
 * @property string $credential_id        base64url, what the browser presents at sign-in
 * @property string $public_key           COSE public key, base64url
 * @property integer $sign_count
 * @property array $transports
 * @property string $aaguid
 * @property string $name
 * @property boolean $is_backed_up
 * @property \Carbon\Carbon $last_used_at
 * @property boolean $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class WebauthnCredentials extends Model
{
    use UuidId, SoftDeletes;

    public $timestamps = true;

    protected $table = 'iam_webauthn_credentials';

    protected $guarded = [];

    protected $fillable = [
        'iam_user_id',
        'credential_id',
        'public_key',
        'sign_count',
        'transports',
        'aaguid',
        'name',
        'is_backed_up',
        'last_used_at',
        'is_active',
    ];

    protected $casts = [
        'id' => 'integer',
        'iam_user_id' => 'integer',
        'sign_count' => 'integer',
        'transports' => 'array',
        'is_backed_up' => 'boolean',
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Users::class, 'iam_user_id');
    }
}
