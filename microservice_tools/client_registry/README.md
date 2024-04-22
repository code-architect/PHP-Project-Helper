1. We define an interface ClientDiscoveryInterface that outlines the getServiceAddress method for discovering service clients.
2. A ClientDiscoveryException class is used for handling errors during discovery.
3. The LocalClientRegistry class implements the ClientDiscoveryInterface.
4. It uses a local JSON file (services.json) to store service names and their corresponding addresses.
5. The getServiceAddress method retrieves the registry data, checks for the requested service, and throws an exception if not found.
6. The example usage demonstrates how to utilize the LocalClientRegistry to discover the address of a specific service.


PLEASE USE Zookeeper or Consul in production