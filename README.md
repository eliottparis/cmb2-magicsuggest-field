CMB2 magicsuggest Field
==================

Custom field for the wordpress [CMB2](https://github.com/WebDevStudios/CMB2) plugin.

cmb2-magicsuggest turns the [magicsuggest script](https://github.com/nicolasbize/magicsuggest) by Nicolas Bize into a custom field type that can be added to your metaboxes.

The `magicselect` field acts much like a select/multiselect field but with a typeahead-style search, allowing you to select items from a list of suggestions. 
This field can also be configured to : 
 * allow the user to enter non-suggested entries.
 * set the limit of items that can be selected.
 * allow the user to reenter the same entry multiple times.

[magicsuggest script demo](http://nicolasbize.com/magicsuggest/examples.html).

## Installation

Follow the example in [`example-field-setup.php`](https://github.com/eliottparis/cmb2-magicsuggest-field/blob/master/example-field-setup.php) for a demonstration. The example assumes you have both CMB2 and this extension in your mu-plugins directory. If you're using CMB2 installed as a plugin, remove [lines 6-9 of the example](https://github.com/eliottparis/cmb2-magicsuggest-field/blob/master/example-field-setup.php#L6-L9).

## Screenshots
![Image](screenshot-1.png?raw=true)

## Usage
The [`example`](https://github.com/eliottparis/cmb2-magicsuggest-field/blob/master/example-field-setup.php) includes two configuration demos of the Magic Suggest custom field.

You can retrieve the meta data using the following:

```php
$fruits = get_post_meta( get_the_ID(), '_cmb2_magicsuggest_demo_fruits', true );
```

This will return an array of string.

```php
$related_posts = get_post_meta( get_the_ID(), '_cmb2_magicsuggest_demo_related_posts', true );
```

This will return an array of related post IDs. You can loop through those post IDs like the following example:

```php
foreach ( $related_posts as $related_post ) {
	$post = get_post( $related_post );
}
```

Once you have the post data for the post ID, you can proceed with the desired functionality relating to each attached post.

## Note
cmb2-magicsuggest does not support all of the [`magicsuggest API`](http://nicolasbize.com/magicsuggest/doc.html) configuration options but only the few that I needed.
