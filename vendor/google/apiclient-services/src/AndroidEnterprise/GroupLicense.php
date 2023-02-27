<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\AndroidEnterprise;

class GroupLicense extends \Google\Model
{
  public $acquisitionKind;
  public $approval;
  public $numProvisioned;
  public $numPurchased;
  public $permissions;
  public $productId;

  public function setAcquisitionKind($acquisitionKind)
  {
    $this->acquisitionKind = $acquisitionKind;
  }
  public function getAcquisitionKind()
  {
    return $this->acquisitionKind;
  }
  public function setApproval($approval)
  {
    $this->approval = $approval;
  }
  public function getApproval()
  {
    return $this->approval;
  }
  public function setNumProvisioned($numProvisioned)
  {
    $this->numProvisioned = $numProvisioned;
  }
  public function getNumProvisioned()
  {
    return $this->numProvisioned;
  }
  public function setNumPurchased($numPurchased)
  {
    $this->numPurchased = $numPurchased;
  }
  public function getNumPurchased()
  {
    return $this->numPurchased;
  }
  public function setPermissions($permissions)
  {
    $this->permissions = $permissions;
  }
  public function getPermissions()
  {
    return $this->permissions;
  }
  public function setProductId($productId)
  {
    $this->productId = $productId;
  }
  public function getProductId()
  {
    return $this->productId;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GroupLicense::class, 'Google_Service_AndroidEnterprise_GroupLicense');