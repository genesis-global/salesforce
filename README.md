# Salesforce
Salesforce REST PHP client


How to use:
```
$config = [
    'authentication' => [
        'endpoint' => 'https://login.salesforce.com',
        'client_id' => 'id',
        'client_secret' => 'secret',
        'username' => 'name',
        'password' => 'pass'
    ],
    'rest' => [
        'version' => 'v35.0',
        'endpoint' => 'http://endpoint'
    ]
];
$salesforceClient = new GenesisGlobal\Salesforce\Client\SalesforceClientFactory($config);
$query = 'SELECT Id, Name, Code__c, Active__c FROM Exclusive__c';
$response = $salesforceClient->get('query', $query);
```
>If you’re verifying authentication on a sandbox organization, use “test.salesforce.com” instead of “login.salesforce.com”.

>You must append the user’s security token to their password A security token is an automatically-generated key from Salesforce. For example, if a user's password is mypassword, and their security token is XXXXXXXXXX, then the value provided for this parmeter must be mypasswordXXXXXXXXXX. For more information on security tokens see “Reset Your Security Token” in the online help.
Feel free to create your own Factory, with custom Authenticator or HttpClient, just make sure they implement proper interfaces

Make sure to reset your token to get first token.