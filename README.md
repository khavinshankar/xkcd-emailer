# XKCD EMAILER
#### *a simple web-app to subscribe for recieving a random xkcd comic over the email every 5 mins.*

[`goto SETUP`](#SETUP)

## App Design
##### There are 2 parts to this app,
1. **a php web interface** for the users to subscribe and unsubscribe 
2. **a php script** that downloads a random comic and emails it to the users

### 1. Web Interface
> built based on the customized MVC architechture where [`index.php`](/index.php) is the entry file in which [`DotEnv`](/helpers/DotEnv.php "`DotEnv`"), [`Router`](/Router.php "`Router`") and [`Database`](/Database.php "`Database`") are initailized and every available path is fed into the router which handles the routing, calling the respective function in the controller, [`MainController`](/controllers/MainController.php "`MainController`"), which inturn uses either a model, [`UserModel`](/models/User.php "`UserModel`") to commumicate with the databse or calls the router->render with view path for the view to be rendered by the router for the users to see.

***get to know all the available APIs in the app and the user flow***

* ####  get /
This is the default entry path for the application where [`subscribe()`](/controllers/MainController.php "`subscribe()`") function in the main controller is called which renders the [`subscribe.php`](/views/subscribe.php "`subscribe.php`") view, where the user can enter thier email and click on  subscribe which will trigger [`post /`](#post-).

![image](https://user-images.githubusercontent.com/29787772/146320551-b405fe62-e69f-4abd-aa3a-3f6a9c309868.png)

* ####  post /
This path expects email parameter and calls the [`subscribe()`](/controllers/MainController.php "`subscribe()`") function in the main controller which creates an unverified user in the database and redirects to [`get /send-otp`](#get-send-otp) with email as querry parameter if email is valid else renders [`subscribe.php`](/views/subscribe.php "`subscribe.php`") with an error message.

![image](https://user-images.githubusercontent.com/29787772/146321342-2c66b350-8756-4e46-91c7-be716bf39177.png)

* ####  get /send-otp
This path expects email parameter and calls the [`send_otp()`](/controllers/MainController.php "`send_otp()`") function in the main controller which redirects to [`get /success`](#get-success) if the user is already verified esle genrates a random 6 digit number, stores it in the database and send a mail with the otp to the user and redirects to [`get /verify-otp`](#get-verify-otp) with email as querry parameter.

* ####  get /verify-otp
This path expects email parameter and calls the [`verify_otp()`](/controllers/MainController.php "`verify_otp()`") function in the main controller which renders the [`verify_otp.php`](/views/verify_otp.php "`verify_otp.php`") view, where the user can enter the 6 digit otp that they recieved in the email and click on verify which will trigger [`post /verify-otp`](#post-verify-otp) or they can also click on resend which will trigger [`get /send-otp`](#get-send-otp).

![image](https://user-images.githubusercontent.com/29787772/146320757-fdfcf7d5-ad22-41f6-9c86-ab71747fe6c3.png)

* ####  post /verify-otp
This path expects email and otp parameters and calls the [`verify_otp()`](/controllers/MainController.php "`verify_otp()`") function in the main controller which marks the user as verified and redirects to [`get /success`](#get-success) if entered otp is correct else renders [`verify_otp.php`](/views/verify_otp.php "`verify_otp.php`") with an error message.

![image](https://user-images.githubusercontent.com/29787772/146321022-7683a136-16bb-4552-9347-01b0a271969e.png)

* ####  get /success
This path calls [`all_done()`](/controllers/MainController.php "`all_done()`") function in the main controller which renders [`all_done.php`](/views/all_done.php "`all_done.php`") view showing an ALL DONE message. 

![image](https://user-images.githubusercontent.com/29787772/146321135-71ae9877-94e6-434b-855b-b344d4bef114.png)

* ####  get /unsubscribe
This path expects email and otp parameters and calls [`unsubscribe()`](/controllers/MainController.php "`unsubscribe()`") function in the main controller which deletes the user from the database if otp is correct. There is a link to this path sent to user with every comic email so that if the user wants to unsubscribe, they can unsubscribe.

### 2. Script
> fetches a random comic from [xkcd.com](https://xkcd.com/ "xkcd.com") and also fetches all the verified users in the database and sends an email with title of the comic as the subject, comic image along with unsubscribe link as the body and comic image file as an attachment to all the fetched users.

___
</br>

## SETUP
> On Ubuntu 

```bash
git clone https://github.com/khavinshankar/xkcd-emailer.git xkcd-emailer
cd xkcd-emailer
composer update

# webserver
php -S localhost:80

# script - setting up a cron job to run every 5 mins
{ echo "*/5 * * * * php ~/xkcd-emailer/xkcd-mailer.php" ; } | crontab -
```
