## Token Artisan Commands

The commands in the `token` namespace provide easy ways to list tokens, setup new tokens, regenerate tokens and delete tokens.

### `token:setup`

The `token:setup` command creates a new `AppToken` record and generates a server token to allow access to this API.

This command will ask for a name for the app you'd like to create a token for. This is only used to identify this token within this app. 

Once you've defined the name of the app, the command will print the app token to the console.

**Note** The server token is not stored in the application. Be sure to copy the token as it is not retrievable and will need to be regenerated if it is misplaced.

### `token:list`

The `token:list` command simple prints a table with the names of the apps with generated tokens

### `token:refresh`

The `token:refresh` command is used to refresh a token. This may be usefull if you suspect your token was compromised or if your token was not copied from the `token:setup` command.

The command will print a table of currently configured tokend and ask you for the id of the token you wish to refresh.

### `token:delete`

The `token:delete` command is used to delete a token from the database. The command will print a table of currently configured tokens and ask you for the id of the token you wish to delete. Once provided, you'll be asked to confirm deletion, then your token will be deleted. 