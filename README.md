# 26929. Test Assignment for Laravel _ Frontend 

https://app.codeline.io/#/projects/3064/tasks/26929

# For Developer

## Installation procedure

### Backend
1. Run `composer update`
2. Run `php artisan key:generate`
3. Update .env variables
4. Run `php artisan migrate:fresh --seed`
5. Run `php artisan passport:install`
6. Run `php artisan passport:keys`
7. Run `php artisan passport:client --personal`
8. On local device run `php artisan serve` to start server

Note: the project makes use of Cloudinary to store images so ensure to include the following variables in your .env file
```
	CLOUDINARY_API_KEY=***YOUR API KEY****
	CLOUDINARY_API_SECRET=***YOUR API SECRET***
	CLOUDINARY_CLOUD_NAME=***YOUR CLOUDNAME***
```


### Frontend
1. Run `yarn install`
2. Run `yarn run dev` for development or `yarn run production` for production

# For Users

#### The landing page for users is the laravel wlecome screen. No functionality has been created for users here. Only Admins have viewable/usable pages currently

### For Admins
1. The URL for the landing page for admin is `http://localhost:PORT/admin/` for local pages or `http://DOMAIN_NAME/admin/` if deployed on a server
2. The admin landing page is a login page. Once logged in Admin is redirected to hotel page.
3. On Hotel page admin can perform **RUD** operations on the hotel.
4. The navigation bar on the left containes links to the other pages where Admin can perform **CRUD** operations for rooms, room types, prices and bookings.
5. On the bookings manager page, you can switch between list and calendar view for bookings. Edit is only enabled for list view


