## Laravel CRUD API with Auth
Laravel CRUD API application for RMMS project included with Authentication Module & Book, Video, & Device Module. It's included with JWT authentication and Swagger API format.

----

### Language & Framework Used:
1. PHP-8
1. Laravel-9

### Architecture Used:
1. Laravel 9.x
1. Interface-Repository Pattern
1. Model Based Eloquent Query
1. Swagger API Documentation - https://github.com/DarkaOnLine/L5-Swagger
1. JWT Auth - https://github.com/tymondesigns/jwt-auth
1. PHP Unit Testing - Some basic unit testing added.

### Add, update & remove announcement
```bash
sudo nano /var/www/rmms-backend/public/announcement.txt
```
after updating the txt file hit ctrl + x > enter Y > hit enter again to save.
### Update admin password
```bash
sudo nano /var/www/rmms-backend/public/admin_password.txt
```
after updating the txt file hit ctrl + x > enter Y > hit enter again to save.
### API List:
##### Authentication Module
1. [x] Register User API with Token
1. [x] Login API with Token
1. [x] Authenticated User Profile
1. [x] Refresh Data
1. [x] Logout

##### Book Module
1. [x] Book List
1. [x] Book List [Public]
1. [x] Create Book
1. [x] Edit Book
1. [x] View Book
1. [x] Delete Book

##### Video Module
1. [x] Video List
1. [x] Video List [Public]
1. [x] Create Video
1. [x] Edit Video
1. [x] View Video
1. [x] Delete Video

##### Device Module
1. [x] Device IP
1. [x] Device List
1. [x] Device List [Public]
1. [x] Create Device
1. [x] Edit Device
1. [x] View Device
1. [x] Delete Device

### How to Run:
1. Clone Project - 

```bash
git clone https://github.com/juancarloscruzdela/rmms-backend.git
```
1. Go to the project drectory by `cd rmms-backend` & Run the
2. Create `.env` file & Copy `.env.example` file to `.env` file
3. Create a database called - `rmms`.
4. Install composer packages - `composer install`.
5. Now migrate and seed database to complete whole project setup by running this-

Migrate tables
``` bash
php artisan migrate:refresh
```
Migrate & seed tables
``` bash
php artisan migrate:refresh --seed
```
It will create `21` Users and `103` Dummy Books.

6. Generate Swagger API
``` bash
php artisan l5-swagger:generate
```
7. Initialize API routes & config.
``` bash
php artisan optimize
```
8. Run the server -
``` bash
php artisan serve
```
9. Open Browser -
http://127.0.0.1:8000 & go to API Documentation -
http://127.0.0.1:8000/api/documentation
10. You'll see a Swagger Panel.


### Procedure
1. First Login with the given credential or any other user credential
1. Set bearer token to Swagger Header or Post Header as Authentication
1. Hit Any API, You can also hit any API, before authorization header data set to see the effects.

### Test
1. Test with Postman - https://www.getpostman.com/collections/5642915d135f376b84af [Click to open with post man]
1. Test with Swagger.
1. Swagger Limitation: Image can not be uploaded throw Swagger, it can be uploaded throw Postman.
