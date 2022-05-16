# ReVa
ReVa (Request Vacation) is the go-to project to manage employee requests for vacations!

## How ReVa may help you
ReVa streamlines the vacation request and approval process through simplicity and automation.
It exposes a dashboard for the users to submit their requests and you only have to click on the "approve" or "reject" link
that will automatically be sent to you after the user's submission. The user will be notified immediately of your decision.

## Installation
You can access the technical documentation [here](https://www.spiroszermalias.com/reva_docs/). Installation is really easy with ReVa and you're only required to perform the least number of steps possible 🙃.
You should be good to go in a few minutes following these steps:
1. Clone the repo to your desired working directory.

2. Create an empty MySQL or MariaDB database and a user with full privileges on the database.
Place the credentials in prod-config.php and/or dev-config.php under the config dir*.
ReVa will populate the database automatically.

3. Run `composer update` to install dependencies.

4. After you make sure that you have set `/public` dir as your webserver's document root,
visit `example.com/setup` (if your domain would be example.com). This will allow you to
add the first admin user. Voila!

You might also want to set some of the options found in config/config.php - for example the Timezone or even
the "from" email address (GLOBAL_MAIL_FROM constant).

*These two files are identical and are meant to be used in case you need to separate
development from production-specific configuration constants. The config that gets loaded
is controlled by the master config.php located in the same dir, by setting `APP_MODE`.

## Features
###### Application user
* Email notifications
* Request history, state and other info
* User authentication
* User edit and roles
* Quick approve/reject
* Responsive design
###### Technical features
* PSR-4 class autoloading
* Multiple alias functions to easily access class methods'
* bramus/router for routing
* MeekroDB for easy and secure DB transactions
* User persistent sessions
* Strong authentication hashing using bcrypt
* Strong password validation

## Basic usage
Usage is pretty simple. Below, usage is referenced based on the two distinct user roles:

###### Admins
As an 'admin' user you may perform these actions:
* Register new users.
* Edit existing users.
* Approve or reject vacation requests.
You are also able to submit vacation requests yourself but whether or not this makes sense, depends on you/organization and your workflow.

###### Employees
As an 'employee' user:
* Submit requests for vacation time, stating the reason and date-range (end date ir forced to be larger than the start one).
* Watch your request history, info and state

## Mumbo jumbo
For the more tech savvy out there, you may be interested in the following technical notes to keep in mind
in case you need to extend or tweak the codebase. For more, access the documentation [here](https://www.spiroszermalias.com/reva_docs/).

###### Project structure
Most of the code that you may need to deal with is in the /App directory. Directory tree:
```
├───App
│   ├───Controller
│   ├───core
│   ├───functions
│   ├───Model
│   └───views
│       └───global
```

###### Security and user sessions
Loging in by default sets the session lifetime to a month. Wherever hashing is performed, bcrypt algorithm is explicitly used.
Each logged in user gets attached to these cookies:
* `random_password` and `random_selector` which are random hashed values. They do NOT relate by any means to the user's original or hashed password.
* `user_login` which contains the login identifier (the email in our case)
* The default php session cookie `PHPSESSID`
