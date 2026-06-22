# PHP_Laravel10_Shortcodes_With_API


## Project Description

PHP_Laravel10_Shortcodes_With_API is a Laravel 10 RESTful API application that demonstrates how custom shortcodes can be converted into HTML output using a shortcode parsing system.

The application provides API endpoints to parse WordPress-like shortcodes, store parsed content in the database, and retrieve shortcode posts through JSON responses. It uses the tehwave/laravel-shortcodes package for shortcode compilation and follows a clean REST API architecture.


## Key Features

🔹 Create shortcode content via API

🔹 Parse shortcodes into HTML

🔹 Return JSON response

🔹 Store posts in database

🔹 Fetch parsed content anytime

🔹 WordPress-like shortcode engine

🔹 Laravel 10 RESTful API



## Technologies Used

* Laravel 10
* PHP 8+
* MySQL
* REST API
* Composer
* JSON
* tehwave/laravel-shortcodes Package



## Project Highlights

✨ Implementation of WordPress-style shortcodes in Laravel

✨ Custom shortcode classes for reusable HTML components

✨ Real-time parsing of user input into HTML output

✨ Clean MVC architecture (Controller + Model + API Routes)

✨ Package-based integration for scalability

✨ RESTful API architecture

✨ JSON-based request and response handling

✨ Beginner-friendly and interview-ready project



## Application Flow

1. Client sends API request with shortcode content
2. Request reaches Laravel API route
3. Controller validates incoming data
4. Shortcode package compiles shortcode content
5. Parsed HTML is generated
6. Data is optionally stored in database
7. JSON response is returned to client


## Requirements

- PHP 8.1+
- Composer
- MySQL
- Laravel 10


---



## Installation Steps


---


## STEP 1: Create Laravel 10 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel10_Shortcodes_With_API "10.*"

```

### Go inside project:

```
cd PHP_Laravel10_Shortcodes_With_API 

```

#### Explanation:

Creates a fresh Laravel 10 application using Composer.

This is the base structure for building the Shortcodes system.




## STEP 2: Database Setup 

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel10_shortcodes_api
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel10_shortcodes_api


```



#### Explanation:

Configures MySQL connection inside .env file.

Database stores all application data like posts and content.




## STEP 3: Install Shortcode Package

### Run:

```
composer require tehwave/laravel-shortcodes

```

#### Explanation:

Installs tehwave/laravel-shortcodes via Composer.

This package provides shortcode parsing functionality.





## STEP 4: Publish Configuration

### Run:

```
php artisan vendor:publish --provider="Tehwave\Shortcodes\ShortcodesServiceProvider"

```

#### Explanation:

Publishes package config into Laravel project.

Allows customization of shortcode behavior and settings.





## STEP 5: Create Migration

### Run:

```
php artisan make:model Post -m

```

### database/migrations/xxxx_create_posts_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->text('parsed_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

```


### app/Models/Post.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content',
        'parsed_content'
    ];
}

```

### Run

```
php artisan migrate

```


#### Explanation:

Creates the posts table and Post model.

The table stores original shortcode content and parsed HTML output.





## STEP 6: Create Shortcodes Folder


### Make:

```
app/
└── Shortcodes/
    ├── AlertShortcode.php
    ├── ButtonShortcode.php
    └── BadgeShortcode.php

```

### app/Shortcodes/AlertShortcode.php

```
<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class AlertShortcode extends Shortcode
{
    protected $tag = 'alert';

    public function handle(): ?string
    {
        return "<div class='alert alert-warning'>{$this->body}</div>";
    }
}

```


### app/Shortcodes/ButtonShortcode.php

```
<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class ButtonShortcode extends Shortcode
{
    protected $tag = 'button';

    public function handle(): ?string
    {
        $url = $this->attributes['url'] ?? '#';

        return "<a href='{$url}' class='btn btn-primary'>{$this->body}</a>";
    }
}

```

### app/Shortcodes/BadgeShortcode.php

```
<?php

namespace App\Shortcodes;

use tehwave\Shortcodes\Shortcode;

class BadgeShortcode extends Shortcode
{
    protected $tag = 'badge';

    public function handle(): ?string
    {
        return "<span class='badge bg-success'>{$this->body}</span>";
    }
}

```

#### Explanation: 

Creates custom shortcode classes (Alert, Button, Badge).

Each class defines how a shortcode will render HTML.




## STEP 7: Register Shortcodes

### config/shortcode.php

```
<?php

return [
    'shortcodes' => [
        'alert' => App\Shortcodes\AlertShortcode::class,
        'button' => App\Shortcodes\ButtonShortcode::class,
        'badge' => App\Shortcodes\BadgeShortcode::class,
    ],
];

```


#### Explanation: 

Registers all shortcode classes inside config/shortcode.php.

Laravel uses this file to map tags to classes.



## STEP 8: Create API Controller

### Run:

```
php artisan make:controller Api/ShortcodeController

```

### app/Http/Controllers/Api/ShortcodeController.php

```
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use tehwave\Shortcodes\Shortcode;

class ShortcodeController extends Controller
{
    // CREATE + PARSE
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $parsed = Shortcode::compile($request->content);

        $post = Post::create([
            'content' => $request->content,
            'parsed_content' => $parsed
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => $post
        ]);
    }

    // GET ALL POSTS
    public function index()
    {
        return response()->json(Post::latest()->get());
    }

    // GET SINGLE POST
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post);
    }

    // PARSE ONLY (NO SAVE)
    public function parse(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $parsed = Shortcode::compile($request->content);

        return response()->json([
            'original' => $request->content,
            'parsed' => $parsed
        ]);
    }
}

```


#### Explanation: 

Handles input and processes shortcode parsing logic.

Converts raw shortcode text into HTML output.





## STEP 9: Add Routes

### routes/api.php

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShortcodeController;

Route::get('/posts', [ShortcodeController::class, 'index']);
Route::get('/posts/{id}', [ShortcodeController::class, 'show']);

Route::post('/posts', [ShortcodeController::class, 'store']);
Route::post('/parse', [ShortcodeController::class, 'parse']);

```

#### Explanation: 

Defines REST API endpoints for parsing and managing shortcode content.

Connects API requests to controller methods.



## STEP 10: API Testing Using Postman 

### Start dev server:

```
php artisan serve

```


### Open in browser:

```
http://127.0.0.1:8000

```

### Parse Shortcode Only (Without Saving)

1. Method: POST

2. URL:

```
http://127.0.0.1:8000/api/parse

```
3. Headers:

```
Accept: application/json
Content-Type: application/json

```

4. Body → raw → JSON

```
{
    "content": "[alert]Welcome to Laravel API[/alert]"
}

```

#### Response:

```
{
    "original": "[alert]Welcome to Laravel API[/alert]",
    "parsed": "<div class='alert alert-warning'>Welcome to Laravel API</div>"
}

```



### Create Post (Parse + Save)

1. Method: POST

2. URL:

```
http://127.0.0.1:8000/api/posts

```

3. Headers:

```
Accept: application/json
Content-Type: application/json

```

4. Body → raw → JSON

```
{
    "content": "[badge]New Feature[/badge]"
}

```

#### Response:

```
{
    "message": "Post created successfully",
    "data": {
        "id": 1,
        "content": "[badge]New Feature[/badge]",
        "parsed_content": "<span class='badge bg-success'>New Feature</span>"
    }
}

```



### Get All Posts

1. Method: GET

2. URL:

```
http://127.0.0.1:8000/api/posts

```

3. Headers:

```
Accept: application/json

```

#### Response:

```
[
    {
        "id": 1,
        "content": "[badge]New Feature[/badge]",
        "parsed_content": "<span class='badge bg-success'>New Feature</span>"
    }
]

```


### Get Single Post

1. Method: GET

2. URL:

```
http://127.0.0.1:8000/api/posts/1

```

3. Headers

```
Accept: application/json

```

#### Response

```
{
    "id": 1,
    "content": "[badge]New Feature[/badge]",
    "parsed_content": "<span class='badge bg-success'>New Feature</span>"
}

```




### Test Button Shortcode

1. Method: POST

2. URL

```
http://127.0.0.1:8000/api/parse

```

3. Body:

```
{
    "content": "[button url=\"https://laravel.com\"]Visit Laravel[/button]"
}

```

#### Response

```
{
    "original": "[button url=\"https://laravel.com\"]Visit Laravel[/button]",
    "parsed": "<a href='https://laravel.com' class='btn btn-primary'>Visit Laravel</a>"
}

```


### Test Multiple Shortcodes

1. Method: POST

2. URL:

```
http://127.0.0.1:8000/api/parse

```

3. Body:

```
{
    "content": "[alert]Welcome[/alert] [badge]New[/badge] [button url=\"https://laravel.com\"]Click Here[/button]"
}

```

#### Response:

```
{
    "original": "[alert]Welcome[/alert] [badge]New[/badge] [button url=\"https://laravel.com\"]Click Here[/button]",
    "parsed": "<div class='alert alert-warning'>Welcome</div> <span class='badge bg-success'>New</span> <a href='https://laravel.com' class='btn btn-primary'>Click Here</a>"
}

```


#### Explanation:

Starts Laravel development server using Artisan.

Allows testing project in browser at localhost.



## API Testing Results (Postman)


### Parse Shortcode Only (Without Saving):


<img width="1402" height="907" alt="Screenshot 2026-06-22 110620" src="https://github.com/user-attachments/assets/7a4d914e-a4e7-4ff7-b897-053845a92e50" />


### Create Post (Parse + Save):


<img width="1396" height="912" alt="Screenshot 2026-06-22 110838" src="https://github.com/user-attachments/assets/9bacc582-3ab2-495b-9a21-cb270d53bd2e" />


### Get All Posts:


<img width="1399" height="913" alt="Screenshot 2026-06-22 110935" src="https://github.com/user-attachments/assets/001e0dbd-f8e3-4cd2-b6c1-dfc4511b0cf3" />


### Get Single Post:


<img width="1406" height="916" alt="Screenshot 2026-06-22 111040" src="https://github.com/user-attachments/assets/c75506b1-477d-4bbc-a489-3bce1186810f" />


### Test Button Shortcode:


<img width="1397" height="908" alt="Screenshot 2026-06-22 111136" src="https://github.com/user-attachments/assets/fcaa754b-a7b7-42b7-9869-baf834d4284a" />


### Test Multiple Shortcodes:


<img width="1400" height="914" alt="Screenshot 2026-06-22 111218" src="https://github.com/user-attachments/assets/24d14bd8-5cff-4a0b-9824-56374f2a9a0b" />



---


## Project Folder Structure

```
PHP_Laravel10_Shortcodes_With_API/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           └── ShortcodeController.php
│   │
│   ├── Models/
│   │   └── Post.php
│   │
│   └── Shortcodes/
│       ├── AlertShortcode.php
│       ├── BadgeShortcode.php
│       └── ButtonShortcode.php
│
├── config/
│   └── shortcode.php
│
├── database/
│   ├── migrations/
│   │   └── xxxx_xx_xx_create_posts_table.php
│   │
│   └── seeders/
│
├── routes/
│   ├── api.php
│   └── web.php
│
├── resources/
│   └── views/
│
├── public/
│
├── storage/
│
├── bootstrap/
│
├── vendor/
│
├── tests/
│
├── .env
├── .env.example
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── phpunit.xml
└── README.md
```
