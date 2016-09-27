# Funnel
A catch-all controller (for Laravel)

## Installation
1. Install from Composer:
```sh
composer require marklj/funnel
```
2. Add `Marklj\Funnel\FunnelServiceProvider` to your `app.php` service provider configuration values.
3. Publish the packages configuration:
```sh
php artisan vendor:publish
```
## Quick Start
### 1. Send a request
Send a POST request to `/mailbox`. You can do this with AJAX from your front-end library of choice (Angular / Vue / etc), but for simplicity, we'll use a simple HTML form example.

The default Funnel endpoint is `/mailbox`, but this can be configured in the `funnel.php` configuration file that was published in the installation section.

The `command` request parameter is required and is automatically converted to StudlyCase when processed by Funnel.

```html
<form action="/mailbox" method="POST">
    <input type="hidden" name="command" value="post_blog" />
    <input type="text" name="payload['blog_title']" />
    <button>Submit</button>
</form> 
```

### 2. Map to an Action
Funnel will try to associate the StudlyCase command, in this case `PostBlog`, to an action. This association is made in the `funnel.php` configuration file.

```php
// config/funnel.php
[
    // other config options
    
    'action_mappings' => [
        'PostBlog' => 'App/Blog/Actions/PostAction',
        
        // other mappings here
    ]
]
```

### 3. Create Action
The action class must implement the `Marklj\Funnel\Actionalble` interface. You are free to place whatever code you need here.

All of your payload data data will be available in the `ActionPayload` object. 
```php
<?php namespace App\Blog\Actions;

use Marklj\Funnel\Actionable;
use Marklj\Funnel\ActionPayload;

class PostAction implements Actionable 
{
    public function __invoke(ActionPayload $payload) {
        print 'Hello Funnel!';
        print 'Blog Post Title: ' . $payload->get('blog_title');
    }
}
```