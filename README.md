# betGames task manager

1. [Setup](#project-setup)
2. [System architecture](#system-structure--patterns)
3. [Documentation](#documentation)
4. [Tests](#tests)

## Project setup
To locally set up the project all you need to have is docker installed on your machine and run `docker-compose up --build`

This command will set up all necessary infrastructure, will run database migrations and some fixture data.

Local development fixtures are configured in `app/DataFixtures` directory

For authentication decided to use JWT with the help of `lexik/jwt-authentication-bundle`.
I know it's a bad practice to commit JWT SSL keys, but for test project purposes and simplier local setup i added them in `app/config/jwt` directory.

## System structure + patterns
Decided to use Domain Driven Design layered architecture. `User`, `Category` `Task` domains are in their own directories and each domain has sub directories named `Application`, `Domain`, `Infrastructure`
1. `Application` directory is responsible of handling the bussiness logic by using symfony messages and message handlers
2. `Domain` directory is responsible in storing `Entity` type classes and `Request/Response` DTO classes.
3. `Infrastructure` directory is responsible for various 3rd party integrations like doctrine repositories or Symfony Http controllers.

Also in `Application` directory you will find `Command` and `Query` Sub directories. The `Command` directory writes data and the `Query` one is responsible for reading and getting data.

## Documentation
For system endpoints documentation decided to use OpenAPI. And with the help of `nelmio/api-doc-bundle` generated documentation which can be reached via `http://localhost:8070/api/doc`

To Authorize you will need to login with existing user via the `/api/login` endpoint the response is the JWT token that can be entered by clicking `Authorize` button

## Tests
Wrote unit tests for the parts of the system that has some logic to it. Like `Application` directories or some parts of `Domain` directories
Skipped feature tests as this test task took a lot of time as it is. 
Test coverage can be found in `app/Reports` directory.
