<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $product): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isVendor();
    }

    public function update(User $user, Product $product): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isVendor()) {
            return $product->vendor_id === $user->id;
        }

        return false;
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->update($user, $product);
    }
}
