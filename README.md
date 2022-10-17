# LaraCaptcha
Laravel simple captcha

## Documentation
LaraCaptcha is an easy-to-use captcha creator package for Laravel framework.
It is built based on Laravel APIs and you can use it alongside Laravel facilities.
LaraCaptcha using image based captcha to protect you from spams.


### Installation
Run Terminal (Linux Based Environment) or Command Prompt (Windows OS)
for your project's root where you can see `composer.json' file.
Then run following command:

```
composer require miladrahimi/laracaptcha
```

After adding the package to your project, you need to add LaraCaptcha provider to your project's providers.
To do that, open `config/app.php` file and append following code to the list of providers.

Laravel <= 5.0

```
'MiladRahimi\LaraCaptcha\Provider',
```

Laravel => 5.1

```
MiladRahimi\LaraCaptcha\Provider::class,
```

### Captcha Image
You need to display a captcha image in your HTML forms,
so LaraCaptcha provides a image url like what you see below that you can use easily.

```
http://your-project.com/laracaptcha.png
```

You may use Laravel `url()` function in Blade template system to resolve this URL.

```
{{ url('/laracaptcha.php') }}
```

So your captcha image should be like this:

```
<img src="{{ url('/laracaptcha.php') }}">
```

### Random URL and caching problem
If you use methods mentioned above you will face to caching problem very soon.
As it's needed every captcha must be a different thing when user reloads the page or press refresh button.
But sometimes user browsers like Firefox and Chrome cache the image
so users see the same image while server has created new image.

You may ask what should I do now? That's a good question!
You have to add a fake parameter to the image url and pass a random value like following example:

```
http://your-project.com/laracaptcha.png?r=65442
```

To do it in Blade template system:

```
url('/laracaptcha.png?r=' . rand(0, 100000))
```

So your captcha image should be like this:

```
<img src="{{ url('/laracaptcha.png?r=' . rand(0, 100000)) }}">
```

### Refresh Button
If you don't need to refresh button for you captcha skip this section.

You are still here so you need it!

I consider you have created a button in your page Blade like this:

```
<button type="button" id="refresh">Refresh</button>
```

So you need to add following jQuery code to your page:

```
<script>
    $("#refresh").click(function () {
        $("#captcha").attr("src", '/laracaptcha.png?r=' + Math.random());
    });
</script>
```

### Validation
Now it's time to validate user input.
I hope you use Laravel validation rules, so you can use `laraCaptcha` rule just like this:

```
$validator = Validator::make(Request::all(), [
    'captcha' => 'required|laraCaptcha',
]);
if ($validator->fails()) {
    // On error
} else {
    // No error
}
```
* `captcha` is the name of HTML form field. 

Of course there is one step left.
You should add a user-friendly error message if the user entered wrong captcha.
To do this, open `resources/lang/en/validation.php` and add following item to the existent array.

```
"laracaptcha" => "You entered the security code incorrectly.",
```

Of course you are able to use `:attribute` in the validation message instead.

This approach enables you to use Laravel internationalization tools.

## Homepage
*   [LaraCaptcha](http://miladrahimi.github.io/laracaptcha)

## Contributors
*	[Milad Rahimi](http://miladrahimi.com)

## License
LaraCaptcha is released under the [MIT License](http://opensource.org/licenses/mit-license.php).
