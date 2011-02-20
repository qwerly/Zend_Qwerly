Observations
============

Qwerly's API provides two sets of methods: "full" ones and just services ones.
With the full ones you can pull all the data qwerly has about an user
searching by Twitter username, Facebook username, Facebook user id or qwerly
username.
Meanwhile, the "services" ones let you do just the same but they retrieve just
the services the user uses.

We think that it's not very useful to have this last set of methods, since the
overhead the rest of the data adds is nothing given the small data size.

And that's why they are not implemented. Use the full ones.

Qwerly's API status codes
-------------------------

Qwerly works this way: when they don't have data for the user you want, the API
returns with a 202 code, which means wait a few seconds and try again.
When the user doesn't exists, it returns 404.

In both cases our library will rise an exception, being the exception's code
the API return code. This is the way you should handle this:
    try {
        $api->retrieveByTwitterUsername('test');
    } catch (Qwerly_API_NotFoundException $e) {
        if ($e->getCode() == Qwerly_API::TRY_AGAIN_LATER_CODE) {
            // code...
        } else if ($e->getCode() == Qwerly_API::NOT_FOUND_CODE) {
            // more code...
        }
    }

This is pretty basic, but just to be sure you understand why the library
throws exceptions all the time.

Batch lookups
--------------

When doing batch lookups some users can be found, not found and there might be 
others that you'll need to try again in a few secs, so throwing exceptions is
not enough anymore. Instead, the API class returns a special object that sorts
out the returned users and provides different getters for each "category".
    $ret->getFoundUsers();
    $ret->getNotFoundUsers();
    $ret->getTryAgainLaterUsers();

Yes, we know that the name of the last one sucks. __getFoundUsers__ retrieves an
array of Qwerly\_API\_Response\_User objects (which is the normal object retrieved
when doing single lookups) and the other ones just string arrays containing the
original string that you looked up.
