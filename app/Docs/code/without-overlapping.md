# A crisis of concurrent requests

There was a sales performance report that everyone (I mean everyone) at pretty much the same time several times a day. The report took a LONG time to run. Many multiples of times the same report being run in concurrent requests was killing the database server and killing lots of other things too.

I was tasked with scheduling the most commonly requested report requests at specific times of day, caching the result, and presenting the cached version instead of allowing a fresh request to hit the database. All well and good, but of course if the parameters of the report were slightly different there would be no cache provided by the scheduled jobs and it was still possible for users to clog up the server with multiple copies of the same request (sometimes the same user with the same request over and over never waiting for the first to finish, but that is another story perhaps).

One simple part of the mostly successful solution to was to add WithoutOverlapping middleware to the job to prevent more than one request of the same type running at any one time.

```php
    public function middleware()
    {
        return [(new WithoutOverlapping(Arr::query($this->params)))->dontRelease()->expireAfter(300)];
    }
```

The report parameters, an array, is converted to a query string to provide the cache lock key in Redis, any request for the following five minutes which matches these parameters is discarded from the queue and not requeued. Since the result from the job that acquires the lock is being cached there is no need to release these overlapping jobs back into the queue.

The result is that the same report can only be requested once every five minutes and everyone else receives the cached version in the meantime.
