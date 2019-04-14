<?php namespace Mapper;

/**
 * Class EnvironmentToConfigMapper
 */
class EnvironmentToConfigMapper {

	protected $prefix = 'pma.';

	public function setPrefix( $prefix ) {
		$this->prefix = $prefix;
	}

	protected $config;

	protected $environment;

	public function setEnvironment( $environment ) {
		$this->environment = $environment;
		return $this;
	}

	public function map() {
		$this->config = [];

		foreach($this->environment as $name => $value)
			$this->mapVariable( $name, $value );

		return $this->config;
	}

	public function mapVariable( $name, $value ) {
		if( !begins_with($this->prefix, $name) )
			return;

		$this->setVariable($name, $value);
	}

	private function setVariable($name, $value) {
		$unprefixedName = $this->removePrefix($name);
		$configSections = $this->splitNameIntoSections( $unprefixedName );
		$this->setSection($configSections, $value);
	}

	private function removePrefix( $name ) {
		return substr($name, strlen($this->prefix));
	}

	private function splitNameIntoSections( $name ) {
		return explode('.', $name);
	}

	private function setSection( array $configSections, $value ) {
		$this->setSectionRecursive($this->config, $configSections, $value);
	}

	private function setSectionRecursive( array &$config, array $configSections, $value ) {
		$configSection = array_shift($configSections);

		if ( empty($configSections) ) {
			$config[$configSection] = $this->mapStringValueToPhp($value);
			return;
		}

		if ( !array_key_exists($configSection, $config) )
			$config[$configSection] = [];

		$this->setSectionRecursive($config[$configSection], $configSections, $value);
	}

	private function mapStringValueToPhp($value) {
		switch ($value) {
			case 'true':
				return true;
				break;
			case 'false':
				return false;
				break;
		}

		return $value;
	}

}