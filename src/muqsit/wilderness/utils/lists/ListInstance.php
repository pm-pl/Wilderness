<?php

declare(strict_types=1);

namespace muqsit\wilderness\utils\lists;

use Closure;
use InvalidArgumentException;

abstract class ListInstance{

	/**
	 * @var string[]
	 *
	 * @phpstan-var array<string, string>
	 */
	protected array $values = [];

	/**
	 * @param string[] $values
	 * @param Closure|null $validator
	 * @return ListInstance
	 *
	 * @phpstan-param Closure(string) : bool $validator
	 */
	final public static function create(array $values, ?Closure $validator = null) : self{
		$valid_values = [];
		foreach($values as $value){
			if($validator !== null && !$validator($value)){
				throw new InvalidArgumentException("Could not create list, got invalid list entry: {$value}");
			}
			$valid_values[$value] = $value;
		}

		return new static($valid_values);
	}

	/**
	 * @param string[] $values
	 *
	 * @phpstan-param array<string, string> $values
	 */
	final private function __construct(array $values){
		$this->values = $values;
	}

	/**
	 * @return string[]
	 */
	final public function getValues() : array{
		return array_keys($this->values);
	}

	abstract public function contains(string $value) : bool;
}