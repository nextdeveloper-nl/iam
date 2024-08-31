# NextDeveloper IAM Library
This library provides an enterprise level basic identity and access management functionality. Functionalities here on this library is kept as simple as can be. The idea behind this library is for the developer to make it as complicated as they want.

Identity management software is a crucial tool in today's security-conscious digital environment. We will be adding these functionalities through time. Core functionalities of an identity management software usually include the following:

- [x] User Provisioning: This feature enables administrators to create, modify, disable or delete user accounts and permissions across IT systems in a timely manner. This also includes account (or team) provisioning. 
- [ ] Authentication: Authentication ensures that users are who they claim to be. This could include multi-factor authentication (MFA), biometric authentication, or password management.
- - [ ] Password
- - [x] One Time Email (OTP)
- - [ ] One Time SMS (OTP)
- - [ ] Google
- - [ ] Facebook
- - [ ] Yahoo
- - [ ] OpenID
- - [ ] Microsoft
- - [ ] Apple
- - [ ] Github
- - [ ] Gitlab
- - [ ] Linkedin
- - [ ] Twitter
- - [ ] Firebase
- - [ ] OneAll
- - [ ] OneLogin
- - [ ] Okta
- - [ ] Auth0
- [ ] Authorization: After verifying identity through authentication, the system determines what actions the user is allowed to perform, what files they can access, what resources they can use, etc.
- [ ] Single Sign-On (SSO): This feature allows users to log in once and gain access to a variety of applications, eliminating the need to remember multiple passwords.
- [ ] Federated Identity: This allows users to use the same credentials across different systems or even across different organizations.
- [ ] Directory Services: These services store, organize, and provide access to information about users and resources.
- - [ ] LDAP
- - [ ] Active Directory
- [x] Role-Based Access Control (RBAC): This feature enables the assignment of access rights based on roles within the organization. For example, all employees in the marketing department could have similar access rights.
- [ ] Identity Governance: This includes tools for defining and implementing policies and rules for user access and for auditing and reporting on user access.
- [ ] Identity Lifecycle Management: This includes the processes for managing identities from the initial creation of the account, through various changes, to the eventual retirement of the account.
- [ ] Password Management: Tools for managing and resetting passwords, enforcing password policies, etc.
- [ ] Risk-Based Authentication (RBA): This feature uses machine learning to assess the risk level of user activities and adapt the authentication requirements accordingly.
- [ ] Integration with Other Systems: Identity management systems need to integrate with other systems, like HR systems, to automate the process of adding, changing, and removing users as employees join, move within, or leave the organization.
- [ ] 2FA implementations
- - [ ] SMS one time code
- - [ ] Email one time code 
- - [ ] Whatsapp one time code
- - [ ] Telegram one time code
- - [ ] Various push mechanisms for one time code
- - [ ] Google Authenticator
- - [ ] SMS
- - [ ] Whatsapp

These functionalities provide a way for organizations to manage digital identities effectively, helping ensure security and compliance with data privacy regulations.

# Authentication Mechanisms
In this library we try to support almost all available authentication mechanisms as well as a secure authorization mechanisms. For that we will be applying various standarts stated previously.

# Password Management
For password management we are and will be applying various different practices to increase the security;
- [x] using Argon2id for hashing passwords and scrypt for fallback.
- [ ] storing the old passwords to check if the user is not using the very same password
- [ ] checking the password quality, in terms of complexity
- [ ] rehashing passwords using rehash algorithms if available.

Notes to developers;
- Please take a good look at configuration file which is under the config folder.
- Please set the hashing algorithm, and please use argon2id or scrypt for fallback.

Notes for myself, and maybe you ?
- https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html#argon2id
- https://wiki.php.net/rfc/argon2_password_hash

# Token Management
We are producing tokens with JWT and Laravel Password implementation. However we are also creating different tokens to be able to login user with the client information and location information for enhanced security. That is why we are actually saving tokens with location, ip, client information (user-agent), JWT token and returning the user a hash of this data. When the user sends the token without "NDAuth" keyword instead of "Bearer" we understand that they are using our implementation of token management. In that case we go to JWT token database and look at the client information. If we think that the user is correct then we return the JWT token.

## Transparent JWT token manipulation
When the user is sending the token that we generate instead of JWT token, we need to tell the application that the user is valid and its the user we are looking for. There are various ways to do this, including but not limited to database search, redis search or monipulation at load balancer or proxy level.

We implement application level lookup at the moment but we will be offering Load Balancer level of lookup for reduced cpu usage and overhead.

- [x] Application lookup
- [ ] Load balancer lookup

# Commercial Support
Please let us know if you need any commercial support. We dont have such a business plan but we will be happy to help you on your project and/or applying this library in your project

# Want to contribute?
You are very welcome to contribute of course. Please send us an email so that we can get in touch and talk about details;
codewithus@nextdeveloper.com
