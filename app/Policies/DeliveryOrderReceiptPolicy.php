<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryOrderReceipt;

class DeliveryOrderReceiptPolicy
{
    public function viewAny(User $user)
    {
        return $user->canOnRoute('upload-proof', 'can_view');
    }
    public function view(User $user, DeliveryOrderReceipt $receipt)
    {
        return $user->canOnRoute('upload-proof', 'can_view');
    }
    public function create(User $user)
    {
        return $user->canOnRoute('upload-proof', 'can_create');
    }
    public function update(User $user, DeliveryOrderReceipt $receipt)
    {
        return $user->canOnRoute('upload-proof', 'can_edit');
    }
    public function delete(User $user, DeliveryOrderReceipt $receipt)
    {
        return $user->canOnRoute('upload-proof', 'can_delete');
    }
}
