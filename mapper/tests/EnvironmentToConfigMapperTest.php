<?php

/**
 * Class EnvironmentToConfigMapperTest
 */
class EnvironmentToConfigMapperTest extends \PHPUnit\Framework\TestCase {

	/**
	 * @var \Mapper\EnvironmentToConfigMapper
	 */
	protected $environmentToConfigMapper;

	protected function setUp(): void {
		$this->environmentToConfigMapper = new \Mapper\EnvironmentToConfigMapper();
		parent::setUp();
	}


	/**
	 * @test
	 * @param $environment
	 * @param $expectedConfig
	 * @dataProvider data
	 */
	public function mapsEnvironmentVariables( $environment, $expectedConfig  ) {
		$config = [];

		$this->environmentToConfigMapper->setConfig($config);
		$this->environmentToConfigMapper->setEnvironment($environment);

		$createdConfig = $this->environmentToConfigMapper->map();
		$this->assertArrayEqual($expectedConfig, $createdConfig);

	}

	/**
	 * @param $expectedArray
	 * @param $actualArray
	 */
	public function assertArrayEqual($expectedArray, $actualArray) {
		if( !is_array($expectedArray) ) {
			$this->assertEquals($expectedArray, $actualArray);
			return;
		}

		foreach ($expectedArray as $name => $value)
			$this->assertArrayHasKey($name, $actualArray);
			$this->assertArrayEqual($expectedArray[$name], $actualArray[$name]);

	}

	public function data(  ) {
		return [
			[
				// environment
				[
					'pma.Servers.0.ssl' => 'true'
				],
				// expected config
				[
					'Servers' => [ [ 'ssl' => true ] ]
				],
			],
		];

	}
}