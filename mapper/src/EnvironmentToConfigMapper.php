<?php namespace Mapper;

/**
 * Class EnvironmentToConfigMapper
 */
class EnvironmentToConfigMapper {

	public $prefix = 'phpunit.';

	protected $config;

	public function setConfig( $config ) {
		$this->config = $config;
		return $this;
	}

	protected $environment;

	public function setEnvironment( $environment ) {
		$this->environment = $environment;
		return $this;
	}

	public function map() {

		foreach($this->environment as $name => $value)
			$this->mapVariable( $name, $value );

		return $this->config;
	}

	public function mapVariable( $name, $value ) {
		if( !begins_with($this->prefix, $name) )
			return;

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
	}

}