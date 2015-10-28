# Civirules HTTP Action

This extension for Civirules and Civicrm adds an action to do HTTP requests as an action of Civirules.
This means that you could perform to connect to other services. 

The user could setup a URL, an HTTP Method and eventually a request body.

The means of the action is to be extended for specifics use case. E.g. you could add your own tweet action and use the HTTP request from this extension. 

## Tweeting

This extension contains an extension of the HTTP Post action for posting tweets to twitter. 
To use the tweeting functionality you have to set up an app at https://apps.twitter.com After you have done so you have to create a consumer key and consumer secret. And also an access token and access token secret

Note your consumer key, consumer secret, access token and access secret and fill them in at Administer --> Twitter Accounts in CiviCRM. After that you are ready to use the Tweet action from within Civirules.
