# AddWatchers

## Add / Remove Watchers
This extension allows you to use {{#addwatchers:username,username1,username3}} to add multiple users as watchers to a page. You can also use {{#addwatchers:username,username1,username3|REMOVE}} if you want to remove users from the page as watcher. If you don't put "REMOVE" in all caps, it will not work.

## Output
This extension will have an output that shows the user's real name, and say they have been added as a watcher. To turn the output off/on set "AddWatchersShowOutput" in the extension.json file to true or false.

### Example
{{#info:{{#addwatchers: {{#show:{{PAGENAME}} |?Project members usernames}}}}|note}} 
