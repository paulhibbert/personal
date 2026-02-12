# Queued Listeners get access to ShouldBeUnique

Obviously had been aware of queued listeners as well as the ShouldBeUnique pattern on jobs, but looking at this PR illuminates how queued listeners work under the hood.

In the Dispatcher for Events we have the `queueHandler` method, obviously for queued listeners. This method calls `createListenerAndJob`, i.e. there is not really a queued Listener, there is a listener and a job (like an anonymous class perhaps) to process the event. The properties of the listener get propagated to the job.

Now, as of this PR, if the Listener should be unique, then the job should be unique, and if the job is not able to acquire a unique lock (using the properties passed to it) then the `queueHandler` returns early with no futher action. I feel sure I have seen (but not recognised) the result of this lack of uniqueness in a production system.

```php
$job->shouldBeUnique = $listener instanceof ShouldBeUnique;
$job->shouldBeUniqueUntilProcessing = $listener instanceof ShouldBeUniqueUntilProcessing;
```
