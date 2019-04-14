<?php namespace MapperTests;

/**
 * Class BaseTestCase
 */
class BaseTestCase extends \PHPUnit\Framework\TestCase {

	/**
	 * @param $expectedArray
	 * @param $actualArray
	 */
	public function assertArrayEqual($expectedArray, $actualArray) {

		$errors = [];

		$success = $this->assertArrayEqualRecursive($expectedArray, $actualArray, [], $errors);

		$this->assertTrue($success, implode(', ', $errors) );

	}

	/**
	 * @param $expectedArray
	 * @param $actualArray
	 */
	public function assertArrayNotEqual($expectedArray, $actualArray) {

		$errors = [];

		$success = $this->assertArrayEqualRecursive($expectedArray, $actualArray, [], $errors);

		$this->assertFalse($success, implode(PHP_EOL,[
			'Array equal to expectedArray, supposed to be different',
				var_export($expectedArray, true),
				var_export($actualArray, true),
			])
		);

	}

	protected function assertArrayEqualRecursive($expectedArray, $actualArray, $arrayPath, &$errors) {
		if( !is_array($expectedArray) ) {
			if( $expectedArray !== $actualArray) {
				$errors[] = implode('.', $arrayPath).' is not equal to '.var_export($expectedArray, true);
				return false;
			}
			return true;
		}

		$allSubElementsSuccessful = true;
		foreach ($expectedArray as $name => $value) {

			$path = $arrayPath;
			$path[] = $name;

			if(!array_key_exists($name, $actualArray)) {
				$errors[] = implode('.', $path).' does not exist.';
				$allSubElementsSuccessful = false;
				continue;
			}

			$elementSucessful = $this->assertArrayEqualRecursive($expectedArray[$name], $actualArray[$name], $path, $errors);
			if( !$elementSucessful )
				$allSubElementsSuccessful = false;
		}

		return $allSubElementsSuccessful;
	}

}