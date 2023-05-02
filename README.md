1. `php artisan passport:keys`

2. `php artisan passport:client --password`
```
What should we name the password grant client? [AuthService Password Grant Client]:
>

Which user provider should this client use to retrieve users? [users]:
[0] users
[1] services
>

Password grant client created successfully.
Client ID: 96c50182-31ea-4a05-98c9-ebbb4bcb298d
Client secret: qaTV7yzGULX7RNMzNq9x4GxU545YJpPdbrTLe9pz
```
Into .env file set these credentials in this way:
```
PASSWORD_GRAND_CLIENT_ID=96a505af-b530-44fc-b7d0-581a13b3ee78
PASSWORD_GRAND_CLIENT_SECRET=p9EGk6Qbu9pzv2iFMCxmFqvMMc1lFciWncG1HLe2
```

3. `php artisan passport:client --password`
```aidl
What should we name the password grant client? [AuthService Password Grant Client]:
 > Service Execution Connector

 Which user provider should this client use to retrieve users? [users]:
  [0] users
  [1] services
 > 1

Password grant client created successfully.
Client ID: 96c50258-fd7f-4a2e-837e-9d972282becf
Client secret: JOyN1nziid9ldOOJMDNx1jYxIrjHOaCX44Tz9GUc
```
Into .env file set these credentials in this way:
```aidl
SERVICE_CONNECTOR_CLIENT_ID=96c50258-fd7f-4a2e-837e-9d972282becf
SERVICE_CONNECTOR_CLIENT_SECRET=JOyN1nziid9ldOOJMDNx1jYxIrjHOaCX44Tz9GUc
```
4. Create a PKCE-enabled client
```aidl
php artisan passport:client --public

 Which user ID should the client be assigned to?:
 >

 What should we name the client?:
 > BackOffice Client

 Where should we redirect the request after authorization? [https://ps-accounts.dev.scalewest.com/auth/callback]:
 > https://ps-article-backoffice.dev.scalewest.com/auth/callback

New client created successfully.
Client ID: 96c508ad-2de7-4813-845d-40db09c966c5
Client secret:
```
This client we will use to SSO settings of BackOffice Client (src/environments/environment.prod.ts as a `passport_client_id` parameter)

Now we will create client_id and for the article editor's application
```aidl
 php artisan passport:client --public
 
 Which user ID should the client be assigned to?:
 >

 What should we name the client?:
 > Article Editor Client

 Where should we redirect the request after authorization? [https://ps-accounts.dev.scalewest.com/auth/callback]:
 > https://ps-article-editor.dev.scalewest.com/auth/callback

New client created successfully.
Client ID: 96c50ae2-91d6-4df2-b9b0-1b1f5ef40def
Client secret:

```

For docker implementation use `php artisan db:seed --class=DockerSeeder` to seed needed data
