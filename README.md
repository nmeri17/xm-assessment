Built courtesy of the [Suphle framework](https://suphle.com)

## steps to execute

	- Installation: run composer create-project. Tests can execute at this point. 
        - To run in browser: run php suphle server:start AllModules --insane

## run tests

	- phpunit test/file.php. They are all contained under AllModules/companySymbols/tests/featureTests
## info
	- entry route via browser: localhost:8080/symbols/all-symbols 
	- I'm not using migrations since the tests will attempt to seed data, which isn't applicable in this scenario. Data is either fetched from an external API or fixed
