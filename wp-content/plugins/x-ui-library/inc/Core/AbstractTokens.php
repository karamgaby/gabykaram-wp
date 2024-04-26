<?php
namespace X_UI\Core;
abstract class AbstractTokens {
  public readonly array $metas;

  public function __construct( array $metas ) {
    $this->metas = $metas;
  }

  public function getMeta( $key ) {
    return $this->metas[ $key ] ?? null;
  }
}
