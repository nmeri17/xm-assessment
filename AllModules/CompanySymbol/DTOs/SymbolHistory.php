<?php

namespace AllModules\CompanySymbol\DTOs;

class SymbolHistory {

	public function __construct (

		public readonly int $date,

		public readonly int $open,

		public readonly int $high,

		public readonly int $low,

		public readonly int $close,

		public readonly int $volume,
	) {

		//
	}
}