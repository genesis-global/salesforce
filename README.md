# Salesforce
Salesforce REST PHP client


How to use:
```
$config = [
    'authentication' => [
        'endpoint' => 'http://endpoint',
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

Feel free to create your own Factory, with custom Authenticator or HttpClient, just make sure they implement proper interfaces