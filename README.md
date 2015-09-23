CMB2 magicsuggest Field
==================

Custom field for the wordpress [CMB2](https://github.com/WebDevStudios/CMB2) plugin.

cmb2-magicsuggest allows you to add a [magicsuggest](https://github.com/nicolasbize/magicsuggest) field type to your metaboxes.

## Installation

Follow the example in [`example-field-setup.php`](https://github.com/eliottparis/cmb2-magicsuggest-field/blob/master/example-field-setup.php) for a demonstration. The example assumes you have both CMB2 and this extension in your mu-plugins directory. If you're using CMB2 installed as a plugin, remove [lines 6-9 of the example](https://github.com/eliottparis/cmb2-magicsuggest-field/blob/master/example-field-setup.php#L6-L9).

## Screenshots
![Image](screenshot-1.png?raw=true)

## Customization
The example demonstrates how to configure the Magic Suggest custom field.

## Usage
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
