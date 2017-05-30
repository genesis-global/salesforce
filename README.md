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
        'password' => 'pass',
        'security_token' => '2e2d3233434'
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

Make sure to reset your token to get first security_token.