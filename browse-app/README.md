# Browse App

React based app for rending the search facets as defined in the admin

## Tech overview



## Development Notes

Add a mu.local.php plugin to mu-plugin directory with the following

add_filter( 'browse_js_dev_path', function () {
	return 'https://localhost:3000/dist/master.js';
} );

and then run `npm run dev`

Make sure to first hit https://localhost:3000/dist/master.js and allow https to insecure server


