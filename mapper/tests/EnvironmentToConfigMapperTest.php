<?php namespace MapperTests;

/**
 * Class EnvironmentToConfigMapperTestCase
 */
class EnvironmentToConfigMapperTest extends BaseTestCase {

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
	 * @dataProvider correctData
	 */
	public function correctValuesPass( $environment, $expectedConfig  ) {
		$this->environmentToConfigMapper->setEnvironment($environment);

		$createdConfig = $this->environmentToConfigMapper->map();
		$this->assertArrayEqual($expectedConfig, $createdConfig);

	}

	public function correctData(  ) {
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


	/**
	 * @test
	 * @param $environment
	 * @param $expectedConfig
	 * @dataProvider incorrectData
	 */
	public function incorrectValuesFail( $environment, $expectedConfig  ) {
		$this->environmentToConfigMapper->setEnvironment($environment);

		$createdConfig = $this->environmentToConfigMapper->map();
		$this->assertArrayNotEqual($expectedConfig, $createdConfig);

	}

	public function incorrectData(  ) {
		return [
			[
				// environment
				[
					'pma.Servers.0.ssl' => 'true'
				],
				// expected config
				[
					'Servers' => [ 1 => [ 'ssl' => true ] ]
				],
			],
			[
				// environment
				[
					'pma.Servers.0.ssl' => 'true'
				],
				// expected config
				[
					'Cookies' => [ [ 'ssl' => true ] ]
				],
			],
			[
				// environment
				[
					'pma.Servers.0.ssl' => 'true'
				],
				// expected config
				[
					'Servers' => [ [ 'sslk' => true ] ]
				],
			],
			[
				// environment
				[
					'pma.Servers.0.ssl' => 'true'
				],
				// expected config
				[
					'Servers' => [ [ 'ssl' => false ] ]
				],
			],
		];

	}

}