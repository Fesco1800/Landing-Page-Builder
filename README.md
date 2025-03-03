# RMS - Codebase

This uses a simple Model-View-Controller (MVC) framework which is designed to develop modular features.

## Requirements

- PHP 8.0+ (recommended version is 8.0.29)
- MySQL (recommended version is 5.7)

## Basic Structure

```
Project
-- .htaccess
-- application
|  -- config
|  |  -- config.php
|  -- core
|  |  -- application.php
|  |  -- controller.php
|  -- controller
|  |  -- home.php
|  -- model
|  |  -- custom
|  |  -- page
|  |  |  -- home_model.php
|  -- view
|  |  -- _templates
|  |  |  -- header
|  |  |  -- sidebar
|  |  |  -- footer
|  -- libs
|  |  -- database.php
|  |  -- publicFunctions.php
-- public
|  -- index.php
|  -- .htaccess
|  -- css
|  |  -- style.css
|  |  -- page
|  |  |  -- home.css
|  |  -- custom
|  -- js
|  |  -- page
|  |  |  -- home.js
|  |  -- custom
|  -- img
|  -- plugins
|  -- files
```

## Theme Plugins Used

- Bootstrap 5.3.2
- Bootstrap Icons
- ckeditor 5
- Datatable 1.13.4 (other extensions included)
- jQuery 3.7.1 (Vanilla JS is recommended for front-end scripts, however, jQuery can still be used if you prefer)

## Configuration

Setup config file under `/application/config/config.php`

- Update database constants for your development use:
  - `DB_NAME`
  - `DB_USER`
  - `DB_PASS`
  - Note: Keep the `DB_CHARSET` as `utf8mb4`, this is the universal charset being used to prevent encoding issues.
- Update `APP_VERSION` for every major updates to prevent caching issues, app version is applied to css/js files to ensure new updates are applied.
- For Database side (MySQL), please set default storage engine as `InnoDB`, it is recommended to apply relational database. Also set default collation to `utf8mb4_unicode_520_ci`

## Overview

This is a URL based framework.
URL will always end with a trailing slash.

For example we have `rms.com` domain, then we want to add `users` module or endpoint, we will need to add the following files:

- **controller**: `/application/controller/users.php`
  - Please refer to `/application/controller/home.php` file as reference, update the class name accordingly.
  - If module name is two words, for example `User Settings`, set controller name as `user-settings.php` and set class name as `UserSettings`
- **model**: `/application/model/users_model.php`
  - Please refer to `/application/model/home_model.php` file as reference, update the class name accordingly.
  - If module name is two words, for example `User Settings`, set model name as `user-settings_model.php` and set class name as `UserSettingsModel`
- **view**: `/application/view/users/index.php`
  - Please refer to `/application/view/home/index.php` file as reference.
  - `/application/view/users/index.php` points to module home page `rms.com/users/`
  - We can add other pages within users module, for example, adding `/application/view/users/profile.php` which points to `rms.com/users/profile/`, then add the corresponding page initialization under controller file.
- **css** (optional): `/public/css/page/users.css`
- **js** (optional): `/public/js/page/users.js`

Above files are auto loaded for the page.
It is also possible to add and include custom models which acts as a separate library to organize module functions, can also add custom css/js.

### Controller Page Initialization

Sample page initialization under `/application/controller/users.php`:

    PHP:

    function index() {
    	$breadcrumb = [
    		[
    			'label' => 'Users',
    			'active' => true,
    			'icon' => '<i class="bi bi-people"></i>'
    		]
    	];

    	require APP . "view/_templates/header.php";
    	require APP . "view/users/index.php";
    	require APP . "view/_templates/footer.php";
    }

#### Page breadcrumb

We can set page breadcrumb using `$breadcrumb` variable, example:

    PHP:

    $breadcrumb = [
    	[
    		'label' => 'Users',
    		'url' => URL . 'users',
    		'icon' => '<i class="bi bi-people"></i>'
    	],
    	[
    		'label' => 'Settings',
    		'active' => true
    	]
    ];

### Creating Functions

We can add a function under a controller, for example, we want to have a function to get list of users. Add a function under `users` controller:

    PHP:

    function get_user_list() {
        $userStatus = $_POST['user_status'];
    	$list = $this->model->get_user_list($userStatus);
    	outputJson($list);
    }

Above function corresponds to this URL: `rms.com/users/get-user-list/`
Sample HTTP Request (POST) from front-end script:

    JS:

    const postData = new URLSearchParams();
    postData.append('user_status', 'active');
    post(url + 'users/get-user-list/', postData)
    	.then((response) => {
    		if (response.ok) return response.json();
    		throw new Error('Something went wrong');
    	})
    	.then((response) => {
    		// code
    	})
    	.catch((error) => {
    		console.log('post_request_error', error);
    	});

A function can have a URL parameter, for example:
`function get_user_list($status = 'active')`
Then the request URL will be `rms.com/users/get-user-list/inactive/`
You can add more parameters if needed.

### Database Library

Database library is located under `/application/libs/database.php`
This contains functions to transact database records.
DB library uses PDO.

### Models

Models extends `Database` library.
Functions which transacts database records should be added under models, and it is good to have a common/single function for specific module method to prevent function redundancy.

Under a controller, we can access corresponding model function by accessing model property, for example:

    PHP:

    $this->model->get_user_list();

#### Including other page model

We can include other page model which we can use, for example, we add `product_model.php` under `/application/model/page/`, then we can include this model to other controller/model file like below:

    PHP:

    require DIR_MODEL_PAGE . 'product_model.php';
    $modelProduct = new ProductModel;
    $data = $modelProduct->get_product_details();

#### Including custom model

We can also create custom models, for example we add `client_model.php` under `/application/model/custom/`, then we can include like below:

    PHP:

    require DIR_MODEL_CUSTOM . 'client_model.php';
    $modelClient = new ClientModel;

We can include and use page/custom models under `controller` or `model` file.

### Page Template

Header, Sidebar and Footer templates are located under `/application/view/_templates/`

#### Adding a sidebar nav item

Sidebar nav menu items are defined within `sidebar.php` file.
`sidebarGenerateItems()` function is used to output predefined sidebar items (`$navItems` array).

Example of adding a nav item:

    PHP:

    $navItems[] = [
    	'controller' => 'users',
    	'icon' => 'bi-people',
    	'label' => 'Users'
    ];

Example of adding a nav item with sub-pages/dropdowns:

    PHP:

    $navItems[] = [
    	'controller' => 'users',
    	'icon' => 'bi-people',
    	'label' => 'Users',
    	'sub_items' => [
    		[
    			'controller' => 'users',
    			'icon' => 'bi-caret-right',
    			'label' => 'Users Home Page'
    		],
    		[
    			'controller' => 'users',
    			'action' => 'user_settings',
    			'icon' => 'bi-caret-right',
    			'label' => 'User Settings'
    		]
    ];

A nav sub item can have another sub items.

### Public Files

Public files are under `/public/` directory. This contains following files:

- css
- js
- img
- plugins
- files (can contain user uploaded files or similar)

#### CSS/JS page files

CSS and JS page files are located under `/public/css/page/` and `/public/js/page/` respectively.
Filenames for page CSS/JS must correspond to controller name, for example for users module, add `users.js` or `users.css`.
css/js page files are auto included when rendering the page, these files are optional.

#### CSS/JS custom files

We can add custom CSS/JS under `/public/css/custom/` and `/public/js/custom/` respectively, for example add following files:

- `/public/css/custom/test-custom-style.css`
- `/public/js/custom/test-custom-script.js`

Then we can include these files under controller page initialization like below:

    PHP:

    function index() {
    	$breadcrumb = [
    		[
    			'label' => 'Home',
    			'active' => true,
    			'icon' => '<i class="bi bi-house-door"></i>'
    		]
    	];

    	$customCSS = [
    		'test-custom-style'
    	];

    	$customJS = [
    		'test-custom-script'
    	];

    	require APP . "view/_templates/header.php";
    	require APP . "view/home/index.php";
    	require APP . "view/_templates/footer.php";
    }

### Plugins

Plugins are not directly included under header/footer templates.
Plugins must me defined under `sysPlugins($type)` function under public functions library `/application/libs/publicFunctions.php` as shown below:

    PHP:

    function sysPlugins($type) {
    	if ($type === 'datatable') {
    		return [
    			'css' => [
    				'datatable/datatables.min',
    				'datatable/Responsive-2.4.1/css/responsive.bootstrap5.min'
    			],
    			'js' => [
    				'datatable/datatables.min',
    				'datatable/Responsive-2.4.1/js/responsive.bootstrap5.min',
    			]
    		];
    	} else if ($type === 'datepicker') {
    		return [
    			'css' => [
    				'bootstrap-datepicker/css/bootstrap-datepicker.min'
    			],
    			'js' => [
    				'bootstrap-datepicker/js/bootstrap-datepicker.min'
    			]
    		];
    	} else if ($type === 'ckeditor') {
    		return [
    			'js' => [
    				'ckeditor5-build-classic/build/ckeditor'
    			]
    		];
    	}
    	return null;
    }

We can add more plugins by adding plugin folder resources under `/public/plugins/` and define its resources (css and/or js files) under `sysPlugins($type)` function like above.

Then we can include these plugins under `controller` page initialization like below:

    PHP:

    function index() {
    	$breadcrumb = [
    		[
    			'label' => 'Home',
    			'active' => true,
    			'icon' => '<i class="bi bi-house-door"></i>'
    		]
    	];

    	$pluginCSS = [];
    	$pluginCSS = array_merge($pluginCSS, sysPlugins('datatable')['css']);

    	$pluginJS = [];
    	$pluginJS = array_merge($pluginJS, sysPlugins('datatable')['js']);
    	$pluginJS = array_merge($pluginJS, sysPlugins('ckeditor')['js']);

    	require APP . "view/_templates/header.php";
    	require APP . "view/home/index.php";
    	require APP . "view/_templates/footer.php";
    }

### Other Notes

- When implementing new module, module functions should not be included under general libraries like:
  - `/application/libs/publicFunctions.php`
  - `/public/js/applications.js`
- Module functions should only be under page/custom `models` or page/custom `script/js`. Same goes to styles or `css`, module styles should not be added under `/public/css/style.css`, add page/custom css file for this.
- Organize module files and functions, group functions by `models` (custom) if module covers many areas, same goes to `js/scripts`, following OOP approach is good.
